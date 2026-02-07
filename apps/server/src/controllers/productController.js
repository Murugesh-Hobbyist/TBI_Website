const productService = require('../services/productService');

async function list(req, res) {
  try {
    const products = await productService.listProducts();
    res.json(products);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load products' });
  }
}

async function detail(req, res) {
  try {
    const product = await productService.getProductById(req.params.id);
    if (!product) return res.status(404).json({ error: 'Not found' });
    res.json(product);
  } catch (err) {
    res.status(500).json({ error: 'Failed to load product' });
  }
}

module.exports = { list, detail };
