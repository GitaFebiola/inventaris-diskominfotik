@extends('layouts.admin')

@section('title','Pemeliharaan Barang')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Pemeliharaan</h5>

        <a href="{{ route('pemeliharaan.create') }}"
           class="btn btn-primary">

            Tambah Pemeliharaan

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
                    <th>Barang</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @foreach($pemeliharaan as $item)

            <tr>

                <td></td>
                <td>{{ $item->tanggal_pemeliharaan }}</td>
                <td>
                    {{ $item->barang->nomor_register }}
                </td>

                <td>
                    {{ $item->barang->nama_barang }}
                </td>

                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->keterangan }}
                </td>
                <td>

                    <a href="{{ route('pemeliharaan.show',$item->id) }}"
                       class="btn btn-info btn-sm">

                        Detail

                    </a>

                    @if($item->status=='Proses')

                    <form
                        action="{{ route('pemeliharaan.selesai',$item->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <button
                            class="btn btn-success btn-sm">

                            Selesai

                        </button>

                    </form>

                    @endif

                </td>

            </tr>

            @endforeach
            </tbody>
</x-datatable>    </div>
</div>


@endsection