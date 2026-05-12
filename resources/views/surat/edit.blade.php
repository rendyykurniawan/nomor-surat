<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold mb-4">Edit Data Surat</h2>
            <a href="{{ route('surat.index') }}" class="text-slate-600 text-sm hover:text-slate-700">← Kembali</a>
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

        <form method="POST" action="{{ route('surat.update', $surat->id) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-md border border-slate-300 shadow-sm p-6 flex flex-col gap-5 max-w-2xl">

                {{-- Nomor Surat (readonly) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                    <input type="text" value="{{ $surat->nomor }}" disabled
                        class="w-full border border-gray-200 bg-gray-100 rounded-lg px-3 py-2 text-sm text-gray-500 font-mono cursor-not-allowed" />
                    <p class="text-xs text-gray-400 mt-1">Nomor surat tidak dapat diubah.</p>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                    <input type="date" name="tanggal" value="{{ $surat->tanggal }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                {{-- Kategori --}}
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ $surat->kategori_id == $kat->id ? 'selected' : '' }}>

                                {{ $kat->nama }} ({{ $kat->awalan_nomor }})

                            </option>
                        @endforeach

                    </select>
                </div> --}}
               
                <input type="hidden" name="kategori_id" value="{{ $surat->kategori_id }}" />

                {{-- Perihal Surat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perihal Surat</label>
                    <input type="text" name="nama_surat" value="{{ $surat->nama_surat }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ $surat->keterangan }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                {{-- Tombol --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-slate-800 text-white text-sm py-2 px-6 rounded-lg hover:bg-slate-700 transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('surat.index') }}"
                        class="bg-gray-100 text-gray-600 text-sm py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>

            </div>
        </form>

        {{-- Notifikasi sukses edit --}}
        @if (session('success_edit'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-6 right-6 bg-green-500 text-white text-sm px-5 py-3 rounded-lg shadow-lg">
                {{ session('success_edit') }}
            </div>
        @endif
    </div>

</x-app-layout>
