<!DOCTYPE html>
<html lang="en">

<head>

    <title>Cetak Laporan</title>
    <link rel="stylesheet" href="{{ asset('css/cetak.css') }}">

</head>

<body>
    @extends('default')
    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Laporan Penjualan</h2>
            <p>Tanggal Cetak: {{ now()->format('Y-m-d H:i:s') }}</p>
            @if (request()->has('tanggal_awal') || request()->has('tanggal_akhir') || request()->has('search'))
                <div class="filter-info">
                    <p><strong>Filter:</strong>
                        {{ request()->input('tanggal_awal') ? 'Dari ' . request()->input('tanggal_awal') : '' }}
                        {{ request()->input('tanggal_akhir') ? 'Sampai ' . request()->input('tanggal_akhir') : '' }}
                        {{ request()->input('search') ? ' | Pencarian: ' . request()->input('search') : '' }}
                    </p>
                </div>
            @endif
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>ID TRANSAKSI</th>
                    <th>ID BARANG</th>
                    <th>JUMLAH BARANG</th>
                    <th>HARGA SATUAN</th>
                    <th>TANGGAL TRANSAKSI</th>
                    <th>TOTAL TRANSAKSI</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($penjualans) && $penjualans->count() > 0)
                    @foreach ($penjualans as $penjualan)
                        @foreach ($penjualan->detilPenjualan as $detil)
                            <tr>
                                <td>{{ $penjualan->id_transaksi }}</td>
                                <td>{{ $detil->id_barang }}</td>
                                <td>{{ $detil->jml_barang }}</td>
                                <td>{{ $detil->harga_satuan }}</td>
                                <td>{{ $penjualan->tgl_transaksi }}</td>
                                <td>{{ $penjualan->total_transaksi }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">Data Tidak Tersedia.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary">Cetak</button>
            <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };

        // Close window after printing
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 1000);
        };
    </script>
</body>

</html>
