import Link from 'next/link';
import { SITE } from '../lib/siteData';

export default function Header() {
  return (
    <header>
      <div className="header-inner">
        <Link className="brand" href="/">
          <span className="brand-mark">TB</span>
          <span>{SITE.brand.shortName}</span>
        </Link>
        <nav className="nav">
          <Link href="/">Home</Link>
          <Link href="/solutions">Solutions</Link>
          <Link href="/projects">Projects</Link>
          <Link href="/videos">Videos</Link>
          <Link href="/products">Products</Link>
          <Link href="/pricing">Pricing</Link>
          <Link href="/about">About</Link>
          <Link href="/contact">Contact</Link>
        </nav>
        <div className="header-cta">
          <Link className="btn ghost" href="/cart">Cart</Link>
          <Link className="btn" href="/quote-request">Quote</Link>
        </div>
      </div>
    </header>
  );
}
