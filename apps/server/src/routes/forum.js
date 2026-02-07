const express = require('express');
const controller = require('../controllers/forumController');

const router = express.Router();

router.get('/topics', controller.listTopics);
router.post('/topics', controller.createTopic);
router.get('/topics/:topicId/posts', controller.listPosts);
router.post('/topics/:topicId/posts', controller.createPost);
router.get('/posts/:postId/comments', controller.listComments);
router.post('/posts/:postId/comments', controller.createComment);

module.exports = router;
