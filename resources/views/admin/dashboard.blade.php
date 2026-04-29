<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0d7f7a] to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/30 text-white">
                <i class="fas fa-chart-line text-lg"></i>
            </div>
            Overview
        </h1>
        <p class="text-slate-500 mt-2">Cuplikan data operasional, metrik performa, dan sertifikat terbaru.</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Total Proyek</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $projectCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#0d7f7a] text-white flex items-center justify-center text-xl shadow-md">
                    <i class="fas fa-diagram-project"></i>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">RFQ Pending</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $pendingRfqCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-md">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Material Inventory</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $inventoryCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Sertifikat Terbit</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $certifiedUsersCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xl shadow-md">
                    <i class="fas fa-certificate"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- RFQ Trends Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800"><i class="fas fa-chart-area text-[#0d7f7a] mr-2"></i> Tren RFQ (6 Bulan Terakhir)</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="rfqChart"></canvas>
            </div>
        </div>

        <!-- Project Status Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800"><i class="fas fa-chart-pie text-[#0d7f7a] mr-2"></i> Status Proyek</h3>
            </div>
            <div class="relative h-64 w-full flex items-center justify-center">
                <canvas id="projectStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Certificates -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-lg text-slate-800"><i class="fas fa-award text-emerald-500 mr-2"></i> Sertifikat Terbaru</h3>
                <a href="{{ route('admin.certificates.index') }}" class="text-sm font-semibold text-[#0d7f7a] hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-white text-slate-400 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Peserta</th>
                            <th class="px-6 py-4">Tgl Terbit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($recentCertificates as $c)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-700">{{ $c->validation_code }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $c->participant->name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $c->issued_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada sertifikat terbit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent RFQs -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-lg text-slate-800"><i class="fas fa-file-invoice text-amber-500 mr-2"></i> RFQ Terbaru</h3>
                <a href="{{ route('admin.rfqs.index') }}" class="text-sm font-semibold text-[#0d7f7a] hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-white text-slate-400 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">No. RFQ</th>
                            <th class="px-6 py-4">Klien</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($recentRfqs as $r)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-700">{{ $r->rfq_number }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $r->client->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase
                                        {{ $r->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $r->status === 'processed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $r->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $r->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $r->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada RFQ.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup RFQ Chart
            const rfqCtx = document.getElementById('rfqChart').getContext('2d');
            const rfqGradient = rfqCtx.createLinearGradient(0, 0, 0, 400);
            rfqGradient.addColorStop(0, 'rgba(13, 127, 122, 0.5)'); // Teal with opacity
            rfqGradient.addColorStop(1, 'rgba(13, 127, 122, 0)');

            new Chart(rfqCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($rfqChartLabels) !!},
                    datasets: [{
                        label: 'RFQ Masuk',
                        data: {!! json_encode($rfqChartData) !!},
                        borderColor: '#0d7f7a',
                        backgroundColor: rfqGradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0d7f7a',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { size: 13, family: 'Inter' },
                            bodyFont: { size: 14, family: 'Inter', weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#94a3b8', font: { family: 'Inter' } },
                            grid: { color: '#f1f5f9', drawBorder: false }
                        },
                        x: {
                            ticks: { color: '#94a3b8', font: { family: 'Inter' } },
                            grid: { display: false, drawBorder: false }
                        }
                    }
                }
            });

            // Setup Project Status Chart
            const projCtx = document.getElementById('projectStatusChart').getContext('2d');
            
            // Map statuses to colors
            const statusColors = {
                'draft': '#94a3b8',
                'in_progress': '#3b82f6',
                'completed': '#10b981',
                'on_hold': '#f59e0b',
                'cancelled': '#ef4444'
            };
            
            const rawLabels = {!! json_encode($projectStatusLabels) !!};
            const bgColors = rawLabels.map(label => statusColors[label] || '#0d7f7a');

            new Chart(projCtx, {
                type: 'doughnut',
                data: {
                    labels: rawLabels.map(l => l.replace('_', ' ').toUpperCase()),
                    datasets: [{
                        data: {!! json_encode($projectStatusData) !!},
                        backgroundColor: bgColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { family: 'Inter', size: 11, weight: 'bold' },
                                color: '#64748b'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { size: 13, family: 'Inter' },
                            bodyFont: { size: 14, family: 'Inter', weight: 'bold' },
                            padding: 12,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
