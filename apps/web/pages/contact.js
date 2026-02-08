import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function Contact() {
  return (
    <Layout title="Contact" description="Contact TwinBot Innovations">
      <section className="page-hero">
        <h1>Contact</h1>
        <p>Reach us for partnerships, support, or custom ECS builds.</p>
      </section>
      <section className="grid">
        <div className="card">
          <h3>Talk to us</h3>
          <p>Email: {SITE.contact.email}</p>
          <p>Phone: {SITE.contact.phoneDisplay}</p>
          <p>Location: {SITE.contact.location}</p>
          <div className="header-cta" style={{ marginTop: '12px' }}>
            <a className="btn" href={`mailto:${SITE.contact.email}`}>Email us</a>
            <a className="btn outline" href={SITE.contact.whatsappUrl}>WhatsApp</a>
          </div>
        </div>
        <div className="card">
          <h3>Quick answers</h3>
          <div className="list">
            {SITE.faqs.slice(0, 4).map((faq) => (
              <div key={faq.q}>
                <strong>{faq.q}</strong>
                <p>{faq.a}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </Layout>
  );
}
