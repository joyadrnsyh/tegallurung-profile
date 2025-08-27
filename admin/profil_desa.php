<?php
// Memanggil header admin yang sudah menggunakan struktur Bootstrap 5
require_once 'templates/header.php';

// Ambil data profil desa saat ini untuk ditampilkan di form
try {
    $stmt = $pdo->query("SELECT * FROM profil_desa WHERE id = 1");
    $profil = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tampilkan pesan error jika gagal mengambil data
    echo "<div class='alert alert-danger'>Gagal mengambil data profil desa.</div>";
    $profil = ['sejarah' => '', 'visi' => '', 'misi' => '']; // Set default agar form tidak error
}
?>

<div class="container-fluid px-4" data-aos="fade-in">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4">Manajemen Profil Desa</h1>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Profil desa berhasil <strong>diupdate</strong>!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title fw-bold">Edit Konten Profil</h5>
        </div>
        <div class="card-body">
            <form action="profil_proses.php" method="post">
                <div class="mb-3">
                    <label for="sejarah" class="form-label">Sejarah Desa</label>
                    <textarea class="form-control" name="sejarah" id="sejarah" rows="8" required><?= htmlspecialchars($profil['sejarah']); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="visi" class="form-label">Visi</label>
                    <textarea class="form-control" name="visi" id="visi" rows="4" required><?= htmlspecialchars($profil['visi']); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="misi" class="form-label">Misi</label>
                    <textarea class="form-control" name="misi" id="misi" rows="6" required><?= htmlspecialchars($profil['misi']); ?></textarea>
                    <div class="form-text">Untuk membuat baris baru, gunakan tombol Enter.</div>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class='bx bx-save me-2'></i>Update Profil</button>
            </form>
        </div>
    </div>
</div>

<?php
// Memanggil footer admin
require_once 'templates/footer.php';
?>