import { useEffect, useState } from 'react';
import Layout from '../../components/Layout';

export default function AdminDashboard() {
  const [user, setUser] = useState(null);
  const [products, setProducts] = useState([]);
  const [quotes, setQuotes] = useState([]);
  const [orders, setOrders] = useState([]);

  useEffect(() => {
    fetch('/api/admin/me')
      .then((res) => (res.ok ? res.json() : Promise.reject()))
      .then((data) => setUser(data.user))
      .catch(() => {
        window.location.href = '/admin/login';
      });
  }, []);

  useEffect(() => {
    if (!user) return;
    fetch('/api/products')
      .then((res) => res.json())
      .then(setProducts);
    fetch('/api/admin/quotes')
      .then((res) => res.json())
      .then(setQuotes);
    fetch('/api/admin/orders')
      .then((res) => res.json())
      .then(setOrders);
  }, [user]);

  const logout = async () => {
    await fetch('/api/admin/logout', { method: 'POST' });
    window.location.href = '/admin/login';
  };

  return (
    <Layout title="Admin" description="Admin dashboard">
      <section className="page-hero">
        <h1>Admin Dashboard</h1>
        <p>Manage quotes, orders, and forum moderation.</p>
        <button className="btn outline" onClick={logout}>Logout</button>
      </section>

      <section className="card">
        <h3>Products</h3>
        {products.length === 0 && <p>No products yet.</p>}
        {products.map((product) => (
          <div key={product.id} className="row">
            <div>
              <strong>{product.name}</strong>
              <p>${Number(product.price).toFixed(2)}</p>
            </div>
            <div>{product.is_active ? 'Active' : 'Inactive'}</div>
          </div>
        ))}
      </section>

      <section className="card">
        <h3>Quotes</h3>
        {quotes.length === 0 && <p>No quotes yet.</p>}
        {quotes.map((quote) => (
          <div key={quote.id} className="row">
            <div>
              <strong>{quote.name}</strong>
              <p>{quote.product_name || 'General inquiry'}</p>
            </div>
            <div>{quote.status}</div>
          </div>
        ))}
      </section>

      <section className="card">
        <h3>Orders</h3>
        {orders.length === 0 && <p>No orders yet.</p>}
        {orders.map((order) => (
          <div key={order.id} className="row">
            <div>
              <strong>Order #{order.id}</strong>
              <p>{order.status}</p>
            </div>
            <div>${Number(order.total).toFixed(2)}</div>
          </div>
        ))}
      </section>
    </Layout>
  );
}
