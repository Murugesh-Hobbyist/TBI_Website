const { pool } = require('./db');

async function listProducts() {
  const [rows] = await pool.query(
    'SELECT p.*, (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) AS image_url FROM products p WHERE is_active = 1 ORDER BY created_at DESC'
  );
  return rows;
}

async function getProductById(id) {
  const [rows] = await pool.query('SELECT * FROM products WHERE id = ?', [id]);
  if (rows.length === 0) return null;
  const product = rows[0];
  const [images] = await pool.query('SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC', [id]);
  product.images = images;
  return product;
}

async function createProduct(data) {
  const { name, slug, description, price, stock, is_active } = data;
  const [result] = await pool.query(
    'INSERT INTO products (name, slug, description, price, stock, is_active) VALUES (?, ?, ?, ?, ?, ?)',
    [name, slug, description || null, price || 0, stock || 0, is_active ? 1 : 0]
  );
  return result.insertId;
}

async function addProductImage(productId, url, altText, sortOrder) {
  await pool.query(
    'INSERT INTO product_images (product_id, url, alt_text, sort_order) VALUES (?, ?, ?, ?)',
    [productId, url, altText || null, sortOrder || 0]
  );
}

module.exports = {
  listProducts,
  getProductById,
  createProduct,
  addProductImage
};
