<x-app-layout>
    <div class="py-6">
        <div class="px-6">
            <div class="border-b border-slate-300 mb-6">
                <h2 class="text-xl font-bold mb-4">Log Aktivitas</h2>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('log.index') }}" class="flex gap-3 mb-6 flex-wrap">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama pengguna..."
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />

                        <select name="modul" onchange="this.form.submit()"
                            class="border border-gray-300 rounded-lg px-6 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Modul</option>
                            @foreach ($modulList as $modul)
                                <option value="{{ $modul }}" {{ request('modul') == $modul ? 'selected' : '' }}>
                                    {{ $modul }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                            Cari
                        </button>

                        @if (request('search') || request('modul'))
                            <a href="{{ route('log.index') }}"
                                class="px-4 py-2 border border-gray-300 text-sm text-gray-600 rounded-lg hover:bg-gray-50 transition">
                                Reset
                            </a>
                        @endif
                    </form>

                    {{-- Tabel --}}
                    @if ($logs->isEmpty())
                        <div class="text-center py-12 text-gray-400">
                            <p class="text-lg">Belum ada log aktivitas.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm whitespace-nowrap">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            No</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            Pengguna</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            Aktivitas</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            Modul</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            Keterangan</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            IP Address</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                            Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($logs as $index => $log)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 text-gray-500">
                                                {{ ($logs->currentPage() - 1) * $logs->perPage() + $index + 1 }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $log->user->name ?? 'Sistem' }}
                                                <span
                                                    class="text-xs text-gray-400 block">{{ $log->user->email ?? '' }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $warna = match (true) {
                                                        str_contains($log->aktivitas, 'Membuat') => 'green',
                                                        str_contains($log->aktivitas, 'Mengedit') => 'blue',
                                                        str_contains($log->aktivitas, 'Menghapus') => 'red',
                                                        str_contains($log->aktivitas, 'Login') => 'indigo',
                                                        str_contains($log->aktivitas, 'Logout') => 'gray',
                                                        default => 'yellow',
                                                    };
                                                @endphp
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $warna }}-100 text-{{ $warna }}-700">
                                                    {{ $log->aktivitas }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">{{ $log->modul }}</td>
                                            <td class="px-4 py-3 text-gray-500">{{ $log->keterangan }}</td>
                                            <td class="px-4 py-3 text-gray-400 font-mono text-xs">
                                                {{ $log->ip_address }}</td>
                                            <td class="px-4 py-3 text-gray-400 text-xs">
                                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d F Y, H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginasi --}}
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-400">
                            <span>
                                Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }}
                                dari {{ $logs->total() }} log
                            </span>
                            <div>
                                {{ $logs->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
