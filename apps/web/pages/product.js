import { useEffect, useMemo, useState } from 'react';
import { useRouter } from 'next/router';
import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

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
        const fallback = SITE.productsFallback.find((p) => p.id === productId) || SITE.productsFallback[0];
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
        <p>{product.description || 'Request full specifications and a pricing quote.'}</p>
        {note && <p className="status">{note}</p>}
      </section>
      <section className="grid">
        <div className="image-card">
          {firstImage ? (
            <img src={firstImage.url} alt={firstImage.alt_text || product.name} />
          ) : (
            <div style={{ height: '200px', background: '#f1ece2' }} />
          )}
          <div className="content">
            <strong>Configuration Notes</strong>
            <p>We customize channels, display size, and logging based on your workflow.</p>
          </div>
        </div>
        <div className="card">
          <h3>Request This Product</h3>
          <p>Specify quantity and our team will share pricing and lead time.</p>
          <div className="row" style={{ display: 'grid', gap: '8px', marginTop: '12px' }}>
            <label>Quantity</label>
            <input type="number" min="1" value={quantity} onChange={(e) => setQuantity(e.target.value)} />
          </div>
          <div className="header-cta" style={{ marginTop: '12px' }}>
            <button className="btn" onClick={addToCart}>Add to cart</button>
            <a className="btn outline" href="/quote-request">Request quote</a>
          </div>
          {message && <p className="status">{message}</p>}
        </div>
      </section>
      {product.highlights && product.highlights.length > 0 && (
        <section className="card">
          <h3>Highlights</h3>
          <div className="list">
            {product.highlights.map((item) => (
              <div key={item}>- {item}</div>
            ))}
          </div>
        </section>
      )}
    </Layout>
  );
}
