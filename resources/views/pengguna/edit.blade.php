<x-app-layout>
    <div class="p-6">
        <div class="border-b border-slate-300 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Edit Pengguna</h2>
                <a href="{{ route('pengguna.index') }}" class="text-slate-600 text-sm hover:text-slate-700">← Kembali</a>
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

        <form method="POST" action="{{ route('pengguna.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-md border border-slate-300 shadow-sm p-6 flex flex-col gap-5 max-w-lg">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru
                        <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span>
                    </label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 text-white text-sm py-2 px-6 rounded-lg hover:bg-blue-500 transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('pengguna.index') }}"
                        class="bg-gray-100 text-gray-600 text-sm py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>