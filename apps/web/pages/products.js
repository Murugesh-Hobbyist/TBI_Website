import { useEffect, useMemo, useState } from 'react';
import Layout from '../components/Layout';
import Link from 'next/link';
import { SITE } from '../lib/siteData';

const categoryFromId = (id) => {
  if (id >= 300) return 'Accessories';
  if (id >= 200) return 'FitSense Series';
  return 'DigiDial Console';
};

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
        setProducts(SITE.productsFallback);
        setNote('Live products API is unavailable in this deployment.');
      });
  }, []);

  const grouped = useMemo(() => {
    const groups = {};
    products.forEach((product) => {
      const category = product.category || categoryFromId(product.id || 0);
      if (!groups[category]) groups[category] = [];
      groups[category].push(product);
    });
    return groups;
  }, [products]);

  return (
    <Layout title="Products" description="TwinBot products">
      <section className="page-hero">
        <h1>Products</h1>
        <p>Production-ready ECS hardware and measurement systems.</p>
        {note && <p className="status">{note}</p>}
      </section>

      {Object.keys(grouped).length === 0 && <p>No products yet.</p>}
      {Object.entries(grouped).map(([category, items]) => (
        <section key={category}>
          <div className="section-title">
            <div>
              <h2>{category}</h2>
              <p>Built for accuracy and repeatability.</p>
            </div>
            <a className="btn ghost" href="/quote-request">Request pricing</a>
          </div>
          <div className="grid">
            {items.map((product) => (
              <div className="image-card" key={product.id}>
                {product.image_url ? (
                  <img src={product.image_url} alt={product.name} />
                ) : (
                  <div style={{ height: '200px', background: '#f1ece2' }} />
                )}
                <div className="content">
                  <span className="badge">{category}</span>
                  <h3>{product.name}</h3>
                  <p>{product.description || 'Request full specifications and a pricing quote.'}</p>
                  <Link className="btn ghost" href={`/product?id=${encodeURIComponent(product.id)}`}>View details</Link>
                </div>
              </div>
            ))}
          </div>
        </section>
      ))}
    </Layout>
  );
}
