<!DOCTYPE html>
<html lang="en">

<head>

    <title>Tambah Data User</title>


    <link rel="stylesheet" href="{{ asset('css/action.css') }}">

<body>
    @extends('default')
    <div class="container post-container">
        <div class="card">
            <div class="card-body">
                <h2>Tambah User</h2>
                <form action="{{ route('store_user') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" placeholder="Masukkan Username" required>
                        @error('username')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" placeholder="Masukkan Email" required>
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Masukkan Password" required>
                        @error('password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-control @error('role') is-invalid @enderror" name="role" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="karyawan" selected>Karyawan</option>
                        </select>
                        @error('role')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group button-group">
                        <button type="submit" class="signup-btn button">Simpan User</button>
                        <a href="{{ route('user') }}" class="btn-warning button"
                            style="padding: 15px; text-align: center; border: none; border-radius: 5px; cursor: pointer; font-size: 18px; font-weight: bold; width: 100%; text-decoration: none;">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sidebar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
