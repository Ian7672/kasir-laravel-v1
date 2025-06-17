<!DOCTYPE html>
<html lang="en">

<head>

    <title>Tambah Data Barang</title>
    <link rel="stylesheet" href="{{ asset('css/action.css') }}">
</head>

<body>
    @extends('default')
    <div class="container post-container">
        <div class="card">
            <div class="card-body">
                <h2>Tambah Barang</h2>
                <form action="{{ route('storeBarang') }}" method="POST" id="barangForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                            name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                            placeholder="Masukkan Nama Barang">
                        <div id="nama_barang-error" class="alert alert-danger mt-2" style="display: none;"></div>
                        @error('nama_barang')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga Barang</label>
                        <input type="number" class="form-control @error('harga_barang') is-invalid @enderror"
                            name="harga_barang" value="{{ old('harga_barang') }}" placeholder="Masukkan Harga Barang">
                        @error('harga_barang')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stock Barang</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                            value="{{ old('stock') }}" placeholder="Masukkan Stock Barang">
                        @error('stock')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group button-group">
                        <button type="submit" class="signup-btn button" id="submitBtn">Simpan</button>
                        <a href="{{ route('barang') }}" class="btn-warning button"
                            style="padding: 15px; text-align: center; border: none; border-radius: 5px; cursor: pointer; font-size: 18px; font-weight: bold; width: 100%; text-decoration: none;">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sidebar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cek ketersediaan nama barang saat form submit
            $('#barangForm').on('submit', function(e) {
                e.preventDefault();
                const nama_barang = $('#nama_barang').val().trim();

                if (nama_barang === '') {
                    $('#nama_barang-error').text('Nama barang harus diisi').show();
                    return;
                }

                // Disable tombol submit untuk mencegah multiple click
                $('#submitBtn').prop('disabled', true);

                // Cek ketersediaan nama barang via AJAX
                $.ajax({
                    url: '{{ route('check.barang') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nama_barang: nama_barang
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#nama_barang-error').text('Nama barang sudah ada').show();
                            $('#submitBtn').prop('disabled', false);
                        } else {
                            // Jika nama tersedia, submit form
                            $('#barangForm').off('submit').submit();
                        }
                    },
                    error: function() {
                        $('#nama_barang-error').text('Terjadi kesalahan saat memeriksa nama')
                            .show();
                        $('#submitBtn').prop('disabled', false);
                    }
                });
            });

            // Sembunyikan pesan error saat user mulai mengetik
            $('#nama_barang').on('input', function() {
                $('#nama_barang-error').hide();
            });
        });
    </script>
</body>

</html>
