"use client";

import { useState, useEffect } from "react";
import Cookies from "js-cookie";
import {
  Plus,
  Search,
  Edit2,
  Trash2,
  Calendar as CalendarIcon,
  MapPin,
  CheckCircle,
  Eye,
  Clock
} from "lucide-react";
import Link from "next/link";
import TablePagination from "@/components/admin/TablePagination";

interface Event {
  id: number;
  title: string;
  category: string;
  area_name: string;
  area_zone: string;
  event_date: string;
  price_type: string;
  price_amount: number;
  is_published: boolean;
}

export default function AdminEventsPage() {
  const [events, setEvents] = useState<Event[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [formData, setFormData] = useState<any>({
    title: "",
    category: "Concerts",
    description: "",
    event_date: "",
    start_time: "18:00",
    area_name: "",
    area_zone: "DNCC",
    price_type: "free",
    price_amount: 0,
    is_published: true
  });

  const [sortBy, setSortBy] = useState("id-desc");
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 8;

  const fetchEvents = async () => {
    setLoading(true);
    const token = Cookies.get('auth_token');
    try {
      const res = await fetch("http://localhost:8000/api/admin/events", {
        headers: {
          "Authorization": `Bearer ${token}`,
          "Accept": "application/json"
        }
      });
      const data = await res.json();
      if (data.status === 'success') {
        setEvents(data.data);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchEvents();
  }, []);

  useEffect(() => {
    setCurrentPage(1);
  }, [search, sortBy]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const token = Cookies.get('auth_token');
    const method = formData.id ? 'PUT' : 'POST';
    const url = formData.id
      ? `http://localhost:8000/api/admin/events/${formData.id}`
      : "http://localhost:8000/api/admin/events";

    try {
      const res = await fetch(url, {
        method,
        headers: {
          "Authorization": `Bearer ${token}`,
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify(formData)
      });
      const data = await res.json();
      if (data.status === 'success') {
        setIsModalOpen(false);
        fetchEvents();
      } else {
        alert("Error saving event: " + JSON.stringify(data.errors));
      }
    } catch (err) {
      console.error(err);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Are you sure you want to delete this event?")) return;
    const token = Cookies.get('auth_token');
    try {
      const res = await fetch(`http://localhost:8000/api/admin/events/${id}`, {
        method: 'DELETE',
        headers: {
          "Authorization": `Bearer ${token}`,
          "Accept": "application/json"
        }
      });
      if (res.ok) {
        setEvents(events.filter(e => e.id !== id));
      }
    } catch (err) {
      console.error(err);
    }
  };

  const filteredEvents = events
    .filter(e =>
      (e.title?.toLowerCase() || "").includes(search.toLowerCase()) ||
      (e.area_name?.toLowerCase() || "").includes(search.toLowerCase())
    )
    .sort((a, b) => {
      if (sortBy === "id-desc") return b.id - a.id;
      if (sortBy === "id-asc") return a.id - b.id;
      return 0;
    });

  const totalPages = Math.ceil(filteredEvents.length / itemsPerPage);
  const paginatedEvents = filteredEvents.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const openForm = (event: any = null) => {
    if (event) {
      setFormData(event);
    } else {
      setFormData({
        title: "",
        category: "Concerts",
        description: "",
        event_date: "",
        start_time: "18:00",
        area_name: "",
        area_zone: "DNCC",
        price_type: "free",
        price_amount: 0,
        is_published: true
      });
    }
    setIsModalOpen(true);
  };

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div className="flex items-center gap-4 w-full sm:w-auto">
          <div className="relative w-full sm:w-80">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[var(--text-muted)]" />
            <input
              type="text"
              placeholder="Search events..."
              className="search-input"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
            />
          </div>
          <select
            className="bg-[var(--bg-elevated)] border border-[var(--border)] rounded-xl px-4 py-2 text-sm outline-none font-bold"
            value={sortBy}
            onChange={(e) => setSortBy(e.target.value)}
          >
            <option value="id-desc">Newest First (ID)</option>
            <option value="id-asc">Oldest First (ID)</option>
          </select>
        </div>
        <button onClick={() => openForm()} className="flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-red-500/20 hover:bg-red-600 transition-all uppercase tracking-widest">
          <Plus className="h-4 w-4" /> Create New Event
        </button>
      </div>

      {/* Table Section */}
      <div className="admin-card overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-[var(--bg-default)] border-b border-[var(--border)]">
                <th className="px-6 py-4 text-xs font-black uppercase tracking-wider text-[var(--text-muted)]">ID & Event</th>
                <th className="px-6 py-4 text-xs font-black uppercase tracking-wider text-[var(--text-muted)]">Category</th>
                <th className="px-6 py-4 text-xs font-black uppercase tracking-wider text-[var(--text-muted)]">Schedule</th>
                <th className="px-6 py-4 text-xs font-black uppercase tracking-wider text-[var(--text-muted)]">Pricing</th>
                <th className="px-6 py-4 text-xs font-black uppercase tracking-wider text-[var(--text-muted)]">Created At</th>
                <th className="px-6 py-4 text-xs font-black uppercase tracking-wider text-[var(--text-muted)] text-right">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-[var(--border)]">
              {loading ? (
                Array(3).fill(0).map((_, i) => (
                  <tr key={i} className="animate-pulse"><td colSpan={6} className="px-6 py-4"><div className="h-8 bg-[var(--bg-default)] rounded-lg w-full" /></td></tr>
                ))
              ) : paginatedEvents.map((event: any) => (
                <tr key={event.id} className="hover:bg-red-500/[0.02] transition-colors group">
                  <td className="px-6 py-4">
                    <div className="font-bold text-[var(--text-primary)]">{event.title}</div>
                    <div className="text-xs text-[var(--text-muted)] font-mono">#{event.id}</div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="text-[10px] font-black uppercase px-2 py-1 bg-red-500/10 text-red-500 rounded-lg">
                      {event.category}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex flex-col gap-1">
                      <div className="flex items-center gap-1.5 text-xs font-bold text-[var(--text-primary)]">
                        <CalendarIcon className="h-3.5 w-3.5 text-red-500" />
                        {new Date(event.event_date).toLocaleDateString()}
                      </div>
                      <div className="flex items-center gap-1.5 text-[10px] text-[var(--text-muted)]">
                        <MapPin className="h-3 w-3" /> {event.area_name}
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex flex-col gap-1">
                      <span className={`text-[9px] font-black uppercase px-1.5 py-0.5 rounded-md w-fit ${event.price_type === 'free' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-blue-500/10 text-blue-500'}`}>
                        {event.price_type}
                      </span>
                      {event.price_type === 'paid' && (
                        <span className="text-xs font-bold text-[var(--text-primary)]">৳{event.price_amount}</span>
                      )}
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-1.5 text-xs text-[var(--text-muted)]">
                      <Clock className="h-3.5 w-3.5" />
                      {new Date(event.created_at).toLocaleDateString()}
                    </div>
                  </td>
                  <td className="px-6 py-4 text-right">
                    <div className="flex items-center justify-end gap-2 text-[var(--text-muted)]">
                      <Link href={`/events/${event.id}`} className="p-2 hover:text-blue-500 hover:bg-blue-500/10 rounded-lg transition-all"><Eye className="h-4 w-4" /></Link>
                      <button onClick={() => openForm(event)} className="p-2 hover:text-emerald-500 hover:bg-emerald-500/10 rounded-lg transition-all"><Edit2 className="h-4 w-4" /></button>
                      <button onClick={() => handleDelete(event.id)} className="p-2 hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-all"><Trash2 className="h-4 w-4" /></button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
        <TablePagination
          currentPage={currentPage}
          totalPages={totalPages}
          totalItems={filteredEvents.length}
          itemsPerPage={itemsPerPage}
          onPageChange={setCurrentPage}
        />
      </div>

      {/* Event Form Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
          <div className="bg-[var(--bg-elevated)] w-full max-w-3xl rounded-3xl p-8 shadow-2xl border border-[var(--border)] animate-in zoom-in-95 duration-200 overflow-y-auto max-h-[90vh]">
            <h2 className="text-2xl font-black mb-6" style={{ color: 'var(--text-primary)' }}>
              {formData.id ? 'Edit Event' : 'Launch New Event'}
            </h2>

            <form onSubmit={handleSubmit} className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div className="space-y-2 md:col-span-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Event Title</label>
                <input
                  required
                  value={formData.title}
                  onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                  placeholder="e.g. Dhaka Music Fest 2024"
                />
              </div>

              <div className="space-y-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Category</label>
                <select
                  value={formData.category}
                  onChange={(e) => setFormData({ ...formData, category: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                >
                  <option>Concerts</option>
                  <option>Art & Culture</option>
                  <option>Food & Festivals</option>
                  <option>Nightlife</option>
                  <option>Workshops</option>
                </select>
              </div>

              <div className="space-y-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Event Date</label>
                <input
                  required
                  type="date"
                  value={formData.event_date}
                  onChange={(e) => setFormData({ ...formData, event_date: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                />
              </div>

              <div className="space-y-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Area Name</label>
                <input
                  required
                  value={formData.area_name}
                  onChange={(e) => setFormData({ ...formData, area_name: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                  placeholder="e.g. Banani"
                />
              </div>
              <div className="space-y-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Area Zone</label>
                <input
                  required
                  value={formData.area_zone}
                  onChange={(e) => setFormData({ ...formData, area_zone: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                  placeholder="e.g. DNCC"
                />
              </div>

              <div className="space-y-2 md:col-span-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Description</label>
                <textarea
                  required
                  rows={3}
                  value={formData.description}
                  onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                  placeholder="Describe the event vibes..."
                />
              </div>

              <div className="space-y-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Price Type</label>
                <select
                  value={formData.price_type}
                  onChange={(e) => setFormData({ ...formData, price_type: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                >
                  <option value="free">Free</option>
                  <option value="paid">Paid</option>
                </select>
              </div>

              <div className="space-y-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">Amount (BDT)</label>
                <input
                  type="number"
                  disabled={formData.price_type === 'free'}
                  value={formData.price_amount ?? ""}
                  onChange={(e) => setFormData({ ...formData, price_amount: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all disabled:opacity-50"
                  placeholder="0"
                />
              </div>

              <div className="space-y-2 md:col-span-2">
                <label className="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">External Ticket URL</label>
                <input
                  value={formData.ticket_url ?? ""}
                  onChange={(e) => setFormData({ ...formData, ticket_url: e.target.value })}
                  className="w-full px-4 py-3 bg-[var(--bg-default)] border border-[var(--border)] rounded-xl outline-none focus:border-red-500 transition-all"
                  placeholder="https://get-tickets.com/..."
                />
              </div>

              <div className="flex gap-4 md:col-span-2 pt-6">
                <button type="button" onClick={() => setIsModalOpen(false)} className="flex-1 px-6 py-4 rounded-2xl border border-[var(--border)] font-black uppercase tracking-widest text-xs hover:bg-[var(--bg-default)] transition-all">Cancel</button>
                <button type="submit" className="flex-1 px-6 py-4 rounded-2xl bg-red-500 text-white font-black uppercase tracking-widest text-xs shadow-lg shadow-red-500/20 hover:bg-red-600 transition-all">Save {formData.id ? 'Changes' : 'Event'}</button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
