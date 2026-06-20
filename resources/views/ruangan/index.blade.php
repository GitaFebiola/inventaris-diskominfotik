@extends('layouts.admin')

@section('title','Ruangan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Ruangan</h5>

        <a href="{{ route('ruangan.create') }}"
           class="btn btn-primary">

            Tambah Ruangan

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

<x-datatable>

<table class="table table-bordered table-striped align-middle datatable">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Ruangan</th>
                <th>Pengurus Barang</th>
                <th>Aksi</th>
            </tr>
            </thead>

            <tbody>

            @forelse($ruangan as $item)

            <tr>

                <td></td>

                <td>{{ $item->nama_ruangan }}</td>

                <td>{{ $item->penanggung_jawab }}</td>

                <td>

                    <a href="{{ route('ruangan.edit',$item->id) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form
                        action="{{ route('ruangan.destroy',$item->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        <!-- @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus data?')">

                            Hapus

                        </button> -->

                    </form>

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5" class="text-center">
                    Data kosong
                </td>
            </tr>

            @endforelse

            </tbody>

</x-datatable>

    </div>

</div>

@endsection