<?php
require_once 'templates/header.php';
$layanan = ['id' => '', 'judul' => '', 'deskripsi' => '', 'ikon' => ''];
$is_edit = false;
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM layanan WHERE id = ?");
    $stmt->execute([$id]);
    $layanan = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="container-fluid px-4">
    <h1 class="fs-4 my-4"><?= $is_edit ? 'Edit' : 'Tambah'; ?> Layanan</h1>
    <div class="card shadow-sm col-lg-6">
        <div class="card-body">
            <form action="layanan_proses.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($layanan['id']); ?>">
                <div class="mb-3"><label for="judul" class="form-label">Judul</label><input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($layanan['judul']); ?>" required></div>
                <div class="mb-3"><label for="deskripsi" class="form-label">Deskripsi Singkat</label><input type="text" name="deskripsi" class="form-control" value="<?= htmlspecialchars($layanan['deskripsi']); ?>" required></div>
                <div class="mb-3"><label for="ikon" class="form-label">Ikon (Emoji)</label><input type="text" name="ikon" class="form-control" value="<?= htmlspecialchars($layanan['ikon']); ?>" required></div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>