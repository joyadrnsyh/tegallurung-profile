<?php
require_once __DIR__ . '/../core/init.php';
// Mendapatkan nama file saat ini untuk menandai menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Tegallurung</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top custom-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL; ?>">
            Desa Tegallurung
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-bold">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="<?= BASE_URL; ?>index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'profil.php') ? 'active' : ''; ?>" href="<?= BASE_URL; ?>profil.php">Profil Desa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'berita.php') ? 'active' : ''; ?>" href="<?= BASE_URL; ?>berita.php">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'galeri.php') ? 'active' : ''; ?>" href="<?= BASE_URL; ?>galeri.php">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'perangkat.php') ? 'active' : ''; ?>" href="<?= BASE_URL; ?>perangkat.php">Perangkat Desa</a>
                 <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'padukuhan.php') ? 'active' : ''; ?>" href="<?= BASE_URL; ?>padukuhan.php">Info Padukuhan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'umkm.php') ? 'active' : ''; ?>" href="umkm.php">UMKM</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="main-container">