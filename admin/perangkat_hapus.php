<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

$id = $_GET['id'] ?? 0;
if (!$id) redirect('perangkat.php');

try {
    $stmt = $pdo->prepare("SELECT foto FROM perangkat_desa WHERE id = ?");
    $stmt->execute([$id]);
    $perangkat = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("DELETE FROM perangkat_desa WHERE id = ?");
    $stmt->execute([$id]);

    if ($perangkat && $perangkat['foto']) {
        $file_path = __DIR__ . '/../assets/images/perangkat/' . $perangkat['foto'];
        if (file_exists($file_path)) unlink($file_path);
    }
    
    $_SESSION['toast_message'] = 'Data perangkat berhasil dihapus!';
    redirect('perangkat.php');
} catch (PDOException $e) {
    die("Gagal menghapus data: " . $e->getMessage());
}