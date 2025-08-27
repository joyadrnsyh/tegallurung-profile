<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deskripsi = $_POST['deskripsi_singkat'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $fb = $_POST['link_facebook'];
    $ig = $_POST['link_instagram'];
    $yt = $_POST['link_youtube'];

    try {
        $sql = "UPDATE kontak_info SET deskripsi_singkat=?, alamat=?, email=?, telepon=?, link_facebook=?, link_instagram=?, link_youtube=? WHERE id = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$deskripsi, $alamat, $email, $telepon, $fb, $ig, $yt]);
        
        redirect('kontak_form.php?status=sukses');
    } catch (PDOException $e) {
        die("Gagal memperbarui data: " . $e->getMessage());
    }
}