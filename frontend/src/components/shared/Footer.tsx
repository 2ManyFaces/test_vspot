"use client";

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { MapPin } from 'lucide-react';

// Social icons as inline SVGs (not available in lucide-react)
const socialIcons = {
  Instagram: (p: any) => (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" {...p}>
      <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
    </svg>
  ),
  Facebook: (p: any) => (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" {...p}>
      <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
    </svg>
  ),
  Twitter: (p: any) => (
    <svg viewBox="0 0 24 24" fill="currentColor" {...p}>
      <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
    </svg>
  ),
  Youtube: (p: any) => (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" {...p}>
      <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/>
    </svg>
  ),
};

const footerLinks = {
  Discover: [
    { label: 'Places', href: '/places' },
    { label: 'Events', href: '/events' },
    { label: 'Blog & Guides', href: '/blog' },
    { label: 'Neighbourhoods', href: '/places?area=Gulshan' },
  ],
  Company: [
    { label: 'About VibeSpot', href: '/about' },
    { label: 'List Your Place', href: '/for-owners' },
    { label: 'Advertise', href: '/advertise' },
    { label: 'Contact Us', href: '/contact' },
  ],
  Legal: [
    { label: 'Privacy Policy', href: '/privacy' },
    { label: 'Terms of Use', href: '/terms' },
    { label: 'Cookie Policy', href: '/cookies' },
  ],
};

const socials = [
  { key: 'Instagram' as const, href: 'https://instagram.com', label: 'Instagram' },
  { key: 'Facebook' as const, href: 'https://facebook.com', label: 'Facebook' },
  { key: 'Twitter' as const, href: 'https://twitter.com', label: 'Twitter / X' },
  { key: 'Youtube' as const, href: 'https://youtube.com', label: 'YouTube' },
];

export default function Footer() {
  const pathname = usePathname();
  const isAdmin = pathname.startsWith('/admin');

  if (isAdmin) return null;

  return (
    <footer className="mt-auto" style={{ backgroundColor: 'var(--bg-card)' }}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12">

          {/* Brand column */}
          <div className="lg:col-span-2 space-y-5">
            <div className="flex items-center gap-2.5">
              <div className="w-9 h-9 bg-brand-600 rounded-xl flex items-center justify-center shadow-[0_0_12px_rgba(124,58,237,0.3)]">
                <MapPin className="h-4 w-4 text-white" />
              </div>
              <span className="text-lg font-bold" style={{ color: 'var(--text-primary)' }}>
                Vibe<span className="text-brand-500">Spot</span>
              </span>
            </div>
            <p className="text-sm leading-relaxed max-w-xs" style={{ color: 'var(--text-muted)' }}>
              Dhaka's community-powered platform for discovering the best places, events, and hidden gems — curated by locals, for locals.
            </p>
            {/* Social Links */}
            <div className="flex items-center gap-3 pt-2">
              {socials.map(({ key, href, label }) => {
                const Icon = socialIcons[key];
                return (
                  <a
                    key={label}
                    href={href}
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label={label}
                    className="w-10 h-10 rounded-xl flex items-center justify-center hover:text-brand-400 transition-all duration-200"
                    style={{ backgroundColor: 'var(--bg-elevated)', color: 'var(--text-muted)' }}
                  >
                    <Icon className="h-4 w-4" />
                  </a>
                );
              })}
            </div>
          </div>

          {/* Link columns */}
          {Object.entries(footerLinks).map(([title, links]) => (
            <div key={title} className="space-y-4">
              <h4 className="text-sm font-semibold uppercase tracking-widest" style={{ color: 'var(--text-primary)' }}>
                {title}
              </h4>
              <ul className="space-y-3">
                {links.map((link) => (
                  <li key={link.label}>
                    <Link
                      href={link.href}
                      className="text-sm hover:text-brand-400 transition-colors duration-200"
                      style={{ color: 'var(--text-muted)' }}
                    >
                      {link.label}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        {/* Bottom bar */}
        <div className="mt-14 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style={{ borderTop: '1px solid var(--border)' }}>
          <p className="text-xs" style={{ color: 'var(--text-muted)' }}>
            &copy; {new Date().getFullYear()} VibeSpot Technologies Ltd. All rights reserved. Dhaka, Bangladesh.
          </p>
          <div className="flex items-center gap-1 text-xs" style={{ color: 'var(--text-muted)' }}>
            <span>Serving</span>
            <span className="text-brand-500 font-semibold mx-1">DNCC &amp; DSCC</span>
            <span>— Phase 1</span>
          </div>
        </div>
      </div>
    </footer>
  );
}
