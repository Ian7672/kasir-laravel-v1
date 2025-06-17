<!DOCTYPE html>
<html lang="en">

<head>

    <title>Tambah Data Pelanggan</title>
    <link rel="stylesheet" href="{{ asset('css/action.css') }}">
</head>

<body>
    @extends('default')
    <div class="container post-container">
        <div class="card">
            <div class="card-body">
                <h2>Tambah Pelanggan</h2>
                <form action="{{ route('storepelanggan') }}" method="POST" id="pelangganForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            id="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Pelanggan">
                        <div id="nama-error" class="alert alert-danger mt-2" style="display: none;"></div>
                        @error('nama')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                            <option value="">Pilih Gender</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group button-group">
                        <button type="submit" class="signup-btn button" id="submitBtn">Simpan</button>
                        <a href="{{ route('pelanggan') }}" class="btn-warning button"
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
            // Cek ketersediaan nama saat form submit
            $('#pelangganForm').on('submit', function(e) {
                e.preventDefault();
                const nama = $('#nama').val().trim();

                if (nama === '') {
                    $('#nama-error').text('Nama pelanggan harus diisi').show();
                    return;
                }

                // Disable tombol submit untuk mencegah multiple click
                $('#submitBtn').prop('disabled', true);

                // Cek ketersediaan nama via AJAX
                $.ajax({
                    url: '{{ route('check.pelanggan') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nama: nama
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#nama-error').text('Nama pelanggan sudah ada').show();
                            $('#submitBtn').prop('disabled', false);
                        } else {
                            // Jika nama tersedia, submit form
                            $('#pelangganForm').off('submit').submit();
                        }
                    },
                    error: function() {
                        $('#nama-error').text('Terjadi kesalahan saat memeriksa nama').show();
                        $('#submitBtn').prop('disabled', false);
                    }
                });
            });

            // Sembunyikan pesan error saat user mulai mengetik
            $('#nama').on('input', function() {
                $('#nama-error').hide();
            });
        });
    </script>
</body>

</html>
