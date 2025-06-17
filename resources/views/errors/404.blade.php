<!DOCTYPE html>
<html lang="id">

<head>

    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/404.css') }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⚠️</text></svg>">


</head>

<body>
    <div class="error-container fade-in">
        <div class="error-icon">⚠️</div>
        <div class="error-number">404</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p class="error-message">Maaf, halaman yang Anda cari tidak dapat ditemukan.</p>
        <p class="error-description">
            Halaman mungkin telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.
            Silakan periksa kembali alamat atau gunakan tombol di bawah untuk kembali ke halaman utama.
        </p>

        <div class="action-buttons">
            <a href="{{ route('signin') }}" class="btn btn-primary">Kembali ke Beranda</a>
            <button onclick="history.back()" class="btn btn-secondary">Halaman Sebelumnya</button>
        </div>

    </div>

    <script>
        // Auto redirect after 30 seconds
        setTimeout(function() {
            if (confirm('Apakah Anda ingin dialihkan ke halaman utama?')) {
                window.location.href = "{{ route('signin') }}";
            }
        }, 30000);
    </script>
</body>

</html>
