@extends('layouts.admin')

@section('title','Edit Merk')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Edit Merk</h5>
    </div>

    <div class="card-body">

        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route('merk.update', $merk->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    class="form-select"
                    required>

                    <option value="">
                        Pilih Kategori
                    </option>

                    @foreach($kategori as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kategori_id', $merk->kategori_id) == $item->id ? 'selected' : '' }}>

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
                    value="{{ old('nama_merk', $merk->nama_merk) }}"
                    required>

            </div>

            <div class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn btn-primary">

                    Simpan Perubahan

                </button>

                <a href="{{ route('merk.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection