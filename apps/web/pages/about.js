import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function About() {
  return (
    <Layout title="About" description="About TwinBot Innovations">
      <section className="page-hero">
        <h1>{SITE.about.headline}</h1>
        <p>{SITE.about.missionShort}</p>
      </section>

      <section className="grid">
        {SITE.about.values.map((value) => (
          <div className="card" key={value.title}>
            <h3>{value.title}</h3>
            <p>{value.desc}</p>
          </div>
        ))}
      </section>

      <section>
        <div className="section-title">
          <div>
            <h2>Leadership</h2>
            <p>People behind the ECS vision.</p>
          </div>
        </div>
        <div className="grid">
          {SITE.about.team.map((member) => (
            <div className="card" key={member.name}>
              <h3>{member.name}</h3>
              <p>{member.role}</p>
            </div>
          ))}
        </div>
      </section>

      <section className="card">
        <h3>Our Belief</h3>
        <p>{SITE.about.quote}</p>
      </section>
    </Layout>
  );
}
