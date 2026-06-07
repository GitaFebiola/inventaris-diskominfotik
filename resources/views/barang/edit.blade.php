@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')

<div class="card shadow-sm">

<div class="card-header">
    <h5 class="mb-0">Edit Barang</h5>
</div>

<div class="card-body">

    <form action="{{ route('barang.update', $barang->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Nomor Register
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $barang->nomor_register }}"
                       readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Status
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $barang->status }}"
                       readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Nama Barang
                </label>

                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="{{ old('nama_barang', $barang->nama_barang) }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Merk
                </label>

                <input type="text"
                       name="merk"
                       class="form-control"
                       value="{{ old('merk', $barang->merk) }}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">
                    Spesifikasi
                </label>

                <textarea name="spesifikasi"
                          rows="4"
                          class="form-control">{{ old('spesifikasi', $barang->spesifikasi) }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Tahun Perolehan
                </label>

                <input type="number"
                       name="tahun_perolehan"
                       class="form-control"
                       value="{{ $barang->tahun_perolehan }}"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Harga Perolehan
                </label>

                <input type="number"
                       name="harga_perolehan"
                       class="form-control"
                       value="{{ $barang->harga_perolehan }}"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Kondisi
                </label>

                <select name="kondisi"
                        class="form-select">

                    <option value="Baik"
                        {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>
                        Baik
                    </option>

                    <option value="Rusak Ringan"
                        {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>
                        Rusak Ringan
                    </option>

                    <option value="Rusak Berat"
                        {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>
                        Rusak Berat
                    </option>

                </select>
            </div>

            <div class="col-md-12 mb-3">

                <label class="form-label">
                    Ganti Foto
                </label>

                <input type="file"
                       name="foto"
                       class="form-control">

            </div>

        </div>

        <a href="{{ route('barang.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

        <button type="submit"
                class="btn btn-warning">

            Update

        </button>

    </form>

</div>

</div>

@endsection
