<?php
require_once 'templates/header.php';

// Pastikan koneksi $pdo sudah dibuat sebelum bagian ini

$item_per_halaman = 10;
$halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halaman_saat_ini < 1) $halaman_saat_ini = 1;

// Hitung total berita
$total_berita_stmt = $pdo->query("SELECT COUNT(*) FROM berita");
$total_berita = (int)$total_berita_stmt->fetchColumn();
$total_halaman = $total_berita > 0 ? ceil($total_berita / $item_per_halaman) : 1;

// Validasi halaman agar tidak melebihi jumlah halaman
if ($halaman_saat_ini > $total_halaman) $halaman_saat_ini = $total_halaman;

$offset = ($halaman_saat_ini - 1) * $item_per_halaman;

try {
    $stmt = $pdo->prepare("SELECT id, judul, tanggal_publikasi FROM berita ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $item_per_halaman, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $berita_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $berita_list = [];
    echo "<div class='alert alert-danger'>Gagal mengambil data berita.</div>";
}
?>

<div class="container-fluid px-4" data-aos="fade-in"></div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4">Manajemen Berita</h1>
        <a href="berita_form.php" class="btn btn-primary">
            <i class='bx bx-plus-circle me-2'></i>Tambah Berita Baru
        </a>
    </div>

    <?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Berita berhasil <strong><?= htmlspecialchars($_GET['status']); ?></strong>!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Judul Berita</th>
                            <th scope="col">Tanggal Publikasi</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($berita_list)): ?>
                            <?php foreach ($berita_list as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td><?= date('d M Y, H:i', strtotime($row['tanggal_publikasi'])); ?></td>
                                <td class="text-center">
                                    <a href="berita_form.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <a href="berita_hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                        <i class='bx bxs-trash'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada berita.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php if ($total_halaman > 1): ?>
    <nav aria-label="Navigasi Halaman" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($halaman_saat_ini <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?halaman=<?= max(1, $halaman_saat_ini - 1); ?>">Sebelumnya</a>
            </li>
            <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                <li class="page-item <?= ($i == $halaman_saat_ini) ? 'active' : ''; ?>">
                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($halaman_saat_ini >= $total_halaman) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?halaman=<?= min($total_halaman, $halaman_saat_ini + 1); ?>">Selanjutnya</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php
require_once 'templates/footer.php';
?>
