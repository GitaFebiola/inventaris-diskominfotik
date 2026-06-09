<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(Request $request)
{
    $query = Ruangan::query();

    if ($request->filled('search')) {

        $query->where('nama_ruangan', 'like', '%' . $request->search . '%')
              ->orWhere('penanggung_jawab', 'like', '%' . $request->search . '%');

    }

    $ruangan = $query
        ->latest()
    ->get();

    return view(
        'ruangan.index',
        compact('ruangan')
    );
}

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|max:100',
            'penanggung_jawab' => 'nullable|max:100'
        ]);

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'penanggung_jawab' => $request->penanggung_jawab
        ]);

        return redirect()
            ->route('ruangan.index')
            ->with(
                'success',
                'Ruangan berhasil ditambahkan'
            );
    }

    public function show(Ruangan $ruangan)
    {
        return view(
            'ruangan.show',
            compact('ruangan')
        );
    }

    public function edit(Ruangan $ruangan)
    {
        return view(
            'ruangan.edit',
            compact('ruangan')
        );
    }

    public function update(
        Request $request,
        Ruangan $ruangan
    ) {
        $request->validate([
            'nama_ruangan' =>
                'required|max:100',

            'penanggung_jawab' =>
                'nullable|max:100'
        ]);

        $ruangan->update([

            'nama_ruangan' =>
                $request->nama_ruangan,

            'penanggung_jawab' =>
                $request->penanggung_jawab
        ]);

        return redirect()
            ->route('ruangan.index')
            ->with(
                'success',
                'Ruangan berhasil diperbarui'
            );
    }

    public function destroy(
        Ruangan $ruangan
    ) {
        $ruangan->delete();

        return redirect()
            ->route('ruangan.index')
            ->with(
                'success',
                'Ruangan berhasil dihapus'
            );
    }
}