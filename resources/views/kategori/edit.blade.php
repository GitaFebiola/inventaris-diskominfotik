@extends('layouts.admin')

@section('title','Edit Kategori')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Edit Kategori</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('kategori.update',$kategori->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Kode BMD</label>

                <input type="text"
                       name="kode_bmd"
                       value="{{ $kategori->kode_bmd }}"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Nama Kategori</label>

                <input type="text"
                       name="nama_kategori"
                       value="{{ $kategori->nama_kategori }}"
                       class="form-control">

            </div>

            <a href="{{ route('kategori.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

            <button class="btn btn-warning">

                Update

            </button>

        </form>

    </div>

</div>

@endsection