<!DOCTYPE html>
<html>

<head>
    <title>Invoice Penjualan</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
</head>

<body>
    @extends('default')
    <div class="preview-badge" id="preview-badge">
        <i class="fas fa-eye"></i> PREVIEW MODE
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="invoice-title">
                <i class="fas fa-receipt"></i> INVOICE
            </h1>
            <p class="invoice-subtitle" id="invoice-subtitle">Transaksi Penjualan</p>
        </div>

        <div class="transaction-info">
            <div class="info-card">
                <h3 class="info-title">
                    <i class="fas fa-user-circle"></i>
                    Informasi Pelanggan
                </h3>
                <div class="info-item">
                    <span class="info-label">ID Pelanggan</span>
                    <span class="info-value" id="customer-id"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama</span>
                    <span class="info-value" id="customer-name"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gender</span>
                    <span class="info-value" id="customer-gender"></span>
                </div>
            </div>

            <div class="info-card">
                <h3 class="info-title">
                    <i class="fas fa-calendar-alt"></i>
                    Detail Transaksi
                </h3>
                <div class="info-item">
                    <span class="info-label">Tanggal</span>
                    <span class="info-value" id="transaction-date"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Waktu</span>
                    <span class="info-value" id="transaction-time"></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total Item</span>
                    <span class="info-value" id="total-items"></span>
                </div>
            </div>
        </div>

        <div class="items-section">
            <h2 class="section-title">
                <i class="fas fa-shopping-bag"></i>
                Daftar Barang
            </h2>
            <div id="items-list"></div>
        </div>

        <div class="invoice-summary">
            <div class="summary-row">
                <span class="summary-label">Subtotal</span>
                <span class="summary-value" id="subtotal-amount"></span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Diskon</span>
                <span class="summary-value" id="discount-amount">Rp 0</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Pajak</span>
                <span class="summary-value">Termasuk</span>
            </div>

            <div class="total-amount">
                <div class="total-label">TOTAL PEMBAYARAN</div>
                <div class="total-value" id="total-amount"></div>
            </div>
        </div>

        <div class="action-buttons" id="action-buttons">
            <button class="btn btn-primary" id="print-button">
                <i class="fas fa-print"></i>
                Cetak Invoice
            </button>
            <button class="btn btn-secondary" id="close-button">
                <i class="fas fa-times"></i>
                Tutup Preview
            </button>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengisi data invoice
            function fillInvoiceData(data) {
                console.log('Received data:', data); // Debugging

                // Format currency
                const formatCurrency = (number) => {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                };

                // Generate items HTML if not provided
                if (!data.itemsHTML && data.items) {
                    let itemsHTML = '<table class="items-table">';
                    itemsHTML +=
                        '<thead><tr><th>Nama Barang</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>';

                    data.items.forEach(item => {
                        itemsHTML += `<tr>
                        <td>${item.nama_barang}</td>
                        <td>${item.jml_barang}</td>
                        <td>${formatCurrency(item.harga_satuan)}</td>
                        <td>${formatCurrency(item.jml_barang * item.harga_satuan)}</td>
                    </tr>`;
                    });

                    itemsHTML += '</tbody></table>';
                    data.itemsHTML = itemsHTML;
                }

                // Isi data ke elemen HTML
                if (data.transactionNumber) {
                    document.getElementById('invoice-subtitle').textContent =
                    `Transaksi #${data.transactionNumber}`;
                }
                if (data.pelanggan) {
                    document.getElementById('customer-id').textContent = data.pelanggan;
                }
                if (data.nama) {
                    document.getElementById('customer-name').textContent = data.nama;
                }
                if (data.gender) {
                    document.getElementById('customer-gender').textContent = data.gender;
                }
                if (data.tanggal) {
                    document.getElementById('transaction-date').textContent = data.tanggal;
                }
                if (data.waktu) {
                    document.getElementById('transaction-time').textContent = data.waktu;
                }
                if (data.itemCount) {
                    document.getElementById('total-items').textContent = `${data.itemCount} item`;
                }
                if (data.itemsHTML) {
                    document.getElementById('items-list').innerHTML = data.itemsHTML;
                }
                if (data.totalTransaksi) {
                    document.getElementById('total-amount').textContent = formatCurrency(data.totalTransaksi);
                    document.getElementById('subtotal-amount').textContent = formatCurrency(data.totalTransaksi);
                }

                // Tampilkan tombol aksi jika preview
                if (data.isPreview) {
                    document.getElementById('preview-badge').style.display = 'block';
                    document.getElementById('action-buttons').style.display = 'flex';
                }
            }

            // Cek jika ada data langsung dari server
            @if (isset($isPreview))
                fillInvoiceData({
                    isPreview: @json($isPreview ?? false),
                    transactionNumber: @json($transactionNumber ?? ''),
                    pelanggan: @json($pelanggan ?? ''),
                    nama: @json($nama ?? ''),
                    gender: @json($gender ?? ''),
                    tanggal: @json($tanggal ?? ''),
                    waktu: @json($waktu ?? ''),
                    totalTransaksi: @json($totalTransaksi ?? 0),
                    itemCount: @json($itemCount ?? 0),
                    itemsHTML: @json($itemsHTML ?? '')
                });
            @endif

            // Listen for messages from parent window
            window.addEventListener('message', function(event) {
                console.log('Message received:', event.data); // Debugging
                if (event.data && event.data.type === 'FILL_INVOICE_DATA') {
                    fillInvoiceData(event.data.data);
                }
            });

            // Jika tidak ada data dari server atau parent window, coba request data
            if (!@json(isset($isPreview))) {
                // Kirim pesan ke parent window untuk meminta data
                window.opener?.postMessage({
                    type: 'REQUEST_INVOICE_DATA'
                }, '*');
            }

            // Tombol cetak
            document.getElementById('print-button')?.addEventListener('click', function() {
                window.print();
            });

            // Tombol tutup
            document.getElementById('close-button')?.addEventListener('click', function() {
                window.close();
            });
        });

        // Auto print when window loads (for print-only mode)
        window.addEventListener('load', function() {
            // Check if this is a print-only page
            if (window.location.pathname.includes('/invoice/print/')) {
                window.print();

                // Optional: close window after printing
                window.onafterprint = function() {
                    setTimeout(function() {
                        window.close();
                    }, 500);
                };
            }
        });
    </script>
</body>

</html>
