<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $subjudul = $_POST['subjudul'];
    $tombol_teks = $_POST['tombol_teks'];
    $tombol_url = $_POST['tombol_url'];

    try {
        $sql = "UPDATE hero_section SET judul = ?, subjudul = ?, tombol_teks = ?, tombol_url = ? WHERE id = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$judul, $subjudul, $tombol_teks, $tombol_url]);
        
        redirect('hero_form.php?status=sukses');
    } catch (PDOException $e) {
        die("Gagal memperbarui data: " . $e->getMessage());
    }
}