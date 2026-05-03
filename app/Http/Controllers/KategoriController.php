<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KodeKategori;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use LogsActivity;

    private string $prefix = 'WIM.16.IMI.2-';

    public function index(Request $request)
    {
        $kodeList = KodeKategori::orderBy('kode')->get();

        $kategori = Kategori::latest()
            ->when($request->kode, fn($q, $kode) => $q->where('awalan_nomor', 'like', '%-' . $kode . '.%'))
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategori', 'kodeList'));
    }

    public function create()
    {
        $kodeList = KodeKategori::orderBy('kode')->get();
        return view('kategori.create', compact('kodeList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'kode_kategori' => 'required|string|exists:kode_kategori,kode',
            'sub_kode'      => 'required|string|max:50',
        ]);

        $awalanNomor  = $this->prefix . $request->kode_kategori . '.' . $request->sub_kode;
        $kodeKategori = KodeKategori::where('kode', $request->kode_kategori)->first();

        Kategori::create([
            'kode_kategori_id' => $kodeKategori->id,
            'nama'             => $request->nama,
            'awalan_nomor'     => $awalanNomor,
        ]);

        $this->log(
            'Membuat Kategori',
            'Kategori',
            "Kategori baru: {$request->nama} ({$awalanNomor})"
        );

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        $kodeList = KodeKategori::orderBy('kode')->get();
        $bagian   = str_replace($this->prefix, '', $kategori->awalan_nomor);
        $parts    = explode('.', $bagian, 2);
        $kodeAwal = $parts[0] ?? '';
        $subKode  = $parts[1] ?? '';

        return view('kategori.edit', compact('kategori', 'kodeList', 'kodeAwal', 'subKode'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'kode_kategori' => 'required|string|exists:kode_kategori,kode',
            'sub_kode'      => 'required|string|max:50',
        ]);

        $awalanNomor  = $this->prefix . $request->kode_kategori . '.' . $request->sub_kode;
        $kodeKategori = KodeKategori::where('kode', $request->kode_kategori)->first();

        $kategori->update([
            'kode_kategori_id' => $kodeKategori->id,
            'nama'             => $request->nama,
            'awalan_nomor'     => $awalanNomor,
        ]);

        $this->log(
            'Mengedit Kategori',
            'Kategori',
            "Kategori diedit: {$request->nama} ({$awalanNomor})"
        );

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama;
        $kategori->delete();

        $this->log(
            'Menghapus Kategori',
            'Kategori',
            "Kategori dihapus: {$nama}"
        );

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
