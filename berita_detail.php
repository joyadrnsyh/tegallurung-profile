<?php
require_once 'templates/header.php';

// Ambil ID dari URL, pastikan itu angka
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    // Jika ID tidak valid, tampilkan pesan error
    echo "<div class='container my-5 text-center'><div class='alert alert-danger'>Halaman berita tidak valid.</div></div>";
    require_once 'templates/footer.php';
    exit();
}

try {
    // Ambil data berita dari database
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika berita dengan ID tersebut tidak ditemukan
    if (!$berita) {
        echo "<div class='container my-5 text-center'><div class='alert alert-warning'>Berita yang Anda cari tidak ditemukan.</div></div>";
        require_once 'templates/footer.php';
        exit();
    }
} catch (PDOException $e) {
    // Jika terjadi error saat query
    die("Gagal mengambil data berita: " . $e->getMessage());
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <article class="berita-detail-content">
                <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($berita['judul']); ?></h1>

                <p class="text-muted mb-4">
                    Dipublikasikan pada: <strong><?= date('d F Y', strtotime($berita['tanggal_publikasi'])); ?></strong>
                </p>

                <img src="<?= BASE_URL . 'assets/images/berita/' . htmlspecialchars($berita['gambar']); ?>" class="img-fluid rounded-3 shadow-sm mb-4" alt="Gambar Berita">

                <div class="fs-5 lh-lg">
                    <?= nl2br(htmlspecialchars($berita['konten'])); ?>
                </div>

                <div class="mt-5">
                    <a href="berita.php" class="btn btn-outline-primary">&larr; Kembali ke Daftar Berita</a>
                </div>
            </article>

        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>