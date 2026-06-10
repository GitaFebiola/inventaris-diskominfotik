<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Mutasi;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    public function index(Request $request)
{
    $query = Mutasi::with([
        'barang',
        'ruanganAsal',
        'ruanganTujuan'
    ]);

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

    $mutasi = $query
        ->latest()
    ->get();

    return view(
        'mutasi.index',
        compact('mutasi')
    );
}

    public function create()
    {
        $barang = Barang::with('ruangan')
            ->where('status', 'Aktif')
            ->orderBy('nama_barang')
            ->get();

        $ruangan = Ruangan::orderBy('nama_ruangan')
            ->get();

        return view(
            'mutasi.create',
            compact(
                'barang',
                'ruangan'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'ruangan_tujuan_id' => 'required|exists:ruangans,id',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        $barang = Barang::findOrFail(
            $request->barang_id
        );

        if ($barang->status != 'Aktif') {

            return back()
                ->with(
                    'error',
                    'Barang tidak dapat dimutasi karena statusnya bukan Aktif.'
                );
        }

        if (
            $barang->ruangan_id ==
            $request->ruangan_tujuan_id
        ) {
            return back()
                ->with(
                    'error',
                    'Ruangan tujuan tidak boleh sama dengan ruangan sekarang.'
                );
        }

        Mutasi::create([
            'barang_id' => $barang->id,

            'ruangan_asal_id' =>
                $barang->ruangan_id,

            'ruangan_tujuan_id' =>
                $request->ruangan_tujuan_id,

            'tanggal_mutasi' =>
                $request->tanggal_mutasi,

            'keterangan' =>
                $request->keterangan
        ]);

        $barang->update([
            'ruangan_id' =>
                $request->ruangan_tujuan_id
        ]);

        return redirect()
            ->route('mutasi.index')
            ->with(
                'success',
                'Mutasi berhasil disimpan.'
            );
    }

    public function show(Mutasi $mutasi)
    {
        $mutasi->load([
            'barang',
            'ruanganAsal',
            'ruanganTujuan'
        ]);

        return view(
            'mutasi.show',
            compact('mutasi')
        );
    }

    public function edit(Mutasi $mutasi)
    {
        return redirect()
            ->route('mutasi.index');
    }

    public function update(
        Request $request,
        Mutasi $mutasi
    ) {
        return redirect()
            ->route('mutasi.index');
    }

    public function destroy(
        Mutasi $mutasi
    ) {
        return back()
            ->with(
                'error',
                'Data mutasi tidak boleh dihapus karena merupakan histori perpindahan barang.'
            );
    }
}