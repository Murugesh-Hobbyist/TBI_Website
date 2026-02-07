const express = require('express');
const controller = require('../controllers/adminController');
const { requireAdmin } = require('../middleware/auth');

const router = express.Router();

router.post('/login', controller.login);
router.post('/logout', controller.logout);
router.get('/me', controller.me);

router.post('/products', requireAdmin, controller.createProduct);
router.post('/products/images', requireAdmin, controller.addProductImage);
router.get('/quotes', requireAdmin, controller.listQuotes);
router.get('/orders', requireAdmin, controller.listOrders);
router.post('/forum/flag-post', requireAdmin, controller.flagPost);
router.post('/forum/flag-comment', requireAdmin, controller.flagComment);

module.exports = router;
