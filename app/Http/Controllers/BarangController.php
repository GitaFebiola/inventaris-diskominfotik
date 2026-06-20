<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Merk;
use Barryvdh\DomPDF\Facade\Pdf;
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
        // FILTER BULAN & TAHUN
        if ($request->bulan && $request->tahun) {
            $query->whereMonth('created_at', $request->bulan)
                  ->whereYear('created_at', $request->tahun);
        } elseif ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        // FILTER SEARCH
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
                    'Sumber',
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

                // FILTER KONDISI
        if ($request->kondisi) {
            if ($request->kondisi == 'Rusak') {
                // Jika pilih 'Rusak', cari yang mengandung kata 'Rusak' (Gabungan)
                $query->where('kondisi', 'like', '%Rusak%');
            } else {
                // Jika pilih yang lain (Rusak Ringan, Rusak Berat, Baik), cari persis
                $query->where('kondisi', $request->kondisi);
            }
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
        
        // Ambil semua data merk untuk diolah di dropdown
        $merk = Merk::all(); 

        return view('barang.create', compact(
            'kategori',
            'ruangan',
            'merk'
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
            'Sumber' => 'required|max:100', 
            'spesifikasi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tahun_perolehan' => 'required|digits:4',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required',
            'keterangan' => 'nullable',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
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

            'Sumber' => $request->Sumber, // Simpan Sumber

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
            
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(),

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
        // Tidak perlu passing variable tambahan di controller agar tidak "ubah kode lain"
        // Data master akan diambil langsung di view menggunakan @php
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
            'Sumber' => 'nullable|max:100', // Validasi Sumber
            'spesifikasi' => 'nullable',
            'tahun_perolehan' => 'required|digits:4',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi' => 'required',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoPath = $barang->foto;

        if ($request->hasFile('foto')) {

            if (
                $barang->foto &&
                Storage::disk('public')->exists($barang->foto)
            ) {
                Storage::disk('public')
                    ->delete($barang->foto);
            }

            $fotoPath = $request->file('foto')
                ->store('barang', 'public');
        }

        $barang->update([
            'nama_barang' =>
                $request->nama_barang,

            'merk' =>
                $request->merk,

            'Sumber' => $request->Sumber, // Update Sumber

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
            'keterangan' => $request->keterangan
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
            Storage::disk('public')->exists($barang->foto)
        ) {
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

            public function pdf(Request $request)
    {
        $query = Barang::with(['kategori', 'ruangan']);

        // Filter Bulan & Tahun
        if ($request->bulan && $request->tahun) {
            $query->whereMonth('created_at', $request->bulan)
                  ->whereYear('created_at', $request->tahun);
        } elseif ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        // --- BAGIAN PENTING: FILTER KONDISI ---
        if ($request->kondisi) {
            $kondisiVal = $request->kondisi;

            // Debug: Jika masih kosong, buka tanda komentar di bawah untuk melihat isinya
            // dd($kondisiVal); 

            if ($kondisiVal == 'Rusak') {
                // Jika pilih 'Rusak', cari yang mengandung kata 'Rusak' (Gabungan)
                $query->where('kondisi', 'like', '%Rusak%');
            } else {
                // Jika pilih yang lain, cari persis
                $query->where('kondisi', 'like', '%' . $kondisiVal . '%');
            }
        }
        // ---------------------------------------

        $barang = $query->get();

        $pdf = Pdf::loadView('barang.pdf', compact('barang'))
                 ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang.pdf');
    }
}