<?php
require_once 'templates/header.php';
try {
    $stmt = $pdo->query("SELECT * FROM hero_section WHERE id = 1");
    $hero = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Gagal mengambil data hero section.</div>";
    $hero = []; // Kosongkan agar form tidak error
}
?>
<div class="container-fluid px-4">
    <h1 class="fs-4 my-4">Manajemen Hero Section</h1>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
    <div class="alert alert-success">Hero section berhasil diperbarui!</div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="hero_proses.php" method="POST">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Utama</label>
                    <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($hero['judul']); ?>">
                </div>
                <div class="mb-3">
                    <label for="subjudul" class="form-label">Subjudul / Deskripsi</label>
                    <textarea class="form-control" name="subjudul" rows="3"><?= htmlspecialchars($hero['subjudul']); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tombol_teks" class="form-label">Teks Tombol</label>
                        <input type="text" class="form-control" name="tombol_teks" value="<?= htmlspecialchars($hero['tombol_teks']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tombol_url" class="form-label">URL Tombol</label>
                        <input type="text" class="form-control" name="tombol_url" value="<?= htmlspecialchars($hero['tombol_url']); ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>