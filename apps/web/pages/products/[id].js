import { useState } from 'react';
import Layout from '../../components/Layout';

export async function getServerSideProps({ req, params }) {
  const protocol = req.headers['x-forwarded-proto'] || 'http';
  const baseUrl = `${protocol}://${req.headers.host}`;
  const res = await fetch(`${baseUrl}/api/products/${params.id}`);
  if (!res.ok) return { notFound: true };
  const product = await res.json();
  return { props: { product } };
}

export default function ProductDetail({ product }) {
  const [quantity, setQuantity] = useState(1);
  const [message, setMessage] = useState('');

  const addToCart = async () => {
    const res = await fetch('/api/cart/items', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ product_id: product.id, quantity: Number(quantity) })
    });
    if (res.ok) setMessage('Added to cart.');
  };

  return (
    <Layout title={product.name} description={product.description || ''}>
      <section className="page-hero">
        <h1>{product.name}</h1>
        <p>{product.description || 'No description provided.'}</p>
      </section>
      <section className="product-detail">
        <div className="image-placeholder">
          {product.images && product.images.length > 0 ? (
            <img src={product.images[0].url} alt={product.images[0].alt_text || product.name} />
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
