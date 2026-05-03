<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KodeKategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    private string $prefix = 'WIM.16.IMI.2-';

    public function index()
    {
        $kategori = Kategori::latest()->paginate(10);
        return view('kategori.index', compact('kategori'));
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
        ], [
            'nama.required'          => 'Nama kategori wajib diisi.',
            'kode_kategori.required' => 'Kode kategori wajib dipilih.',
            'sub_kode.required'      => 'Sub kode wajib diisi.',
        ]);

        $awalanNomor = $this->prefix . $request->kode_kategori . '.' . $request->sub_kode;

        Kategori::create([
            'nama'         => $request->nama,
            'awalan_nomor' => $awalanNomor,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        $kodeList = KodeKategori::orderBy('kode')->get();

        // Pisahkan: WIM.16.IMI.2-GR.03.09 → kode=GR, subKode=03.09
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

        $awalanNomor = $this->prefix . $request->kode_kategori . '.' . $request->sub_kode;

        $kategori->update([
            'nama'         => $request->nama,
            'awalan_nomor' => $awalanNomor,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
