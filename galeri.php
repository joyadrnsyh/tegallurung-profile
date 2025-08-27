<?php
require_once 'templates/header.php';

// --- LOGIKA PAGINATION ---
$item_per_halaman = 12; // Menampilkan 12 foto per halaman
$halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halaman_saat_ini < 1) $halaman_saat_ini = 1;

try {
    $total_galeri_stmt = $pdo->query("SELECT COUNT(*) FROM galeri");
    $total_galeri = $total_galeri_stmt->fetchColumn();
    $total_halaman = ceil($total_galeri / $item_per_halaman);

    $offset = ($halaman_saat_ini - 1) * $item_per_halaman;

    $stmt = $pdo->prepare("SELECT * FROM galeri ORDER BY tanggal_upload DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $item_per_halaman, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $galeri_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $galeri_list = [];
    echo "<p class='text-center text-danger container my-5'>Gagal mengambil data galeri.</p>";
}
?>

<div class="container my-5" data-aos="fade-in">

    <div class="page-header text-center mb-5">
        <h1 class="display-5 fw-bold section-title-gradient">Galeri Kegiatan Desa</h1>
        <p class="lead text-muted col-lg-8 mx-auto">Dokumentasi visual dari berbagai acara dan kegiatan di Desa Tegallurung.</p>
    </div>

    <div class="row g-4">
        <?php if (!empty($galeri_list)): ?>
            <?php
            $delay = 0;
            foreach ($galeri_list as $row):
                $delay += 50;
                $judulFoto = htmlspecialchars($row['judul_foto']);
                $imagePath = BASE_URL . 'assets/images/galeri/' . htmlspecialchars($row['nama_file']);
            ?>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?= $delay; ?>">
                    <a href="<?= $imagePath; ?>" data-lightbox="galeri-desa" data-title="<?= $judulFoto; ?>" class="gallery-card">
                        <img src="<?= $imagePath; ?>" alt="<?= $judulFoto; ?>" class="img-fluid">
                        <div class="gallery-overlay">
                            <i class='bx bx-search-alt-2'></i>
                            <div class="overlay-text"><?= $judulFoto; ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada foto yang diunggah di galeri.</div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($total_halaman > 1): ?>
    <nav aria-label="Navigasi Halaman Galeri" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($halaman_saat_ini <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?halaman=<?= $halaman_saat_ini - 1; ?>">Sebelumnya</a>
            </li>
            <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                <li class="page-item <?= ($i == $halaman_saat_ini) ? 'active' : ''; ?>">
                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($halaman_saat_ini >= $total_halaman) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?halaman=<?= $halaman_saat_ini + 1; ?>">Selanjutnya</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

</div>

<?php require_once 'templates/footer.php'; ?>