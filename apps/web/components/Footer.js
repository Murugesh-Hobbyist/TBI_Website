import Link from 'next/link';
import { SITE } from '../lib/siteData';

export default function Footer() {
  return (
    <footer className="footer">
      <div className="grid">
        <div>
          <strong>{SITE.brand.name}</strong>
          <p>{SITE.brand.tagline}</p>
          <p>{SITE.contact.location}</p>
        </div>
        <div>
          <p>Email: <a href={`mailto:${SITE.contact.email}`}>{SITE.contact.email}</a></p>
          <p>Phone: <a href={`tel:${SITE.contact.phoneE164}`}>{SITE.contact.phoneDisplay}</a></p>
          <p>
            WhatsApp: <a href={SITE.contact.whatsappUrl} target="_blank" rel="noreferrer">Chat now</a>
          </p>
        </div>
        <div>
          <p><strong>Quick links</strong></p>
          <div className="list">
            <Link href="/products">Products</Link>
            <Link href="/solutions">Solutions</Link>
            <Link href="/quote-request">Quote Request</Link>
            <Link href="/contact">Contact</Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
