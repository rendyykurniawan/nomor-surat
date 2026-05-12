<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use App\Models\KodeKategori;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\SuratExport;
use Maatwebsite\Excel\Facades\Excel;

class SuratController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $kategori     = $request->kategori;
        $search       = $request->search;
        $kategoriList = Kategori::all();
        $kodeList     = KodeKategori::orderBy('kode')->get();
        $kode         = $request->kode;
        $tahun        = $request->tahun;

        if (Auth::user()->role == 'admin') {
            $surat = Surat::with(['user', 'kategori.kodeKategori'])
                ->when($kategori, fn($q) => $q->where('kategori_id', $kategori))
                ->when($kode, fn($q) => $q->whereHas('kategori.kodeKategori', fn($q2) => $q2->where('kode', $kode)))
                ->when($search, fn($q) => $q->where(fn($q2) => $q2->where('nomor', 'like', "%$search%")->orWhere('nama_surat', 'like', "%$search%")))
                ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
                ->latest()
                ->paginate(10);

            $totalPerKategori = Kategori::withCount('surats')->get();
            $totalSemua       = Surat::count();

            $tahunList = Surat::selectRaw('YEAR(tanggal) as tahun')
                ->distinct()
                ->orderByDesc('tahun')
                ->pluck('tahun');

            return view('surat.index', compact(
                'surat',
                'kategori',
                'search',
                'totalPerKategori',
                'totalSemua',
                'kategoriList',
                'kodeList',
                'tahunList',
                'tahun',
                'kode' 
            ));
        }

        $surat = Surat::with('kategori')
            ->where('user_id', Auth::id())
            ->latest()->get();

        return view('surat.index', compact('surat', 'kategori', 'kategoriList', 'kodeList'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tanggal'              => 'required|date',
            'surat'                => 'required|array|min:1',
            'surat.*.kategori_id'  => 'required|exists:kategori,id',
            'surat.*.nama_surat'   => 'required|string|max:255',
            'surat.*.keterangan'   => 'required|string|max:255',
        ]);

        $nomorList = [];
        $dataNotif = [];

        DB::transaction(function () use ($request, &$nomorList, &$dataNotif) {
            foreach ($request->surat as $item) {
                $kategoriId = $item['kategori_id'];
                $kategori   = Kategori::findOrFail($kategoriId);
                $tahun      = date('Y', strtotime($request->tanggal));

                $maxUrutan    = Surat::whereYear('tanggal', $tahun)->lockForUpdate()->max('urutan') ?? 0;
                $urutan       = $maxUrutan + 1;
                $urutanFormat = str_pad($urutan, 3, '0', STR_PAD_LEFT);
                $nomorSurat   = $kategori->awalan_nomor . '-' . $urutanFormat;

                Surat::create([
                    'user_id'     => Auth::id(),
                    'tanggal'     => $request->tanggal,
                    'kategori_id' => $kategoriId,
                    'nama_surat'  => $item['nama_surat'],
                    'keterangan'  => $item['keterangan'],
                    'nomor'       => $nomorSurat,
                    'urutan'      => $urutan,
                ]);

                $nomorList[] = $nomorSurat;
                $dataNotif[] = [
                    'kategori'   => $kategori->nama,
                    'nomor'      => $nomorSurat,
                    'nama'       => $item['nama_surat'],
                    'keterangan' => $item['keterangan'],
                ];
            }
        });

        $this->log(
            'Membuat Surat',
            'Surat',
            'Nomor surat dibuat: ' . implode(', ', $nomorList)
        );

        return redirect()->back()->with([
            'success'    => 'Surat berhasil dibuat!',
            'nomor_list' => $nomorList,
            'data_surat' => $dataNotif,
        ]);
    }

    public function riwayat(Request $request)
    {
        $kategori     = $request->kategori;
        $kode         = $request->kode;
        $kategoriList = Kategori::with('kodeKategori')->get();
        $kodeList     = KodeKategori::orderBy('kode')->get();

        $surat = Surat::with('kategori')
            ->where('user_id', Auth::id())
            ->when($kategori, fn($q) => $q->where('kategori_id', $kategori))
            ->when($kode, fn($q) => $q->whereHas('kategori.kodeKategori', fn($q2) => $q2->where('kode', $kode)))
            ->latest()
            ->paginate(10);

        return view('surat.riwayat', compact('surat', 'kategori', 'kode', 'kategoriList', 'kodeList'));
    }

    public function mundur(Request $request, Surat $surat)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_surat'  => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($request->kategori_id);

        $suffixList = Surat::where('nomor_referensi', $surat->nomor)
            ->whereNotNull('suffix')
            ->pluck('suffix')
            ->toArray();

        $nextSuffix = 'A';
        if (!empty($suffixList)) {
            $lastSuffix = max($suffixList);
            $nextSuffix = chr(ord($lastSuffix) + 1);
        }

        $urutanFormat = str_pad($surat->urutan, 3, '0', STR_PAD_LEFT);
        $nomorMundur  = $kategori->awalan_nomor . '-' . $urutanFormat . $nextSuffix;

        Surat::create([
            'user_id'         => Auth::id(),
            'tanggal'         => $surat->tanggal,
            'kategori_id'     => $request->kategori_id,
            'nama_surat'      => $request->nama_surat,
            'keterangan'      => $surat->keterangan,
            'nomor'           => $nomorMundur,
            'urutan'          => $surat->urutan,
            'is_mundur'       => true,
            'suffix'          => $nextSuffix,
            'nomor_referensi' => $surat->nomor,
        ]);

        $this->log(
            'Membuat Surat Mundur',
            'Surat',
            "Surat mundur dari {$surat->nomor} → {$nomorMundur}"
        );

        return redirect()->back()->with([
            'success_mundur' => true,
            'data_mundur'    => [
                'nomor'      => $nomorMundur,
                'nama'       => $request->nama_surat,
                'keterangan' => $surat->keterangan,
            ],
        ]);
    }


    public function edit(Surat $surat)
    {
        $kategoriList = Kategori::orderBy('nama')->get();
        $kodeList     = KodeKategori::orderBy('kode')->get();
        return view('surat.edit', compact('surat', 'kategoriList', 'kodeList'));
    }

    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'kategori_id' => 'required|exists:kategori,id',
            'nama_surat'  => 'required|string|max:255',
            'keterangan'  => 'required|string|max:255',
        ]);

        $nomorLama = $surat->nomor;

        $surat->update([
            'tanggal'     => $request->tanggal,
            'kategori_id' => $request->kategori_id,
            'nama_surat'  => $request->nama_surat,
            'keterangan'  => $request->keterangan,
        ]);

        $this->log(
            'Mengedit Surat',
            'Surat',
            "Surat {$nomorLama} diedit"
        );

        return redirect()->route('surat.edit', $surat->id)->with('success_edit', 'Data surat berhasil diupdate!');
    }

    public function destroy(Surat $surat)
    {
        $nomor = $surat->nomor;
        $surat->delete();

        $this->log(
            'Menghapus Surat',
            'Surat',
            "Surat {$nomor} dihapus"
        );

        return redirect()->route('surat.index')->with('success_delete', 'Data surat berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;

        if (!$tahun) {
            return redirect()->back()->with('error', 'Pilih tahun terlebih dahulu.');
        }

        $fileName = 'data-surat-' . $tahun . '.xlsx';

        $this->log(
            'Export Surat',
            'Surat',
            "Data surat tahun {$tahun} diekspor ke Excel"
        );

        return Excel::download(new SuratExport($tahun), $fileName);
    }
}
