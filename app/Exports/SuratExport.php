<?php

namespace App\Exports;

use App\Models\Surat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Surat::with(['user', 'kategori'])
            ->whereYear('tanggal', $this->tahun)
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Nama Surat',
            'Kategori',
            'Keterangan',
            'Dibuat Oleh',
            'Tanggal',
        ];
    }

    public function map($surat): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $surat->nomor,
            $surat->nama_surat,
            $surat->kategori->nama ?? '-',
            $surat->keterangan,
            $surat->user->name ?? '-',
            \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Baris header (baris 1) bold & background biru
            1 => [
                'font'    => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'    => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
