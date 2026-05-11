<x-app-layout>
    <div class="p-6">
        <div class="border-b border-slate-300 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Manajemen Pengguna</h2>
                <a href="{{ route('pengguna.create') }}"
                    class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-all duration-500 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                    + Tambah Pengguna
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-6 right-6 bg-green-500 text-white text-sm px-5 py-3 rounded-lg shadow-lg z-50">
                {{ session('success') }}
            </div>
        @endif

        @if ($users->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <p class="text-lg">Belum ada pengguna.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-500">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('pengguna.edit', $user->id) }}"
                                            class="px-3 py-1.5 text-xs font-medium text-blue-600 border border-blue-400 rounded-lg hover:bg-blue-50 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-red-600 border border-red-400 rounded-lg hover:bg-red-50 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center justify-between text-sm text-gray-400">
                <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna</span>
                <div>{{ $users->links() }}</div>
            </div>
        @endif
    </div>
</x-app-layout>