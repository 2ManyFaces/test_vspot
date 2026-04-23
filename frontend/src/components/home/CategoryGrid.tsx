import Link from 'next/link';

const categories = [
  { label: 'Food & Drinks', emoji: '🍜', href: '/places?category=Food+%26+Drinks' },
  { label: 'Entertainment', emoji: '🎭', href: '/places?category=Entertainment' },
  { label: 'Culture', emoji: '🎨', href: '/places?category=Culture' },
  { label: 'Landmarks & Heritage', emoji: '🏛️', href: '/places?category=Landmarks+%26+Heritage' },
  { label: 'Outdoors', emoji: '🌿', href: '/places?category=Outdoors' },
  { label: 'Cinema & Screenings', emoji: '🎬', href: '/places?category=Cinema+%26+Screenings' },
  { label: 'Shopping', emoji: '🛍️', href: '/places?category=Shopping' },
];

export default function CategoryGrid({ categoryCounts = {} }: { categoryCounts?: any }) {
  return (
    <div className="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-7 gap-3">
      {categories.map((cat) => (
        <Link key={cat.label} href={cat.href}>
          <div
            className="group flex flex-col items-center justify-center gap-2.5 p-5 rounded-2xl text-center cursor-pointer transition-all duration-300 border-2 border-[var(--border)] hover:border-[var(--accent-brand)] hover:shadow-[0_12px_24px_-10px_rgba(0,0,0,0.5),0_0_15px_-5px_var(--accent-brand-glow)] animate-breathe hover:animate-none hover:scale-105"
            style={{
              backgroundColor: 'var(--bg-card)',
            }}
          >
            <span className="text-3xl leading-none select-none group-hover:animate-wiggle">{cat.emoji}</span>
            <div>
              <p className="text-xs font-semibold leading-tight group-hover:text-brand-400 transition-colors" style={{ color: 'var(--text-primary)' }}>
                {cat.label}
              </p>
              <p className="text-[11px] mt-0.5" style={{ color: 'var(--text-muted)' }}>
                {(categoryCounts[cat.label] || 0)}+ spots
              </p>
            </div>
          </div>
        </Link>
      ))}
    </div>
  );
}
