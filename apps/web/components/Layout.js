import Head from 'next/head';
import Header from './Header';
import Footer from './Footer';
import VoiceAssistant from './VoiceAssistant';
import { SITE } from '../lib/siteData';

export default function Layout({ title, children, description }) {
  const fullTitle = title ? `${title} | ${SITE.brand.name}` : SITE.brand.name;
  const desc = description || SITE.brand.tagline;
  return (
    <>
      <Head>
        <title>{fullTitle}</title>
        <meta name="description" content={desc} />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#d06b2e" />
        <meta property="og:site_name" content={SITE.brand.name} />
        <meta property="og:title" content={fullTitle} />
        <meta property="og:description" content={desc} />
      </Head>
      <div className="page">
        <Header />
        <main className="main">{children}</main>
        <Footer />
        <VoiceAssistant />
      </div>
    </>
  );
}
