<?php
require_once 'templates/header.php';
// (Tambahkan logika pagination di sini jika diperlukan)
try {
    $stmt = $pdo->query("SELECT umkm.*, padukuhan.nama_rt FROM umkm JOIN padukuhan ON umkm.id_rt = padukuhan.id ORDER BY umkm.id DESC");
    $umkm_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $umkm_list = []; }
?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4">Manajemen UMKM</h1>
        <a href="umkm_form.php" class="btn btn-primary"><i class='bx bx-plus-circle me-2'></i>Tambah UMKM Baru</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead><tr><th>Foto</th><th>Nama UMKM</th><th>Pemilik</th><th>RT</th><th class="text-center">Aksi</th></tr></thead>
                <tbody>
                    <?php foreach ($umkm_list as $umkm): ?>
                    <tr>
                        <td><img src="<?= BASE_URL . 'assets/images/umkm/' . htmlspecialchars($umkm['foto']); ?>" style="width: 80px; aspect-ratio: 16/9; object-fit: cover;" class="rounded"></td>
                        <td class="fw-bold"><?= htmlspecialchars($umkm['nama_umkm']); ?></td>
                        <td><?= htmlspecialchars($umkm['nama_pemilik']); ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($umkm['nama_rt']); ?></span></td>
                        <td class="text-center">
                            <a href="umkm_form.php?id=<?= $umkm['id']; ?>" class="btn btn-sm btn-warning"><i class='bx bxs-edit'></i></a>
                            <a href="umkm_hapus.php?id=<?= $umkm['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')"><i class='bx bxs-trash'></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>