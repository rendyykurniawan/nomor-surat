{{-- create.blade.php --}}
<x-app-layout>
    <div class="p-6">
        <div class="border-b border-slate-300 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Tambah Kategori</h2>
                <a href="{{ route('kategori.index') }}" class="text-slate-600 text-sm hover:text-slate-700">← Kembali</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-300 text-red-600 text-sm rounded-lg p-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kategori.store') }}">
            @csrf
            <div class="bg-white rounded-md border border-slate-300 shadow-sm p-6 flex flex-col gap-5 w-fit">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        placeholder="Cth. Persuratan"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                {{-- BAGIAN YANG DIUBAH --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Awalan Nomor</label>
                    <div class="flex items-center gap-2">

                        {{-- Prefix statis --}}
                        <span
                            class="bg-slate-100 border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-gray-500 whitespace-nowrap">
                            WIM.16.IMI.2-
                        </span>

                        {{-- Dropdown kode (GR, UM, PW) --}}
                        <select name="kode_kategori" required
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kode --</option>
                            @foreach ($kodeList as $kode)
                                <option value="{{ $kode->kode }}"
                                    {{ old('kode_kategori') == $kode->kode ? 'selected' : '' }}>
                                    {{ $kode->kode }} - {{ $kode->nama }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Titik pemisah --}}
                        <span class="text-gray-400 font-mono font-bold">.</span>

                        {{-- Input sub-kode --}}
                        <input type="text" name="sub_kode" value="{{ old('sub_kode') }}" required
                            placeholder="Cth. 03.09"
                            class="w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <p class="text-xs text-gray-400 mt-1">
                        Nomor surat akan menjadi: WIM.16.IMI.2-[kode].[sub-kode]-001, dst.
                    </p>
                </div>
                {{-- AKHIR BAGIAN YANG DIUBAH --}}

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-slate-800 text-white text-sm py-2 px-6 rounded-lg hover:bg-slate-700 transition-all duration-500 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(30, 41, 59, 0.4)]">
                        Simpan
                    </button>
                    <a href="{{ route('kategori.index') }}"
                        class="bg-gray-100 text-gray-600 text-sm py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
