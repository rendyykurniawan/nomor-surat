<x-app-layout>
    <div class="p-6">
        <div class="border-b border-slate-300 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Kategori Surat</h2>
                <a href="{{ route('kategori.create') }}"
                    class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition duration-300">
                    + Tambah Kategori
                </a>
            </div>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-6 right-6 bg-green-500 text-white text-sm px-5 py-3 rounded-lg shadow-lg z-50">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER KODE --}}
        <div class="mb-4 flex items-center gap-2">
            <span class="text-sm text-gray-500 font-medium">Filter Kode:</span>
            <form method="GET" action="{{ route('kategori.index') }}">
                <select name="kode" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Kode --</option>
                    @foreach ($kodeList as $kode)
                        <option value="{{ $kode->kode }}" {{ request('kode') == $kode->kode ? 'selected' : '' }}>
                            {{ $kode->kode }} - {{ $kode->nama }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        {{-- AKHIR FILTER --}}

        @if ($kategori->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <p class="text-lg">Belum ada kategori{{ request('kode') ? ' untuk kode ' . request('kode') : '' }}.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama Kategori</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Awalan Nomor</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($kategori as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-500">
                                    {{ ($kategori->currentPage() - 1) * $kategori->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $item->nama }}</td>
                                <td class="px-4 py-3 font-mono text-gray-600">{{ $item->awalan_nomor }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('kategori.edit', $item->id) }}"
                                            class="px-3 py-1.5 text-xs font-medium text-blue-600 border border-blue-400 rounded-lg hover:bg-blue-50 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                <span>Total: {{ $kategori->total() }} kategori</span>
                <div>{{ $kategori->links() }}</div>
            </div>
        @endif
    </div>
</x-app-layout>
