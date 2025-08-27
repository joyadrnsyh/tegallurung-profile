<?php
require_once 'templates/header.php';

$berita = ['id' => '', 'judul' => '', 'konten' => '', 'gambar' => ''];
$is_edit = false;
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$berita) redirect('berita.php');
}

// Logika untuk menampilkan pesan error
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'file_size': $error_message = 'Ukuran file terlalu besar! Maksimal 2MB.'; break;
        case 'file_type': $error_message = 'Format file tidak diizinkan! Hanya JPG, JPEG, PNG.'; break;
        default: $error_message = 'Terjadi kesalahan tidak diketahui.'; break;
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="fs-4 my-4"><?= $is_edit ? 'Edit' : 'Tambah'; ?> Berita</h1>

    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message; ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="berita_proses.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($berita['id']); ?>">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control" value="<?= htmlspecialchars($berita['judul']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="konten" class="form-label">Konten</label>
                            <textarea name="konten" id="konten" rows="10" class="form-control" required><?= htmlspecialchars($berita['konten']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Unggulan</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" <?= $is_edit ? '' : 'required'; ?>>
                            <?php if ($is_edit && $berita['gambar']): ?>
                                <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($berita['gambar']); ?>">
                                <div class="form-text">Kosongkan jika tidak ingin mengubah gambar.</div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class='bx bx-save me-2'></i><?= $is_edit ? 'Update' : 'Simpan'; ?></button>
                        <a href="berita.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
             <div class="card shadow-sm">
                <div class="card-header">Pratinjau Gambar</div>
                <div class="card-body text-center">
                    <img id="imagePreview" src="<?= ($is_edit && $berita['gambar']) ? BASE_URL . 'assets/images/berita/' . $berita['gambar'] : 'https://placehold.co/400x300/eec/7ee?text=Pilih+Gambar'; ?>" class="img-fluid rounded" alt="Pratinjau">
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>