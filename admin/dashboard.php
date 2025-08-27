<?php
require_once 'templates/header.php';

// Inisialisasi variabel untuk menghindari error jika query gagal
$jumlah_berita = 0;
$jumlah_galeri = 0;
$jumlah_perangkat = 0;
$recent_activities = [];

try {
    // Menghitung jumlah total dengan cara yang aman
    $jumlah_berita = (int) $pdo->query("SELECT COUNT(*) FROM berita")->fetchColumn();
    $jumlah_galeri = (int) $pdo->query("SELECT COUNT(*) FROM galeri")->fetchColumn();
    $jumlah_perangkat = (int) $pdo->query("SELECT COUNT(*) FROM perangkat_desa")->fetchColumn();

    // Mengambil 5 aktivitas terbaru dari berita dan galeri
    $stmt_recent = $pdo->query("
        (SELECT id, judul AS info, tanggal_publikasi AS tanggal, 'berita' AS tipe FROM berita)
        UNION ALL
        (SELECT id, judul_foto AS info, tanggal_upload AS tanggal, 'galeri' AS tipe FROM galeri)
        ORDER BY tanggal DESC
        LIMIT 5
    ");
    $recent_activities = $stmt_recent->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Jika terjadi error, tampilkan pesan di halaman untuk debugging
    // Di lingkungan produksi, ini sebaiknya dicatat (logged) bukan ditampilkan
    echo "<div class='alert alert-danger'>Terjadi error saat mengambil data dashboard: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<div class="container-fluid px-4" data-aos="fade-in">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="fs-4 fw-bold">Dashboard</h1>
        <p class="text-muted">Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_username']); ?></strong>!</p>
    </div>

    <!-- Kartu Statistik -->
    <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card stat-card border-start border-primary border-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text text-muted">Total Berita</p>
                        <h3 class="card-title fw-bold display-5"><?= $jumlah_berita; ?></h3>
                    </div>
                    <div class="stat-icon-wrapper bg-primary-subtle text-primary">
                        <i class='bx bxs-news'></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card stat-card border-start border-success border-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text text-muted">Total Galeri</p>
                        <h3 class="card-title fw-bold display-5"><?= $jumlah_galeri; ?></h3>
                    </div>
                     <div class="stat-icon-wrapper bg-success-subtle text-success">
                        <i class='bx bxs-photo-album'></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card stat-card border-start border-warning border-4 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-text text-muted">Perangkat Desa</p>
                        <h3 class="card-title fw-bold display-5"><?= $jumlah_perangkat; ?></h3>
                    </div>
                    <div class="stat-icon-wrapper bg-warning-subtle text-warning">
                        <i class='bx bxs-user-account'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik & Aktivitas Terbaru -->
    <div class="row g-4 mt-3">
        <div class="col-lg-7" data-aos="fade-up" data-aos-delay="400">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-bold">Grafik Konten</div>
                <div class="card-body"><canvas id="contentChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-5" data-aos="fade-up" data-aos-delay="500">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-bold">Aktivitas Terbaru</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($recent_activities)): ?>
                            <?php foreach ($recent_activities as $activity): ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class='bx bxs-<?= ($activity['tipe'] == 'berita') ? 'news text-primary' : 'photo-album text-success'; ?> fs-4 me-3'></i>
                                    <div>
                                        <a href="<?= htmlspecialchars($activity['tipe']); ?>_form.php?id=<?= $activity['id']; ?>" class="text-decoration-none text-dark fw-semibold"><?= htmlspecialchars(limit_text($activity['info'], 5)); ?></a>
                                        <small class="d-block text-muted"><?= date('d M Y', strtotime($activity['tanggal'])); ?></small>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item">Belum ada aktivitas.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data untuk Grafik -->
<script>
    window.dashboardData = {
        jumlahBerita: <?= json_encode($jumlah_berita); ?>,
        jumlahGaleri: <?= json_encode($jumlah_galeri); ?>,
        jumlahPerangkat: <?= json_encode($jumlah_perangkat); ?>
    };
</script>

<?php
require_once 'templates/footer.php';
?>