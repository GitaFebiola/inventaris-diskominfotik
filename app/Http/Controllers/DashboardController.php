<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::where('status', '!=', 'Dihapus')->count();

        $totalNilaiAset = Barang::where('status', '!=', 'Dihapus')
            ->sum('harga_perolehan');

        $totalPerbaikan = Barang::where('status', 'Perbaikan')->count();

        $totalDihapus = Barang::where('status', 'Dihapus')->count();

        /*
        |--------------------------------------------------------------------------
        | QUERY UNION: Menggabungkan 4 TABEL menjadi 1, lalu ambil 10 terbaru
        |--------------------------------------------------------------------------
        */
        $aktivitasRaw = DB::table('barangs')
            ->select([
                'created_at as tanggal_aktivitas',
                DB::raw("'Pengadaan' as aksi"),
                'nomor_register',
                'nama_barang as barang',
                'user_id'
            ])
            ->unionAll(
                DB::table('mutasis')
                    ->join('barangs as b1', 'mutasis.barang_id', '=', 'b1.id')
                    ->select([
                        DB::raw("CAST(CONCAT(mutasis.tanggal_mutasi, ' 23:59:59') AS DATETIME) as tanggal_aktivitas"),
                        DB::raw("'Mutasi' as aksi"),
                        'b1.nomor_register',
                        'b1.nama_barang as barang',
                        'mutasis.user_id'
                    ])
            )
            ->unionAll(
                DB::table('pemeliharaans')
                    ->join('barangs as b2', 'pemeliharaans.barang_id', '=', 'b2.id') // SUDAH DIPERBAIKI (dikasih huruf s)
                    ->select([
                        'pemeliharaans.updated_at as tanggal_aktivitas',
                        DB::raw("IF(pemeliharaans.status = 'Selesai', 'Selesai Perbaikan', 'Perbaikan') as aksi"),
                        'b2.nomor_register',
                        'b2.nama_barang as barang',
                        'pemeliharaans.user_id'
                    ])
            )
            ->unionAll(
                DB::table('penghapusans')
                    ->join('barangs as b3', 'penghapusans.barang_id', '=', 'b3.id')
                    ->select([
                        DB::raw("CAST(CONCAT(penghapusans.tanggal_penghapusan, ' 23:59:59') AS DATETIME) as tanggal_aktivitas"),
                        DB::raw("'Penghapusan' as aksi"),
                        'b3.nomor_register',
                        'b3.nama_barang as barang',
                        'penghapusans.user_id'
                    ])
            )
            ->orderBy('tanggal_aktivitas', 'desc')
            ->take(10)
            ->get();

        // Ambil ID User yang terlibat di 10 data tersebut untuk menghindari N+1 Query
        $userIds = $aktivitasRaw->pluck('user_id')->unique()->filter()->toArray();
        $users = User::whereIn('id', $userIds)->pluck('name', 'id');

        // Mapping data ke format yang digunakan di Blade
        $aktivitas = $aktivitasRaw->map(function ($item) use ($users) {
            return [
                'tanggal' => $item->tanggal_aktivitas,
                'nomor_register' => $item->nomor_register,
                'aksi' => $item->aksi,
                'barang' => $item->barang,
                'user' => $users[$item->user_id] ?? 'Tidak Dicatat'
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK
        |--------------------------------------------------------------------------
        */
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
            $labelsBulan[] = $date->format('M Y'); 
            
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
                'labelsBulan',      
                'trenBulanan',      
                'grafikKondisi'     
            )
        );
    }
}