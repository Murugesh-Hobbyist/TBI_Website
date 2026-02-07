const express = require('express');
const controller = require('../controllers/orderController');
const { requireAdmin } = require('../middleware/auth');

const router = express.Router();

router.post('/', controller.create);
router.get('/', requireAdmin, controller.list);

module.exports = router;
