<?php
require_once __DIR__ . '/../core/init.php';

// Proteksi halaman admin
if (!isset($_SESSION['admin_logged_in'])) {
    redirect(BASE_URL . 'admin/index.php');
}

$id = $_GET['id'] ?? 0;
if (!$id) {
    redirect('umkm.php');
}

try {
    // 1. Ambil nama file foto dari DB sebelum dihapus
    $stmt = $pdo->prepare("SELECT foto FROM umkm WHERE id = ?");
    $stmt->execute([$id]);
    $umkm = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Hapus data dari database
    $stmt_delete = $pdo->prepare("DELETE FROM umkm WHERE id = ?");
    $stmt_delete->execute([$id]);

    // 3. Hapus file foto dari server jika ada
    if ($umkm && $umkm['foto']) {
        $file_path = __DIR__ . '/../assets/images/umkm/' . $umkm['foto'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // Siapkan notifikasi dan redirect
    $_SESSION['toast_message'] = 'Data UMKM berhasil dihapus!';
    redirect('umkm.php');

} catch (PDOException $e) {
    die("Gagal menghapus data UMKM: " . $e->getMessage());
}