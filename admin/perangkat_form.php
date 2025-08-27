<?php
require_once 'templates/header.php';

$perangkat = ['id' => '', 'nama' => '', 'jabatan' => '', 'foto' => ''];
$is_edit = false;
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM perangkat_desa WHERE id = ?");
    $stmt->execute([$id]);
    $perangkat = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$perangkat) redirect('perangkat.php');
}

$error_message = '';
if (isset($_GET['error'])) { /* ... Logika pesan error ... */ }
?>

<div class="container-fluid px-4">
    <h1 class="fs-4 my-4"><?= $is_edit ? 'Edit' : 'Tambah'; ?> Data Perangkat Desa</h1>
    <?php if ($error_message): ?> <div class="alert alert-danger"><?= $error_message; ?></div> <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form id="perangkatForm" action="perangkat_proses.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($perangkat['id']); ?>">
                <input type="hidden" name="cropped_image_data" id="croppedImageData">
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3"><label for="nama" class="form-label fw-bold">Nama Lengkap</label><input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($perangkat['nama']); ?>" required></div>
                        <div class="mb-3"><label for="jabatan" class="form-label fw-bold">Jabatan</label><input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= htmlspecialchars($perangkat['jabatan']); ?>" required></div>
                        <div class="mb-3"><label for="imageInput" class="form-label fw-bold">Foto</label><input type="file" name="foto" id="imageInput" class="form-control" accept="image/*">
                            <?php if ($is_edit && $perangkat['foto']): ?>
                                <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($perangkat['foto']); ?>">
                                <div class="form-text mt-2">Pilih file baru jika ingin mengganti foto saat ini.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Pratinjau Foto</label>
                        <div class="text-center">
                             <img id="imagePreview" src="<?= ($is_edit && $perangkat['foto']) ? BASE_URL . 'assets/images/perangkat/' . $perangkat['foto'] : 'https://placehold.co/400x400/eec/7ee?text=Foto'; ?>" class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #fff; box-shadow: var(--shadow-sm);" alt="Pratinjau">
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <button type="submit" class="btn btn-primary"><i class='bx bx-save me-2'></i>Simpan Perubahan</button>
                <a href="perangkat.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="modalLabel">Potong Gambar</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body"><div style="height: 400px;"><img id="imageToCrop"></div></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="cropButton">Potong & Simpan</button>
      </div>
  </div></div>
</div>
<style>#imageToCrop { display: block; max-width: 100%; }</style>
<?php require_once 'templates/footer.php'; ?>