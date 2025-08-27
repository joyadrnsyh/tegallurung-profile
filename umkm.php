<?php
require_once 'templates/header.php';

// Ambil data RT untuk filter
try {
    $rt_list_stmt = $pdo->query("SELECT id, nama_rt FROM padukuhan ORDER BY id ASC");
    $rt_list = $rt_list_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $rt_list = [];
}

// Logika filter
$filter_rt = isset($_GET['rt']) ? (int)$_GET['rt'] : 0;
$sql = "SELECT umkm.*, padukuhan.nama_rt 
        FROM umkm 
        JOIN padukuhan ON umkm.id_rt = padukuhan.id";

if ($filter_rt > 0) {
    $sql .= " WHERE umkm.id_rt = :id_rt";
}
$sql .= " ORDER BY umkm.id DESC";

try {
    $stmt = $pdo->prepare($sql);
    if ($filter_rt > 0) {
        $stmt->bindValue(':id_rt', $filter_rt, PDO::PARAM_INT);
    }
    $stmt->execute();
    $umkm_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $umkm_list = [];
    echo "<p class='text-center text-danger container my-5'>Gagal mengambil data UMKM.</p>";
}
?>

<div class="container my-5" data-aos="fade-in">
    <div class="page-header text-center mb-5">
        <h1 class="display-5 fw-bold section-title-gradient">UMKM Desa Tegallurung</h1>
        <p class="lead text-muted col-lg-8 mx-auto">Dukung produk dan usaha lokal dari masyarakat kreatif Desa Tegallurung.</p>
    </div>

    <div class="d-flex justify-content-center mb-4">
        <div class="btn-group d-none d-md-block" role="group">
            <a href="umkm.php" class="btn <?= ($filter_rt == 0) ? 'btn-primary' : 'btn-outline-primary'; ?>">Semua RT</a>
            <?php foreach ($rt_list as $rt): ?>
                <a href="?rt=<?= $rt['id']; ?>" class="btn <?= ($filter_rt == $rt['id']) ? 'btn-primary' : 'btn-outline-primary'; ?>"><?= $rt['nama_rt']; ?></a>
            <?php endforeach; ?>
        </div>

        <div class="dropdown d-md-none">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter Berdasarkan RT
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item <?= ($filter_rt == 0) ? 'active' : ''; ?>" href="umkm.php">Semua RT</a></li>
                <?php foreach ($rt_list as $rt): ?>
                <li><a class="dropdown-item <?= ($filter_rt == $rt['id']) ? 'active' : ''; ?>" href="?rt=<?= $rt['id']; ?>"><?= $rt['nama_rt']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($umkm_list)): ?>
            <?php foreach ($umkm_list as $umkm): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card h-100 shadow-sm">
                    <img src="<?= BASE_URL . 'assets/images/umkm/' . htmlspecialchars($umkm['foto']); ?>" class="card-img-top" style="aspect-ratio: 16/9; object-fit: cover;" alt="<?= htmlspecialchars($umkm['nama_umkm']); ?>">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2"><?= htmlspecialchars($umkm['nama_rt']); ?></span>
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($umkm['nama_umkm']); ?></h5>
                        <p class="card-text text-muted">Pemilik: <?= htmlspecialchars($umkm['nama_pemilik']); ?></p>
                        <p class="card-text"><?= htmlspecialchars($umkm['deskripsi']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada data UMKM untuk filter yang dipilih.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>