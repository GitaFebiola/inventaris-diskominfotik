<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'ruangan_asal_id',
        'ruangan_tujuan_id',
        'tanggal_mutasi',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'barang_id'
        );
    }

    public function ruanganAsal()
    {
        return $this->belongsTo(
            Ruangan::class,
            'ruangan_asal_id'
        );
    }

    public function ruanganTujuan()
    {
        return $this->belongsTo(
            Ruangan::class,
            'ruangan_tujuan_id'
        );
    }
}