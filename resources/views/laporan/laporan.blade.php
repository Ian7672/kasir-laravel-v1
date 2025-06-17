<!DOCTYPE html>
<html lang="en">

<head>

    <title>Dashboard Dinamis</title>
    <script>
        // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    </script>
</head>

<body>

    <div>
        <div class="main-content w-100">
            <!-- Header with Dashboard Title and Search -->
            <div class="header-top">
                <div class="dashboard-info">
                    <div class="dashboard-title">{{ auth()->user()->username }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search by ID" onkeyup="searchTable()">
                </div>
            </div>
            <!-- Section Laporan -->
            <div id="laporan" class="mb-5">
                <h3 class="text-center my-4">Laporan</h3>
                <hr>
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="tgl" for="tanggal_awal">Tanggal Awal</label>
                                    <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control"
                                        value="{{ request()->input('tanggal_awal', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="tgl" for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control"
                                        value="{{ request()->input('tanggal_akhir', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 mb-2">Tampilkan Laporan</button>

                                </div>
                            </div>
                        </form>
                        <table class="table-bordered mt-4" id="inner-table">
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
                                @if (request()->has('show_all'))
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
                                @endif

                                @if ($penjualans->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Data Tidak Tersedia.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                @if (!request()->has('show_all'))
                                    {{ $penjualans->appends(request()->input())->links('pagination::bootstrap-4') }}
                                @endif
                            </div>
                            <div>
                                @if (request()->has('show_all'))
                                    <a href="{{ url()->current() }}" class="btn btn-secondary">Show Less</a>
                                @else
                                    <a href="{{ url()->current() }}?show_all=true" class="btn btn-secondary">Show
                                        All</a>
                                @endif
                            </div>
                            <div>
                                <form action="{{ route('laporan.cetak') }}" method="GET" target="_blank">
                                    @if (request()->has('tanggal_awal'))
                                        <input type="hidden" name="tanggal_awal"
                                            value="{{ request()->input('tanggal_awal') }}">
                                    @endif
                                    @if (request()->has('tanggal_akhir'))
                                        <input type="hidden" name="tanggal_akhir"
                                            value="{{ request()->input('tanggal_akhir') }}">
                                    @endif
                                    @if (request()->has('show_all'))
                                        <input type="hidden" name="show_all" value="true">
                                    @endif
                                    <!-- Tambahkan input hidden untuk search term -->
                                    <input type="hidden" name="search" id="searchTerm" value="">
                                    <button type="submit" class="btn btn-secondary">Cetak</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sidebar')
    </div>

    <script>
        function cetakLaporan() {
            // Mengumpulkan semua data yang diperlukan
            const reportData = {
                title: "Laporan Penjualan",
                date: new Date().toISOString().split('T')[0],
                filter: {
                    tanggal_awal: document.getElementById('tanggal_awal').value,
                    tanggal_akhir: document.getElementById('tanggal_akhir').value
                },
                transactions: [
                    @foreach ($penjualans as $penjualan)
                        @foreach ($penjualan->detilPenjualan as $detil)
                            {
                                id_transaksi: "{{ $penjualan->id_transaksi }}",
                                id_barang: "{{ $detil->id_barang }}",
                                jumlah: "{{ $detil->jml_barang }}",
                                harga: "{{ $detil->harga_satuan }}",
                                tanggal: "{{ $penjualan->tgl_transaksi }}",
                                total: "{{ $penjualan->total_transaksi }}"
                            },
                        @endforeach
                    @endforeach
                ]
            };

            // Buka window baru dan kirim data
            const printWindow = window.open('{{ route('laporan.cetak') }}', '_blank');

            // Tunggu window siap lalu kirim data
            printWindow.onload = function() {
                printWindow.postMessage({
                    type: 'REPORT_DATA',
                    data: reportData
                }, '*');
            };
        }

        // Fungsi untuk mencari data dalam tabel berdasarkan ID Transaksi
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('inner-table');
            const tr = table.getElementsByTagName('tr');

            // Loop melalui semua baris tabel, sembunyikan yang tidak cocok
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[0]; // Kolom pertama (ID TRANSAKSI)
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        document.querySelector('form[action="{{ route('laporan.cetak') }}"]').addEventListener('submit', function() {
            document.getElementById('searchTerm').value = document.getElementById('searchInput').value;
        });
    </script>
</body>

</html>
