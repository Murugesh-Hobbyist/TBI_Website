import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function Home() {
  return (
    <Layout title="Home" description={SITE.brand.tagline}>
      <section className="hero">
        <div>
          <p className="eyebrow">{SITE.hero.eyebrow}</p>
          <h1>{SITE.hero.headline}</h1>
          <p>{SITE.hero.subhead}</p>
          <div className="header-cta" style={{ marginTop: '20px' }}>
            {SITE.hero.ctas.map((cta) => (
              <a key={cta.href} className={`btn ${cta.variant === 'outline' ? 'outline' : ''}`} href={cta.href}>
                {cta.label}
              </a>
            ))}
          </div>
          <div className="hero-metrics">
            <div className="metric">
              <strong>24/7</strong>
              <p>Support-ready automation guidance.</p>
            </div>
            <div className="metric">
              <strong>Industrial Grade</strong>
              <p>Rugged ECS builds for harsh shop floors.</p>
            </div>
            <div className="metric">
              <strong>Fast ROI</strong>
              <p>Lower PLC cost and faster decision cycles.</p>
            </div>
          </div>
        </div>
        <div className="hero-card">
          <h3>Why ECS Now</h3>
          <p>{SITE.highlights.intro}</p>
          <div className="badge-row">
            <span className="badge">Embedded Control Systems</span>
            <span className="badge">Sail OS Dashboards</span>
            <span className="badge">Automation + Measurement</span>
          </div>
        </div>
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>PLC vs ECS</h2>
            <p>See the difference in cost, integration, and control.</p>
          </div>
        </div>
        <table className="table">
          <thead>
            <tr>
              <th>Aspect</th>
              <th>PLC</th>
              <th>ECS</th>
            </tr>
          </thead>
          <tbody>
            {SITE.highlights.plcVsEcs.map((row) => (
              <tr key={row.aspect}>
                <td><strong>{row.aspect}</strong></td>
                <td>{row.plc}</td>
                <td>{row.ecs}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>Core Capabilities</h2>
            <p>Designed for production clarity and operational resilience.</p>
          </div>
          <a className="btn ghost" href="/solutions">Explore solutions</a>
        </div>
        <div className="grid">
          {SITE.highlights.keyFeatures.map((item) => (
            <div className="card" key={item.title}>
              <h3>{item.title}</h3>
              <p>{item.desc}</p>
            </div>
          ))}
        </div>
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>{SITE.sailOs.title}</h2>
            <p>{SITE.sailOs.intro}</p>
          </div>
          <a className="btn ghost" href="/videos">See demos</a>
        </div>
        <div className="grid">
          <div className="image-card">
            <img src={SITE.sailOs.screenshotUrl} alt="Sail OS dashboard" />
            <div className="content">
              <strong>Operator-first dashboards</strong>
              <p>Live metrics, alarms, and guided actions.</p>
            </div>
          </div>
          {SITE.sailOs.features.slice(0, 2).map((feature) => (
            <div className="card" key={feature.title}>
              <h3>{feature.title}</h3>
              <p>{feature.desc}</p>
            </div>
          ))}
        </div>
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>How We Deliver</h2>
            <p>Fast, clear, and production-ready.</p>
          </div>
          <a className="btn outline" href="/quote-request">Start a quote</a>
        </div>
        <div className="grid">
          {SITE.highlights.process.map((step) => (
            <div className="card" key={step.step}>
              <h3>{step.step}</h3>
              <p>{step.desc}</p>
            </div>
          ))}
        </div>
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>{SITE.trust.title}</h2>
            <p>Teams already trust TwinBot in production environments.</p>
          </div>
        </div>
        <div className="logos">
          {SITE.trust.logos.map((logo) => (
            <img key={logo.src} src={logo.src} alt={logo.alt} />
          ))}
        </div>
      </section>

      <section className="page-hero">
        <h2>Talk with our automation voice assistant</h2>
        <p>Ask about products, ECS vs PLC, or request a custom quote in seconds.</p>
        <div className="header-cta" style={{ marginTop: '18px' }}>
          <a className="btn" href="/quote-request">Request a Quote</a>
          <a className="btn outline" href="/products">Browse Products</a>
        </div>
      </section>
    </Layout>
  );
}
