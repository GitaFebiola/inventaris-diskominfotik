<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function index(Request $request)
    {
        $query = Merk::with('kategori');

        if ($request->filled('search')) {

            $query->where('nama_merk', 'like', '%' . $request->search . '%')

                ->orWhereHas('kategori', function ($q) use ($request) {

                    $q->where(
                        'nama_kategori',
                        'like',
                        '%' . $request->search . '%'
                    );

                });
        }

        $merk = $query
            ->latest()
            ->get();

        return view(
            'merk.index',
            compact('merk')
        );
    }

    public function create()
    {
        $kategori = Kategori::orderBy(
            'nama_kategori'
        )->get();

        return view(
            'merk.create',
            compact('kategori')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_merk' => 'required|max:100'
        ]);

        Merk::create([
            'kategori_id' => $request->kategori_id,
            'nama_merk' => $request->nama_merk
        ]);

        return redirect()
            ->route('merk.index')
            ->with(
                'success',
                'Merk berhasil ditambahkan'
            );
    }

    public function edit(Merk $merk)
    {
        $kategori = Kategori::orderBy(
            'nama_kategori'
        )->get();

        return view(
            'merk.edit',
            compact(
                'merk',
                'kategori'
            )
        );
    }

    public function update(
        Request $request,
        Merk $merk
    ) {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_merk' => 'required|max:100'
        ]);

        $merk->update([
            'kategori_id' => $request->kategori_id,
            'nama_merk' => $request->nama_merk
        ]);

        return redirect()
            ->route('merk.index')
            ->with(
                'success',
                'Merk berhasil diubah'
            );
    }

    public function destroy(Merk $merk)
    {
        $merk->delete();

        return redirect()
            ->route('merk.index')
            ->with(
                'success',
                'Merk berhasil dihapus'
            );
    }
}