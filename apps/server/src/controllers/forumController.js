const forumService = require('../services/forumService');

async function listTopics(req, res) {
  try {
    const topics = await forumService.listTopics();
    res.json(topics);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load topics' });
  }
}

async function createTopic(req, res) {
  try {
    const { title } = req.body;
    const id = await forumService.createTopic(title, req.session.user?.id || null);
    res.json({ id });
  } catch (err) {
    res.status(500).json({ error: 'Failed to create topic' });
  }
}

async function listPosts(req, res) {
  try {
    const posts = await forumService.listPosts(req.params.topicId);
    res.json(posts);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load posts' });
  }
}

async function createPost(req, res) {
  try {
    const { content } = req.body;
    const id = await forumService.createPost(req.params.topicId, content, req.session.user?.id || null);
    res.json({ id });
  } catch (err) {
    res.status(500).json({ error: 'Failed to create post' });
  }
}

async function createComment(req, res) {
  try {
    const { content } = req.body;
    const id = await forumService.createComment(req.params.postId, content, req.session.user?.id || null);
    res.json({ id });
  } catch (err) {
    res.status(500).json({ error: 'Failed to create comment' });
  }
}

async function listComments(req, res) {
  try {
    const comments = await forumService.listComments(req.params.postId);
    res.json(comments);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load comments' });
  }
}

module.exports = {
  listTopics,
  createTopic,
  listPosts,
  createPost,
  createComment,
  listComments
};
