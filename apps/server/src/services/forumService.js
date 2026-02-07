const { pool } = require('./db');

async function listTopics() {
  const [rows] = await pool.query('SELECT * FROM forum_topics ORDER BY created_at DESC');
  return rows;
}

async function createTopic(title, userId = null) {
  const [result] = await pool.query(
    'INSERT INTO forum_topics (title, created_by) VALUES (?, ?)',
    [title, userId]
  );
  return result.insertId;
}

async function listPosts(topicId) {
  const [rows] = await pool.query(
    'SELECT * FROM forum_posts WHERE topic_id = ? ORDER BY created_at ASC',
    [topicId]
  );
  return rows;
}

async function createPost(topicId, content, userId = null) {
  const [result] = await pool.query(
    'INSERT INTO forum_posts (topic_id, user_id, content) VALUES (?, ?, ?)',
    [topicId, userId, content]
  );
  return result.insertId;
}

async function createComment(postId, content, userId = null) {
  const [result] = await pool.query(
    'INSERT INTO forum_comments (post_id, user_id, content) VALUES (?, ?, ?)',
    [postId, userId, content]
  );
  return result.insertId;
}

async function listComments(postId) {
  const [rows] = await pool.query(
    'SELECT * FROM forum_comments WHERE post_id = ? ORDER BY created_at ASC',
    [postId]
  );
  return rows;
}

async function flagPost(postId) {
  await pool.query('UPDATE forum_posts SET is_flagged = 1 WHERE id = ?', [postId]);
}

async function flagComment(commentId) {
  await pool.query('UPDATE forum_comments SET is_flagged = 1 WHERE id = ?', [commentId]);
}

module.exports = {
  listTopics,
  createTopic,
  listPosts,
  createPost,
  createComment,
  listComments,
  flagPost,
  flagComment
};
