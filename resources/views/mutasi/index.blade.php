@extends('layouts.admin')

@section('title','Mutasi Barang')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Mutasi</h5>

        <a href="{{ route('mutasi.create') }}"
           class="btn btn-primary">

            Tambah Mutasi

        </a>

    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

<x-datatable>

<table class="table table-bordered table-striped align-middle datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Register</th>
                    <th>Barang</th>
                    <th>Ruangan Asal</th>
                    <th>Ruangan Tujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($mutasi as $item)

            <tr>

                <td></td>
                <td>{{ $item->tanggal_mutasi }}</td>
                <td>{{ $item->barang->nomor_register }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ $item->ruanganAsal->nama_ruangan }}</td>
                <td>{{ $item->ruanganTujuan->nama_ruangan }}</td>
                <td class="text-nowrap text-center">
    <a href="{{ route('mutasi.show', $item->id) }}"
       class="btn btn-info btn-sm" title="Detail">
        <span class="d-none d-sm-inline-block"> Detail</span>
    </a>
    <a href="{{ route('mutasi.edit', $item->id) }}"
       class="btn btn-warning btn-sm" title="Edit">
        <span class="d-none d-sm-inline-block"> Edit</span>
    </a>
</td>

            </tr>

            @empty

            <tr>
                <td colspan="7"
                    class="text-center">

                    Data kosong

                </td>
            </tr>

            @endforelse

            </tbody>
</x-datatable>
    </div>

</div>


@endsection