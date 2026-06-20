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

    {{-- AKTIVITAS TERBARU (DIPINDAH KE ATAS) --}}
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

                            <th>
                                Tanggal
                            </th>

                            <th>
                                No Register
                            </th>

                            <th>
                                Aktivitas
                            </th>

                            <th>
                                Barang
                            </th>

                            <th >
                                Dilakukan Oleh
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse(collect($aktivitas)->sortByDesc('tanggal') as $item)

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
                                {{ $item['user'] ?? '-' }}
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

    {{-- BARIS GRAFIK 1: KATEGORI & KONDISI --}}
    <div class="row mb-4">
        
        {{-- GRAFIK INVENTARIS KATEGORI --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="mb-0">Grafik Jumlah Barang per Kategori</h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="grafikKategori"></canvas>
                </div>
            </div>
        </div>

        {{-- GRAFIK KONDISI BARANG (IDE BARU) --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="mb-0">Kondisi Barang Saat Ini</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 350px;">
                    <canvas id="grafikKondisi"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- BARIS GRAFIK 2: TREN BULANAN --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Tren Pengadaan 6 Bulan Terakhir</h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="grafikTren"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// ==========================================
// 1. GRAFIK KATEGORI (BAR CHART)
// ==========================================
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
                    'rgba(99, 102, 241, 0.75)',   // Indigo
                    'rgba(59, 130, 246, 0.75)',   // Blue
                    'rgba(14, 165, 233, 0.75)',   // Sky
                    'rgba(20, 184, 166, 0.75)',   // Teal
                    'rgba(34, 197, 94, 0.75)',    // Green
                    'rgba(234, 179, 8, 0.75)',    // Yellow
                    'rgba(249, 115, 22, 0.75)',   // Orange
                    'rgba(239, 68, 68, 0.75)'    // Red
                ],
                hoverBackgroundColor: [
                    'rgba(99, 102, 241, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(14, 165, 233, 1)',
                    'rgba(20, 184, 166, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(234, 179, 8, 1)',
                    'rgba(249, 115, 22, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderRadius: 8,          
                borderSkipped: false,     
                borderWidth: 0,           
                barPercentage: 0.6,
                categoryPercentage: 0.7

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false 
                },
                tooltip: {
                    backgroundColor: '#0f172a', 
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 6,
                    displayColors: false
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0,
                        color: '#64748b', 
                        font: { size: 12 }
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)', 
                        drawBorder: false,
                    },
                    border: {
                        display: false 
                    }

                },

                x: {
                    ticks: {
                        color: '#475569',
                        font: { size: 12 }
                    },
                    grid: {
                        display: false 
                    },
                    border: {
                        display: false 
                    }
                }

            }

        }

    });
}

// ==========================================
// 2. GRAFIK KONDISI BARANG (DOUGHNUT CHART)
// ==========================================
const ctxKondisi = document.getElementById('grafikKondisi');
if(ctxKondisi) {
    new Chart(ctxKondisi, {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                data: [
                    {{ $grafikKondisi['Baik'] }}, 
                    {{ $grafikKondisi['Rusak Ringan'] }}, 
                    {{ $grafikKondisi['Rusak Berat'] }}
                ],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.85)',  
                    'rgba(249, 115, 22, 0.85)', 
                    'rgba(239, 68, 68, 0.85)'   
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            cutout: '70%', 
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { color: '#475569', padding: 15, usePointStyle: true, pointStyle: 'circle' } 
                },
                tooltip: { backgroundColor: '#0f172a', padding: 12, cornerRadius: 6 }
            }
        }
    });
}

// ==========================================
// 3. GRAFIK TREN BULANAN (LINE CHART)
// ==========================================
const ctxTren = document.getElementById('grafikTren');
if(ctxTren) {
    new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: [{!! implode(',', array_map(function($lbl) { return "'$lbl'"; }, $labelsBulan)) !!}],
            datasets: [{
                label: 'Total Barang Masuk',
                data: [{!! implode(',', $trenBulanan) !!}],
                borderColor: 'rgba(99, 102, 241, 1)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: 'rgba(99, 102, 241, 1)',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true, 
                tension: 0.4 
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false }, 
                tooltip: { backgroundColor: '#0f172a', padding: 12, cornerRadius: 6, displayColors: false } 
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { precision: 0, color: '#64748b' }, 
                    grid: { color: 'rgba(148, 163, 184, 0.15)', drawBorder: false }, 
                    border: { display: false } 
                },
                x: { 
                    ticks: { color: '#475569' }, 
                    grid: { display: false }, 
                    border: { display: false } 
                }
            }
        }
    });
}

</script>

@endsection