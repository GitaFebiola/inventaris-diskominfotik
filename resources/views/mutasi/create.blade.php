@extends('layouts.admin')

@section('title','Tambah Mutasi')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Tambah Mutasi Barang</h5>
    </div>

    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mutasi.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">
                    Barang
                </label>

                <select
                    name="barang_id"
                    id="barang_id"
                    class="form-select"
                    required>

                    <option value="">
                        Cari Nomor Register atau Nama Barang...
                    </option>

                    @foreach($barang as $item)

                        <option value="{{ $item->id }}">

                            {{ $item->nomor_register }}
                            |
                            {{ $item->nama_barang }}
                            |
                            {{ $item->ruangan->nama_ruangan ?? '-' }}

                        </option>

                    @endforeach

                </select>

                <small class="text-muted">
                    Cari berdasarkan nomor register atau nama barang.
                </small>
            </div>

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Ruangan Tujuan
                </label>

                <select
                    name="ruangan_tujuan_id"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Ruangan Tujuan --
                    </option>

                    @foreach($ruangan as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->kode_ruangan }}
                            -
                            {{ $item->nama_ruangan }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Tanggal Mutasi
                </label>

                <input
                    type="date"
                    name="tanggal_mutasi"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="form-control"
                    placeholder="Contoh: Pemindahan barang ke ruangan baru"></textarea>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('mutasi.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Simpan Mutasi

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function() {

    $('#barang_id').select2({
        placeholder: 'Cari Nomor Register atau Nama Barang',
        allowClear: true,
        width: '100%'
    });

});

</script>

@endsection