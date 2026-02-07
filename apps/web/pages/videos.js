import Layout from '../components/Layout';

export default function Videos() {
  return (
    <Layout title="Videos" description="TBI videos">
      <section className="page-hero">
        <h1>Videos</h1>
        <p>Latest updates, product demonstrations, and tutorials.</p>
      </section>
      <section className="grid">
        <div className="card">
          <h3>Product Tour</h3>
          <p>Quick walkthrough of our core offerings.</p>
        </div>
        <div className="card">
          <h3>Fulfillment 101</h3>
          <p>How we scale commerce operations for growing teams.</p>
        </div>
        <div className="card">
          <h3>Customer Success</h3>
          <p>Highlights from our most recent partnerships.</p>
        </div>
      </section>
    </Layout>
  );
}
