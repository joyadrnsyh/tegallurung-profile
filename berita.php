<?php
require_once 'templates/header.php';

// --- LOGIKA PAGINATION ---
// 1. Tentukan berapa item per halaman
$item_per_halaman = 9;

// 2. Ambil halaman saat ini dari URL, defaultnya adalah halaman 1
$halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halaman_saat_ini < 1) {
    $halaman_saat_ini = 1;
}

// 3. Hitung total berita untuk menentukan jumlah halaman
$total_berita_stmt = $pdo->query("SELECT COUNT(*) FROM berita");
$total_berita = $total_berita_stmt->fetchColumn();
$total_halaman = ceil($total_berita / $item_per_halaman);

// 4. Hitung OFFSET untuk query SQL
$offset = ($halaman_saat_ini - 1) * $item_per_halaman;

// 5. Query utama untuk mengambil berita sesuai halaman saat ini
try {
    $stmt = $pdo->prepare("SELECT * FROM berita ORDER BY tanggal_publikasi DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $item_per_halaman, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $berita_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $berita_list = [];
    echo "<p class='text-danger text-center'>Gagal mengambil data berita.</p>";
}
?>

<div class="container my-5" data-aos="fade-in" style="margin-top: 100px;">

    <div class="page-header text-center mb-5" >
        <h1 class="display-5 fw-bold section-title-gradient " style="padding-top: 100px;">Arsip Berita Desa</h1>
        <p class="lead text-muted col-lg-8 mx-auto">Jelajahi semua informasi, pengumuman, dan kegiatan yang telah berlangsung di Desa Tegallurung.</p>
    </div>

    <div class="row g-4">
        <?php if (!empty($berita_list)): ?>
            <?php
            $delay = 0;
            foreach ($berita_list as $row):
                $delay += 50;
            ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                    <div class="card h-100 shadow-sm">
                    <img class="card-img-top" src="<?= BASE_URL . 'assets/images/berita/' . htmlspecialchars($row['gambar']); ?>" alt="Gambar Berita">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($row['judul']); ?></h5>
                            <small class="text-muted mb-2"><?= date('d F Y', strtotime($row['tanggal_publikasi'])); ?></small>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars(limit_text($row['konten'], 15)); ?></p>
                            <a href="berita_detail.php?id=<?= $row['id']; ?>" class="btn btn-primary mt-auto">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center col-12">Belum ada berita yang dipublikasikan.</p>
        <?php endif; ?>
    </div>

    <?php if ($total_halaman > 1): ?>
    <nav aria-label="Navigasi Halaman Berita" class="mt-5">
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