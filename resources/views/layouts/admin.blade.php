<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Inventaris')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: margin-left 0.3s ease; /* Animasi halus */
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #4b545c;
            margin-bottom: 20px;
        }

        .sidebar-header h4 {
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
        }

        .sidebar-header small {
            color: #adb5bd;
            font-size: 0.8rem;
        }

        /* Menu Styling */
        .nav-link {
            color: #c2c7d0;
            padding: 10px 20px;
            font-size: 0.9rem;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff;
            background-color: #495057;
            border-left-color: #0d6efd;
            text-decoration: none;
        }

        .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        .sidebar-heading {
            padding: 15px 20px 5px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Content Styling */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Overlay Gelap untuk Mobile */
        .sidebar-overlay {
            display: none; /* Default hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* RESPONSIVE DESIGN (Mobile) */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px; /* Sembunyikan sidebar ke kiri */
            }
            
            .sidebar.show {
                margin-left: 0; /* Munculkan sidebar */
            }

            .sidebar-overlay.show {
                display: block; /* Munculkan overlay */
            }

            .main-content {
                margin-left: 0; /* Konten penuh layar */
            }
        }
    </style>
</head>
<body>

    <!-- Overlay Gelap (Klik ini untuk menutup sidebar di HP) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- 1. SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-building"></i> DISKOMINFO</h4>
            <small>Sistem Inventaris</small>
        </div>

        <nav class="nav flex-column">
            
            <!-- MENU DASHBOARD (Paling Atas) -->
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <!-- Group: Master Data -->
            <div class="sidebar-heading">Master Data</div>
            <a class="nav-link" href="{{ route('ruangan.index') }}">
                <i class="fas fa-door-open"></i> Ruangan
            </a>
            <a class="nav-link" href="{{ route('kategori.index') }}">
                <i class="fas fa-tags"></i> Kategori
            </a>

            <!-- Group: Inventaris -->
            <div class="sidebar-heading">Inventaris</div>
            <a class="nav-link" href="{{ route('barang.index') }}">
                <i class="fas fa-boxes"></i> Pengadaan
            </a>
            <a class="nav-link" href="{{ route('mutasi.index') }}">
                <i class="fas fa-exchange-alt"></i> Mutasi
            </a>
            <a class="nav-link" href="{{ route('pemeliharaan.index') }}">
                <i class="fas fa-tools"></i> Pemeliharaan
            </a>
            <a class="nav-link" href="{{ route('penghapusan.index') }}">
                <i class="fas fa-trash-alt"></i> Penghapusan
            </a>

            <!-- Group: Manajemen User -->
            <div class="sidebar-heading">Sistem</div>
            <a class="nav-link" href="#">
                <i class="fas fa-users-cog"></i> Manajemen User
            </a>

        </nav>
    </div>

    <!-- 2. MAIN CONTENT WRAPPER -->
    <div class="main-content">
        
        <!-- Navbar Atas -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4">
            <div class="container-fluid">
                <!-- Tombol Hamburger (Hanya muncul di Mobile) -->
                <button class="btn btn-dark d-md-none" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Spacer untuk dorong profile ke kanan -->
                <div class="ms-auto d-flex align-items-center">
                    
                    <!-- Dropdown Profile -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://picsum.photos/seed/admin/40/40" alt="mdo" width="32" height="32" class="rounded-circle me-2">
                            <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </nav>

        <!-- 3. ISI HALAMAN (Yield) -->
        <main>
            @yield('content')
        </main>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('scripts')

    <!-- Script Khusus untuk Sidebar Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Fungsi Buka/Tutup Sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            // Event Listener klik tombol hamburger
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            // Event Listener klik overlay gelap (menutup sidebar)
            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    
</body>
</html>