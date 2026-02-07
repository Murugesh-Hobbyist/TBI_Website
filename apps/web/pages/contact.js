import Layout from '../components/Layout';

export default function Contact() {
  return (
    <Layout title="Contact" description="Contact TBI">
      <section className="page-hero">
        <h1>Contact</h1>
        <p>Reach us for partnerships, support, or custom work.</p>
      </section>
      <section className="card">
        <p>Email: info@tbi.local</p>
        <p>Phone: (000) 000-0000</p>
        <p>Address: 123 TBI Avenue, Innovation City</p>
      </section>
    </Layout>
  );
}
