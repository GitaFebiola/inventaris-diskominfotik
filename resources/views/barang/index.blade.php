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

<x-datatable>

<table class="table table-bordered table-striped align-middle datatable">
            <thead>

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>No Register</th>

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

                <td></td>

                <td>{{ $item->created_at }}</td>

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
</x-datatable>
            <div class="mt-3">


</div>

    </div>

</div>


@endsection