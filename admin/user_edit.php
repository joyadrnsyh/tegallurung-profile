<?php
require_once 'templates/header.php';

$edit_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$edit_id) redirect('user_management.php?status=gagal&pesan=ID tidak valid');

try {
    $stmt = $pdo->prepare("SELECT id, username FROM admin WHERE id = ?");
    $stmt->execute([$edit_id]);
    $admin_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$admin_to_edit) redirect('user_management.php?status=gagal&pesan=Admin tidak ditemukan');
} catch (PDOException $e) {
    die("Gagal mengambil data akun.");
}

$message = '';
$alert_type = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sukses') {
        $message = 'Akun berhasil diperbarui!';
        $alert_type = 'success';
    } elseif ($_GET['status'] == 'gagal') {
        $message = 'Gagal memperbarui akun: ' . htmlspecialchars($_GET['pesan']);
        $alert_type = 'danger';
    }
}
?>

<div class="container-fluid px-4" data-aos="fade-in">
    <h1 class="fs-4 my-4">Edit Akun Admin</h1>

    <?php if ($message): ?>
    <div class="alert alert-<?= $alert_type; ?> alert-dismissible fade show" role="alert">
        <?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Ubah Detail Akun: <?= htmlspecialchars($admin_to_edit['username']); ?></div>
                <div class="card-body">
                    <form action="user_edit_proses.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($admin_to_edit['id']); ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($admin_to_edit['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text">Kosongkan jika Anda tidak ingin mengubah password.</div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class='bx bx-save me-2'></i>Simpan Perubahan</button>
                        <a href="user_management.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>