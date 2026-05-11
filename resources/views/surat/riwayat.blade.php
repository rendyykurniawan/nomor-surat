<x-app-layout>
    <div class="py-6">
        <div class="px-6">
            <div class="border-b border-slate-300 mb-6">
                @if (auth()->user()->role == 'admin')
                    <h2 class="text-xl font-bold mb-4">Data Pengambilan Nomor Surat</h2>
                @else
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold mb-4">Riwayat Surat Anda</h2>
                    </div>
                @endif
            </div>
        </div>

        @if (auth()->user()->role == 'admin')
            {{-- halaman admin --}}
            <div>ini admin</div>
        @else
            {{-- halaman user --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        {{-- Header --}}
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-700">
                                Riwayat Surat Anda
                            </h3>
                            <a href="{{ route('surat.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-[#b57c02] text-white text-xs font-medium rounded-lg hover:bg-[#d49a1c] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(212,154,28,0.4)]">
                                + Buat Nomor Surat
                            </a>
                        </div>

                        <!-- Filter Kode -->
                        <div class="">

                            <form method="GET" action="{{ route('surat.riwayat') }}"
                                class="mb-4 flex items-center gap-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih
                                    Kode</label>
                                <select name="kode" onchange="this.form.submit()"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Kode</option>
                                    @foreach ($kodeList as $item)
                                        <option value="{{ $item->kode }}"
                                            {{ request('kode') == $item->kode ? 'selected' : '' }}>
                                            {{ $item->kode }} - {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        {{-- Tabel --}}
                        @if ($surat->isEmpty())
                            <div class="text-center py-12 text-gray-400">
                                <p class="text-lg">Belum ada riwayat surat.</p>
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
                                                Nomor Surat</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Perihal Surat</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Kategori</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Keterangan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Tanggal</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Aksi</th>
                                            {{-- <th
                                                class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Cetak</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach ($surat as $index => $item)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-4 py-3 text-gray-500">
                                                    {{ ($surat->currentPage() - 1) * $surat->perPage() + $index + 1 }}
                                                </td>
                                                <td class="px-4 py-3 font-mono font-bold text-gray-600">
                                                    {{ $item->nomor }}</td>
                                                <td class="px-4 py-3 text-gray-700">{{ $item->nama_surat }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold">
                                                        {{ $item->kategori->nama ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-gray-600">{{ $item->keterangan }}</td>
                                                <td class="px-4 py-3 text-gray-500">
                                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                </td>
                                                <!-- Modal -->
                                                <td class="px-4 py-3">
                                                    <!-- Trigger Modal -->
                                                    <button
                                                        onclick="document.getElementById('modal-mundur-{{ $item->id }}').classList.remove('hidden')"
                                                        class="bg-slate-500 rounded text-xs text-white px-3 py-1.5 hover:bg-slate-600 transition">
                                                        Ambil Surat Mundur
                                                    </button>

                                                    <!-- Modal -->
                                                    <div id="modal-mundur-{{ $item->id }}"
                                                        class="hidden fixed inset-0 bg-black/50">
                                                        <div class="flex items-center justify-center z-50 min-h-screen">
                                                            <div class="bg-white rounded-xl shadow-lg p-6 w-[450px]">
                                                                <h3 class="text-lg font-semibold text-gray-700 mb-1">
                                                                    Ambil
                                                                    Surat Mundur</h3>
                                                                <p class="text-sm text-gray-500 mb-4">
                                                                    Nomor referensi: <span
                                                                        class="font-mono font-bold text-blue-600">{{ $item->nomor }}</span>
                                                                </p>

                                                                <form method="POST"
                                                                    action="{{ route('surat.mundur', $item->id) }}">
                                                                    @csrf

                                                                    {{-- Pilih Kode --}}
                                                                    <div class="mb-3">
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 mb-1">Pilih
                                                                            Kode</label>
                                                                        <select
                                                                            onchange="filterKategori(this.value, {{ $item->id }})"
                                                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                            <option value="">-- Pilih Kode --
                                                                            </option>
                                                                            @foreach ($kodeList as $kode)
                                                                                <option value="{{ $kode->id }}">
                                                                                    {{ $kode->kode }} -
                                                                                    {{ $kode->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    {{-- Pilih Jenis Surat --}}
                                                                    <div class="mb-3">
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                                                            / Kategori Surat</label>
                                                                        <select name="kategori_id"
                                                                            id="kategori-select-{{ $item->id }}"
                                                                            required
                                                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                            <option value="">-- Pilih Kode Dulu --
                                                                            </option>
                                                                        </select>
                                                                    </div>

                                                                    {{-- Perihal Surat --}}
                                                                    <div class="mb-4">
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 mb-1">Perihal
                                                                            Surat</label>
                                                                        <input type="text" name="nama_surat" required
                                                                            placeholder="Masukkan perihal surat..."
                                                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                                                    </div>

                                                                    <div class="flex justify-end gap-2">
                                                                        <button type="button"
                                                                            onclick="document.getElementById('modal-mundur-{{ $item->id }}').classList.add('hidden')"
                                                                            class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-300 hover:shadow-lg">
                                                                            Batal
                                                                        </button>
                                                                        <button type="submit"
                                                                            class="px-4 py-2 text-sm text-white bg-slate-600 rounded-lg hover:bg-slate-700">
                                                                            Buat Surat Mundur
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                                {{-- <td class="px-4 py-3">
                                                    <a href="{{ route('surat.cetak', $item->id) }}"
                                                        class="px-3 py-1.5 text-xs font-medium text-green-600 border border-green-400 rounded-lg hover:bg-green-50 transition">
                                                        Cetak
                                                    </a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Footer: Total & Paginasi --}}
                            <div class="mt-4 flex items-center justify-between text-sm text-gray-400">
                                <span>
                                    Menampilkan {{ $surat->firstItem() }}–{{ $surat->lastItem() }}
                                    dari {{ $surat->total() }} surat
                                </span>
                                <div>
                                    {{ $surat->appends(['kode' => request('kode')])->links() }}
                                </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif

        @if (session('success_mundur'))
        <div x-data="{ show: true }" x-show="show"
            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-[400px]">
                <div class="flex justify-center">

                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>


                {{-- Title --}}
                <h2 class="text-slate-900 font-bold text-xl text-center mb-6">
                    Berhasil mengambil<br>nomor surat!
                </h2>

                @if (session('data_mundur'))
                    @php $item = session('data_mundur'); @endphp
                    <div class="bg-gray-100 p-3 rounded mb-2 text-sm text-left flex flex-col gap-1">
                        <span>
                            <p class="text-slate-700 font-semibold text-md">Nomor surat</p>
                            <p class="text-slate-500 text-md">{{ $item['nomor'] }}</p>
                        </span>
                        <span>
                            <p class="text-slate-700 font-semibold text-md">Perihal</p>
                            <p class="text-slate-500 text-md">{{ $item['nama'] }}</p>
                        </span>
                        <span>
                            <p class="text-slate-700 font-semibold text-md">Keterangan</p>
                            <p class="text-slate-500 text-md">{{ $item['keterangan'] }}</p>
                        </span>
                    </div>
                @endif

                <button @click="show = false" class="mt-4 bg-slate-600 text-white px-4 py-2 rounded w-full">
                    Tutup
                </button>
            </div>
        </div>
        @endif

    </div>

    <script>
        // Data kategori dari server
        const kategoriData = @json($kategoriList->load('kodeKategori'));

        function filterKategori(kodeId, itemId) {
            const select = document.getElementById('kategori-select-' + itemId);
            select.innerHTML = '<option value="">-- Pilih --</option>';

            if (!kodeId) return;

            const filtered = kategoriData.filter(k => k.kode_kategori_id == kodeId);

            filtered.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.id;
                opt.textContent = k.nama + ' (' + k.awalan_nomor + ')';
                select.appendChild(opt);
            });
        }
    </script>
</x-app-layout>
