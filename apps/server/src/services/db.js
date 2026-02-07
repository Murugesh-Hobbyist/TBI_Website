const fs = require('fs');
const path = require('path');
const mysql = require('mysql2/promise');

// Load `.env` for scripts (migrations) as well as server boot.
// Primary: repo root (when executed via `node apps/server/server.js` from root).
// Fallback: walk up from this file (useful if working directory differs).
(() => {
  const candidates = [
    path.join(process.cwd(), '.env'),
    path.join(__dirname, '..', '..', '..', '..', '.env')
  ];
  for (const p of candidates) {
    if (fs.existsSync(p)) {
      require('dotenv').config({ path: p });
      break;
    }
  }
})();

const pool = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: Number(process.env.DB_PORT || 3306),
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
  multipleStatements: true
});

module.exports = { pool };
