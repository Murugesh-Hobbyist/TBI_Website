import Link from 'next/link';

export default function Header() {
  return (
    <header className="header">
      <div className="logo">TBI</div>
      <nav className="nav">
        <Link href="/">Home</Link>
        <Link href="/projects">Projects</Link>
        <Link href="/videos">Videos</Link>
        <Link href="/products">Products</Link>
        <Link href="/contact">Contact</Link>
        <Link href="/quote-request">Quote Request</Link>
        <Link href="/forum">Forum</Link>
      </nav>
      <div className="header-actions">
        <Link className="cart-link" href="/cart">Cart</Link>
        <Link className="admin-link" href="/admin">Admin</Link>
      </div>
    </header>
  );
}
