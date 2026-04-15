<x-admin-layout>
    <x-slot name="title">Logs</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title inline-flex items-center gap-2"><i class="fas fa-clock-rotate-left" style="color: var(--admin-primary);"></i> Activity Logs</h1>
            <p class="admin-page-desc">Riwayat aktivitas pengguna untuk aksi perubahan data.</p>
        </div>
    </div>

    <form method="GET" class="admin-card admin-card--padded mb-4 grid gap-3 md:grid-cols-[1fr_auto]">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari deskripsi, route, URL, atau user..."
            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
        >
        <button type="submit" class="admin-btn admin-btn--primary">Cari</button>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th><span class="inline-flex items-center gap-2"><i class="fas fa-calendar-day text-xs"></i> Waktu</span></th>
                    <th><span class="inline-flex items-center gap-2"><i class="fas fa-user text-xs"></i> User</span></th>
                    <th><span class="inline-flex items-center gap-2"><i class="fas fa-bolt text-xs"></i> Aksi</span></th>
                    <th><span class="inline-flex items-center gap-2"><i class="fas fa-route text-xs"></i> Route</span></th>
                    <th><span class="inline-flex items-center gap-2"><i class="fas fa-link text-xs"></i> URL</span></th>
                    <th><span class="inline-flex items-center gap-2"><i class="fas fa-network-wired text-xs"></i> IP</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    @php
                        $method = strtoupper((string) $log->method);
                        $methodBadge = match ($method) {
                            'POST' => 'bg-emerald-100 text-emerald-700',
                            'PUT', 'PATCH' => 'bg-amber-100 text-amber-700',
                            'DELETE' => 'bg-rose-100 text-rose-700',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    @endphp
                    <tr>
                        <td class="whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                {{ $log->created_at?->format('d M Y H:i:s') }}
                            </span>
                        </td>
                        <td>
                            <span class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-2.5 py-1 text-xs font-medium text-sky-700">
                                <i class="fas fa-user text-[10px]"></i> {{ $log->user?->name ?? 'System' }}
                            </span>
                        </td>
                        <td class="space-y-1">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $methodBadge }}">
                                {{ $method }}
                            </span>
                            <div class="text-xs text-slate-600">{{ $log->description }}</div>
                        </td>
                        <td>
                            @if ($log->route_name)
                                <span class="inline-flex items-center rounded-full bg-violet-100 px-2.5 py-1 text-xs font-medium text-violet-700">
                                    {{ $log->route_name }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="max-w-xs truncate" title="{{ $log->url }}">{{ $log->url }}</td>
                        <td>
                            @if ($log->ip_address)
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                    {{ $log->ip_address }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-slate-500">Belum ada activity log.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-pagination">{{ $logs->links() }}</div>
</x-admin-layout>
