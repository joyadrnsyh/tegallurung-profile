<?php
require_once 'templates/header.php';

// --- Logika untuk mengelompokkan perangkat desa ---
$kepala_desa = null;
$pimpinan_lain = [];
$staf = [];

try {
    $stmt = $pdo->query("SELECT * FROM perangkat_desa ORDER BY id ASC");
    $semua_perangkat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($semua_perangkat as $perangkat) {
        if (stripos($perangkat['jabatan'], 'Kepala Desa') !== false) {
            $kepala_desa = $perangkat;
        } elseif (stripos($perangkat['jabatan'], 'Sekretaris') !== false || stripos($perangkat['jabatan'], 'Kasi') !== false || stripos($perangkat['jabatan'], 'Kaur') !== false) {
            $pimpinan_lain[] = $perangkat;
        } else {
            $staf[] = $perangkat;
        }
    }
} catch (PDOException $e) {
    echo "<p class='text-center text-danger container my-5'>Gagal mengambil data perangkat desa.</p>";
}

// DITAMBAHKAN: Menggabungkan pimpinan dan staf menjadi satu array
$aparatur_lainnya = array_merge($pimpinan_lain, $staf);
?>

<div class="container my-5" data-aos="fade-in">
    <div class="page-header text-center mb-5">
        <h1 class="display-5 fw-bold section-title-gradient">Struktur Organisasi Desa</h1>
        <p class="lead text-muted col-lg-8 mx-auto">Mengenal lebih dekat para aparat yang mengabdi untuk kemajuan Desa Tegallurung.</p>
    </div>

    <?php if ($kepala_desa): ?>
    <section id="kepala-desa" class="mb-5 pb-5 border-bottom">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-aos="zoom-in">
                <div class="card shadow-sm overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= BASE_URL . 'assets/images/perangkat/' . htmlspecialchars($kepala_desa['foto']); ?>" class="img-fluid h-100" style="object-fit: cover;" alt="Foto <?= htmlspecialchars($kepala_desa['nama']); ?>">
                        </div>
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card-body p-4">
                                <h3 class="card-title fw-bold"><?= htmlspecialchars($kepala_desa['nama']); ?></h3>
                                <p class="card-text text-primary fw-bold text-uppercase"><?= htmlspecialchars($kepala_desa['jabatan']); ?></p>
                                <p class="card-text text-muted mt-3">Sebagai pimpinan tertinggi di pemerintahan desa, bertanggung jawab atas penyelenggaraan pemerintahan, pembangunan, pembinaan kemasyarakatan, dan pemberdayaan masyarakat desa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section id="aparatur-lainnya">
        <div class="row g-4">
            <?php if (!empty($aparatur_lainnya)): ?>
                <?php foreach ($aparatur_lainnya as $pimpinan): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card h-100 text-center shadow-sm">
                        <img src="<?= BASE_URL . 'assets/images/perangkat/' . htmlspecialchars($pimpinan['foto']); ?>" class="card-img-top" style="height: 300px; object-fit: cover;" alt="Foto <?= htmlspecialchars($pimpinan['nama']); ?>">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($pimpinan['nama']); ?></h5>
                            <p class="card-text text-primary fw-semibold"><?= htmlspecialchars($pimpinan['jabatan']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">Data perangkat desa lainnya belum tersedia.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php require_once 'templates/footer.php'; ?>