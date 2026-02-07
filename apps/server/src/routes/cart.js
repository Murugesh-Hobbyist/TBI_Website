const express = require('express');
const controller = require('../controllers/cartController');

const router = express.Router();

router.get('/', controller.getCart);
router.post('/items', controller.addItem);
router.post('/clear', controller.clear);

module.exports = router;
