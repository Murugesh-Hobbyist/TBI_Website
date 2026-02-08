import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function Pricing() {
  return (
    <Layout title="Pricing" description="Pricing overview">
      <section className="page-hero">
        <h1>Pricing</h1>
        <p>{SITE.pricing.intro}</p>
      </section>

      <section className="grid">
        {SITE.pricing.points.map((point) => (
          <div className="card" key={point}>
            <h3>Value Focused</h3>
            <p>{point}</p>
          </div>
        ))}
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>Included In Every Engagement</h2>
            <p>Practical support and long-term reliability.</p>
          </div>
          <a className="btn" href="/quote-request">Request pricing</a>
        </div>
        <div className="grid">
          {SITE.pricing.includedFeatures.map((feature) => (
            <div className="card" key={feature.title}>
              <h3>{feature.title}</h3>
              <p>{feature.desc}</p>
            </div>
          ))}
        </div>
      </section>
    </Layout>
  );
}
