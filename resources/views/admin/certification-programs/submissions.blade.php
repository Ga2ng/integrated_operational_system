<x-admin-layout>
    <x-slot name="title">Submissions: {{ $program->name }}</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.certification-programs.index') }}" class="text-sm text-slate-500 hover:text-[#0d7f7a] mb-2 inline-block"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 class="admin-page-title"><i class="fas fa-inbox" style="color: var(--admin-primary);"></i> Review Submissions</h1>
        <p class="admin-page-desc">Program: {{ $program->name }}</p>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Peserta</th>
                    <th>Waktu Submit</th>
                    <th>Status</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $sub)
                    <tr>
                        <td>
                            <p class="font-medium text-slate-800">{{ $sub->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $sub->user->email }}</p>
                        </td>
                        <td class="text-sm text-slate-600">
                            {{ $sub->submitted_at ? $sub->submitted_at->format('d M Y, H:i') : '-' }}
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-slate-100 text-slate-600',
                                    'submitted' => 'bg-blue-100 text-blue-700',
                                    'reviewed' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-emerald-100 text-emerald-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 {{ $statusColors[$sub->status] ?? 'bg-slate-100' }} text-xs font-bold rounded uppercase">
                                {{ $sub->status }}
                            </span>
                        </td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.certification-programs.submissions.show', $sub) }}" class="admin-btn admin-btn--primary !py-1 !px-3 text-xs">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500">Belum ada submission.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $submissions->links() }}</div>
</x-admin-layout>
