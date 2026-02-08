import Layout from '../components/Layout';
import { SITE } from '../lib/siteData';

export default function Projects() {
  return (
    <Layout title="Projects" description="TwinBot project highlights">
      <section className="page-hero">
        <h1>Projects</h1>
        <p>Selected ECS and automation builds that show our production capability.</p>
      </section>
      <section className="grid">
        {SITE.solutions.sampleProjects.map((project) => (
          <div className="card" key={project.title}>
            <h3>{project.title}</h3>
            <p>{project.desc}</p>
          </div>
        ))}
        <div className="card">
          <h3>Sail OS Deployments</h3>
          <p>Operator dashboards for data logging, reporting, and visualization.</p>
        </div>
      </section>
    </Layout>
  );
}
