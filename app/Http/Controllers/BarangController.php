<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
{
    $query = Barang::with([
        'kategori',
        'ruangan'
    ]);

    if($request->search)
    {
        $query->where(function($q)
            use ($request)
        {
            $q->where(
                'nomor_register',
                'like',
                '%'.$request->search.'%'
            )
            ->orWhere(
                'nama_barang',
                'like',
                '%'.$request->search.'%'
            )
            ->orWhere(
                'merk',
                'like',
                '%'.$request->search.'%'
            )
            
            ->orWhere(
                'kondisi',
                'like',
                '%'.$request->search.'%'
            )
            ->orWhere(
                'status',
                'like',
                '%'.$request->search.'%'
            );
        });
    }

    $barang = $query
    ->latest()
    ->get();

    return view(
        'barang.index',
        compact('barang')
    );
}

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        $ruangan = Ruangan::orderBy('nama_ruangan')->get();

        return view('barang.create', compact(
            'kategori',
            'ruangan'
        ));
    }

    private function generateNomorRegister($kategoriId)
    {
        $kategori = Kategori::findOrFail($kategoriId);

        $prefix = $kategori->kode_bmd;

        $lastBarang = Barang::where(
            'kategori_id',
            $kategoriId
        )
        ->latest('id')
        ->first();

        if ($lastBarang) {

            $lastNumber = (int) substr(
                $lastBarang->nomor_register,
                -5
            );

            $newNumber = $lastNumber + 1;

        } else {

            $newNumber = 1;
        }

        return $prefix . '-' .
            str_pad(
                $newNumber,
                5,
                '0',
                STR_PAD_LEFT
            );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'ruangan_id' => 'required|exists:ruangans,id',
            'nama_barang' => 'required|max:150',
            'merk' => 'nullable|max:100',
            'spesifikasi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tahun_perolehan' => 'required|digits:4',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {

            // Diubah dari 'local' menjadi 'public'
            $fotoPath = $request->file('foto')
                ->store('barang', 'public');
        }

        Barang::create([
            'nomor_register' =>
                $this->generateNomorRegister(
                    $request->kategori_id
                ),

            'kategori_id' =>
                $request->kategori_id,

            'ruangan_id' =>
                $request->ruangan_id,

            'nama_barang' =>
                $request->nama_barang,

            'merk' =>
                $request->merk,

            'spesifikasi' =>
                $request->spesifikasi,

            'foto' =>
                $fotoPath,

            'tahun_perolehan' =>
                $request->tahun_perolehan,

            'harga_perolehan' =>
                $request->harga_perolehan,

            'kondisi' =>
                $request->kondisi,

            'status' =>
                'Aktif'
        ]);

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang berhasil ditambahkan'
            );
    }

    public function show(Barang $barang)
    {
        $barang->load([
            'kategori',
            'ruangan'
        ]);

        return view(
            'barang.show',
            compact('barang')
        );
    }

    public function edit(Barang $barang)
    {
        return view(
            'barang.edit',
            compact('barang')
        );
    }

    public function update(
        Request $request,
        Barang $barang
    ) {
        $request->validate([
            'nama_barang' => 'required|max:150',
            'merk' => 'nullable|max:100',
            'spesifikasi' => 'nullable',
            'tahun_perolehan' => 'required|digits:4',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoPath = $barang->foto;

        if ($request->hasFile('foto')) {

            if (
                $barang->foto &&
                // Diubah disk('local') menjadi disk('public')
                Storage::disk('public')->exists($barang->foto)
            ) {
                // Diubah disk('local') menjadi disk('public')
                Storage::disk('public')
                    ->delete($barang->foto);
            }

            // Diubah dari 'local' menjadi 'public'
            $fotoPath = $request->file('foto')
                ->store('barang', 'public');
        }

        $barang->update([
            'nama_barang' =>
                $request->nama_barang,

            'merk' =>
                $request->merk,

            'spesifikasi' =>
                $request->spesifikasi,

            'foto' =>
                $fotoPath,

            'tahun_perolehan' =>
                $request->tahun_perolehan,

            'harga_perolehan' =>
                $request->harga_perolehan,

            'kondisi' =>
                $request->kondisi
        ]);

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang berhasil diubah'
            );
    }

    public function destroy(Barang $barang)
    {
        if (
            $barang->foto &&
            // Diubah disk('local') menjadi disk('public')
            Storage::disk('public')->exists($barang->foto)
        ) {
            // Diubah disk('local') menjadi disk('public')
            Storage::disk('public')
                ->delete($barang->foto);
        }

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang berhasil dihapus'
            );
    }
}