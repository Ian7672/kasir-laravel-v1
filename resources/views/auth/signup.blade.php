<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sign Up Page</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
  @extends('default')
    <div class="container">
        <h2>Daftar</h2>
        <form method="POST" action="{{ route('signup.submit') }}">
            @csrf

            <input type="text" name="username" placeholder="Username (minimal 3 karakter)" value="{{ old('username') }}"
                required minlength="3" maxlength="20">

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>

            <input type="password" name="password" placeholder="Password (minimal 6 karakter)" required minlength="6">

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

            <select name="role" id="role" required onchange="toggleAdminToken()">
                <option value="">Pilih Role</option>
                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

            <div id="admin-token-field">
                <input type="password" name="admin_token" placeholder="Token Admin" value="{{ old('admin_token') }}">
                <div class="token-info">
                    <strong>Informasi:</strong> Token admin diperlukan untuk mendaftar sebagai admin.
                    Hubungi administrator sistem untuk mendapatkan token.
                </div>
            </div>

            <button type="submit" class="signup-btn">Daftar</button>
        </form>

        @if (session('error'))
            <p class="text-danger text-center">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <div class="text-danger text-center">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="signin-link">
            <p>Sudah punya akun? <a href="{{ route('signin') }}">Masuk di sini</a></p>
        </div>
    </div>

    <script>
        function toggleAdminToken() {
            const role = document.getElementById('role').value;
            const tokenField = document.getElementById('admin-token-field');

            if (role === 'admin') {
                tokenField.style.display = 'block';
            } else {
                tokenField.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleAdminToken();
        });
    </script>
</body>

</html>
