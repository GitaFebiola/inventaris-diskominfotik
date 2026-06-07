<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'penanggung_jawab'
    ];

    public function barang()
    {
        return $this->hasMany(
            Barang::class,
            'ruangan_id'
        );
    }
}
