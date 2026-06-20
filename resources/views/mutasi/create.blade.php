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

            {{-- RUANGAN --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Ruangan</label>

                <select id="ruangan_id" class="form-select" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangan as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- NAMA BARANG --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Barang</label>

                <select id="nama_barang" class="form-select" required>
                    <option value="">-- Pilih Ruangan Terlebih Dahulu --</option>
                </select>
            </div>

            {{-- NOMOR REGISTER --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Register</label>

                <select name="barang_id" id="barang_id" class="form-select" required>
                    <option value="">-- Pilih Nama Barang Terlebih Dahulu --</option>
                </select>

                <small class="text-muted">
                    Pilih nomor register barang yang akan dimutasi.
                </small>
            </div>

            {{-- RUANGAN TUJUAN --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Ruangan Tujuan</label>

                <select name="ruangan_tujuan_id"
                        id="ruangan_tujuan_id"
                        class="form-select"
                        required>

                    <option value="">-- Pilih Ruangan Tujuan --</option>

                    @foreach($ruangan as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->kode_ruangan }} - {{ $item->nama_ruangan }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- TANGGAL --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Mutasi</label>

                <input type="date"
                       name="tanggal_mutasi"
                       class="form-control"
                       value="{{ date('Y-m-d') }}"
                       required>
            </div>

            {{-- KETERANGAN --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Keterangan</label>

                <textarea name="keterangan"
                          rows="4"
                          class="form-control"
                          placeholder="Contoh: Pemindahan barang ke ruangan baru"></textarea>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">Kembali</a>

                <button type="submit" class="btn btn-primary">
                    Simpan Mutasi
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
    const dataRuangan = @json($ruangan);

    const ruanganSelect = document.getElementById('ruangan_id');
    const namaBarangSelect = document.getElementById('nama_barang');
    const barangSelect = document.getElementById('barang_id');
    const ruanganTujuanSelect = document.getElementById('ruangan_tujuan_id');

    let ruanganAsal = null;

    // RUANGAN CHANGE
    ruanganSelect.addEventListener('change', function () {

        const ruanganId = this.value;
        ruanganAsal = ruanganId;

        namaBarangSelect.innerHTML =
            '<option value="">-- Pilih Nama Barang --</option>';

        barangSelect.innerHTML =
            '<option value="">-- Pilih Nomor Register --</option>';

        if (!ruanganId) return;

        const namaUnik = [];

        dataBarang.forEach(function(item){

            if (
                item.ruangan_id == ruanganId &&
                item.nama_barang &&
                !namaUnik.includes(item.nama_barang)
            ) {
                namaUnik.push(item.nama_barang);
            }

        });

        namaUnik.sort();

        namaUnik.forEach(function(nama){
            namaBarangSelect.innerHTML +=
                `<option value="${nama}">${nama}</option>`;
        });

        // 🔥 FILTER RUANGAN TUJUAN (HAPUS RUANGAN ASAL)
        ruanganTujuanSelect.innerHTML =
            '<option value="">-- Pilih Ruangan Tujuan --</option>';

        dataRuangan.forEach(function(item){

            if (item.id != ruanganId) {

                ruanganTujuanSelect.innerHTML +=
    `<option value="${item.id}">
        ${item.kode_ruangan ?? ''} ${item.kode_ruangan ? '-' : ''} ${item.nama_ruangan ?? ''}
    </option>`;

            }

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