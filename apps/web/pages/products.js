import Layout from '../components/Layout';
import Link from 'next/link';

export async function getServerSideProps({ req }) {
  const protocol = req.headers['x-forwarded-proto'] || 'http';
  const baseUrl = `${protocol}://${req.headers.host}`;
  const res = await fetch(`${baseUrl}/api/products`);
  const products = res.ok ? await res.json() : [];
  return { props: { products } };
}

export default function Products({ products }) {
  return (
    <Layout title="Products" description="TBI products">
      <section className="page-hero">
        <h1>Products</h1>
        <p>Browse available items and request a custom quote if you need scale.</p>
      </section>
      <section className="grid">
        {products.length === 0 && <p>No products yet. Add some in admin.</p>}
        {products.map((product) => (
          <div className="card" key={product.id}>
            <div className="image-placeholder">
              {product.image_url ? (
                <img src={product.image_url} alt={product.name} />
              ) : (
                <span>Image</span>
              )}
            </div>
            <h3>{product.name}</h3>
            <p>${Number(product.price).toFixed(2)}</p>
            <Link href={`/products/${product.id}`}>View</Link>
          </div>
        ))}
      </section>
    </Layout>
  );
}
