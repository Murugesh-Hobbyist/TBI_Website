const quoteService = require('../services/quoteService');

async function create(req, res) {
  try {
    const payload = {
      name: req.body.name,
      phone: req.body.phone,
      email: req.body.email,
      product_id: req.body.product_id ? Number(req.body.product_id) : null,
      quantity: req.body.quantity ? Number(req.body.quantity) : 1,
      notes: req.body.notes,
      file_path: req.file ? `/uploads/${req.file.filename}` : null
    };
    const id = await quoteService.createQuote(payload);
    res.json({ id });
  } catch (err) {
    res.status(500).json({ error: 'Failed to create quote' });
  }
}

async function list(req, res) {
  try {
    const quotes = await quoteService.listQuotes();
    res.json(quotes);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load quotes' });
  }
}

module.exports = { create, list };
