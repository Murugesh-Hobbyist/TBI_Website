import { useEffect, useState } from 'react';
import Layout from '../components/Layout';

export default function Cart() {
  const [items, setItems] = useState([]);
  const [products, setProducts] = useState([]);
  const [note, setNote] = useState('');

  const load = async () => {
    try {
      const cartRes = await fetch('/api/cart');
      if (!cartRes.ok) throw new Error('Cart API unavailable');
      const cartData = await cartRes.json();
      setItems(cartData.items || []);

      const productsRes = await fetch('/api/products');
      const productData = productsRes.ok ? await productsRes.json() : [];
      setProducts(productData || []);
      setNote('');
    } catch (err) {
      setItems([]);
      setProducts([]);
      setNote('Cart API is unavailable in this deployment.');
    }
  };

  useEffect(() => {
    load();
  }, []);

  const total = items.reduce((sum, item) => {
    const product = products.find((p) => p.id === item.product_id);
    return sum + (product ? Number(product.price) * item.quantity : 0);
  }, 0);

  return (
    <Layout title="Cart" description="Your cart">
      <section className="page-hero">
        <h1>Cart</h1>
        <p>Review your selections before checkout.</p>
        {note && <p className="status">{note}</p>}
      </section>
      <section className="card">
        {items.length === 0 && <p>Your cart is empty.</p>}
        {items.map((item) => {
          const product = products.find((p) => p.id === item.product_id);
          return (
            <div className="row" key={item.product_id} style={{ display: 'flex', justifyContent: 'space-between' }}>
              <div>
                <strong>{product ? product.name : 'Unknown product'}</strong>
                <p>Qty: {item.quantity}</p>
              </div>
              <div>${product ? Number(product.price).toFixed(2) : '0.00'}</div>
            </div>
          );
        })}
        <div className="row total" style={{ display: 'flex', justifyContent: 'space-between', marginTop: '12px' }}>
          <strong>Total</strong>
          <strong>${total.toFixed(2)}</strong>
        </div>
        <a className="btn" href="/checkout">Proceed to checkout</a>
      </section>
    </Layout>
  );
}
