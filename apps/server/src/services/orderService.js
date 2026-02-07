const { pool } = require('./db');

async function createOrderFromCart(cart, userId = null) {
  const items = JSON.parse(cart.items_json || '[]');
  if (items.length === 0) {
    throw new Error('Cart is empty');
  }

  const productIds = items.map((item) => item.product_id);
  const [products] = await pool.query(
    `SELECT id, price FROM products WHERE id IN (${productIds.map(() => '?').join(',')})`,
    productIds
  );

  const priceMap = new Map(products.map((p) => [p.id, Number(p.price)]));
  const orderItems = items.map((item) => {
    const price = priceMap.get(item.product_id) || 0;
    return {
      product_id: item.product_id,
      quantity: item.quantity,
      unit_price: price
    };
  });

  const total = orderItems.reduce((sum, item) => sum + item.unit_price * item.quantity, 0);

  const conn = await pool.getConnection();
  try {
    await conn.beginTransaction();
    const [orderResult] = await conn.query(
      'INSERT INTO orders (user_id, total, status, payment_status) VALUES (?, ?, ?, ?)',
      [userId, total, 'pending', 'unpaid']
    );
    const orderId = orderResult.insertId;

    for (const item of orderItems) {
      await conn.query(
        'INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)',
        [orderId, item.product_id, item.quantity, item.unit_price]
      );
    }

    await conn.query('UPDATE carts SET items_json = ? WHERE id = ?', [JSON.stringify([]), cart.id]);

    await conn.commit();
    return { id: orderId, total };
  } catch (err) {
    await conn.rollback();
    throw err;
  } finally {
    conn.release();
  }
}

async function listOrders() {
  const [rows] = await pool.query('SELECT * FROM orders ORDER BY created_at DESC');
  return rows;
}

module.exports = {
  createOrderFromCart,
  listOrders
};
