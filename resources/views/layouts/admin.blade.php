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
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    
    <style>
        /* FONT MODERN */
        body {
            background-color: #f1f5f9;
            overflow-x: clip;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        
        /* SIDEBAR GRADIEN DARK BLUE */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            padding-top: 20px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 15px;
        }

        .sidebar-header h4 {
            color: #ffffff;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .sidebar-header small {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* MENU STYLING */
        .nav-link {
            color: #94a3b8;
            padding: 11px 20px;
            font-size: 0.88rem;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
            margin: 1px 0;
        }

        .nav-link:hover {
            color: #e2e8f0;
            background-color: rgba(255, 255, 255, 0.05);
            border-left-color: #3b82f6;
            text-decoration: none;
        }

        /* HIGHLIGHT AKTIF */
        .nav-link.active {
            color: #ffffff;
            background-color: rgba(59, 130, 246, 0.15);
            border-left-color: #3b82f6;
            font-weight: 600;
        }

        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 0.9rem;
        }

        .sidebar-heading {
            padding: 18px 20px 5px;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #475569;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        /* CONTENT STYLING */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* NAVBAR ATAS */
        .navbar {
            border-left: none !important;
        }

        /* OVERLAY BLUR UNTUK MOBILE */
        .sidebar-overlay {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.6);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        /* RESPONSIVE DESIGN (Mobile) */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px; 
            }
            
            .sidebar.show {
                margin-left: 0; 
                box-shadow: 4px 0 25px rgba(0,0,0,0.3);
            }

            .sidebar-overlay.show {
                display: block; 
            }

            .main-content {
                margin-left: 0; 
            }
        }
        /* NAVBAR STICKY (DESKTOP & MOBILE) */
.navbar {
    position: -webkit-sticky; /* Support iOS/Safari */
    position: sticky;
    top: 0;
    z-index: 998; /* Di bawah sidebar (1000) dan overlay (999) */
}

/* Styling tambahan khusus Mobile (Bikin navbar nempel tepi layar) */
@media (max-width: 768px) {
    .navbar {
        margin: -20px -20px 20px -20px; 
        border-radius: 0 !important;
    }
}
    </style>
</head>
<body>

    <!-- Overlay Gelap (Klik ini untuk menutup sidebar di HP) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- 1. SIDEBAR -->
    <div class="sidebar" id="sidebar">
       <div class="sidebar-header d-flex align-items-center gap-3">
            <img src="{{ asset('storage/img/logo-kab.png') }}"
                 alt="Logo Bengkalis"
                 width="45"
                 style="background: transparent;">
            <div>
                <h4 class="mb-0">DISKOMINFOTIK</h4>
                <small>Sistem Inventaris</small>
            </div>
        </div>

        <nav class="nav flex-column">
            
            <!-- MENU DASHBOARD -->
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <!-- Group: Master Data -->
            <div class="sidebar-heading">Master Data</div>
            <a class="nav-link {{ request()->is('ruangan*') ? 'active' : '' }}" href="{{ route('ruangan.index') }}">
                <i class="fas fa-door-open"></i> Ruangan
            </a>
            <a class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                <i class="fas fa-star"></i> Kategori
            </a>
            <a class="nav-link {{ request()->is('merk*') ? 'active' : '' }}" href="{{ route('merk.index') }}">
                <i class="fas fa-tags"></i> Merk
            </a>

            <!-- Group: Inventaris -->
            <div class="sidebar-heading">Inventaris</div>
            <a class="nav-link {{ request()->is('barang*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                <i class="fas fa-boxes"></i> Pengadaan
            </a>
            <a class="nav-link {{ request()->is('mutasi*') ? 'active' : '' }}" href="{{ route('mutasi.index') }}">
                <i class="fas fa-exchange-alt"></i> Mutasi
            </a>
            <a class="nav-link {{ request()->is('pemeliharaan*') ? 'active' : '' }}" href="{{ route('pemeliharaan.index') }}">
                <i class="fas fa-tools"></i> Pemeliharaan
            </a>
            <a class="nav-link {{ request()->is('penghapusan*') ? 'active' : '' }}" href="{{ route('penghapusan.index') }}">
                <i class="fas fa-trash-alt"></i> Penghapusan
            </a>

            <!-- Group: Manajemen User -->
            <div class="sidebar-heading">Sistem</div>
            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="fas fa-users-cog"></i> Manajemen User
            </a>

        </nav>
    </div>

    <!-- 2. MAIN CONTENT WRAPPER -->
    <div class="main-content">
        
        <!-- Navbar Atas -->
                <!-- Navbar Atas -->
        <nav class="navbar navbar-expand-lg navbar-dark rounded shadow-sm mb-4 py-2" style="background-color: #0f172a;">
            <div class="container-fluid d-flex align-items-center">
                
                <!-- Tombol Hamburger (Hanya muncul di Mobile) -->
                <button class="btn btn-sm btn-outline-light d-md-none me-3" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Spacer kosong di desktop agar profile tetap ke kanan -->
                <div class="d-none d-md-block"></div>

                <!-- Spacer untuk dorong profile ke kanan di mobile -->
                <div class="ms-auto d-flex align-items-center">
                    
                    <!-- Dropdown Profile -->
                    <div class="dropdown">
                        <a href="{{ route('profile') }}" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://picsum.photos/seed/{{ Auth::user()->username ?? 'admin' }}/40/40" alt="mdo" width="32" height="32" class="rounded-circle me-2 border border-light">
                            <strong class="d-none d-sm-inline-block">{{ Auth::user()->name ?? 'Admin' }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
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

    <!-- JQuery (DIPERBAIKI: TIDAK DUPLIKAT) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Script dari halaman lain -->
    @yield('scripts')
    @stack('scripts')

    <!-- Script Khusus untuk Sidebar Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>
</html>