@extends('layouts.admin')

@section('title','Tambah Merk')

@section('content')

<div class="card">

    <div class="card-header">
        <h5>Tambah Merk</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('merk.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    class="form-control"
                    required>

                    <option value="">
                        Pilih Kategori
                    </option>

                    @foreach($kategori as $item)

                    <option value="{{ $item->id }}">
                        {{ $item->nama_kategori }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nama Merk
                </label>

                <input
                    type="text"
                    name="nama_merk"
                    class="form-control"
                    required>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection