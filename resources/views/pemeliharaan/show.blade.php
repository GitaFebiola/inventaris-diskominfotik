@extends('layouts.admin')

@section('title','Detail Pemeliharaan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Detail Pemeliharaan</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">
                    Nomor Register
                </th>
                <td>
                    {{ $pemeliharaan->barang->nomor_register }}
                </td>
            </tr>

            <tr>
                <th>Nama Barang</th>
                <td>
                    {{ $pemeliharaan->barang->nama_barang }}
                </td>
            </tr>

            <tr>
                <th>Jenis Pemeliharaan</th>
                <td>
                    {{ $pemeliharaan->jenis_pemeliharaan }}
                </td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    {{ $pemeliharaan->status }}
                </td>
            </tr>

            <tr>
                <th>Biaya</th>
                <td>
                    Rp {{ number_format($pemeliharaan->biaya,0,',','.') }}
                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>
                    {{ $pemeliharaan->keterangan }}
                </td>
            </tr>

        </table>
         <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>

</div>

@endsection