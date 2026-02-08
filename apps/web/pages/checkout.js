import { useState } from 'react';
import Layout from '../components/Layout';

export default function Checkout() {
  const [status, setStatus] = useState('');

  const submit = async () => {
    try {
      const res = await fetch('/api/orders', { method: 'POST' });
      if (!res.ok) throw new Error('Orders API unavailable');
      const data = await res.json();
      setStatus(`Order #${data.order.id} created. Redirecting to payment placeholder...`);
      setTimeout(() => {
        window.location.href = '/payment-placeholder';
      }, 1200);
    } catch (err) {
      setStatus('Checkout is unavailable in this deployment.');
    }
  };

  return (
    <Layout title="Checkout" description="Checkout">
      <section className="page-hero">
        <h1>Checkout</h1>
        <p>Confirm your order and proceed to payment placeholder.</p>
      </section>
      <section className="card">
        <button className="btn" onClick={submit}>Place order</button>
        {status && <p className="status">{status}</p>}
      </section>
    </Layout>
  );
}
