@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Detail Barang</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="250">Nomor Register</th>
                <td>{{ $barang->nomor_register }}</td>
            </tr>

            <tr>
                <th>Nama Barang</th>
                <td>{{ $barang->nama_barang }}</td>
            </tr>

            <!-- FOTO -->
            <tr>
                <th>Foto Barang</th>
                <td>
                    @if($barang->foto)
                        <img src="{{ Storage::url($barang->foto) }}" 
                             alt="Foto {{ $barang->nama_barang }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 300px; display: block;">
                    @else
                        <span class="text-muted fst-italic">Tidak ada foto</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>Kategori</th>
                <td>{{ $barang->kategori->nama_kategori }}</td>
            </tr>

            <tr>
                <th>Ruangan</th>
                <td>{{ $barang->ruangan->nama_ruangan }}</td>
            </tr>

            <tr>
                <th>Merk</th>
                <td>{{ $barang->merk }}</td>
            </tr>

            <!-- SUMBER ANGGARAN -->
            <tr>
                <th>Sumber Anggaran</th>
                <td>{{ $barang->Sumber ?? '-' }}</td>
            </tr>

            <tr>
                <th>Spesifikasi</th>
                <td>{!! nl2br(e($barang->spesifikasi)) !!}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $barang->keterangan ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tahun Perolehan</th>
                <td>{{ $barang->tahun_perolehan }}</td>
            </tr>

            <tr>
                <th>Harga Perolehan</th>
                <td>Rp {{ number_format($barang->harga_perolehan,0,',','.') }}</td>
            </tr>

            <tr>
                <th>Kondisi</th>
                <td>{{ $barang->kondisi }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $barang->status }}</td>
            </tr>
        </table>

        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>
</div>
@endsection