<!DOCTYPE html>
<html lang="en">

<head>

    <title>Edit Pelanggan</title>

    <link rel="stylesheet" href="{{ asset('css/action.css') }}">
</head>

<body>
    @extends('default')
    <div class="container edit-container">
        <div class="card">
            <div class="card-body">
                <h2>Edit Pelanggan</h2>
                <form action="{{ route('updatepelanggan', $pelanggan->id_pelanggan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            value="{{ old('nama', $pelanggan->nama) }}">
                        @error('nama')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                            <option value="">Pilih Gender</option>
                            <option value="Laki-laki" {{ old('gender', $pelanggan->gender) == 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $pelanggan->gender) == 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group button-group">
                        <button type="submit" class="signup-btn button">Update</button>
                        <button type="reset" class="btn-warning button">Reset</button>
                        <a href="{{ route('pelanggan') }}" class="btn-secondary button">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sidebar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
