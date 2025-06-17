<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard Dinamis</title>
</head>

<body>

    <div>
        <div class="main-content w-100">
            <!-- Header with Dashboard Title and Search -->
            <div class="header-top">
                <div class="dashboard-info">
                    <div class="dashboard-title">{{ auth()->user()->username }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search by ID" onkeyup="searchTable()">
                </div>
            </div>
            <!-- Section Pelanggan -->
            <div id="pelanggan" class="mb-5">
                <h3 class="text-center my-4">Pelanggan</h3>
                <hr>
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <!-- Ganti route legacy karyawan.createpelanggan dengan createpelanggan -->
                        <a href="{{ route('createpelanggan') }}" class="btn btn-md btn-success mb-3">TAMBAH DATA</a>
                        <table class="table-bordered" id="pelanggan-table">
                            <thead>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelanggan)
                                    <tr>
                                        <td>{{ $pelanggan->id_pelanggan }}</td>
                                        <td>{{ $pelanggan->nama }}</td>
                                        <td>{{ $pelanggan->gender }}</td>
                                        <td>
                                            <!-- Ganti route legacy karyawan.editpelanggan dengan editpelanggan -->
                                            <a href="{{ route('editpelanggan', $pelanggan->id_pelanggan) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <!-- Ganti route legacy karyawan.delete_pelanggan dengan delete_pelanggan -->
                                            <form action="{{ route('delete_pelanggan', $pelanggan->id_pelanggan) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($pelanggans->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">Data Pelanggan Belum Tersedia.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('sidebar')
    </div>
</body>

</html>
