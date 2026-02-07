const cartService = require('../services/cartService');

async function getCart(req, res) {
  try {
    const cart = await cartService.getOrCreateCart(req.sessionID, req.session.user?.id || null);
    const items = JSON.parse(cart.items_json || '[]');
    res.json({ id: cart.id, items });
  } catch (err) {
    res.status(500).json({ error: 'Failed to load cart' });
  }
}

async function addItem(req, res) {
  try {
    const { product_id, quantity } = req.body;
    const cart = await cartService.getOrCreateCart(req.sessionID, req.session.user?.id || null);
    const items = JSON.parse(cart.items_json || '[]');
    const existing = items.find((item) => item.product_id === product_id);
    if (existing) {
      existing.quantity += Number(quantity || 1);
    } else {
      items.push({ product_id, quantity: Number(quantity || 1) });
    }
    await cartService.updateCartItems(cart.id, items);
    res.json({ id: cart.id, items });
  } catch (err) {
    res.status(500).json({ error: 'Failed to update cart' });
  }
}

async function clear(req, res) {
  try {
    const cart = await cartService.getOrCreateCart(req.sessionID, req.session.user?.id || null);
    await cartService.clearCart(cart.id);
    res.json({ ok: true });
  } catch (err) {
    res.status(500).json({ error: 'Failed to clear cart' });
  }
}

module.exports = { getCart, addItem, clear };
