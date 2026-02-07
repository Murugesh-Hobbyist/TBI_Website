import Head from 'next/head';
import Header from './Header';
import Footer from './Footer';

export default function Layout({ title, children, description }) {
  return (
    <>
      <Head>
        <title>{title ? `${title} | TBI Website` : 'TBI Website'}</title>
        <meta name="description" content={description || 'TBI website'} />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
      </Head>
      <div className="page">
        <Header />
        <main className="main">{children}</main>
        <Footer />
      </div>
    </>
  );
}
