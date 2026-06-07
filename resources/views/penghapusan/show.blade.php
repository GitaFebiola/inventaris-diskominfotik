@extends('layouts.admin')

@section('title','Detail Penghapusan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Detail Penghapusan</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">
                    Nomor Register
                </th>
                <td>
                    {{ $penghapusan->barang->nomor_register }}
                </td>
            </tr>

            <tr>
                <th>Nama Barang</th>
                <td>
                    {{ $penghapusan->barang->nama_barang }}
                </td>
            </tr>

            <tr>
                <th>Tanggal Penghapusan</th>
                <td>
                    {{ $penghapusan->tanggal_penghapusan }}
                </td>
            </tr>

            <tr>
                <th>Alasan</th>
                <td>
                    {{ $penghapusan->alasan }}
                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>
                    {{ $penghapusan->keterangan ?? '-' }}
                </td>
            </tr>

        </table>

        <a href="{{ route('penghapusan.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

@endsection