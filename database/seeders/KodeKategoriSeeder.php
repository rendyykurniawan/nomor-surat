<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KodeKategori;


class KodeKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'GR', 'nama' => 'Keimigrasian'],
            ['kode' => 'UM', 'nama' => 'Umum'],
            ['kode' => 'PW', 'nama' => 'Pengawasan'],
            ['kode' => 'PR', 'nama' => 'Perencanaan'],
            ['kode' => 'KU', 'nama' => 'Keuangan'],
            ['kode' => 'OT', 'nama' => 'Organisasi dan Tata Laksana'],
            ['kode' => 'SA', 'nama' => 'Sumber Daya Manusia Aparatur'],
            ['kode' => 'PB', 'nama' => 'Penatausahaan Barang Milik Negara'],
            ['kode' => 'HK', 'nama' => 'Hukum dan Kerja Sama'],
            ['kode' => 'TI', 'nama' => 'Teknologi, Informasi dan Komunikasi Publik'],
            ['kode' => 'PK', 'nama' => 'Pemasyarakatan'],
            ['kode' => 'SM', 'nama' => 'Sumber Daya Manusia'],
            ['kode' => 'LT', 'nama' => 'Penelitian dan Pengembangan'],

            // tambah kode lain di sini
        ];

        foreach ($data as $item) {
            KodeKategori::firstOrCreate(['kode' => $item['kode']], $item);
        }
    }
}
