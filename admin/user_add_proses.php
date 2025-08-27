<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect('dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        redirect('user_management.php?status=gagal&pesan=Input tidak boleh kosong');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE username = ?");
        $stmt_check->execute([$username]);
        if ($stmt_check->fetchColumn() > 0) {
            redirect('user_management.php?status=gagal&pesan=Username sudah digunakan');
        }

        $stmt_insert = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $stmt_insert->execute([$username, $hashed_password]);
        
        redirect('user_management.php?status=sukses_tambah');

    } catch (PDOException $e) {
        redirect('user_management.php?status=gagal&pesan=' . urlencode($e->getMessage()));
    }
}