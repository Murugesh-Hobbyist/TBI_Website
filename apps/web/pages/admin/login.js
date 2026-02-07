import { useState } from 'react';
import Layout from '../../components/Layout';

export default function AdminLogin() {
  const [status, setStatus] = useState('');

  const submit = async (event) => {
    event.preventDefault();
    const formData = new FormData(event.target);
    const payload = Object.fromEntries(formData.entries());
    const res = await fetch('/api/admin/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    if (res.ok) {
      window.location.href = '/admin';
    } else {
      setStatus('Login failed.');
    }
  };

  return (
    <Layout title="Admin Login" description="Admin login">
      <section className="page-hero">
        <h1>Admin Login</h1>
        <p>Use the admin credentials to access dashboards.</p>
      </section>
      <form className="form" onSubmit={submit}>
        <div className="row">
          <label>Email</label>
          <input name="email" type="email" required />
        </div>
        <div className="row">
          <label>Password</label>
          <input name="password" type="password" required />
        </div>
        <button className="btn" type="submit">Sign in</button>
        {status && <p className="status">{status}</p>}
      </form>
    </Layout>
  );
}
