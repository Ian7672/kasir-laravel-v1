<!DOCTYPE html>
<html lang="en">

<head>

    <title>Edit Barang</title>

    <link rel="stylesheet" href="{{ asset('css/action.css') }}">

</head>

<body>
    @extends('default')
    <div class="container edit-container">
        <div class="card">
            <div class="card-body">
                <h2>Edit Barang</h2>
                <form action="{{ route('updatebarang', $barang->id_barang) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                            name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}">
                        @error('nama_barang')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga Barang</label>
                        <input type="number" class="form-control @error('harga_barang') is-invalid @enderror"
                            name="harga_barang" value="{{ old('harga_barang', $barang->harga_barang) }}">
                        @error('harga_barang')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                            value="{{ old('stock', $barang->stock) }}">
                        @error('stock')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group button-group">
                        <button type="submit" class="signup-btn button">Update</button>
                        <button type="reset" class="btn-warning button">Reset</button>
                        <a href="{{ route('barang') }}" class="btn-secondary button">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sidebar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
