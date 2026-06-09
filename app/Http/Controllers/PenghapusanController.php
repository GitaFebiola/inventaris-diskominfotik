<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penghapusan;
use Illuminate\Http\Request;

class PenghapusanController extends Controller
{
    public function index(Request $request)
{
    $query = Penghapusan::with('barang');

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

    $penghapusan = $query
        ->latest()
    ->get();

    return view(
        'penghapusan.index',
        compact('penghapusan')
    );
}

    public function create()
    {
        $barang = Barang::where(
            'status',
            'Aktif'
        )->orderBy(
            'nama_barang'
        )->get();

        return view(
            'penghapusan.create',
            compact('barang')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_penghapusan' => 'required|date',
            'alasan' => 'required|max:100',
            'keterangan' => 'nullable'
        ]);

        $barang = Barang::findOrFail(
            $request->barang_id
        );

        if ($barang->status != 'Aktif') {

            return back()->with(
                'error',
                'Barang tidak dapat dihapus.'
            );
        }

        Penghapusan::create([
            'barang_id' => $barang->id,
            'tanggal_penghapusan' => $request->tanggal_penghapusan,
            'alasan' => $request->alasan,
            'keterangan' => $request->keterangan
        ]);

        $barang->update([
            'status' => 'Dihapus'
        ]);

        return redirect()
            ->route('penghapusan.index')
            ->with(
                'success',
                'Penghapusan berhasil disimpan.'
            );
    }

    public function show(
        Penghapusan $penghapusan
    ) {
        return view(
            'penghapusan.show',
            compact('penghapusan')
        );
    }

    public function edit(
        Penghapusan $penghapusan
    ) {
        return redirect()
            ->route('penghapusan.index');
    }

    public function update(
        Request $request,
        Penghapusan $penghapusan
    ) {
        return redirect()
            ->route('penghapusan.index');
    }

    public function destroy(
        Penghapusan $penghapusan
    ) {
        return redirect()
            ->route('penghapusan.index')
            ->with(
                'error',
                'Riwayat penghapusan tidak boleh dihapus.'
            );
    }
}