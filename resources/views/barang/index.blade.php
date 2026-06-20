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
        @php
 $bulanList = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
@endphp

<form method="GET" action="{{ route('barang.index') }}" class="mb-3 d-flex gap-2 align-items-center flex-wrap">

    {{-- BULAN --}}
    <select name="bulan" class="form-select shadow-sm rounded-3" style="max-width: 200px;">
        <option value="">Pilih Bulan</option>
        @foreach($bulanList as $key => $value)
            <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>

    {{-- TAHUN --}}
    <select name="tahun" class="form-select shadow-sm rounded-3" style="max-width: 150px;">
        <option value="">Tahun</option>
        @for($i = date('Y'); $i >= 2020; $i--)
            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                {{ $i }}
            </option>
        @endfor
    </select>

    {{-- KONDISI --}}
    <select name="kondisi" class="form-select shadow-sm rounded-3" style="max-width: 180px;">
        <option value="">Kondisi</option>
        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
        <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak (Semua)</option>
        <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
        <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
    </select>

    {{-- BUTTON FILTER --}}
    <button type="submit" class="btn btn-primary shadow-sm px-3 rounded-3">
        <i class="fas fa-filter"></i> Filter
    </button>

    {{-- TOMBOL REFRESH (Hanya muncul jika ada filter aktif) --}}
    @if(request('bulan') || request('tahun') || request('kondisi') || request('search'))
        <a href="{{ route('barang.index') }}" 
           class="btn btn-outline-secondary shadow-sm px-3 rounded-3" 
           title="Hapus Filter">
            <i class="fas fa-sync-alt"></i> Refresh
        </a>
    @endif

    {{-- PDF --}}
    <a href="{{ route('barang.pdf', request()->all()) }}"
       class="btn btn-success shadow-sm px-3 rounded-3">
        <i class="fas fa-file-pdf"></i> Unduh PDF
    </a>

    {{-- DISPLAY SELECTED FILTER --}}
    @if(request('bulan') || request('tahun') || request('kondisi') || request('search'))
        <div class="ms-3 text-muted small w-100 mt-1">
            <strong>Filter aktif:</strong>
            {{ $bulanList[request('bulan')] ?? '-' }}
            {{ request('tahun') ?? '' }}
            {{ request('kondisi') ? '| Kondisi: ' . request('kondisi') : '' }}
            {{ request('search') ? '| Cari: ' . request('search') : '' }}
        </div>
    @endif

</form>

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

                <th>Keterangan</th>

                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            @foreach($barang as $index => $item) <!-- Tambah $index untuk nomor urut -->

            <tr>

                <td class="text-center">{{ $index + 1 }}</td> <!-- Tampilkan Nomor -->

                <td>{{ $item->created_at->format('d-m-Y') }}</td> <!-- Format Tanggal -->

                <td>{{ $item->nomor_register }}</td>

                <td>{{ $item->nama_barang }}</td>

                <td>{{ $item->kategori->nama_kategori }}</td>

                <td>{{ $item->ruangan->nama_ruangan }}</td>

                <td>{{ $item->kondisi }}</td>
                
                {{-- DIUBAH: Logika tampilan Status --}}
                <td>
                    {{ $item->status == 'Aktif' ? 'Bagus' : $item->status }}
                </td>
                <td>{{ $item->keterangan ?? '-' }}</td>

                <td class="text-nowrap text-center">

    <a href="{{ route('barang.show', $item->id) }}"
       class="btn btn-info btn-sm" title="Detail">
        <span class="d-none d-sm-inline-block"> Detail</span>
    </a>

    <a href="{{ route('barang.edit', $item->id) }}"
       class="btn btn-warning btn-sm" title="Edit">
        <span class="d-none d-sm-inline-block"> Edit</span>
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