<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $ikon = $_POST['ikon'];

    try {
        if (empty($id)) {
            $sql = "INSERT INTO layanan (judul, deskripsi, ikon) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul, $deskripsi, $ikon]);
        } else {
            $sql = "UPDATE layanan SET judul = ?, deskripsi = ?, ikon = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul, $deskripsi, $ikon, $id]);
        }
        redirect('layanan.php');
    } catch (PDOException $e) {
        die("Gagal menyimpan data: " . $e->getMessage());
    }
}