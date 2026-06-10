<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{

    protected $fillable = [
        'kode_bmd',
        'nama_kategori'
    ];

    public function barang()
    {
        return $this->hasMany(
            Barang::class,
            'kategori_id'
        );
    }

    public function merk()
{
    return $this->hasMany(
        Merk::class,
        'kategori_id'
    );
}
}
