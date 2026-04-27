"use client";

interface TablePaginationProps {
  currentPage: number;
  totalPages: number;
  totalItems: number;
  itemsPerPage: number;
  onPageChange: (page: number) => void;
}

export default function TablePagination({
  currentPage,
  totalPages,
  totalItems,
  itemsPerPage,
  onPageChange,
}: TablePaginationProps) {
  if (totalItems <= itemsPerPage) return null;

  return (
    <div className="px-6 py-4 flex items-center justify-between border-t border-[var(--border)] bg-[var(--bg-default)]/50">
      <div className="text-xs font-bold text-[var(--text-muted)]">
        Showing {(currentPage - 1) * itemsPerPage + 1} to {Math.min(currentPage * itemsPerPage, totalItems)} of {totalItems} entries
      </div>
      <div className="flex gap-2">
        <button
          disabled={currentPage === 1}
          onClick={() => onPageChange(currentPage - 1)}
          className="px-3 py-1.5 rounded-lg border border-[var(--border)] text-xs font-black uppercase tracking-widest disabled:opacity-50 hover:bg-[var(--bg-elevated)] transition-all"
        >
          Prev
        </button>
        {Array.from({ length: totalPages }, (_, i) => i + 1).map(page => (
          <button
            key={page}
            onClick={() => onPageChange(page)}
            className={`w-8 h-8 rounded-lg text-xs font-black transition-all ${
              currentPage === page
                ? 'bg-red-500 text-white'
                : 'border border-[var(--border)] text-[var(--text-muted)] hover:bg-[var(--bg-elevated)]'
            }`}
          >
            {page}
          </button>
        ))}
        <button
          disabled={currentPage === totalPages}
          onClick={() => onPageChange(currentPage + 1)}
          className="px-3 py-1.5 rounded-lg border border-[var(--border)] text-xs font-black uppercase tracking-widest disabled:opacity-50 hover:bg-[var(--bg-elevated)] transition-all"
        >
          Next
        </button>
      </div>
    </div>
  );
}

