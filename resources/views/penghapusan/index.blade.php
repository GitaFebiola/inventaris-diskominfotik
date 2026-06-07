@extends('layouts.admin')

@section('title','Penghapusan Barang')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Penghapusan</h5>

        <a href="{{ route('penghapusan.create') }}"
           class="btn btn-danger">

            Tambah Penghapusan

        </a>

    </div>

    <div class="card-body">
        <x-search-bar
    :action="route('penghapusan.index')"
    placeholder="Cari penghapusan..." />

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Register</th>
                    <th>Barang</th>
                    <th>Alasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @foreach($penghapusan as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->tanggal_penghapusan }}</td>

                <td>{{ $item->barang->nomor_register }}</td>

                <td>{{ $item->barang->nama_barang }}</td>

                <td>{{ $item->alasan }}</td>

                <td>

                    <a href="{{ route('penghapusan.show',$item->id) }}"
                       class="btn btn-info btn-sm">

                        Detail

                    </a>

                </td>

            </tr>

            @endforeach

            </tbody>

        </table>
        {{ $penghapusan->links() }}

    </div>

</div>

@endsection