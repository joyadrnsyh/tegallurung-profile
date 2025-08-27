<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $ketua_rt = $_POST['ketua_rt'];
    $jumlah_kk = $_POST['jumlah_kk'];

    try {
        $sql = "UPDATE padukuhan SET ketua_rt = ?, jumlah_kk = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ketua_rt, $jumlah_kk, $id]);
        redirect('padukuhan.php');
    } catch (PDOException $e) {
        die("Gagal menyimpan data: " . $e->getMessage());
    }
}