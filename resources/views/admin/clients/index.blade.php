<x-admin-layout>
    <x-slot name="title">Klien</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2"><i class="fa-solid fa-users text-[#0d7f7a]"></i> Data klien</h1>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2">{{ $client->name }}</td>
                        <td class="px-4 py-2">{{ $client->email }}</td>
                        <td class="px-4 py-2">{{ $client->clientProfile?->category ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $client->clientProfile?->status ?? '—' }}</td>
                        <td class="px-4 py-2 text-right">
                            @can('permission', 'client.update')
                                <a href="{{ route('admin.clients.edit', $client) }}" class="text-[#0d7f7a] hover:underline"><i class="fa-solid fa-pen"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $clients->links() }}</div>
</x-admin-layout>
