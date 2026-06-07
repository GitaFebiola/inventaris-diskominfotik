<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penghapusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'tanggal_penghapusan',
        'alasan',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'barang_id'
        );
    }
}
