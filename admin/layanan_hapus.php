<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

$id = $_GET['id'] ?? 0;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM layanan WHERE id = ?");
    $stmt->execute([$id]);
}
redirect('layanan.php');