import { useEffect, useState } from 'react';
import Layout from '../../components/Layout';

export default function ForumTopic({ topicId }) {
  const [posts, setPosts] = useState([]);
  const [content, setContent] = useState('');

  const load = async () => {
    const res = await fetch(`/api/forum/topics/${topicId}/posts`);
    const postData = await res.json();
    const postsWithComments = await Promise.all(
      postData.map(async (post) => {
        const commentsRes = await fetch(`/api/forum/posts/${post.id}/comments`);
        const comments = await commentsRes.json();
        return { ...post, comments };
      })
    );
    setPosts(postsWithComments);
  };

  useEffect(() => {
    if (topicId) load();
  }, [topicId]);

  const submit = async (event) => {
    event.preventDefault();
    await fetch(`/api/forum/topics/${topicId}/posts`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ content })
    });
    setContent('');
    load();
  };

  const addComment = async (postId, commentText) => {
    await fetch(`/api/forum/posts/${postId}/comments`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ content: commentText })
    });
    load();
  };

  return (
    <Layout title="Forum" description="Forum topic">
      <section className="page-hero">
        <h1>Topic #{topicId}</h1>
        <p>Join the discussion below.</p>
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
              {post.comments.map((comment) => (
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

ForumTopic.getInitialProps = ({ query }) => ({ topicId: query.id });

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
