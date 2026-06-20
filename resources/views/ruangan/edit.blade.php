@extends('layouts.admin')

@section('title','Edit Ruangan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Edit Ruangan</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('ruangan.update',$ruangan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Nama Ruangan</label>

                <input
                    type="text"
                    name="nama_ruangan"
                    value="{{ $ruangan->nama_ruangan }}"
                    class="form-control">

            </div>

            <div class="mb-3">

                <label>Pengurus Barang</label>

                <input
                    type="text"
                    name="penanggung_jawab"
                    value="{{ $ruangan->penanggung_jawab }}"
                    class="form-control">

            </div>

            <a href="{{ route('ruangan.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

            <button
                class="btn btn-warning">

                Update

            </button>

        </form>

    </div>

</div>

@endsection