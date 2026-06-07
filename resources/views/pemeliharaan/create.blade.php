@extends('layouts.admin')

@section('title','Tambah Pemeliharaan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Tambah Pemeliharaan Barang</h5>
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

        <form action="{{ route('pemeliharaan.store') }}" method="POST">

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
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_pemeliharaan"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Jenis Pemeliharaan
                </label>

                <input
                    type="text"
                    name="jenis_pemeliharaan"
                    class="form-control"
                    placeholder="Contoh: Perbaikan Keyboard, Ganti RAM, Service Printer"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Biaya
                </label>

                <input
                    type="number"
                    name="biaya"
                    class="form-control"
                    min="0"
                    placeholder="Masukkan biaya jika ada">

            </div>

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="form-control"
                    placeholder="Tambahkan keterangan jika diperlukan"></textarea>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('pemeliharaan.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Simpan Pemeliharaan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>

$(document).ready(function () {

    $('#barang_id').select2({
        placeholder: 'Cari Nomor Register atau Nama Barang',
        allowClear: true,
        width: '100%'
    });

});

</script>

@endsection