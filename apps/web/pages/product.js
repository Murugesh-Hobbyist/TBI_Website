import { useEffect, useMemo, useState } from 'react';
import { useRouter } from 'next/router';
import Layout from '../components/Layout';

const FALLBACK_PRODUCTS = [
  { id: 1, name: 'Sample Product', description: 'Example description.', price: 99.0, images: [] },
  { id: 2, name: 'Starter Kit', description: 'A simple starter product.', price: 149.0, images: [] }
];

export default function ProductDetail() {
  const router = useRouter();
  const productId = useMemo(() => {
    const raw = router.query?.id;
    const id = Array.isArray(raw) ? raw[0] : raw;
    const n = Number(id);
    return Number.isFinite(n) ? n : null;
  }, [router.query]);

  const [product, setProduct] = useState(null);
  const [quantity, setQuantity] = useState(1);
  const [message, setMessage] = useState('');
  const [note, setNote] = useState('');

  useEffect(() => {
    if (!productId) return;
    fetch(`/api/products/${productId}`)
      .then((res) => (res.ok ? res.json() : Promise.reject(new Error('API unavailable'))))
      .then((data) => setProduct(data))
      .catch(() => {
        const fallback = FALLBACK_PRODUCTS.find((p) => p.id === productId) || FALLBACK_PRODUCTS[0];
        setProduct(fallback);
        setNote('Live product API is unavailable in this deployment.');
      });
  }, [productId]);

  const addToCart = async () => {
    if (!product) return;
    setMessage('');
    try {
      const res = await fetch('/api/cart/items', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: product.id, quantity: Number(quantity) })
      });
      if (!res.ok) throw new Error('Cart API unavailable');
      setMessage('Added to cart.');
    } catch (err) {
      setMessage('Cart is unavailable in this deployment.');
    }
  };

  if (!productId) {
    return (
      <Layout title="Product" description="Product details">
        <section className="page-hero">
          <h1>Product</h1>
          <p>Missing product id.</p>
        </section>
      </Layout>
    );
  }

  if (!product) {
    return (
      <Layout title="Product" description="Product details">
        <section className="page-hero">
          <h1>Loading...</h1>
        </section>
      </Layout>
    );
  }

  const firstImage = product.images && product.images.length > 0 ? product.images[0] : null;

  return (
    <Layout title={product.name} description={product.description || ''}>
      <section className="page-hero">
        <h1>{product.name}</h1>
        <p>{product.description || 'No description provided.'}</p>
        {note && <p className="status">{note}</p>}
      </section>
      <section className="product-detail">
        <div className="image-placeholder">
          {firstImage ? (
            <img src={firstImage.url} alt={firstImage.alt_text || product.name} />
          ) : (
            <span>Image</span>
          )}
        </div>
        <div className="product-info">
          <p className="price">${Number(product.price).toFixed(2)}</p>
          <div className="row">
            <label>Quantity</label>
            <input type="number" min="1" value={quantity} onChange={(e) => setQuantity(e.target.value)} />
          </div>
          <button className="btn" onClick={addToCart}>Add to cart</button>
          {message && <p className="status">{message}</p>}
        </div>
      </section>
    </Layout>
  );
}

