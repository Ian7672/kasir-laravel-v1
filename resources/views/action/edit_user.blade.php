<!DOCTYPE html>
<html lang="en">

<head>

    <title>Edit User</title>

    <link rel="stylesheet" href="{{ asset('css/action.css') }}">
</head>

<body>
    @extends('default')
    <div class="container edit-container">
        <div class="card">
            <div class="card-body">
                <h2>Edit User</h2>
                @if (auth()->user()->role !== 'admin')
                    <div class="alert alert-danger">
                        Anda tidak memiliki akses untuk mengedit user.
                    </div>
                @else
                    <form action="{{ route('update_user', $user->username) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ old('username', $user->username) }}"
                                placeholder="Masukkan Username" required>
                            @error('username')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email"
                                required>
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            @error('password')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                            <div class="password-note">Biarkan kosong jika tidak ingin mengubah password</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role"
                                {{ auth()->user()->username == $user->username ? 'disabled' : '' }} required>
                                <option value="" disabled>Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="karyawan" {{ old('role', $user->role) == 'karyawan' ? 'selected' : '' }}>
                                    Karyawan</option>
                            </select>
                            @if (auth()->user()->username == $user->username)
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                            @error('role')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group button-group">
                            <button type="submit" class="signup-btn button">Update User</button>
                            <button type="reset" class="btn-warning button">Reset</button>
                            <a href="{{ route('user') }}" class="btn-secondary button">Kembali</a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @include('sidebar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
