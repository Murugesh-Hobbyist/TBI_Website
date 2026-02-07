const { pool } = require('./db');

async function createQuote(data) {
  const { name, phone, email, product_id, quantity, notes, file_path } = data;
  const [result] = await pool.query(
    'INSERT INTO quotes (name, phone, email, product_id, quantity, notes, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)',
    [name, phone, email, product_id || null, quantity || 1, notes || null, file_path || null]
  );
  return result.insertId;
}

async function listQuotes() {
  const [rows] = await pool.query(
    'SELECT q.*, p.name AS product_name FROM quotes q LEFT JOIN products p ON q.product_id = p.id ORDER BY q.created_at DESC'
  );
  return rows;
}

module.exports = {
  createQuote,
  listQuotes
};
