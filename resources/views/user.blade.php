<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Admin</title>
</head>

<body>
    <div class="container">
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


            <div id="laporan" class="mb-5">
                <h3 class="text-center my-4">User</h3>
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="text-right mb-3">
                            <a href="{{ route('add_user') }}" class="signup-btn btn btn-md btn-success mb-3">Tambah
                                User</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td class="action-buttons">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('action.edit_user', $user->username) }}">Edit</a>
                                            <form action="{{ route('delete_user', $user->username) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sidebar')

    <script>
        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toUpperCase();
            const table = document.querySelector(".table");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[0]; // Search by username (first column)
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>
