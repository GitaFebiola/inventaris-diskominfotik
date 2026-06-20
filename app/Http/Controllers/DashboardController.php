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
        | QUERY UNION: Semua punya kolom 'waktu_sortir' yang pasti terisi timestamp
        |--------------------------------------------------------------------------
        */
        
        // 1. Pengadaan
        $pengadaan = DB::table('barangs')
            ->select([
                'created_at as tanggal_aktivitas',
                'created_at as waktu_sortir', // Diisi created_at
                DB::raw("'Pengadaan' as aksi"),
                'nomor_register',
                'nama_barang as barang',
                'user_id'
            ]);

        // 2. Mutasi
        $mutasi = DB::table('mutasis')
            ->join('barangs as b1', 'mutasis.barang_id', '=', 'b1.id')
            ->select([
                'mutasis.tanggal_mutasi as tanggal_aktivitas', // Untuk ditampilkan
                'mutasis.created_at as waktu_sortir',          // Diisi created_at
                DB::raw("'Mutasi' as aksi"),
                'b1.nomor_register',
                'b1.nama_barang as barang',
                'mutasis.user_id'
            ]);

        // 3. Pemeliharaan
        $pemeliharaan = DB::table('pemeliharaans')
            ->join('barangs as b2', 'pemeliharaans.barang_id', '=', 'b2.id')
            ->select([
                'pemeliharaans.updated_at as tanggal_aktivitas', // Untuk ditampilkan
                'pemeliharaans.updated_at as waktu_sortir',     // Diisi updated_at
                DB::raw("IF(pemeliharaans.status = 'Selesai', 'Selesai Perbaikan', 'Perbaikan') as aksi"),
                'b2.nomor_register',
                'b2.nama_barang as barang',
                'pemeliharaans.user_id'
            ]);

        // 4. Penghapusan
        $penghapusan = DB::table('penghapusans')
            ->join('barangs as b3', 'penghapusans.barang_id', '=', 'b3.id')
            ->select([
                'penghapusans.tanggal_penghapusan as tanggal_aktivitas', // Untuk ditampilkan
                'penghapusans.created_at as waktu_sortir',               // Diisi created_at
                DB::raw("'Penghapusan' as aksi"),
                'b3.nomor_register',
                'b3.nama_barang as barang',
                'penghapusans.user_id'
            ]);

        // Gabungkan semua
        $unionQuery = $pengadaan
            ->unionAll($mutasi)
            ->unionAll($pemeliharaan)
            ->unionAll($penghapusan);

        // Urutkan berdasarkan waktu_sortir (pasti akurat karena tidak ada yang NULL)
        $aktivitasRaw = DB::query()
            ->fromSub($unionQuery, 'aktivitas_gabungan')
            ->orderBy('waktu_sortir', 'desc') 
            ->take(10)
            ->get();

        // Ambil User yang terlibat
        $userIds = $aktivitasRaw->pluck('user_id')->unique()->filter()->toArray();
        $users = User::whereIn('id', $userIds)->pluck('name', 'id');

        // Mapping data (tanggal yang ditampilkan tetap tanggal_aktivitas)
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