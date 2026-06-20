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

            {{-- RUANGAN --}}
            <div class="mb-3">

                <label class="form-label fw-bold">
                    Ruangan
                </label>

                <select
                    id="ruangan_id"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Ruangan --
                    </option>

                    @foreach($ruangan as $r)

                        <option value="{{ $r->id }}">
                            {{ $r->nama_ruangan }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- NAMA BARANG --}}
            <div class="mb-3">

                <label class="form-label fw-bold">
                    Nama Barang
                </label>

                <select
                    id="nama_barang"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Ruangan Terlebih Dahulu --
                    </option>

                </select>

            </div>

            {{-- NOMOR REGISTER --}}
            <div class="mb-3">

                <label class="form-label fw-bold">
                    Nomor Register
                </label>

                <select
                    name="barang_id"
                    id="barang_id"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Nama Barang Terlebih Dahulu --
                    </option>

                </select>

                <small class="text-muted">
                    Pilih nomor register sesuai barang yang akan dipelihara.
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

document.addEventListener('DOMContentLoaded', function () {

    const dataBarang = @json($barang);

    const ruanganSelect = document.getElementById('ruangan_id');
    const namaBarangSelect = document.getElementById('nama_barang');
    const barangSelect = document.getElementById('barang_id');

    // SAAT PILIH RUANGAN
    ruanganSelect.addEventListener('change', function () {

        const ruanganId = this.value;

        namaBarangSelect.innerHTML =
            '<option value="">-- Pilih Nama Barang --</option>';

        barangSelect.innerHTML =
            '<option value="">-- Pilih Nama Barang Terlebih Dahulu --</option>';

        if (!ruanganId) return;

        const namaBarangUnik = [];

        dataBarang.forEach(function(item){

            if (
                item.ruangan_id == ruanganId &&
                !namaBarangUnik.includes(item.nama_barang)
            ) {
                namaBarangUnik.push(item.nama_barang);
            }

        });

        namaBarangUnik.sort();

        namaBarangUnik.forEach(function(nama){

            namaBarangSelect.innerHTML +=
                `<option value="${nama}">${nama}</option>`;

        });

    });

    // SAAT PILIH NAMA BARANG
    namaBarangSelect.addEventListener('change', function () {

        const ruanganId = ruanganSelect.value;
        const namaBarang = this.value;

        barangSelect.innerHTML =
            '<option value="">-- Pilih Nomor Register --</option>';

        if (!namaBarang) return;

        dataBarang.forEach(function(item){

            if (
                item.ruangan_id == ruanganId &&
                item.nama_barang == namaBarang
            ) {

                barangSelect.innerHTML +=
                    `<option value="${item.id}">
                        ${item.nomor_register}
                    </option>`;

            }

        });

    });

});

</script>

@endsection