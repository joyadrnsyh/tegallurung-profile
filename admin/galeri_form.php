<?php
require_once 'templates/header.php';

// Inisialisasi variabel untuk form galeri
$galeri = ['id' => '', 'judul_foto' => '', 'nama_file' => ''];
$is_edit = false;

// Jika mode edit, ambil data dari database
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false) {
        redirect('galeri.php');
    }

    $stmt = $pdo->prepare("SELECT * FROM galeri WHERE id = ?");
    $stmt->execute([$id]);
    $galeri = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$galeri) {
        redirect('galeri.php');
    }
}

// Logika untuk menampilkan pesan error
$error_message = '';
if (isset($_GET['error'])) {
    $error = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING);
    switch ($error) {
        case 'file_size':
            $error_message = 'Ukuran file terlalu besar! Maksimal 10MB.';
            break;
        case 'file_type':
            $error_message = 'Format file tidak diizinkan! Hanya JPG, JPEG, PNG, GIF.';
            break;
        default:
            $error_message = 'Terjadi kesalahan tidak diketahui.';
            break;
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="fs-4 my-4"><?= htmlspecialchars($is_edit ? 'Edit' : 'Tambah'); ?> Foto Galeri</h1>

    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form id="galeriForm" action="galeri_proses.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($galeri['id']); ?>">
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul_foto" class="form-label fw-bold">Judul Foto</label>
                            <input type="text" name="judul_foto" id="judul_foto" class="form-control" value="<?= htmlspecialchars($galeri['judul_foto']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-bold">File Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" <?= $is_edit ? '' : 'required'; ?>>
                            <?php if ($is_edit && !empty($galeri['nama_file'])): ?>
                                <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($galeri['nama_file']); ?>">
                                <div class="form-text mt-2">Pilih file baru jika ingin mengganti gambar.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Pratinjau</label>
                        <div class="text-center">
                             <img id="imagePreview" src="<?= htmlspecialchars(($is_edit && !empty($galeri['nama_file'])) ? BASE_URL . 'assets/images/galeri/' . $galeri['nama_file'] : 'https://placehold.co/400x300/e9ecef/6c757d?text=Pilih+Gambar'); ?>" class="img-fluid rounded" style="aspect-ratio: 4/3; object-fit: cover; border: 1px solid #ddd;" alt="Pratinjau">
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <button type="submit" class="btn btn-primary"><i class='bx bx-save me-2'></i><?= htmlspecialchars($is_edit ? 'Update' : 'Simpan'); ?></button>
                <a href="galeri.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>