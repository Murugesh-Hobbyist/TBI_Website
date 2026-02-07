const cartService = require('../services/cartService');
const orderService = require('../services/orderService');

async function create(req, res) {
  try {
    const cart = await cartService.getOrCreateCart(req.sessionID, req.session.user?.id || null);
    const order = await orderService.createOrderFromCart(cart, req.session.user?.id || null);
    res.json({ order });
  } catch (err) {
    res.status(400).json({ error: err.message || 'Failed to create order' });
  }
}

async function list(req, res) {
  try {
    const orders = await orderService.listOrders();
    res.json(orders);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load orders' });
  }
}

module.exports = { create, list };
