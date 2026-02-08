import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function Solutions() {
  return (
    <Layout title="Solutions" description="TwinBot automation solutions">
      <section className="page-hero">
        <h1>{SITE.solutions.headline}</h1>
        <p>{SITE.solutions.intro}</p>
      </section>

      <section className="grid">
        {SITE.solutions.areas.map((area) => (
          <div className="card" key={area.title}>
            <h3>{area.title}</h3>
            <p>{area.desc}</p>
          </div>
        ))}
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>Sample Projects</h2>
            <p>Approved examples that show the depth of our ECS stack.</p>
          </div>
          <a className="btn ghost" href="/videos">Watch demo</a>
        </div>
        <div className="grid">
          {SITE.solutions.sampleProjects.map((project) => (
            <div className="card" key={project.title}>
              <h3>{project.title}</h3>
              <p>{project.desc}</p>
            </div>
          ))}
        </div>
      </section>
    </Layout>
  );
}
