import { useEffect, useState } from 'react';
import Layout from '../components/Layout';
import Link from 'next/link';

const FALLBACK_PRODUCTS = [
  { id: 1, name: 'Sample Product', price: 99.0, image_url: null },
  { id: 2, name: 'Starter Kit', price: 149.0, image_url: null }
];

export default function Products() {
  const [products, setProducts] = useState([]);
  const [note, setNote] = useState('');

  useEffect(() => {
    fetch('/api/products')
      .then((res) => (res.ok ? res.json() : Promise.reject(new Error('API unavailable'))))
      .then((data) => {
        setProducts(Array.isArray(data) ? data : []);
      })
      .catch(() => {
        setProducts(FALLBACK_PRODUCTS);
        setNote('Live products API is unavailable in this deployment.');
      });
  }, []);

  return (
    <Layout title="Products" description="TBI products">
      <section className="page-hero">
        <h1>Products</h1>
        <p>Browse available items and request a custom quote if you need scale.</p>
        {note && <p className="status">{note}</p>}
      </section>
      <section className="grid">
        {products.length === 0 && <p>No products yet.</p>}
        {products.map((product) => (
          <div className="card" key={product.id}>
            <div className="image-placeholder">
              {product.image_url ? (
                <img src={product.image_url} alt={product.name} />
              ) : (
                <span>Image</span>
              )}
            </div>
            <h3>{product.name}</h3>
            <p>${Number(product.price).toFixed(2)}</p>
            <Link href={`/product?id=${encodeURIComponent(product.id)}`}>View</Link>
          </div>
        ))}
      </section>
    </Layout>
  );
}
