@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Tambah Barang</h5>
    </div>

<div class="card-body">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori</label>

                <select name="kategori_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_kategori }}
                            ({{ $item->kode_bmd }})
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Ruangan</label>

                <select name="ruangan_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Ruangan --
                    </option>

                    @foreach($ruangan as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_ruangan }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Barang</label>

                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="{{ old('nama_barang') }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Merk</label>

                <input type="text"
                       name="merk"
                       class="form-control"
                       value="{{ old('merk') }}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Spesifikasi</label>

                <textarea name="spesifikasi"
                          rows="4"
                          class="form-control">{{ old('spesifikasi') }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Tahun Perolehan
                </label>

                <input type="number"
                       name="tahun_perolehan"
                       class="form-control"
                       min="2000"
                       max="{{ date('Y') }}"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Harga Perolehan
                </label>

                <input type="number"
                       name="harga_perolehan"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    Kondisi
                </label>

                <select name="kondisi"
                        class="form-select"
                        required>

                    <option value="Baik">
                        Baik
                    </option>

                    <option value="Rusak Ringan">
                        Rusak Ringan
                    </option>

                    <option value="Rusak Berat">
                        Rusak Berat
                    </option>

                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">
                    Foto Barang
                </label>

                <input type="file"
                       name="foto"
                       class="form-control"
                       accept=".jpg,.jpeg,.png">
            </div>

        </div>

        <a href="{{ route('barang.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

        <button type="submit"
                class="btn btn-primary">

            Simpan

        </button>

    </form>

</div>

</div>

@endsection
