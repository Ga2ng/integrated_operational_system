<x-admin-layout>
    <x-slot name="title">Proyek</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-diagram-project" style="color: var(--admin-primary);"></i> Tracking proyek</h1>
            <p class="admin-page-desc">Status, jadwal, dan penanggung jawab.</p>
        </div>
        @can('permission', 'project.create')
            <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Tambah</a>
        @endcan
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($projects as $project)
            @php
                $isCompleted = $project->isCompleted();
                $totalTasks = (int) ($project->total_tasks ?? 0);
                $completedTasks = (int) ($project->completed_tasks ?? 0);
                $progress = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;
            @endphp

            <article class="admin-card p-5 border {{ $isCompleted ? 'border-emerald-200 bg-emerald-50/40' : 'border-slate-200' }}">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 leading-tight">{{ $project->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">PM: {{ $project->manager->name ?? 'Belum ditentukan' }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold border
                        {{ $isCompleted ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                        {{ $project->status }}
                    </span>
                </div>

                <div class="space-y-3 mb-4">
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="text-slate-500">Progress task</span>
                            <span class="font-semibold text-slate-700">{{ $progress }}%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full rounded-full transition-all {{ $isCompleted ? 'bg-emerald-500' : 'bg-[#0d7f7a]' }}" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="rounded-lg bg-slate-100 p-2">
                            <p class="text-[10px] text-slate-500 uppercase">Total</p>
                            <p class="text-sm font-bold text-slate-700">{{ $totalTasks }}</p>
                        </div>
                        <div class="rounded-lg bg-blue-50 p-2">
                            <p class="text-[10px] text-blue-500 uppercase">On Going</p>
                            <p class="text-sm font-bold text-blue-700">{{ (int) ($project->in_progress_tasks ?? 0) }}</p>
                        </div>
                        <div class="rounded-lg bg-emerald-50 p-2">
                            <p class="text-[10px] text-emerald-500 uppercase">Done</p>
                            <p class="text-sm font-bold text-emerald-700">{{ $completedTasks }}</p>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-slate-500 space-y-1.5 mb-5">
                    <p><i class="far fa-calendar mr-1.5"></i> Mulai: {{ $project->start_date?->format('d M Y') ?? '—' }}</p>
                    <p><i class="far fa-calendar-check mr-1.5"></i> Deadline: {{ $project->end_date?->format('d M Y') ?? '—' }}</p>
                </div>

                <div class="flex items-center justify-between gap-2 pt-4 border-t border-slate-100">
                    @can('permission', 'project.view')
                        <a href="{{ route('admin.projects.show', $project) }}" class="admin-btn admin-btn--ghost !px-3 !py-2 text-xs">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    @endcan

                    @can('permission', 'project.update')
                        <div class="flex items-center gap-2">
                            @if (!$isCompleted)
                                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--ghost !px-3 !py-2 text-xs">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('admin.projects.mark-completed', $project) }}" method="POST" onsubmit="return confirm('Tandai proyek ini sebagai selesai? Setelah selesai, proyek tidak bisa diedit dan task tidak bisa ditambah.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-btn admin-btn--primary !px-3 !py-2 text-xs">
                                        <i class="fas fa-check-circle"></i> Selesaikan
                                    </button>
                                </form>
                            @else
                                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-md">Terkunci (Selesai)</span>
                            @endif
                        </div>
                    @endcan
                </div>
            </article>
        @empty
            <div class="admin-card admin-card--padded text-center text-slate-500 sm:col-span-2 xl:col-span-3">
                Belum ada proyek.
            </div>
        @endforelse
    </div>
    <div class="admin-pagination">{{ $projects->links() }}</div>
</x-admin-layout>
