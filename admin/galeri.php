<?php require_once 'templates/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="mb-3">Manajemen Galeri</h1>
            <p class="mb-4 text-muted">Kelola semua foto kegiatan yang ditampilkan di halaman galeri.</p>

            <a href="galeri_form.php" class="btn btn-primary mb-4">
                <i class="bi bi-plus-lg"></i> Tambah Foto Baru
            </a>

            <?php if (isset($_GET['status'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Foto berhasil <?= htmlspecialchars($_GET['status']); ?>!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Pratinjau</th>
                            <th scope="col">Judul Foto</th>
                            <th scope="col">Tanggal Upload</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM galeri ORDER BY id DESC");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td>
                                    <img src="<?= BASE_URL . 'assets/images/galeri/' . htmlspecialchars($row['nama_file']); ?>" alt="Pratinjau" class="img-thumbnail" style="width: 100px; height: auto;">
                                </td>
                                <td><?= htmlspecialchars($row['judul_foto']); ?></td>
                                <td><?= date('d M Y, H:i', strtotime($row['tanggal_upload'])); ?></td>
                                <td>
                                    <a href="galeri_form.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning me-2">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="galeri_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='4' class='text-center text-danger'>Gagal mengambil data galeri.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>