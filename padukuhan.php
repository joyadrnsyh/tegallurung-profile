<?php
require_once 'templates/header.php';

try {
    // Ambil semua data padukuhan dari database
    $stmt = $pdo->query("SELECT * FROM padukuhan ORDER BY id ASC");
    $rt_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $rt_list = [];
}
?>

<div class="container my-5" data-aos="fade-in">

    <div class="page-header text-center mb-5">
        <h1 class="display-5 fw-bold section-title-gradient">Informasi Padukuhan</h1>
        <p class="lead text-muted col-lg-8 mx-auto">Data wilayah administratif Desa Tegallurung berdasarkan Rukun Tetangga (RT).</p>
    </div>

    <div class="row g-4">
        <?php if (!empty($rt_list)): ?>
            <?php
            $delay = 0;
            foreach ($rt_list as $rt):
                $delay += 100;
            ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                    <div class="card h-100 shadow-sm text-center padukuhan-card">
                        <div class="card-header bg-primary text-white fw-bold fs-5">
                            <?= htmlspecialchars($rt['nama_rt']); ?>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div>
                                <h5 class="card-title text-muted">Ketua RT</h5>
                                <p class="fw-bold fs-5"><?= htmlspecialchars($rt['ketua_rt']); ?></p>
                            </div>
                            <hr>
                            <div>
                                <h5 class="card-title text-muted">Jumlah KK</h5>
                                <p class="fw-bold fs-5"><?= htmlspecialchars($rt['jumlah_kk']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">Data informasi padukuhan belum tersedia.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>