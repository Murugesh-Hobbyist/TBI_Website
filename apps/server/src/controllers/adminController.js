const bcrypt = require('bcryptjs');
const userService = require('../services/userService');
const productService = require('../services/productService');
const quoteService = require('../services/quoteService');
const orderService = require('../services/orderService');
const forumService = require('../services/forumService');

async function login(req, res) {
  try {
    const { email, password } = req.body;
    const user = await userService.findByEmail(email);
    if (!user) return res.status(401).json({ error: 'Invalid credentials' });

    const ok = await bcrypt.compare(password, user.password_hash);
    if (!ok) return res.status(401).json({ error: 'Invalid credentials' });

    req.session.user = { id: user.id, role: user.role, email: user.email, name: user.name };
    res.json({ ok: true, user: req.session.user });
  } catch (err) {
    res.status(500).json({ error: 'Login failed' });
  }
}

function logout(req, res) {
  req.session.destroy(() => {
    res.json({ ok: true });
  });
}

function me(req, res) {
  if (!req.session.user) return res.status(401).json({ error: 'Unauthorized' });
  res.json({ user: req.session.user });
}

async function createProduct(req, res) {
  try {
    const id = await productService.createProduct(req.body);
    res.json({ id });
  } catch (err) {
    res.status(500).json({ error: 'Failed to create product' });
  }
}

async function addProductImage(req, res) {
  try {
    const { product_id, url, alt_text, sort_order } = req.body;
    await productService.addProductImage(product_id, url, alt_text, sort_order);
    res.json({ ok: true });
  } catch (err) {
    res.status(500).json({ error: 'Failed to add image' });
  }
}

async function listQuotes(req, res) {
  const quotes = await quoteService.listQuotes();
  res.json(quotes);
}

async function listOrders(req, res) {
  const orders = await orderService.listOrders();
  res.json(orders);
}

async function flagPost(req, res) {
  await forumService.flagPost(req.body.post_id);
  res.json({ ok: true });
}

async function flagComment(req, res) {
  await forumService.flagComment(req.body.comment_id);
  res.json({ ok: true });
}

module.exports = {
  login,
  logout,
  me,
  createProduct,
  addProductImage,
  listQuotes,
  listOrders,
  flagPost,
  flagComment
};
