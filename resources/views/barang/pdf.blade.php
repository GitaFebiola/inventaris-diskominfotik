<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Barang</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }

        /* Styling Kop Surat */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
        
        .kop-surat h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .kop-surat h4 {
            margin: 0;
            font-size: 12pt;
            font-weight: normal;
        }

        .kop-surat p {
            margin: 2px 0;
            font-size: 10pt;
        }

        .periode-info {
            margin-top: 5px;
            font-weight: bold;
            font-size: 11pt;
        }

        h2.judul-laporan {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            text-decoration: underline;
            font-size: 14pt;
            text-transform: uppercase;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td{
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        th{
            background: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-center{
            text-align: center;
        }

        .text-right{
            text-align: right;
        }
        
        /* Footer Style */
        .footer-print {
            text-align: right;
            color: #808080; /* Warna Abu-abu */
            font-size: 9px;
            margin-top: 50px; /* Jarak dari tabel */
        }
    </style>
</head>
<body>

    @php
        // Definisikan array bulan di sini agar tidak perlu ubah controller
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $namaBulan = request('bulan') ? $bulanList[request('bulan')] : '';
        $tahun = request('tahun');
    @endphp

    <!-- Kop Surat Diskominfotik -->
    <div class="kop-surat">
        <h3>Pemerintah Kabupaten Bengkalis</h3>
        <h3>DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK</h3>
        <h4>(DISKOMINFOTIK)</h4>
        <p>Jl. Kartini No. 012, Kode Pos 28712, Bengkalis, Riau</p>
        <p>Website: Website Resmi Diskominfotik Bengkalis | Email: diskominfotik@bengkaliskab.go.id</p>

        <!-- Tambahan Periode di bawah Header/Kop -->
        @if($namaBulan || $tahun)
            <div class="periode-info">
                Periode: {{ $namaBulan }} {{ $tahun }}
            </div>
        @endif
    </div>

    <!-- Judul Laporan -->
    <h2 class="judul-laporan">Laporan Inventaris Barang</h2>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="9%">Tgl Input</th>
                <th width="10%">No Register</th>
                <th width="15%">Nama Barang</th>
                <th width="10%">Kategori</th>
                <th width="10%">Ruangan</th>
                <th width="10%">Merk</th>
                <th width="10%">Sumber Anggaran</th>
                <th width="15%">Spesifikasi</th>
                <th width="5%">Tahun</th>
                <th width="10%">Harga</th>
                <th width="7%">Kondisi</th>
                <th width="15%">Keterangan</th>
                <!-- <th width="7%">Status</th> -->
            </tr>
        </thead>

        <tbody>
            @forelse($barang as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>

                <td class="text-center">
                    {{ $item->created_at->format('d-m-Y') }}
                </td>

                <td>{{ $item->nomor_register }}</td>

                <td>{{ $item->nama_barang }}</td>

                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>

                <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>

                <td>{{ $item->merk ?? '-' }}</td>

                <td>
                    {{ $item->Sumber ?? '-' }}
                </td>

                <td>
                    {{ $item->spesifikasi ?? '-' }}
                </td>

                <td class="text-center">{{ $item->tahun_perolehan }}</td>

                <td class="text-right">
                    Rp {{ number_format($item->harga_perolehan,0,',','.') }}
                </td>

                <td>{{ $item->kondisi }}</td>
                 <td>
                    {{ $item->keterangan ?? '-' }}
                </td>

                <!-- <td>{{ $item->status }}</td> -->
            </tr>
            @empty
            <tr>
                <td colspan="14" class="text-center">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer Kapan Dicetak -->
    <div class="footer-print">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>