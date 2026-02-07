const { pool } = require('./db');

async function createVoiceSession(userId, ipAddress) {
  const [result] = await pool.query(
    'INSERT INTO voice_sessions (user_id, ip_address) VALUES (?, ?)',
    [userId || null, ipAddress || null]
  );
  return result.insertId;
}

async function endVoiceSession(sessionId) {
  await pool.query('UPDATE voice_sessions SET ended_at = CURRENT_TIMESTAMP WHERE id = ?', [sessionId]);
}

async function addTranscript(sessionId, role, text) {
  if (!text || !text.trim()) return;
  await pool.query(
    'INSERT INTO voice_transcripts (session_id, role, text) VALUES (?, ?, ?)',
    [sessionId, role, text]
  );
}

module.exports = {
  createVoiceSession,
  endVoiceSession,
  addTranscript
};
