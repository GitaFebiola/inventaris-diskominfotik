@extends('layouts.admin')

@section('title','Tambah Penghapusan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Tambah Penghapusan Barang</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('penghapusan.store') }}"
              method="POST">

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

            {{-- NOMOR REGISTER (INI YANG DIPAKAI STORE) --}}
            <div class="mb-3">

                <label>Barang</label>

                <select
                    name="barang_id"
                    id="barang_id"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Nama Barang Terlebih Dahulu --
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label>Tanggal Penghapusan</label>

                <input
                    type="date"
                    name="tanggal_penghapusan"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                    required>

            </div>

            <div class="mb-3">

                <label>Alasan</label>

                <select
                    name="alasan"
                    class="form-select"
                    required>

                    <option value="">
                        Pilih Alasan
                    </option>

                    <option>Rusak Berat</option>
                    <option>Hilang</option>
                    <option>Musnah</option>
                    <option>Lelang</option>
                    <option>Lainnya</option>

                </select>

            </div>

            <div class="mb-3">

                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="form-control"></textarea>

            </div>

            <button class="btn btn-danger">
                Simpan
            </button>

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

    // RUANGAN CHANGE
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

    // NAMA BARANG CHANGE
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