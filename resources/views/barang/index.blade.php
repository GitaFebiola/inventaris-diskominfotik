@extends('layouts.admin')

@section('title','Pengadaan Barang')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h5>Pengadaan Barang</h5>

        <a href="{{ route('barang.create') }}"
           class="btn btn-primary">

            Tambah Barang

        </a>

    </div>

    <div class="card-body">
        <x-search-bar
    :action="route('barang.index')"
    placeholder="Cari nomor register, nama barang, atau lainnya..." />

<x-responsive-table>

    <table class="table table-bordered table-striped align-middle">
            <thead>

            <tr>

                <th>No</th>

                <th>Register</th>

                <th>Nama Barang</th>

                <th>Kategori</th>

                <th>Ruangan</th>

                <th>Kondisi</th>

                <th>Status</th>

                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            @foreach($barang as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->nomor_register }}</td>

                <td>{{ $item->nama_barang }}</td>

                <td>{{ $item->kategori->nama_kategori }}</td>

                <td>{{ $item->ruangan->nama_ruangan }}</td>

                <td>{{ $item->kondisi }}</td>

                <td>{{ $item->status }}</td>

                <td>

    <a href="{{ route('barang.show',$item->id) }}"
       class="btn btn-info btn-sm">

        Detail

    </a>

    <a href="{{ route('barang.edit',$item->id) }}"
       class="btn btn-warning btn-sm">

        Edit

    </a>

</td>

            </tr>

            @endforeach

            </tbody>

        </table>
        </x-responsive-table>
        <div class="mt-3">

    {{ $barang->links() }}

</div>

    </div>

</div>


@endsection