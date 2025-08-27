<?php
require_once 'templates/header.php';
try {
    $stmt = $pdo->query("SELECT * FROM kontak_info WHERE id = 1");
    $kontak = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $kontak = []; }
?>
<div class="container-fluid px-4">
    <h1 class="fs-4 my-4">Manajemen Informasi Kontak & Footer</h1>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
    <div class="alert alert-success">Informasi berhasil diperbarui!</div>
    <?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="kontak_proses.php" method="POST">
                <div class="mb-3"><label class="form-label">Deskripsi Singkat (di Footer)</label><textarea class="form-control" name="deskripsi_singkat" rows="3"><?= htmlspecialchars($kontak['deskripsi_singkat']); ?></textarea></div>
                <div class="mb-3"><label class="form-label">Alamat</label><input type="text" class="form-control" name="alamat" value="<?= htmlspecialchars($kontak['alamat']); ?>"></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($kontak['email']); ?>"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control" name="telepon" value="<?= htmlspecialchars($kontak['telepon']); ?>"></div>
                </div>
                <hr>
                <h5 class="mb-3">Link Sosial Media</h5>
                <div class="row">
                    <div class="col-md-4 mb-3"><label class="form-label">Facebook URL</label><input type="url" class="form-control" name="link_facebook" value="<?= htmlspecialchars($kontak['link_facebook']); ?>"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Instagram URL</label><input type="url" class="form-control" name="link_instagram" value="<?= htmlspecialchars($kontak['link_instagram']); ?>"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">YouTube URL</label><input type="url" class="form-control" name="link_youtube" value="<?= htmlspecialchars($kontak['link_youtube']); ?>"></div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>