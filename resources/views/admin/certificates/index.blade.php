<x-admin-layout>
    <x-slot name="title">Sertifikat</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2"><i class="fa-solid fa-award text-[#0d7f7a]"></i> Sertifikat</h1>
        @can('permission', 'certificate.create')
            <a href="{{ route('admin.certificates.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium hover:opacity-90">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Peserta</th>
                    <th class="px-4 py-2 text-left">Terbit</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $cert)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2 font-mono text-xs">{{ $cert->validation_code }}</td>
                        <td class="px-4 py-2">{{ $cert->participant->name }}</td>
                        <td class="px-4 py-2">{{ $cert->issued_at->format('d M Y') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('certificates.verify', $cert->validation_code) }}" target="_blank" class="text-gray-600 hover:underline" title="Validasi publik"><i class="fa-solid fa-magnifying-glass"></i></a>
                            @can('permission', 'certificate.update')
                                <a href="{{ route('admin.certificates.edit', $cert) }}" class="text-[#0d7f7a] hover:underline"><i class="fa-solid fa-pen"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $certificates->links() }}</div>
</x-admin-layout>
