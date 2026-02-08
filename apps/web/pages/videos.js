import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function Videos() {
  const demo = SITE.media.demoVideos[0];
  return (
    <Layout title="Videos" description="TwinBot product demos">
      <section className="page-hero">
        <h1>Videos</h1>
        <p>Product demonstrations and approved project samples.</p>
      </section>
      <section className="grid">
        <div className="card">
          <h3>{demo.title}</h3>
          <p>{demo.note}</p>
          <video controls preload="metadata" style={{ width: '100%', marginTop: '12px', borderRadius: '12px' }}>
            <source src={demo.src} type="video/mp4" />
            Your browser does not support the video tag.
          </video>
        </div>
        <div className="card">
          <h3>Sail OS Overview</h3>
          <p>Learn how Sail OS turns raw signals into real-time dashboards.</p>
        </div>
        <div className="card">
          <h3>FitSense Walkthrough</h3>
          <p>Understand the measurement workflow and operator experience.</p>
        </div>
      </section>
    </Layout>
  );
}
