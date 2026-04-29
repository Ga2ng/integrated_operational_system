<x-admin-layout>
    <x-slot name="title">Detail Proyek: {{ $project->name }}</x-slot>
    @php $isCompleted = $project->isCompleted(); @endphp

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                <a href="{{ route('admin.projects.index') }}" class="hover:text-[#0d7f7a] transition-colors"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar</a>
                <span>/</span>
                <span class="text-slate-700 font-medium truncate max-w-[200px]">{{ $project->name }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800"><i class="fas fa-diagram-project mr-2" style="color: var(--admin-primary);"></i> {{ $project->name }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border 
                {{ $project->status === 'Selesai' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 
                  ($project->status === 'Berjalan' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-slate-100 text-slate-600 border-slate-200') }}">
                Status Proyek: {{ $project->status }}
            </span>
            @can('permission', 'project.update')
                @if(!$isCompleted)
                    <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--ghost"><i class="fas fa-pen"></i> Edit</a>
                    <form action="{{ route('admin.projects.mark-completed', $project) }}" method="POST" onsubmit="return confirm('Tandai proyek ini sebagai selesai? Setelah selesai, proyek tidak bisa diedit dan task tidak bisa ditambah.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-check-circle"></i> Selesaikan Proyek</button>
                    </form>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold border bg-emerald-100 text-emerald-700 border-emerald-200">
                        Proyek terkunci (Selesai)
                    </span>
                @endif
            @endcan
        </div>
    </div>

    {{-- Progress & Stats --}}
    <div class="grid lg:grid-cols-4 gap-6 mb-8">
        {{-- Progress Card --}}
        <div class="lg:col-span-2 admin-card p-6 flex flex-col justify-center bg-gradient-to-br from-teal-50 to-white border border-teal-100">
            <div class="flex justify-between items-end mb-4">
                <div>
                    <p class="text-xs font-bold text-teal-600 uppercase tracking-wider mb-1">Total Progress</p>
                    <h3 class="text-3xl font-extrabold text-slate-800">{{ $progressPercentage }}%</h3>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">{{ $completedTasks }} dari {{ $totalTasks }} Task Selesai</p>
                </div>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-3.5 mb-2 overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-teal-400 to-[#0d7f7a] h-3.5 rounded-full transition-all duration-1000" style="width: {{ $progressPercentage }}%"></div>
            </div>
        </div>

        {{-- Counters --}}
        <div class="admin-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                <i class="fas fa-spinner text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">In Progress</p>
                <p class="text-2xl font-bold text-slate-800">{{ $inProgressTasks }}</p>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-check-double text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Completed</p>
                <p class="text-2xl font-bold text-slate-800">{{ $completedTasks }}</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 items-start">
        
        {{-- LEFT COLUMN: Todo List --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-2xl">
                    <h3 class="font-bold text-slate-800"><i class="fas fa-tasks mr-2 text-slate-400"></i> Project Todo List</h3>
                    @if(!$isCompleted)
                        <button type="button" onclick="document.getElementById('addTaskForm').classList.toggle('hidden')" class="admin-btn admin-btn--primary !py-1.5 !px-3 text-xs">
                            <i class="fas fa-plus"></i> Tambah Task
                        </button>
                    @else
                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-md">Task dikunci</span>
                    @endif
                </div>

                {{-- Add Task Form (Hidden by default) --}}
                @if(!$isCompleted)
                    <div id="addTaskForm" class="hidden p-6 border-b border-slate-100 bg-teal-50/30">
                        <form action="{{ route('admin.projects.tasks.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="admin-label">Judul Task</label>
                                <input type="text" name="title" required class="admin-input" placeholder="Masukkan judul task...">
                            </div>
                            <div>
                                <label class="admin-label">Deskripsi <span class="text-slate-400 font-normal">(opsional)</span></label>
                                <textarea name="description" rows="2" class="admin-input" placeholder="Detail pekerjaan..."></textarea>
                            </div>
                            <div>
                                <label class="admin-label">Lampiran <span class="text-slate-400 font-normal">(PDF/Gambar, opsional)</span></label>
                                <input type="file" name="attachment" accept=".pdf,image/*" class="admin-input py-2 text-sm file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan Task</button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Tasks List --}}
                <div class="divide-y divide-slate-100">
                    @forelse($project->tasks as $task)
                        <div class="p-6 hover:bg-slate-50 transition-colors {{ $task->status === 'completed' ? 'opacity-70' : '' }}">
                            <div class="flex flex-col sm:flex-row gap-4 justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <h4 class="font-semibold text-slate-800 {{ $task->status === 'completed' ? 'line-through text-slate-500' : '' }}">
                                            {{ $task->title }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                                            {{ $task->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 
                                              ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600') }}">
                                            {{ str_replace('_', ' ', $task->status) }}
                                        </span>
                                    </div>
                                    @if($task->description)
                                        <p class="text-sm text-slate-500 mb-3">{{ $task->description }}</p>
                                    @endif
                                    
                                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400">
                                        <span><i class="far fa-user mr-1"></i> {{ $task->createdBy->name ?? 'Admin' }}</span>
                                        
                                        @if($task->status === 'completed' && $task->completed_at)
                                            <span class="text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-md">
                                                <i class="far fa-clock mr-1"></i> Selesai pada {{ $task->completed_at->format('d M Y, H:i') }}
                                            </span>
                                        @endif

                                        @if($task->file_path)
                                            <a href="{{ asset('storage/' . $task->file_path) }}" target="_blank" class="text-teal-600 hover:text-teal-800 font-medium bg-teal-50 px-2 py-0.5 rounded-md transition-colors flex items-center gap-1.5">
                                                @if(in_array(strtolower($task->file_type), ['jpg','jpeg','png','webp']))
                                                    <i class="fas fa-image"></i> Lihat Gambar
                                                @else
                                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                                @endif
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                {{-- Status Form --}}
                                @if(!$isCompleted)
                                    <div class="shrink-0">
                                        <form action="{{ route('admin.tasks.status.update', $task) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="text-sm border-slate-200 rounded-lg bg-white text-slate-600 py-1.5 pl-3 pr-8 focus:ring-teal-500 focus:border-teal-500 cursor-pointer shadow-sm">
                                                <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-md">Locked</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500">
                            <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-clipboard-list text-2xl text-slate-300"></i>
                            </div>
                            <p>Belum ada task untuk proyek ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Chart & Details --}}
        <div class="space-y-6">
            {{-- Chart Card --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3"><i class="fas fa-chart-pie mr-2 text-slate-400"></i> Statistik Task</h3>
                <div class="relative h-64 w-full flex items-center justify-center">
                    @if($totalTasks > 0)
                        <canvas id="taskChart"></canvas>
                    @else
                        <p class="text-sm text-slate-400 text-center">Data belum tersedia.<br>Tambahkan task untuk melihat grafik.</p>
                    @endif
                </div>
            </div>

            {{-- Project Details Info --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3"><i class="fas fa-info-circle mr-2 text-slate-400"></i> Informasi Proyek</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Manajer Proyek</p>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-[#0d7f7a] text-white flex items-center justify-center text-xs font-bold">{{ substr($project->manager->name ?? '?', 0, 1) }}</div>
                            <span class="font-medium text-slate-800 text-sm">{{ $project->manager->name ?? 'Belum Ditentukan' }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Mulai</p>
                            <p class="text-sm font-medium text-slate-800">{{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Selesai</p>
                            <p class="text-sm font-medium text-slate-800">{{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                    @if($project->scope_of_work)
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Lingkup Pekerjaan</p>
                        <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg leading-relaxed">{{ $project->scope_of_work }}</p>
                    </div>
                    @endif
                    @if($project->notes)
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Catatan Tambahan</p>
                        <p class="text-sm text-slate-700 italic border-l-4 border-slate-200 pl-3 py-1">{{ $project->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    @if($totalTasks > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('taskChart').getContext('2d');
            const data = {
                labels: ['Pending', 'In Progress', 'Completed'],
                datasets: [{
                    data: [{{ $pendingTasks }}, {{ $inProgressTasks }}, {{ $completedTasks }}],
                    backgroundColor: [
                        '#f1f5f9', // slate-100
                        '#bfdbfe', // blue-200
                        '#10b981'  // emerald-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: { size: 12, family: "'Inter', sans-serif" },
                                usePointStyle: true
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
    @endif

</x-admin-layout>
