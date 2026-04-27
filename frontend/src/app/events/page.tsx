import EventCard from '@/components/cards/EventCard';
import CompactFilters from '@/components/filters/CompactFilters';
import { Calendar, Play, Clock } from 'lucide-react';
import { Suspense } from 'react';
import Link from 'next/link';

async function getEvents(searchParams: any) {
  try {
    const query = new URLSearchParams(searchParams).toString();
    const res = await fetch(`http://localhost:8000/api/events?${query}`, { cache: 'no-store' });
    if (!res.ok) throw new Error('Failed');
    return res.json();
  } catch {
    return { data: [] };
  }
}

export default async function EventsPage({ searchParams }: { searchParams: Promise<any> }) {
  const resolvedParams = await searchParams;
  const { data } = await getEvents(resolvedParams);
  const events = data || [];

  const now = new Date();
  now.setHours(0, 0, 0, 0);

  const ongoingEvents = events.filter((event: any) => {
    const startDate = new Date(event.event_date);
    startDate.setHours(0, 0, 0, 0);
    const endDate = event.end_date ? new Date(event.end_date) : startDate;
    endDate.setHours(23, 59, 59, 999);
    return now >= startDate && now <= endDate;
  });

  const upcomingEvents = events.filter((event: any) => {
    const startDate = new Date(event.event_date);
    startDate.setHours(0, 0, 0, 0);
    return startDate > now;
  });

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 w-full flex flex-col gap-10">
      {/* Header */}
      <div className="space-y-4 text-center max-w-2xl mx-auto">
        <div className="flex items-center justify-center gap-2 text-xs font-semibold uppercase tracking-widest text-brand-500">
          <Calendar className="h-4 w-4" />
          The Pulse of Dhaka
        </div>
        <h1 className="text-5xl sm:text-6xl font-extrabold tracking-tight" style={{ color: 'var(--text-primary)' }}>
          Explore Events
        </h1>
        <p className="text-lg" style={{ color: 'var(--text-muted)' }}>
          Cultural Festivals, Concerts, and Community Meetups and More.
        </p>
      </div>

      <div className="max-w-5xl mx-auto w-full">
        <Suspense fallback={<div className="h-20 bg-[var(--bg-elevated)] rounded-2xl animate-pulse" />}>
          <CompactFilters type="events" />
        </Suspense>
      </div>

      {events.length === 0 ? (
        <div className="empty-state text-center py-32 rounded-3xl border-2 border-dashed border-[var(--border)] flex flex-col items-center justify-center">
          <div className="bg-brand-500/10 p-5 rounded-full mb-6 inline-flex items-center justify-center">
            <p className="text-brand-500 font-bold text-4xl">🗓️</p>
          </div>
          <p className="text-2xl font-bold tracking-tight" style={{ color: 'var(--text-primary)' }}>No events found</p>
          <p className="mt-2 text-sm max-w-sm mx-auto" style={{ color: 'var(--text-muted)' }}>Try adjusting your filters or check back later for new vibes.</p>
          <Link
            href="/events"
            className="mt-8 px-6 py-2.5 bg-brand-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-brand-500/20 hover:bg-brand-400 transition-all block"
          >
            Show All Events
          </Link>
        </div>
      ) : (
        <div className="flex flex-col gap-16">
          {/* Ongoing Section */}
          {ongoingEvents.length > 0 && (
            <section className="space-y-8">
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-emerald-500/10 text-emerald-500">
                  <Play className="h-5 w-5 fill-current" />
                </div>
                <div>
                  <h2 className="text-3xl font-extrabold tracking-tight" style={{ color: 'var(--text-primary)' }}>
                    Happening Now
                  </h2>
                  <p className="text-sm font-medium" style={{ color: 'var(--text-muted)' }}>
                    Catch these vibes before they're gone.
                  </p>
                </div>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {ongoingEvents.map((event: any) => (
                  <EventCard key={event.id} event={event} />
                ))}
              </div>
            </section>
          )}

          {/* Upcoming Section */}
          {upcomingEvents.length > 0 && (
            <section className="space-y-8">
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-brand-500/10 text-brand-500">
                  <Clock className="h-5 w-5" />
                </div>
                <div>
                  <h2 className="text-3xl font-extrabold tracking-tight" style={{ color: 'var(--text-primary)' }}>
                    Upcoming Vibes
                  </h2>
                  <p className="text-sm font-medium" style={{ color: 'var(--text-muted)' }}>
                    Mark your calendars for these experiences.
                  </p>
                </div>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {upcomingEvents.map((event: any) => (
                  <EventCard key={event.id} event={event} />
                ))}
              </div>
            </section>
          )}

          {ongoingEvents.length === 0 && upcomingEvents.length === 0 && (
            <div className="empty-state text-center py-20 rounded-2xl">
              <p className="text-lg font-bold" style={{ color: 'var(--text-primary)' }}>No current or future events found in this category.</p>
              <p className="text-sm" style={{ color: 'var(--text-muted)' }}>Try exploring other categories or areas.</p>
            </div>
          )}
        </div>
      )}
    </div>
  );
}

