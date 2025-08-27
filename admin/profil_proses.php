<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) {
    redirect(BASE_URL . 'admin/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sejarah = $_POST['sejarah'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];

    try {
        $sql = "UPDATE profil_desa SET sejarah = ?, visi = ?, misi = ? WHERE id = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sejarah, $visi, $misi]);

        redirect('profil_desa.php?status=sukses');
    } catch (PDOException $e) {
        die("Gagal mengupdate profil: " . $e->getMessage());
    }
}