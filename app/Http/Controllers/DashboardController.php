<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Mutasi;
use App\Models\Pemeliharaan;
use App\Models\Penghapusan;
use App\Models\Kategori;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::where('status', '!=', 'Dihapus')->count();

        $totalNilaiAset = Barang::where('status', '!=', 'Dihapus')
            ->sum('harga_perolehan');

        $totalPerbaikan = Barang::where('status', 'Perbaikan')->count();

        $totalDihapus = Barang::where('status', 'Dihapus')->count();

        $aktivitas = collect();

        /*
        |--------------------------------------------------------------------------
        | Pengadaan Barang
        |--------------------------------------------------------------------------
        */
        foreach (Barang::latest()->take(5)->get() as $item) {
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
        foreach (Mutasi::with('barang')->latest()->take(5)->get() as $item) {
            $aktivitas->push([
                // DIBENAHI: Tambah ->endOfDay() agar seimbang dengan timestamp created_at
                'tanggal' => Carbon::parse($item->tanggal_mutasi)->endOfDay(), 
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
        foreach (Pemeliharaan::with('barang')->latest()->take(5)->get() as $item) {
            $aktivitas->push([
                'tanggal' => $item->updated_at,
                'nomor_register' => $item->barang->nomor_register,
                'aksi' => $item->status == 'Selesai' ? 'Selesai Perbaikan' : 'Perbaikan',
                'barang' => $item->barang->nama_barang
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Penghapusan Barang
        |--------------------------------------------------------------------------
        */
        foreach (Penghapusan::with('barang')->latest()->take(5)->get() as $item) {
            $aktivitas->push([
                // DIBENAHI: Tambah ->endOfDay() agar seimbang dengan timestamp created_at
                'tanggal' => Carbon::parse($item->tanggal_penghapusan)->endOfDay(),
                'nomor_register' => $item->barang->nomor_register,
                'aksi' => 'Penghapusan',
                'barang' => $item->barang->nama_barang
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Urutkan Aktivitas Terbaru
        |--------------------------------------------------------------------------
        */
        $aktivitas = $aktivitas->sortByDesc('tanggal')->take(10);

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK
        |--------------------------------------------------------------------------
        */
        // DIBENAHI: Filter agar barang yang dihitung hanya yang BUKAN 'Dihapus'
        $grafikKategori = Kategori::withCount(['barang' => function ($query) {
            $query->where('status', '!=', 'Dihapus');
        }])->get();

        /*
        |--------------------------------------------------------------------------
        | DATA BARU: TREN PENGADAAN 6 BULAN TERAKHIR
        |--------------------------------------------------------------------------
        */
        $labelsBulan = [];
        $trenBulanan = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labelsBulan[] = $date->format('M Y'); // Contoh: Jan 2024
            
            $count = Barang::where('status', '!=', 'Dihapus')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $trenBulanan[] = $count;
        }

        /*
        |--------------------------------------------------------------------------
        | DATA BARU: KONDISI BARANG SAAT INI
        |--------------------------------------------------------------------------
        */
        $kondisiRaw = Barang::where('status', '!=', 'Dihapus')
            ->selectRaw("kondisi, COUNT(*) as total")
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi')
            ->toArray();

        // Pastikan urutannya selalu Baik, Rusak Ringan, Rusak Berat
        $grafikKondisi = [
            'Baik' => $kondisiRaw['Baik'] ?? 0,
            'Rusak Ringan' => $kondisiRaw['Rusak Ringan'] ?? 0,
            'Rusak Berat' => $kondisiRaw['Rusak Berat'] ?? 0,
        ];

        return view(
            'dashboard',
            compact(
                'totalBarang',
                'totalNilaiAset',
                'totalPerbaikan',
                'totalDihapus',
                'aktivitas',
                'grafikKategori',
                'labelsBulan',      // Baru
                'trenBulanan',      // Baru
                'grafikKondisi'     // Baru
            )
        );
    }
}