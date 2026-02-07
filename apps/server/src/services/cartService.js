const { pool } = require('./db');

async function getOrCreateCart(sessionId, userId = null) {
  const [rows] = await pool.query('SELECT * FROM carts WHERE session_id = ?', [sessionId]);
  if (rows.length > 0) return rows[0];
  const emptyItems = JSON.stringify([]);
  const [result] = await pool.query(
    'INSERT INTO carts (session_id, user_id, items_json) VALUES (?, ?, ?)',
    [sessionId, userId, emptyItems]
  );
  const [created] = await pool.query('SELECT * FROM carts WHERE id = ?', [result.insertId]);
  return created[0];
}

async function updateCartItems(cartId, items) {
  const itemsJson = JSON.stringify(items || []);
  await pool.query('UPDATE carts SET items_json = ? WHERE id = ?', [itemsJson, cartId]);
}

async function clearCart(cartId) {
  await pool.query('UPDATE carts SET items_json = ? WHERE id = ?', [JSON.stringify([]), cartId]);
}

module.exports = {
  getOrCreateCart,
  updateCartItems,
  clearCart
};
