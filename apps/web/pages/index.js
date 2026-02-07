import Layout from '../components/Layout';
import VoiceAssistant from '../components/VoiceAssistant';

export default function Home() {
  return (
    <Layout title="Home" description="TBI digital services and products">
      <section className="hero">
        <div>
          <p className="eyebrow">Technology by TBI</p>
          <h1>Build, ship, and support with one connected team.</h1>
          <p>
            We design products, ship media, and guide every customer through a clear path to
            purchase or quotation.
          </p>
          <div className="hero-actions">
            <a className="btn" href="/products">
              Explore Products
            </a>
            <a className="btn outline" href="/quote-request">
              Request a Quote
            </a>
          </div>
        </div>
        <div className="hero-card">
          <h3>Next release</h3>
          <p>Launch-ready solutions for modern businesses.</p>
          <ul>
            <li>Project planning & delivery</li>
            <li>Media and content production</li>
            <li>Product sourcing & fulfillment</li>
          </ul>
        </div>
      </section>

      <section className="grid">
        <div className="card">
          <h3>Projects</h3>
          <p>Showcase of our latest builds and client results.</p>
          <a href="/projects">View projects</a>
        </div>
        <div className="card">
          <h3>Videos</h3>
          <p>Product demos, tutorials, and behind-the-scenes updates.</p>
          <a href="/videos">Watch videos</a>
        </div>
        <div className="card">
          <h3>Products</h3>
          <p>Browse the catalog and build your cart in seconds.</p>
          <a href="/products">Shop now</a>
        </div>
      </section>

      <section className="voice-section">
        <VoiceAssistant />
      </section>
    </Layout>
  );
}
