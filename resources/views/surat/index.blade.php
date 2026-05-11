<x-app-layout>
    <div class="p-6">
        <div class="border-b border-slate-300 mb-6">
            @if (auth()->user()->role == 'admin')
                <h2 class="text-xl font-bold mb-4">Data Pengambilan Nomor Surat</h2>
            @else
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold mb-4">Pengambilan Nomor Surat</h2>
                    <a href="{{ route('surat.riwayat') }}" class="text-slate-600 text-sm hover:text-slate-700">Riwayat</a>
                </div>
            @endif
        </div>

        @if (auth()->user()->role == 'admin')
            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
                {{-- Kartu Total Semua --}}
                <div
                    class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col gap-1 transition-all duratin-500 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wide">Total Semua</span>
                    <span class="text-3xl font-bold text-slate-700">{{ $totalSemua }}</span>
                    <span class="text-xs text-slate-400">surat</span>
                </div>

                @php
                    $warnaList = [
                        'blue' => [
                            'bg' => 'bg-blue-50',
                            'border' => 'border-blue-200',
                            'text' => 'text-blue-600',
                            'label' => 'text-blue-400',
                        ],
                        'green' => [
                            'bg' => 'bg-green-50',
                            'border' => 'border-green-200',
                            'text' => 'text-green-600',
                            'label' => 'text-green-400',
                        ],
                        'red' => [
                            'bg' => 'bg-red-50',
                            'border' => 'border-red-200',
                            'text' => 'text-red-600',
                            'label' => 'text-red-400',
                        ],
                        'yellow' => [
                            'bg' => 'bg-yellow-50',
                            'border' => 'border-yellow-200',
                            'text' => 'text-yellow-600',
                            'label' => 'text-yellow-400',
                        ],
                        'purple' => [
                            'bg' => 'bg-purple-50',
                            'border' => 'border-purple-200',
                            'text' => 'text-purple-600',
                            'label' => 'text-purple-400',
                        ],
                    ];
                    $warnaKeys = array_keys($warnaList);
                    $topKategori = $totalPerKategori->sortByDesc('surats_count')->take(4);
                @endphp

                @foreach ($topKategori as $i => $kat)
                    @php $w = $warnaList[$warnaKeys[$i % count($warnaKeys)]]; @endphp
                    <div class="{{ $w['bg'] }} {{ $w['border'] }} border rounded-xl p-4 flex flex-col gap-1 transition-all duration-500 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                        <span
                            class="text-xs {{ $w['label'] }} font-medium uppercase tracking-wide truncate">{{ $kat->nama }}</span>
                        <span class="text-3xl font-bold {{ $w['text'] }}">{{ $kat->surats_count }}</span>
                        <span class="text-xs {{ $w['label'] }}">surat</span>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between flex-wrap">
                <form method="GET" action="{{ route('surat.index') }}">

                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <div class="flex items-center gap-3">

                            <label class="text-sm font-medium text-gray-600">Filter Kode:</label>

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
                        </div>

                        <div class="flex gap-2 items-center">
                            <label class="text-sm font-medium text-gray-600">Filter Tahun:</label>
                            <select name="tahun" onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Tahun</option>
                                @foreach ($tahunList as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>

                            <a href="{{ route('surat.export', ['tahun' => request('tahun') ?? date('Y')]) }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-500 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export {{ request('tahun') ?? date('Y') }}
                            </a>
                        </div>

                    </div>

                </form>

                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    {{-- Search --}}
                    <form method="GET" action="{{ route('surat.index') }}" class="flex items-center gap-2">
                        @if ($kategori)
                            <input type="hidden" name="kategori" value="{{ $kategori }}">
                        @endif
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari nomor atau nama surat..."
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 w-72" />
                        <button type="submit"
                            class="px-4 py-2 text-sm bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('surat.index', ['kategori' => $kategori]) }}"
                                class="px-4 py-2 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>


            {{-- Tabel --}}
            @if ($surat->isEmpty())
                <div class="text-center py-12 text-gray-400">
                    <p class="text-lg">Belum ada data surat.</p>
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
                                    Nama Surat</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Keterangan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Dibuat Oleh</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($surat as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-gray-500">
                                        {{ ($surat->currentPage() - 1) * $surat->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 font-mono font-medium text-gray-800">{{ $item->nomor }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->nama_surat }}</td>
                                    <td class="px-4 py-3">
                                        {{-- @php
                                            $warnaList = ['blue', 'green', 'red', 'yellow', 'purple', 'indigo', 'pink'];
                                            $warna = $warnaList[($item->kategori_id - 1) % count($warnaList)];
                                        @endphp --}}
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $item->kategori->nama ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $item->keterangan }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <a href="{{ route('surat.edit', $item->id) }}"
                                                class="px-3 py-1.5 text-xs font-medium text-blue-600 border border-blue-400 rounded-lg hover:bg-blue-50 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('surat.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
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

                {{-- Footer: Total & Paginasi --}}
                <div class="mt-4 flex items-center justify-between text-sm text-gray-400">
                    <span>Menampilkan {{ $surat->firstItem() }}–{{ $surat->lastItem() }} dari {{ $surat->total() }}
                        surat</span>
                    <div>
                        {{ $surat->appends(['kategori' => $kategori])->links() }}
                    </div>
                </div>
            @endif
        @else
            <form method="POST" action="{{ route('surat.generate') }}">
                @csrf

                <div x-data="{
                    surats: [{ id: 1, kategori: '', nama_surat: '', keterangan: '' }],
                    tambah() {
                        this.surats.push({ id: this.surats.length + 1, kategori: '', nama_surat: '', keterangan: '' })
                    },
                    hapus(index) {
                        this.surats.splice(index, 1)
                        this.surats.forEach((s, i) => s.id = i + 1)
                    }
                }">

                    <!-- Tanggal Surat -->
                    <div
                        class="tanggal-surat bg-white rounded-md border border-slate-300 shadow-sm p-5 w-full sm:w-full mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                        <input type="date" name="tanggal" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Form Surat Dinamis -->
                    <div class="flex flex-col gap-4">
                        <template x-for="(surat, index) in surats" :key="surat.id">
                            <div class="flex flex-col gap-2">
                                <div
                                    class="form-surat bg-white rounded-md border border-slate-300 shadow-sm p-5 w-full relative">
                                    <!-- Nomor Urut -->
                                    <span
                                        class="text-sm font-semibold flex items-center justify-center text-white bg-[#D49A1C] w-10 h-10 rounded-full absolute top-[-13px] left-[-13px] z-10 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(212,154,28,0.4)]"
                                        x-text="surat.id"></span>

                                    <!-- Grid field: 1 kolom di HP, 3 kolom di desktop -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">

                                        <!-- Filter Kode -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih
                                                Kode</label>
                                            <select x-model="surat.filterKode"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($kodeList as $kode)
                                                    <option value="{{ $kode->kode }}">{{ $kode->kode }} -
                                                        {{ $kode->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Kategori -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis /
                                                Kategori
                                                Surat</label>
                                            <select :name="'surat[' + index + '][kategori_id]'" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($kategoriList as $kat)
                                                    @php
                                                        $kodeKat = explode(
                                                            '.',
                                                            str_replace('WIM.16.IMI.2-', '', $kat->awalan_nomor),
                                                        )[0];
                                                    @endphp
                                                    <option value="{{ $kat->id }}"
                                                        data-kode="{{ $kodeKat }}"
                                                        x-show="surat.filterKode === '' || surat.filterKode === '{{ $kodeKat }}'">
                                                        {{ $kat->nama }} ({{ $kat->awalan_nomor }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Perihal Surat -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Perihal
                                                Surat</label>
                                            <input type="text" :name="'surat[' + index + '][nama_surat]'" required
                                                placeholder="Cth. Surat Perintah Operasi..."
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        </div>

                                        <!-- Keterangan -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan
                                                (Seksi/Devisi)</label>
                                            <select :name="'surat[' + index + '][keterangan]'" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="" disabled selected>-- Pilih Seksi/Divisi --
                                                </option>
                                                <option value="TIKKIM">TIKKIM</option>
                                                <option value="INTELDAKIM">INTELDAKIM</option>
                                                <option value="TU">TU</option>
                                                <option value="LALIN">LALINTASKIM</option>
                                                <option value="LALIN">INTALTUSKIM</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <div class="mt-4 flex justify-end">
                                        <button type="button" @click="hapus(index)" x-show="surats.length > 1"
                                            class="text-red-500 hover:text-red-700 text-sm font-semibold border border-red-400 px-3 py-2 rounded hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tombol Tambah & Submit -->
                    <div class="flex gap-3 mt-4 flex-col">
                        <button type="button" @click="tambah()"
                            class="border border-gray-600  text-gray-600 text-md py-2 px-4 rounded-lg hover:bg-gray-200 w-full transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                            + Tambah Surat
                        </button>
                        <button type="submit"
                            class="border border-slate-600 bg-slate-700 text-white text-md py-2 px-4 rounded-lg  w-full transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                            Ambil Nomor
                        </button>
                    </div>

                </div>
            </form>
        @endif
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show"
                class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

                <div class="bg-white rounded-2xl shadow-xl w-full max-w-[460px] mx-4 overflow-hidden">
                    {{-- Body --}}
                    <div class="flex flex-col items-center px-8 pt-10 pb-6">

                        {{-- Icon checkmark --}}
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-5">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        {{-- Title --}}
                        <h2 class="text-slate-900 font-bold text-xl text-center mb-6">
                            Berhasil mengambil<br>nomor surat!
                        </h2>

                        {{-- Data surat --}}
                        @if (session('data_surat'))
                            @foreach (session('data_surat') as $item)
                                <div
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-6 py-4 flex flex-col gap-4 text-center mb-2">

                                    <div>
                                        <p class="text-slate-400 text-sm mb-1">Nomor surat</p>
                                        <p class="text-slate-900 font-bold text-base tracking-wide">
                                            {{ $item['nomor'] }}</p>
                                    </div>

                                    <div>
                                        <p class="text-slate-400 text-sm mb-1">Perihal</p>
                                        <p class="text-slate-900 font-bold text-base">{{ $item['nama'] }}</p>
                                    </div>

                                    <div>
                                        <p class="text-slate-400 text-sm mb-1">Keterangan</p>
                                        <p class="text-slate-900 font-bold text-base">{{ $item['keterangan'] }}</p>
                                    </div>

                                </div>
                            @endforeach
                        @endif

                        <button @click="show = false"
                            class="w-full bg-slate-900 hover:bg-[#D49A1C] text-white font-semibold text-base py-4 transition-all duration-300 rounded-md hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(212,154,28,0.4)]">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>

    @push('scripts')
        <script src="{{ asset('js/filter-kategori.js') }}"></script>
    @endpush
</x-app-layout>
