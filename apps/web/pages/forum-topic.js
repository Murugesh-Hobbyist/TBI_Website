import { useEffect, useMemo, useState } from 'react';
import { useRouter } from 'next/router';
import Layout from '../components/Layout';

export default function ForumTopic() {
  const router = useRouter();
  const topicId = useMemo(() => {
    const raw = router.query?.id;
    const id = Array.isArray(raw) ? raw[0] : raw;
    const n = Number(id);
    return Number.isFinite(n) ? n : null;
  }, [router.query]);

  const [posts, setPosts] = useState([]);
  const [content, setContent] = useState('');
  const [note, setNote] = useState('');

  const load = async () => {
    if (!topicId) return;
    try {
      const res = await fetch(`/api/forum/topics/${topicId}/posts`);
      if (!res.ok) throw new Error('Forum API unavailable');
      const postData = await res.json();
      const postsWithComments = await Promise.all(
        postData.map(async (post) => {
          const commentsRes = await fetch(`/api/forum/posts/${post.id}/comments`);
          const comments = commentsRes.ok ? await commentsRes.json() : [];
          return { ...post, comments };
        })
      );
      setPosts(postsWithComments);
    } catch (err) {
      setPosts([]);
      setNote('Forum API is unavailable in this deployment.');
    }
  };

  useEffect(() => {
    if (topicId) load();
  }, [topicId]);

  const submit = async (event) => {
    event.preventDefault();
    if (!topicId) return;
    try {
      const res = await fetch(`/api/forum/topics/${topicId}/posts`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ content })
      });
      if (!res.ok) throw new Error('Forum API unavailable');
      setContent('');
      load();
    } catch (err) {
      setNote('Posting is unavailable in this deployment.');
    }
  };

  const addComment = async (postId, commentText) => {
    try {
      const res = await fetch(`/api/forum/posts/${postId}/comments`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ content: commentText })
      });
      if (!res.ok) throw new Error('Forum API unavailable');
      load();
    } catch (err) {
      setNote('Commenting is unavailable in this deployment.');
    }
  };

  if (!topicId) {
    return (
      <Layout title="Forum" description="Forum topic">
        <section className="page-hero">
          <h1>Forum</h1>
          <p>Missing topic id.</p>
        </section>
      </Layout>
    );
  }

  return (
    <Layout title="Forum" description="Forum topic">
      <section className="page-hero">
        <h1>Topic #{topicId}</h1>
        <p>Join the discussion below.</p>
        {note && <p className="status">{note}</p>}
      </section>
      <form className="form" onSubmit={submit}>
        <div className="row">
          <label>New post</label>
          <textarea value={content} onChange={(e) => setContent(e.target.value)} required />
        </div>
        <button className="btn" type="submit">Post</button>
      </form>
      <section className="card">
        {posts.length === 0 && <p>No posts yet.</p>}
        {posts.map((post) => (
          <div key={post.id} className="post">
            <p>{post.content}</p>
            <small>{new Date(post.created_at).toLocaleString()}</small>
            <div className="comments">
              {(post.comments || []).map((comment) => (
                <div key={comment.id} className="comment">
                  <p>{comment.content}</p>
                </div>
              ))}
            </div>
            <CommentForm onSubmit={(text) => addComment(post.id, text)} />
          </div>
        ))}
      </section>
    </Layout>
  );
}

function CommentForm({ onSubmit }) {
  const [value, setValue] = useState('');

  const submit = async (event) => {
    event.preventDefault();
    await onSubmit(value);
    setValue('');
  };

  return (
    <form className="comment-form" onSubmit={submit}>
      <input
        value={value}
        onChange={(e) => setValue(e.target.value)}
        placeholder="Add a comment"
        required
      />
      <button className="btn outline" type="submit">Reply</button>
    </form>
  );
}

