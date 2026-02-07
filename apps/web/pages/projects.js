import Layout from '../components/Layout';

export default function Projects() {
  return (
    <Layout title="Projects" description="TBI projects">
      <section className="page-hero">
        <h1>Projects</h1>
        <p>Selected work across digital experiences, product systems, and media delivery.</p>
      </section>
      <section className="grid">
        <div className="card">
          <h3>Operations Dashboard</h3>
          <p>Unified view for inventory, orders, and customer insights.</p>
        </div>
        <div className="card">
          <h3>Commerce Studio</h3>
          <p>Multi-channel product launch and fulfillment orchestration.</p>
        </div>
        <div className="card">
          <h3>Media Pipeline</h3>
          <p>Video production and streaming automation for marketing teams.</p>
        </div>
      </section>
    </Layout>
  );
}
