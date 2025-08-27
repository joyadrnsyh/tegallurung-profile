<?php
require_once 'templates/header.php';

try {
    $stmt = $pdo->query("SELECT * FROM perangkat_desa ORDER BY id ASC");
    $perangkat_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $perangkat_list = [];
}
?>

<div class="container-fluid px-4" data-aos="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4">Manajemen Perangkat Desa</h1>
        <a href="perangkat_form.php" class="btn btn-primary"><i class='bx bx-user-plus me-2'></i>Tambah Perangkat Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($perangkat_list)): ?>
                            <?php foreach ($perangkat_list as $row): ?>
                            <tr>
                                <td><img src="<?= BASE_URL . 'assets/images/perangkat/' . htmlspecialchars($row['foto']); ?>" alt="Foto" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;"></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['jabatan']); ?></td>
                                <td class="text-center">
                                    <a href="perangkat_form.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class='bx bxs-edit'></i></a>
                                    <a href="perangkat_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class='bx bxs-trash'></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center">Belum ada data perangkat desa.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"><i class='bx bxs-check-circle me-2 text-success'></i><strong class="me-auto">Sukses</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div>
        <div class="toast-body"><?= isset($_SESSION['toast_message']) ? htmlspecialchars($_SESSION['toast_message']) : ''; ?></div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>