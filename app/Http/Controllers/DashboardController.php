<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Mutasi;
use App\Models\Pemeliharaan;
use App\Models\Penghapusan;

class DashboardController extends Controller
{
    public function index()
    {
        // DIUBAH: Menghitung barang yang statusnya BUKAN 'Dihapus'
        $totalBarang = Barang::where('status', '!=', 'Dihapus')->count();

        // DIUBAH: Menghitung nilai aset yang statusnya BUKAN 'Dihapus' (Agar data seimbang)
        $totalNilaiAset = Barang::where('status', '!=', 'Dihapus')
            ->sum('harga_perolehan');

        $totalPerbaikan = Barang::where(
            'status',
            'Perbaikan'
        )->count();

        $totalDihapus = Barang::where(
            'status',
            'Dihapus'
        )->count();

        $aktivitas = collect();

        /*
        |--------------------------------------------------------------------------
        | Pengadaan Barang
        |--------------------------------------------------------------------------
        */

        foreach (
            Barang::latest()
                ->take(5)
                ->get()
            as $item
        ) {

            $aktivitas->push([
                'tanggal' => $item->created_at,
                'nomor_register' => $item->nomor_register,
                'aksi' => 'Pengadaan',
                'barang' => $item->nama_barang
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Mutasi Barang
        |--------------------------------------------------------------------------
        */

        foreach (
            Mutasi::with('barang')
                ->latest()
                ->take(5)
                ->get()
            as $item
        ) {

            $aktivitas->push([
                'tanggal' => $item->tanggal_mutasi,
                'nomor_register' => $item->barang->nomor_register,
                'aksi' => 'Mutasi',
                'barang' => $item->barang->nama_barang
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Pemeliharaan / Perbaikan
        |--------------------------------------------------------------------------
        */

        foreach (
            Pemeliharaan::with('barang')
                ->latest()
                ->take(5)
                ->get()
            as $item
        ) {

            $aktivitas->push([
                'tanggal' => $item->updated_at,

                'nomor_register' =>
                    $item->barang->nomor_register,

                'aksi' => $item->status == 'Selesai'
                    ? 'Selesai Perbaikan'
                    : 'Perbaikan',

                'barang' =>
                    $item->barang->nama_barang
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Penghapusan Barang
        |--------------------------------------------------------------------------
        */

        foreach (
            Penghapusan::with('barang')
                ->latest()
                ->take(5)
                ->get()
            as $item
        ) {

            $aktivitas->push([
                'tanggal' =>
                    $item->tanggal_penghapusan,

                'nomor_register' =>
                    $item->barang->nomor_register,

                'aksi' => 'Penghapusan',

                'barang' =>
                    $item->barang->nama_barang
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Urutkan Aktivitas Terbaru
        |--------------------------------------------------------------------------
        */

        $aktivitas = $aktivitas
            ->sortByDesc('tanggal')
            ->take(10);

        return view(
            'dashboard',
            compact(
                'totalBarang',
                'totalNilaiAset',
                'totalPerbaikan',
                'totalDihapus',
                'aktivitas'
            )
        );
    }
}