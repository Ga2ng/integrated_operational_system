<x-admin-layout>
    <x-slot name="title">Proyek</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2"><i class="fa-solid fa-diagram-project text-[#0d7f7a]"></i> Tracking proyek</h1>
        @can('permission', 'project.create')
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium hover:opacity-90">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Mulai</th>
                    <th class="px-4 py-2 text-left">Selesai</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2">{{ $project->name }}</td>
                        <td class="px-4 py-2">{{ $project->status }}</td>
                        <td class="px-4 py-2">{{ $project->start_date?->format('d M Y') ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $project->end_date?->format('d M Y') ?? '—' }}</td>
                        <td class="px-4 py-2 text-right">
                            @can('permission', 'project.update')
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-[#0d7f7a] hover:underline"><i class="fa-solid fa-pen"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $projects->links() }}</div>
</x-admin-layout>
