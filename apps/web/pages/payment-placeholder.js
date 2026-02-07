import Layout from '../components/Layout';

export default function PaymentPlaceholder() {
  return (
    <Layout title="Payment" description="Payment placeholder">
      <section className="page-hero">
        <h1>Payment Placeholder</h1>
        <p>This is a temporary redirect-based payment page.</p>
      </section>
      <section className="card">
        <p>Integrate your preferred payment gateway here.</p>
      </section>
    </Layout>
  );
}
