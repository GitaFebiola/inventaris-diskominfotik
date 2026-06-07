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

            <div class="mb-3">

                <label>Barang</label>

                <select
                    name="barang_id"
                    id="barang_id"
                    class="form-select"
                    required>

                    <option value="">
                        Cari Barang...
                    </option>

                    @foreach($barang as $item)

                    <option value="{{ $item->id }}">

                        {{ $item->nomor_register }}
                        |
                        {{ $item->nama_barang }}

                    </option>

                    @endforeach

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

                    <option>
                        Rusak Berat
                    </option>

                    <option>
                        Hilang
                    </option>

                    <option>
                        Musnah
                    </option>

                    <option>
                        Lelang
                    </option>

                    <option>
                        Lainnya
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="form-control"></textarea>

            </div>

            <button
                class="btn btn-danger">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>

$(document).ready(function(){

    $('#barang_id').select2({
        width:'100%'
    });

});

</script>

@endsection