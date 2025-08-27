<?php
require_once __DIR__ . '/../core/init.php';

// Proteksi: Hanya admin yang sudah login yang bisa menghapus user
if (!isset($_SESSION['admin_logged_in'])) {
    redirect('dashboard.php');
}

$id_to_delete = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$current_admin_id = $_SESSION['admin_id'];

// Pengecekan agar tidak bisa menghapus diri sendiri
if ($id_to_delete > 0 && $id_to_delete != $current_admin_id) {
    try {
        // Hapus admin berdasarkan ID
        $stmt = $pdo->prepare("DELETE FROM admin WHERE id = ?");
        $stmt->execute([$id_to_delete]);
        
        redirect('user_management.php?status=dihapus');

    } catch (PDOException $e) {
        redirect('user_management.php?status=gagal&pesan=' . urlencode($e->getMessage()));
    }
} else {
    redirect('user_management.php?status=gagal&pesan=Aksi tidak diizinkan');
}