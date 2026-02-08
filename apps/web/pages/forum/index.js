import { useEffect, useState } from 'react';
import Link from 'next/link';
import Layout from '../../components/Layout';

export default function Forum() {
  const [topics, setTopics] = useState([]);
  const [title, setTitle] = useState('');
  const [note, setNote] = useState('');

  const load = () => {
    fetch('/api/forum/topics')
      .then((res) => res.json())
      .then(setTopics);
  };

  useEffect(() => {
    fetch('/api/forum/topics')
      .then((res) => (res.ok ? res.json() : Promise.reject(new Error('Forum API unavailable'))))
      .then((data) => {
        setTopics(Array.isArray(data) ? data : []);
      })
      .catch(() => {
        setTopics([]);
        setNote('Forum API is unavailable in this deployment.');
      });
  }, []);

  const create = async (event) => {
    event.preventDefault();
    try {
      const res = await fetch('/api/forum/topics', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title })
      });
      if (!res.ok) throw new Error('Forum API unavailable');
      setTitle('');
      setNote('');
      load();
    } catch (err) {
      setNote('Creating topics is unavailable in this deployment.');
    }
  };

  return (
    <Layout title="Forum" description="Community forum">
      <section className="page-hero">
        <h1>Forum</h1>
        <p>Share ideas and ask questions.</p>
        {note && <p className="status">{note}</p>}
      </section>
      <form className="form" onSubmit={create}>
        <div className="row">
          <label>New topic</label>
          <input value={title} onChange={(e) => setTitle(e.target.value)} required />
        </div>
        <button className="btn" type="submit">Create topic</button>
      </form>
      <section className="card">
        {topics.length === 0 && <p>No topics yet.</p>}
        {topics.map((topic) => (
          <div key={topic.id} className="row">
            <div>
              <strong>{topic.title}</strong>
              <p>{new Date(topic.created_at).toLocaleString()}</p>
            </div>
            <Link href={`/forum-topic?id=${encodeURIComponent(topic.id)}`}>Open</Link>
          </div>
        ))}
      </section>
    </Layout>
  );
}
