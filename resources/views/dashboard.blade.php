<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0d7f7a] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-gauge"></i> {{ __('Dashboard Customer') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome & Action Buttons Row -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-teal-50 to-transparent opacity-50"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold text-slate-800">Halo, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-slate-500 mt-1">Selamat datang di portal operasional Anda. Apa yang ingin Anda lakukan hari ini?</p>
                </div>
                <div class="relative z-10 flex flex-wrap gap-3">
                    <a href="{{ route('dashboard.rfqs.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#0d7f7a] to-teal-600 text-white px-5 py-2.5 text-sm font-bold hover:shadow-lg hover:shadow-teal-500/30 transition-all">
                        <i class="fa-solid fa-plus"></i> Buat RFQ Baru
                    </a>
                    <a href="{{ route('dashboard.my-certifications.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 text-white px-5 py-2.5 text-sm font-bold hover:shadow-lg hover:shadow-slate-500/30 transition-all">
                        <i class="fa-solid fa-file-signature"></i> Cek Penugasan
                    </a>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- KPI 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total RFQ Anda</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $totalRfqs }}</h3>
                    </div>
                </div>

                <!-- KPI 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-2xl">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Tugas Pending</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $pendingCertifications->count() }}</h3>
                    </div>
                </div>

                <!-- KPI 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Sertifikat Diraih</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $certificates->count() }}</h3>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column (Chart & Pending Tasks) -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Chart Status RFQ -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-chart-bar text-[#0d7f7a] mr-2"></i> Status RFQ Anda</h3>
                        @if($totalRfqs > 0)
                            <div class="relative h-48 w-full">
                                <canvas id="rfqCustomerChart"></canvas>
                            </div>
                        @else
                            <div class="h-48 flex flex-col items-center justify-center text-slate-400 text-sm">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                                Belum ada data RFQ
                            </div>
                        @endif
                    </div>

                    <!-- Pending Certifications -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-amber-50/50">
                            <h3 class="font-bold text-slate-800"><i class="fas fa-bell text-amber-500 mr-2"></i> Penugasan Perlu Tindakan</h3>
                        </div>
                        <ul class="divide-y divide-slate-50">
                            @forelse ($pendingCertifications as $pc)
                                <li class="p-5 hover:bg-slate-50 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-bold text-slate-800 text-sm">{{ $pc->program->name }}</span>
                                        @if($pc->status === 'rejected')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700">REVISI</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('dashboard.my-certifications.show', $pc) }}" class="text-xs font-bold text-[#0d7f7a] hover:underline flex items-center gap-1 mt-2">
                                        Kerjakan Sekarang <i class="fas fa-arrow-right"></i>
                                    </a>
                                </li>
                            @empty
                                <li class="p-6 text-center text-slate-400 text-sm">
                                    <i class="fas fa-check-circle text-2xl text-emerald-300 mb-2 block"></i>
                                    Semua tugas sudah diselesaikan.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Right Column (Tables) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- RFQ List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-slate-800"><i class="fas fa-file-invoice text-blue-500 mr-2"></i> Pengajuan RFQ Terakhir</h3>
                            <a href="{{ route('dashboard.rfqs.index') }}" class="text-sm font-semibold text-[#0d7f7a] hover:underline">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3">No. RFQ</th>
                                        <th class="px-6 py-3">Judul Permintaan</th>
                                        <th class="px-6 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($rfqs as $rfq)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-mono font-bold text-slate-700">{{ $rfq->rfq_number ?? '-' }}</td>
                                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $rfq->request_title }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-wider uppercase
                                                    {{ $rfq->status === 'pending' ? 'bg-amber-100 text-amber-800 border border-amber-200' : '' }}
                                                    {{ $rfq->status === 'processed' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                                    {{ $rfq->status === 'completed' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}
                                                    {{ $rfq->status === 'rejected' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}">
                                                    {{ $rfq->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                                                <i class="fas fa-folder-open text-3xl mb-3 opacity-30 block"></i>
                                                Anda belum pernah mengajukan RFQ.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Certificates List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-slate-800"><i class="fas fa-award text-emerald-500 mr-2"></i> Sertifikat Anda</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3">Kode Validasi</th>
                                        <th class="px-6 py-3">Program</th>
                                        <th class="px-6 py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($certificates as $cert)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-mono font-bold text-[#0d7f7a]">{{ $cert->validation_code }}</td>
                                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $cert->certificationProgram->name ?? 'Proyek Khusus' }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('certificates.verify', $cert->validation_code) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                                                    <i class="fas fa-external-link-alt"></i> Cek
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">
                                                Anda belum memiliki sertifikat yang diterbitkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if($totalRfqs > 0)
    <!-- Chart.js Script for Customer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('rfqCustomerChart').getContext('2d');
            
            const rawLabels = {!! json_encode($rfqStatusLabels) !!};
            
            // Map statuses to nice colors
            const statusColors = {
                'pending': '#f59e0b',
                'processed': '#3b82f6',
                'completed': '#10b981',
                'rejected': '#ef4444'
            };
            
            const bgColors = rawLabels.map(label => statusColors[label] || '#0d7f7a');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: rawLabels.map(l => l.toUpperCase()),
                    datasets: [{
                        label: 'Jumlah RFQ',
                        data: {!! json_encode($rfqStatusData) !!},
                        backgroundColor: bgColors,
                        borderRadius: 6,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { size: 12, family: 'Inter' },
                            bodyFont: { size: 13, family: 'Inter', weight: 'bold' },
                            padding: 10,
                            cornerRadius: 6,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#94a3b8', font: { family: 'Inter' }, stepSize: 1 },
                            grid: { color: '#f1f5f9', drawBorder: false }
                        },
                        x: {
                            ticks: { color: '#64748b', font: { family: 'Inter', size: 10, weight: 'bold' } },
                            grid: { display: false, drawBorder: false }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>
