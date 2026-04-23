"use client";

import { useEffect, useState } from "react";
import Cookies from "js-cookie";
import { Users, MapPin, Calendar, MessageSquare, ArrowUpRight } from "lucide-react";

export default function AdminDashboardPage() {
  const [stats, setStats] = useState<any>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadStats() {
      const token = Cookies.get('auth_token');
      try {
        const res = await fetch("http://localhost:8000/api/admin/stats", {
          headers: {
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
          }
        });
        if (res.ok) {
          const data = await res.json();
          setStats(data.data);
        }
      } catch (err) {
        console.error("error fetching stats", err);
      } finally {
        setLoading(false);
      }
    }
    loadStats();
  }, []);

  if (loading) {
    return <div className="animate-pulse bg-[var(--bg-elevated)] h-[400px] rounded-2xl w-full" />;
  }

  const statCards = [
    { label: "Total Users", value: stats?.total_users || 0, icon: <Users className="h-6 w-6 text-red-500" />, href: "/admin/users" },
    { label: "Total Places", value: stats?.total_places || 0, icon: <MapPin className="h-6 w-6 text-red-500" />, href: "/admin/places" },
    { label: "Active Events", value: stats?.total_events || 0, icon: <Calendar className="h-6 w-6 text-red-500" />, href: "/admin/events" },
    { label: "Total Reviews", value: stats?.total_reviews || 0, icon: <MessageSquare className="h-6 w-6 text-red-500" />, href: "/admin/places" },
  ];

  return (
    <div className="space-y-6">
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {statCards.map((stat, i) => (
          <a key={i} href={stat.href} className="admin-card p-6 group">
            <div className="flex items-start justify-between">
              <div>
                <p className="text-sm font-medium text-[var(--text-muted)] mb-1">{stat.label}</p>
                <h3 className="text-3xl font-extrabold text-[var(--text-primary)]">{stat.value}</h3>
              </div>
              <div className="p-3 bg-[var(--bg-default)] rounded-xl border border-[var(--border)] group-hover:border-[var(--accent-brand)] transition-colors">
                {stat.icon}
              </div>
            </div>
            <div className="mt-4 flex items-center text-xs font-semibold text-[var(--accent-brand)] opacity-0 group-hover:opacity-100 transition-all">
              Manage {stat.label.split(' ')[1]} <ArrowUpRight className="h-3 w-3 ml-1" />
            </div>
          </a>
        ))}
      </div>

      {/* Add extra charts or data tables here in the future to satisfy complete FR-09 */}
      <div className="admin-card p-6 h-[400px] flex items-center justify-center">
        <p className="text-[var(--text-muted)] font-medium">Activity graph data will render here</p>
      </div>
    </div>
  );
}
