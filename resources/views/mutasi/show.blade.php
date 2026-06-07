@extends('layouts.admin')

@section('title','Detail Mutasi')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Detail Mutasi</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">
                    Tanggal Mutasi
                </th>
                <td>
                    {{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->format('d-m-Y') }}
                </td>
            </tr>

            <tr>
                <th>
                    Nomor Register
                </th>
                <td>
                    {{ $mutasi->barang->nomor_register }}
                </td>
            </tr>

            <tr>
                <th>
                    Nama Barang
                </th>
                <td>
                    {{ $mutasi->barang->nama_barang }}
                </td>
            </tr>

            <tr>
                <th>
                    Ruangan Asal
                </th>
                <td>
                    {{ $mutasi->ruanganAsal->nama_ruangan }}
                </td>
            </tr>

            <tr>
                <th>
                    Ruangan Tujuan
                </th>
                <td>
                    {{ $mutasi->ruanganTujuan->nama_ruangan }}
                </td>
            </tr>

            <tr>
                <th>
                    Keterangan
                </th>
                <td>
                    {{ $mutasi->keterangan ?? '-' }}
                </td>
            </tr>

        </table>

        <a href="{{ route('mutasi.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

@endsection