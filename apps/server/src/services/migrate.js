const fs = require('fs');
const path = require('path');
const bcrypt = require('bcryptjs');
const { pool } = require('./db');

async function run() {
  const schemaPath = path.join(__dirname, '../../../database/schema.sql');
  const sql = fs.readFileSync(schemaPath, 'utf8');
  const conn = await pool.getConnection();

  try {
    await conn.query(sql);

    const [rows] = await conn.query('SELECT id FROM users WHERE email = ?', ['admin@tbi.local']);
    if (rows.length === 0) {
      const passwordHash = await bcrypt.hash('Admin123!', 10);
      await conn.query(
        'INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)',
        ['Admin', 'admin@tbi.local', passwordHash, 'admin']
      );
    }
  } finally {
    conn.release();
    await pool.end();
  }
}

run()
  .then(() => {
    console.log('Migration complete.');
    process.exit(0);
  })
  .catch((err) => {
    console.error('Migration failed:', err);
    process.exit(1);
  });
