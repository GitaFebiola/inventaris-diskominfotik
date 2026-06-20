<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pemeliharaan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    public function index(Request $request)
{
    $query = Pemeliharaan::with('barang');

    if ($request->filled('search')) {

        $query->whereHas('barang', function ($q) use ($request) {

            $q->where(
                'nomor_register',
                'like',
                '%' . $request->search . '%'
            )
            ->orWhere(
                'nama_barang',
                'like',
                '%' . $request->search . '%'
            );

        });

    }
    // FILTER BULAN & TAHUN
    if ($request->bulan && $request->tahun) {
        $query->whereMonth('created_at', $request->bulan)
              ->whereYear('created_at', $request->tahun);
    } elseif ($request->tahun) {
        $query->whereYear('created_at', $request->tahun);
    }

    $pemeliharaan = $query
        ->latest()
    ->get();

    return view(
        'pemeliharaan.index',
        compact('pemeliharaan')
    );
}

public function create()
{
    $barang = Barang::with('ruangan')
        ->where('status', 'Aktif')
        ->orderBy('nama_barang')
        ->get();

    $ruangan = Ruangan::orderBy('nama_ruangan')->get();

    return view(
        'pemeliharaan.create',
        compact('barang', 'ruangan')
    );
}

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_pemeliharaan' => 'required|date',
            'jenis_pemeliharaan' => 'required|max:255',
            'biaya' => 'nullable|numeric',
            'keterangan' => 'nullable',
        ]);

        $barang = Barang::findOrFail(
            $request->barang_id
        );

        if ($barang->status != 'Aktif') {
            return back()->with(
                'error',
                'Barang tidak dapat diproses.'
            );
        }

        Pemeliharaan::create([
            'barang_id' => $barang->id,
            'tanggal_pemeliharaan' => $request->tanggal_pemeliharaan,
            'jenis_pemeliharaan' => $request->jenis_pemeliharaan,
            'biaya' => $request->biaya,
            'keterangan' => $request->keterangan,
            'status' => 'Proses',
            'user_id' => auth()->id()
        ]);

        $barang->update([
            'status' => 'Perbaikan'
        ]);

        return redirect()
            ->route('pemeliharaan.index')
            ->with(
                'success',
                'Pemeliharaan berhasil ditambahkan.'
            );
    }

    public function show(
        Pemeliharaan $pemeliharaan
    ) {
        return view(
            'pemeliharaan.show',
            compact('pemeliharaan')
        );
    }

    public function selesai(
        Pemeliharaan $pemeliharaan
    ) {
        $pemeliharaan->update([
            'status' => 'Selesai',
            'tanggal_selesai' => now()
        ]);

        $pemeliharaan->barang->update([
            'status' => 'Aktif'
        ]);

        return redirect()
            ->route('pemeliharaan.index')
            ->with(
                'success',
                'Pemeliharaan selesai.'
            );
    }
}