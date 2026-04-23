"use client";

import { useState, useEffect } from "react";
import Cookies from "js-cookie";
import { 
  User, 
  Search, 
  Ban, 
  CheckCircle2,
  Mail,
  Shield,
  ShieldAlert
} from "lucide-react";
import TablePagination from "@/components/admin/TablePagination";

interface AppUser {
  id: number;
  display_name: string;
  email: string;
  is_active: boolean;
  created_at: string;
}

export default function AdminUsersPage() {
  const [users, setUsers] = useState<AppUser[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 10;

  const fetchUsers = async () => {
    setLoading(true);
    const token = Cookies.get('auth_token');
    try {
      const res = await fetch("http://localhost:8000/api/admin/users", {
        headers: { 
          "Authorization": `Bearer ${token}`,
          "Accept": "application/json"
        }
      });
      const data = await res.json();
      if (data.status === 'success') {
        setUsers(data.data);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, []);

  useEffect(() => {
    setCurrentPage(1);
  }, [search]);

  const toggleUserStatus = async (id: number) => {
    const token = Cookies.get('auth_token');
    try {
      const res = await fetch(`http://localhost:8000/api/admin/users/${id}/toggle-status`, {
        method: 'POST',
        headers: { 
          "Authorization": `Bearer ${token}`,
          "Accept": "application/json"
        }
      });
      if (res.ok) {
        setUsers(users.map(u => u.id === id ? { ...u, is_active: !u.is_active } : u));
      }
    } catch (err) {
      console.error(err);
    }
  };

  const filteredUsers = users.filter(u => 
    u.display_name.toLowerCase().includes(search.toLowerCase()) ||
    u.email.toLowerCase().includes(search.toLowerCase())
  );

  const totalPages = Math.ceil(filteredUsers.length / itemsPerPage);
  const paginatedUsers = filteredUsers.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <div className="space-y-6">
      <div className="relative w-full sm:w-96">
        <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[var(--text-muted)]" />
        <input 
          type="text"
          placeholder="Search users..."
          className="search-input"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />
      </div>

      <div className="admin-card overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-[var(--bg-default)] border-b border-[var(--border)]">
                <th className="px-6 py-4 text-xs font-bold uppercase text-[var(--text-muted)]">User Info</th>
                <th className="px-6 py-4 text-xs font-bold uppercase text-[var(--text-muted)]">Email Address</th>
                <th className="px-6 py-4 text-xs font-bold uppercase text-[var(--text-muted)]">Joined Date</th>
                <th className="px-6 py-4 text-xs font-bold uppercase text-[var(--text-muted)]">Status</th>
                <th className="px-6 py-4 text-xs font-bold uppercase text-[var(--text-muted)] text-right">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-[var(--border)]">
              {loading ? (
                Array(3).fill(0).map((_, i) => (
                  <tr key={i} className="animate-pulse"><td colSpan={5} className="px-6 py-4"><div className="h-10 bg-[var(--bg-default)] rounded-lg w-full" /></td></tr>
                ))
              ) : paginatedUsers.map((user) => (
                <tr key={user.id} className="hover:bg-red-500/[0.02] transition-colors">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <div className="h-9 w-9 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 font-bold">
                        {user.display_name.charAt(0).toUpperCase()}
                      </div>
                      <div className="font-bold text-[var(--text-primary)]">{user.display_name}</div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-2 text-sm text-[var(--text-muted)]">
                      <Mail className="h-3.5 w-3.5" /> {user.email}
                    </div>
                  </td>
                  <td className="px-6 py-4 text-xs text-[var(--text-muted)]">
                    {new Date(user.created_at).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' })}
                  </td>
                  <td className="px-6 py-4">
                    {user.is_active ? (
                      <span className="flex items-center gap-1.5 text-emerald-500 text-[10px] font-black uppercase">
                        <Shield className="h-3.5 w-3.5" /> Active
                      </span>
                    ) : (
                      <span className="flex items-center gap-1.5 text-red-500 text-[10px] font-black uppercase">
                        <ShieldAlert className="h-3.5 w-3.5" /> Banned
                      </span>
                    )}
                  </td>
                  <td className="px-6 py-4 text-right">
                    <button 
                      onClick={() => toggleUserStatus(user.id)}
                      className={`px-4 py-1.5 rounded-lg text-xs font-bold transition-all ${user.is_active ? 'bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white' : 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white'}`}
                    >
                      {user.is_active ? 'Ban User' : 'Unban User'}
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
        <TablePagination
          currentPage={currentPage}
          totalPages={totalPages}
          totalItems={filteredUsers.length}
          itemsPerPage={itemsPerPage}
          onPageChange={setCurrentPage}
        />
      </div>
    </div>
  );
}
