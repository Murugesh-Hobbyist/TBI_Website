import { useEffect, useState } from 'react';
import Layout from '../components/Layout';

export default function QuoteRequest() {
  const [products, setProducts] = useState([]);
  const [status, setStatus] = useState('');

  useEffect(() => {
    fetch('/api/products')
      .then((res) => res.json())
      .then(setProducts)
      .catch(() => setProducts([]));
  }, []);

  const submit = async (event) => {
    event.preventDefault();
    const formData = new FormData(event.target);
    try {
      const res = await fetch('/api/quotes', { method: 'POST', body: formData });
      if (!res.ok) throw new Error('Quotes API unavailable');
      setStatus('Quote submitted. We will reach out soon.');
      event.target.reset();
    } catch (err) {
      setStatus('Quote submission is unavailable in this deployment.');
    }
  };

  return (
    <Layout title="Quote Request" description="Request a quote">
      <section className="page-hero">
        <h1>Quote Request</h1>
        <p>Tell us what you need and we will send a tailored quote.</p>
      </section>
      <form className="form" onSubmit={submit}>
        <div className="row">
          <label>Name</label>
          <input name="name" required />
        </div>
        <div className="row">
          <label>Phone</label>
          <input name="phone" required />
        </div>
        <div className="row">
          <label>Email</label>
          <input name="email" type="email" required />
        </div>
        <div className="row">
          <label>Product</label>
          <select name="product_id">
            <option value="">General inquiry</option>
            {products.map((product) => (
              <option key={product.id} value={product.id}>
                {product.name}
              </option>
            ))}
          </select>
        </div>
        <div className="row">
          <label>Quantity</label>
          <input name="quantity" type="number" min="1" defaultValue="1" />
        </div>
        <div className="row">
          <label>Notes</label>
          <textarea name="notes" rows="4" />
        </div>
        <div className="row">
          <label>File Upload</label>
          <input name="file" type="file" />
        </div>
        <button className="btn" type="submit">Submit quote</button>
        {status && <p className="status">{status}</p>}
      </form>
    </Layout>
  );
}
