@extends('layouts.admin')

@section('title', 'Dashboard Inventaris')

@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Dashboard Inventaris
        </h1>

    </div>

    <div class="row">

        {{-- TOTAL BARANG --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow h-100 py-2"
                 style="border-left:5px solid #4e73df;">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">

                                Total Barang

                            </div>

                            <div class="h5 mb-0 fw-bold">

                                {{ number_format($totalBarang) }}

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-box fa-2x text-secondary opacity-50"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TOTAL NILAI ASET --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow h-100 py-2"
                 style="border-left:5px solid #1cc88a;">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs fw-bold text-success text-uppercase mb-1">

                                Total Nilai Aset

                            </div>

                            <div class="h5 mb-0 fw-bold">

                                Rp {{ number_format($totalNilaiAset,0,',','.') }}

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-money-bill-wave fa-2x text-secondary opacity-50"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- PERBAIKAN --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow h-100 py-2"
                 style="border-left:5px solid #f6c23e;">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">

                                Barang Perbaikan

                            </div>

                            <div class="h5 mb-0 fw-bold">

                                {{ $totalPerbaikan }}

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-tools fa-2x text-secondary opacity-50"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- DIHAPUS --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card shadow h-100 py-2"
                 style="border-left:5px solid #e74a3b;">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">

                                Barang Dihapus

                            </div>

                            <div class="h5 mb-0 fw-bold">

                                {{ $totalDihapus }}

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-trash fa-2x text-secondary opacity-50"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    {{-- GRAFIK INVENTARIS --}}
<div class="card shadow mb-4">

    <div class="card-header">

        <h5 class="mb-0">
            Grafik Jumlah Barang per Kategori
        </h5>

    </div>

    <div class="card-body">

        <canvas id="grafikKategori"></canvas>

    </div>

</div>

    {{-- AKTIVITAS TERBARU --}}
    <div class="card shadow mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Aktivitas Inventaris Terbaru
            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>

                        <tr>

                            <th width="150">
                                Tanggal
                            </th>

                            <th width="180">
                                No Register
                            </th>

                            <th width="180">
                                Aktivitas
                            </th>

                            <th>
                                Barang
                            </th>

                            <th width="120">
                                User
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($aktivitas as $item)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item['nomor_register'] ?? '-' }}
                            </td>

                            <td>

                                @if($item['aksi'] == 'Pengadaan')

                                    <span class="badge bg-primary">
                                        Pengadaan
                                    </span>

                                @elseif($item['aksi'] == 'Mutasi')

                                    <span class="badge bg-success">
                                        Mutasi
                                    </span>

                                @elseif($item['aksi'] == 'Perbaikan')

                                    <span class="badge bg-warning text-dark">
                                        Perbaikan
                                    </span>

                                @elseif($item['aksi'] == 'Selesai Perbaikan')

                                    <span class="badge bg-info">
                                        Selesai Perbaikan
                                    </span>

                                @elseif($item['aksi'] == 'Penghapusan')

                                    <span class="badge bg-danger">
                                        Penghapusan
                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $item['barang'] }}

                            </td>

                            <td>

                                Admin

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center">

                                Belum ada aktivitas.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const grafikKategori = document.getElementById('grafikKategori');

if(grafikKategori)
{
    new Chart(grafikKategori, {

        type: 'bar',

        data: {

            labels: [

                @foreach($grafikKategori as $item)

                    '{{ $item->nama_kategori }}',

                @endforeach

            ],

            datasets: [{

                label: 'Jumlah Barang',

                data: [

                    @foreach($grafikKategori as $item)

                        {{ $item->barang_count }},

                    @endforeach

                ],

                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#858796',
                    '#20c997',
                    '#6f42c1'
                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    }

                }

            }

        }

    });
}

</script>

@endsection