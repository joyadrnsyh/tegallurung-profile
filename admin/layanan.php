<?php
require_once 'templates/header.php';
try {
    $stmt = $pdo->query("SELECT * FROM layanan ORDER BY id ASC");
    $layanan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $layanan_list = []; }
?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4">Manajemen Layanan & Potensi</h1>
        <a href="layanan_form.php" class="btn btn-primary"><i class='bx bx-plus-circle me-2'></i>Tambah Baru</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead><tr><th>Ikon</th><th>Judul</th><th>Deskripsi</th><th class="text-center">Aksi</th></tr></thead>
                <tbody>
                    <?php foreach ($layanan_list as $layanan): ?>
                    <tr>
                        <td class="fs-4"><?= htmlspecialchars($layanan['ikon']); ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($layanan['judul']); ?></td>
                        <td><?= htmlspecialchars($layanan['deskripsi']); ?></td>
                        <td class="text-center">
                            <a href="layanan_form.php?id=<?= $layanan['id']; ?>" class="btn btn-sm btn-warning"><i class='bx bxs-edit'></i></a>
                            <a href="layanan_hapus.php?id=<?= $layanan['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')"><i class='bx bxs-trash'></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>