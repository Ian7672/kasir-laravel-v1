<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">
                <i class="fas fa-receipt me-2"></i>
                Memproses transaksi dan membuat invoice...
            </div>
        </div>
    </div>

    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-shopping-cart me-3"></i>Form Penjualan</h1>
            <p>Kelola transaksi penjualan dengan mudah dan cepat</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active">
                <i class="fas fa-user"></i>
                <span>Data Pelanggan</span>
            </div>
            <div class="step">
                <i class="fas fa-box"></i>
                <span>Pilih Barang</span>
            </div>
            <div class="step">
                <i class="fas fa-check-circle"></i>
                <span>Selesai</span>
            </div>
        </div>

        <form action="{{ route('penjualan.store') }}" method="POST" id="salesForm">
            @csrf
            <!-- Customer Information Section -->
            <div class="form-card">
                <div class="section-title">
                    <i class="fas fa-user-circle"></i>
                    <h5>Informasi Pelanggan</h5>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_pelanggan" class="form-label">
                                <i class="fas fa-id-card"></i>
                                ID Pelanggan
                            </label>
                            <select id="id_pelanggan" class="form-select" name="id_pelanggan" required>
                                <option value="">Pilih ID Pelanggan</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->id_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nama" class="form-label">
                                <i class="fas fa-user"></i>
                                Nama Pelanggan
                            </label>
                            <input type="text" id="nama" name="nama_pelanggan" class="form-control" disabled
                                placeholder="Nama akan muncul otomatis">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="gender" class="form-label">
                                <i class="fas fa-venus-mars"></i>
                                Gender
                            </label>
                            <input type="text" id="gender" name="gender_pelanggan" class="form-control" disabled
                                placeholder="Gender akan muncul otomatis">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_transaksi" class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tanggal Transaksi
                            </label>
                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_transaksi" class="form-label">
                                <i class="fas fa-money-bill-wave"></i>
                                Total Transaksi
                            </label>
                            <input type="number" class="form-control" id="total_transaksi" name="total_transaksi"
                                placeholder="Total Transaksi Otomatis" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Selection Section -->
            <div class="form-card">
                <div class="section-title">
                    <i class="fas fa-boxes"></i>
                    <h5>Pilih Barang</h5>
                </div>

                <div class="item-picker">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="id_barang_0" class="form-label">
                                    <i class="fas fa-barcode"></i>
                                    ID Barang
                                </label>
                                <select class="form-select id-barang" id="id_barang_0"
                                    name="detil_penjualan[0][id_barang]">
                                    <option value="">Pilih ID Barang</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id_barang }}">{{ $barang->id_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nama_barang_0" class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Nama Barang
                                </label>
                                <input type="text" class="form-control nama-barang" id="nama_barang_0"
                                    name="detil_penjualan[0][nama_barang]" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="harga_barang_0" class="form-label">
                                    <i class="fas fa-dollar-sign"></i>
                                    Harga Barang
                                </label>
                                <input type="text" class="form-control harga-barang" id="harga_barang_0"
                                    name="detil_penjualan[0][harga_barang]" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="stok_barang_0" class="form-label">
                                    <i class="fas fa-cubes"></i>
                                    Stok Barang
                                </label>
                                <input type="text" class="form-control stock" id="stok_barang_0"
                                    name="detil_penjualan[0][stok_barang]" disabled>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="jumlah_barang_0" class="form-label">
                                    <i class="fas fa-plus-circle"></i>
                                    Jumlah
                                </label>
                                <input type="number" class="form-control jumlah-barang" id="jumlah_barang_0"
                                    name="detil_penjualan[0][jml_barang]">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="harga_satuan_0" class="form-label">
                                    <i class="fas fa-money-check-alt"></i>
                                    Harga Satuan
                                </label>
                                <input type="number" class="form-control harga-satuan" id="harga_satuan_0"
                                    name="detil_penjualan[0][harga_satuan]">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" id="add-to-cart" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shopping Cart Section -->
            <div class="form-card">
                <div class="section-title">
                    <i class="fas fa-shopping-basket"></i>
                    <h5>Keranjang Belanja</h5>
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table id="cart-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-barcode me-2"></i>ID Barang</th>
                                    <th><i class="fas fa-tag me-2"></i>Nama Barang</th>
                                    <th><i class="fas fa-plus-circle me-2"></i>Jumlah</th>
                                    <th><i class="fas fa-dollar-sign me-2"></i>Harga Satuan</th>
                                    <th><i class="fas fa-calculator me-2"></i>Subtotal</th>
                                    <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="empty-cart">
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                        <div>Keranjang masih kosong</div>
                                        <small>Tambahkan barang untuk memulai transaksi</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="cart-summary" id="cart-summary" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> Pastikan semua data sudah benar sebelum menyimpan transaksi.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="total-amount">
                                <i class="fas fa-receipt me-2"></i>
                                Total: <span id="display-total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="form-card">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" id="preview-button"
                        class="btn btn-outline-info btn-outline-dark text-white me-md-2"
                        style="background-color: black;">
                        <i class="fas fa-eye me-2"></i>
                        Lihat Invoice
                    </button>

                    <button type="submit" class="btn btn-primary btn-lg me-md-2" id="save-button">
                        <i class="fas fa-save me-2"></i>
                        Simpan Transaksi
                    </button>

                    <button type="button" class="btn btn-success btn-lg" id="save-print-button">
                        <i class="fas fa-save me-2"></i>
                        <i class="fas fa-print me-2"></i>
                        Simpan dan Cetak
                    </button>
                </div>
            </div>
        </form>

        @include('sidebar')
        @include('default')
    </div>

    <script src="js/form.js"></script>
</body>

</html>
