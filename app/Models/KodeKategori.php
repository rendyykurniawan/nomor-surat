<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeKategori extends Model
{
    protected $table = 'kode_kategori';
    protected $fillable = ['kode', 'nama'];

    public function kategoris()
    {
        return $this->hasMany(Kategori::class, 'kode_kategori_id');
    }
}

