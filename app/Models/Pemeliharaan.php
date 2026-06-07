<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeliharaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'tanggal_pemeliharaan',
        'jenis_pemeliharaan',
        'biaya',
        'keterangan',
        'status'
    ];

    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'barang_id'
        );
    }
}