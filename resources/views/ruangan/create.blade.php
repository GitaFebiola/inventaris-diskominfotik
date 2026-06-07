@extends('layouts.admin')

@section('title','Tambah Ruangan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Tambah Ruangan</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('ruangan.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>Nama Ruangan</label>

                <input
                    type="text"
                    name="nama_ruangan"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Penanggung Jawab</label>

                <input
                    type="text"
                    name="penanggung_jawab"
                    class="form-control">

            </div>

            <a href="{{ route('ruangan.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

            <button
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection