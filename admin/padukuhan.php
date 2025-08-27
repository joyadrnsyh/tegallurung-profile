<?php
require_once 'templates/header.php';
try {
    $stmt = $pdo->query("SELECT * FROM padukuhan ORDER BY id ASC");
    $rt_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $rt_list = []; }
?>
<div class="container-fluid px-4">
    <h1 class="fs-4 my-4">Informasi Padukuhan</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama RT</th>
                            <th>Ketua RT</th>
                            <th>Jumlah KK</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rt_list as $rt): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($rt['nama_rt']); ?></td>
                            <td><?= htmlspecialchars($rt['ketua_rt']); ?></td>
                            <td><?= htmlspecialchars($rt['jumlah_kk']); ?></td>
                            <td class="text-center">
                                <a href="padukuhan_form.php?id=<?= $rt['id']; ?>" class="btn btn-sm btn-warning"><i class='bx bxs-edit'></i> Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>