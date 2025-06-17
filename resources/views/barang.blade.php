<!DOCTYPE html>
<html lang="en">

<head>

    <title>Dashboard Dinamis</title>

</head>

<body>

    <div>
        @include('sidebar')
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

            <!-- Section Barang -->
            <div id="barang" class="mb-5 p-4">
                <h3 class="text-center my-4">Barang</h3>
                <hr>
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        {{-- Tampilkan tombol tambah data hanya untuk admin --}}
                        @if (auth()->user()->role === 'admin' || (isset($userRole) && $userRole === 'admin'))
                            <a href="{{ route('createBarang') }}" class="btn btn-md btn-success mb-3">TAMBAH DATA</a>
                        @endif

                        <table class="table-bordered" id="barang-table">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Stock</th>
                                    {{-- Tampilkan kolom aksi hanya untuk admin --}}
                                    @if (auth()->user()->role === 'admin' || (isset($userRole) && $userRole === 'admin'))
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop Barang -->
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->id_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                                        <td>{{ $barang->stock }}</td>
                                        {{-- Tampilkan aksi hanya untuk admin --}}
                                        @if (auth()->user()->role === 'admin' || (isset($userRole) && $userRole === 'admin'))
                                            <td>
                                                <a href="{{ route('editbarang', $barang->id_barang) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('delete_barang', $barang->id_barang) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if ($barangs->isEmpty())
                                    <tr>
                                        <td colspan="{{ auth()->user()->role === 'admin' || (isset($userRole) && $userRole === 'admin') ? '5' : '4' }}"
                                            class="text-center">Data Barang Belum Tersedia.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk fungsi search -->
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("barang-table");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Search by ID (kolom pertama)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
