<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

$id = $_GET['id'] ?? 0;
if (!$id) redirect('berita.php');

try {
    $stmt = $pdo->prepare("SELECT gambar FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("DELETE FROM berita WHERE id = ?");
    $stmt->execute([$id]);

    if ($berita && $berita['gambar']) {
        $file_path = __DIR__ . '/../assets/images/berita/' . $berita['gambar'];
        if (file_exists($file_path)) unlink($file_path);
    }
    
    $_SESSION['toast_message'] = 'Berita berhasil dihapus!';
    redirect('berita.php');
} catch (PDOException $e) {
    die("Gagal menghapus berita: " . $e->getMessage());
}