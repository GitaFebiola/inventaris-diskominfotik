<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
{
    $query = Kategori::query();

    if ($request->filled('search')) {

        $query->where(
            'nama_kategori',
            'like',
            '%' . $request->search . '%'
        );

    }

    $kategori = $query
        ->latest()
    ->get();

    return view(
        'kategori.index',
        compact('kategori')
    );
}

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_bmd' => 'required|unique:kategoris,kode_bmd|max:20',
            'nama_kategori' => 'required|max:100'
        ]);

        Kategori::create([
            'kode_bmd' => $request->kode_bmd,
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan'
            );
    }

    public function show(Kategori $kategori)
    {
        return view(
            'kategori.show',
            compact('kategori')
        );
    }

    public function edit(Kategori $kategori)
    {
        return view(
            'kategori.edit',
            compact('kategori')
        );
    }

    public function update(
    Request $request,
    Kategori $kategori
) {
    $request->validate([
        'kode_bmd' =>
            'required|max:20|unique:kategoris,kode_bmd,' .
            $kategori->id,

        'nama_kategori' =>
            'required|max:100'
    ]);

    $kategori->update([
        'kode_bmd' => $request->kode_bmd,
        'nama_kategori' => $request->nama_kategori
    ]);

    $barangList = Barang::where(
        'kategori_id',
        $kategori->id
    )->get();

    foreach ($barangList as $barang) {

        $parts = explode(
            '-',
            $barang->nomor_register
        );

        $urutan = end($parts);

        $barang->update([
            'nomor_register' =>
                $request->kode_bmd .
                '-' .
                $urutan
        ]);
    }

    return redirect()
        ->route('kategori.index')
        ->with(
            'success',
            'Kategori berhasil diubah'
        );
}

    public function destroy(
        Kategori $kategori
    ) {
        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil dihapus'
            );
    }
}