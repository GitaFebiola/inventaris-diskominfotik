<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Barang</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h2{
            text-align: center;
            margin-bottom: 20px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        th, td{
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        th{
            background: #f2f2f2;
            text-align: center;
        }

        .text-center{
            text-align: center;
        }

        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>LAPORAN DATA BARANG</h2>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th>Tanggal Input</th>
                <th>No Register</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Ruangan</th>
                <th>Merk</th>
                <th>Spesifikasi</th>
                <th>Tahun Perolehan</th>
                <th>Harga Perolehan</th>
                <th>Kondisi</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($barang as $index => $item)
            <tr>
                <td class="text-center">
                    {{ $index + 1 }}
                </td>

                <td>
                    {{ $item->created_at->format('d-m-Y') }}
                </td>

                <td>
                    {{ $item->nomor_register }}
                </td>

                <td>
                    {{ $item->nama_barang }}
                </td>

                <td>
                    {{ $item->kategori->nama_kategori ?? '-' }}
                </td>

                <td>
                    {{ $item->ruangan->nama_ruangan ?? '-' }}
                </td>

                <td>
                    {{ $item->merk ?? '-' }}
                </td>

                <td>
                    {{ $item->spesifikasi ?? '-' }}
                </td>

                <td class="text-center">
                    {{ $item->tahun_perolehan }}
                </td>

                <td class="text-right">
                    Rp {{ number_format($item->harga_perolehan,0,',','.') }}
                </td>

                <td>
                    {{ $item->kondisi }}
                </td>

                <td>
                    {{ $item->status }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>