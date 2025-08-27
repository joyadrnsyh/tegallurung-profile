<?php
require_once 'templates/header.php';

// Logika untuk menampilkan pesan status (sukses/gagal)
$message = '';
$alert_type = '';
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $pesan = isset($_GET['pesan']) ? htmlspecialchars($_GET['pesan']) : '';
    if ($status == 'sukses_tambah') {
        $message = 'Admin baru berhasil ditambahkan!';
        $alert_type = 'success';
    } elseif ($status == 'sukses_hapus') {
        $message = 'Admin berhasil dihapus!';
        $alert_type = 'success';
    } elseif ($status == 'gagal') {
        $message = 'Terjadi kesalahan: ' . $pesan;
        $alert_type = 'danger';
    }
}

// Ambil semua data admin dari database
try {
    $stmt = $pdo->query("SELECT id, username FROM admin ORDER BY id ASC");
    $admin_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $admin_list = [];
}
?>

<div class="container-fluid px-4" data-aos="fade-in">
    <h1 class="fs-4 my-4">Manajemen User Admin</h1>

    <?php if ($message): ?>
    <div class="alert alert-<?= $alert_type; ?> alert-dismissible fade show" role="alert">
        <?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-bold">Daftar Admin</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admin_list as $admin): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($admin['username']); ?></td>
                                    <td class="text-center">
                                        <a href="user_edit.php?id=<?= $admin['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class='bx bxs-edit'></i> Edit
                                        </a>
                                        <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                            <a href="user_hapus.php?id=<?= $admin['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                                <i class='bx bxs-trash'></i> Hapus
                                            </a>
                                        <?php else: ?>
                                            <span class="badge bg-secondary ms-2">Akun Anda</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-bold">Tambah Admin Baru</div>
                <div class="card-body">
                    <form action="user_add_proses.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class='bx bx-plus-circle me-2'></i>Tambah Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>