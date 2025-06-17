<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sidebar {{ ucfirst($role) }}</title>

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

</head>

<body>

    @extends('default')

    <!-- Tombol toggle FAB -->
    <button class="sidebar-toggle-btn" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="{{ $role }}Sidebar">
        <div class="text-center fs-4 fw-bold mb-4">{{ ucfirst($role) }}</div>
        <ul class="list-unstyled">
            <li><a href="{{ route('barang') }}"><i class="bi bi-box-seam me-2"></i> Barang</a></li>
            <li><a href="{{ route('pelanggan') }}"><i class="bi bi-people me-2"></i> Pelanggan</a></li>
            <li><a href="{{ route('laporan') }}"><i class="bi bi-graph-up me-2"></i> Laporan</a></li>
            <li><a href="{{ route('form') }}"><i class="bi bi-cash me-2"></i> Kasir</a></li>
            @if ($role == 'admin')
                <li><a href="{{ route('user') }}"><i class="bi bi-person me-2"></i> User</a></li>
            @endif
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("{{ $role }}Sidebar");
            sidebar.classList.toggle("show");
        }

        // Aktifkan link saat ini berdasarkan segment URL kedua
        const pathSegments = window.location.pathname.split('/').filter(segment => segment);
        const currentSegment = pathSegments.length > 0 ? pathSegments[0] : '';

        document.querySelectorAll('.sidebar a').forEach(link => {
            const linkPath = new URL(link.href).pathname;
            const linkSegment = linkPath.split('/').filter(segment => segment)[0] || '';

            if (linkSegment === currentSegment) {
                link.classList.add('active');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
