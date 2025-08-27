<?php
require_once 'templates/header.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('padukuhan.php');

try {
    $stmt = $pdo->prepare("SELECT * FROM padukuhan WHERE id = ?");
    $stmt->execute([$id]);
    $rt = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$rt) redirect('padukuhan.php');
} catch (PDOException $e) { die("Gagal mengambil data."); }
?>
<div class="container-fluid px-4">
    <h1 class="fs-4 my-4">Edit Data <?= htmlspecialchars($rt['nama_rt']); ?></h1>
    <div class="card shadow-sm col-lg-6">
        <div class="card-body">
            <form action="padukuhan_proses.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($rt['id']); ?>">
                <div class="mb-3">
                    <label for="nama_rt" class="form-label">Nama RT</label>
                    <input type="text" name="nama_rt" class="form-control" value="<?= htmlspecialchars($rt['nama_rt']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="ketua_rt" class="form-label">Nama Ketua RT</label>
                    <input type="text" name="ketua_rt" class="form-control" value="<?= htmlspecialchars($rt['ketua_rt']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah_kk" class="form-label">Jumlah Kepala Keluarga (KK)</label>
                    <input type="number" name="jumlah_kk" class="form-control" value="<?= htmlspecialchars($rt['jumlah_kk']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>