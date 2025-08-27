<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

$id = $_GET['id'] ?? 0;
if (!$id) redirect('galeri.php');

try {
    $stmt = $pdo->prepare("SELECT nama_file FROM galeri WHERE id = ?");
    $stmt->execute([$id]);
    $galeri = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("DELETE FROM galeri WHERE id = ?");
    $stmt->execute([$id]);

    if ($galeri && $galeri['nama_file']) {
        $file_path = __DIR__ . '/../assets/images/galeri/' . $galeri['nama_file'];
        if (file_exists($file_path)) unlink($file_path);
    }
    
    $_SESSION['toast_message'] = 'Foto berhasil dihapus!';
    redirect('galeri.php');
} catch (PDOException $e) {
    die("Gagal menghapus foto: " . $e->getMessage());
}