<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'kode_kategori_id',
        'nama',
        'awalan_nomor',
    ];

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function kodeKategori()
    {
        return $this->belongsTo(KodeKategori::class, 'kode_kategori_id');
    }
}
