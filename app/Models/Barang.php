<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_register',
        'kategori_id',
        'ruangan_id',
        'nama_barang',
        'merk',
        'spesifikasi',
        'foto',
        'tahun_perolehan',
        'harga_perolehan',
        'kondisi',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function mutasis()
    {
        return $this->hasMany(Mutasi::class);
    }

    public function pemeliharaans()
    {
        return $this->hasMany(Pemeliharaan::class);
    }

    public function penghapusans()
    {
        return $this->hasMany(Penghapusan::class);
    }
}
