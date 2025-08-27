<?php
require_once __DIR__ . '/../../core/init.php';

// Proteksi: Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect(BASE_URL . 'admin/index.php');
}

// Mendapatkan nama file saat ini untuk menandai menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Desa Tegallurung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/style.css">
</head>
<body class="admin-body">

<div class="d-flex" id="adminWrapper">
    <div class="sidebar-wrapper" id="sidebar">
        <div class="sidebar-header">
            <a class="sidebar-brand" href="dashboard.php">
                <i class='bx bxs-buildings'></i>
                <span>Desa Tegallurung</span>
            </a>
        </div>
        <ul class="sidebar-nav list-unstyled">
            <li>
                <a href="dashboard.php" class="nav-link px-3 <?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-dashboard me-2'></i> Dashboard
                </a>
            </li>
            
            <li class="nav-heading px-3 my-2">
                Manajemen Konten
            </li>

            <li>
                <a href="berita.php" class="nav-link px-3 <?= ($current_page == 'berita.php' || $current_page == 'berita_form.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-news me-2'></i> Berita
                </a>
            </li>
            <li>
                <a href="galeri.php" class="nav-link px-3 <?= ($current_page == 'galeri.php' || $current_page == 'galeri_form.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-photo-album me-2'></i> Galeri
                </a>
            </li>
            <li>
                <a href="perangkat.php" class="nav-link px-3 <?= ($current_page == 'perangkat.php' || $current_page == 'perangkat_form.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-user-account me-2'></i> Perangkat
                </a>
            </li>

            <li class="nav-heading px-3 my-2">
                Halaman Statis
            </li>
            <li>
                <a href="hero_form.php" class="nav-link px-3 <?= ($current_page == 'hero_form.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-star me-2'></i> Hero Section
                </a>
            </li>
                <li>
                <a href="layanan.php" class="nav-link px-3 <?= (in_array($current_page, ['layanan.php', 'layanan_form.php'])) ? 'active' : ''; ?>">
                    <i class='bx bx-grid-alt me-2'></i> Layanan
                </a>
            </li>
            <li>
                <a href="profil_desa.php" class="nav-link px-3 <?= ($current_page == 'profil_desa.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-info-square me-2'></i> Profil Desa
                </a>
            </li>
                        <li>
                <a href="user_management.php" class="nav-link px-3 <?= ($current_page == 'user_management.php') ? 'active' : ''; ?>">
                    <i class='bx bxs-user-detail me-2'></i> Manajemen Admin
                </a>
            </li>

            <li>
                <a href="padukuhan.php" class="nav-link px-3 <?= (in_array($current_page, ['padukuhan.php', 'padukuhan_form.php'])) ? 'active' : ''; ?>">
                   <i class='bx bxs-map-alt me-2'></i> Padukuhan
                 </a>
           </li>
           <li>
                 <a href="umkm.php" class="nav-link px-3 <?= (in_array($current_page, ['umkm.php', 'umkm_form.php'])) ? 'active' : ''; ?>">
                    <i class='bx bxs-store me-2'></i> UMKM
                </a>
            </li>

          <li>
                <a href="kontak_form.php" class="nav-link px-3 <?= ($current_page == 'kontak_form.php') ? 'active' : ''; ?>">
                <i class='bx bxs-contact me-2'></i> Info Kontak
        </a>
            </li>

            <li class="mt-auto">
                <hr class="dropdown-divider" />
                <a href="logout.php" class="nav-link px-3 text-danger">
                    <i class='bx bx-log-out-circle me-2'></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content-wrapper">
        <nav class="navbar navbar-expand-lg py-3 px-4 shadow-sm">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bxs-user-circle me-1'></i>
                            <?= htmlspecialchars($_SESSION['admin_username']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        
        <main class="container-fluid p-4">
