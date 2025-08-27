<?php
require_once 'templates/header.php';
$umkm = ['id' => '', 'nama_umkm' => '', 'nama_pemilik' => '', 'deskripsi' => '', 'foto' => '', 'id_rt' => ''];
$is_edit = false;
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM umkm WHERE id = ?");
    $stmt->execute([$id]);
    $umkm = $stmt->fetch(PDO::FETCH_ASSOC);
}
// Ambil daftar RT untuk dropdown
$rt_list = $pdo->query("SELECT id, nama_rt FROM padukuhan ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-fluid px-4">
    <h1 class="fs-4 my-4"><?= $is_edit ? 'Edit' : 'Tambah'; ?> Data UMKM</h1>
    <div class="card shadow-sm col-lg-8">
        <div class="card-body">
            <form action="umkm_proses.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($umkm['id']); ?>">
                <div class="mb-3"><label class="form-label">Nama UMKM</label><input type="text" name="nama_umkm" class="form-control" value="<?= htmlspecialchars($umkm['nama_umkm']); ?>" required></div>
                <div class="mb-3"><label class="form-label">Nama Pemilik</label><input type="text" name="nama_pemilik" class="form-control" value="<?= htmlspecialchars($umkm['nama_pemilik']); ?>" required></div>
                <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($umkm['deskripsi']); ?></textarea></div>
                <div class="mb-3"><label class="form-label">Lokasi RT</label><select name="id_rt" class="form-select" required><option value="">Pilih RT</option><?php foreach ($rt_list as $rt): ?><option value="<?= $rt['id']; ?>" <?= ($rt['id'] == $umkm['id_rt']) ? 'selected' : ''; ?>><?= $rt['nama_rt']; ?></option><?php endforeach; ?></select></div>
                <div class="mb-3"><label class="form-label">Foto Produk/Usaha</label><input type="file" name="foto" class="form-control" <?= $is_edit ? '' : 'required'; ?>><input type="hidden" name="foto_lama" value="<?= htmlspecialchars($umkm['foto']); ?>"></div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>