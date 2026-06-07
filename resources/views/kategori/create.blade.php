@extends('layouts.admin')

@section('title','Tambah Kategori')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Tambah Kategori</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('kategori.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>
                    Kode BMD
                </label>

                <input type="text"
                       name="kode_bmd"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label>
                    Nama Kategori
                </label>

                <input type="text"
                       name="nama_kategori"
                       class="form-control"
                       required>

            </div>

            <a href="{{ route('kategori.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

            <button class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection