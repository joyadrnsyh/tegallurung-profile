<?php
require_once __DIR__ . '/../core/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('register.php');
}

// Ambil data form
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

// Validasi dasar
if (empty($username) || empty($password) || empty($confirm)) {
    redirect('register.php?error=Semua field wajib diisi');
}

if ($password !== $confirm) {
    redirect('register.php?error=Password tidak cocok');
}

if (strlen($password) < 6) {
    redirect('register.php?error=Password minimal 6 karakter');
}

// Cek apakah username sudah digunakan
$stmt = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    redirect('register.php?error=Username sudah terdaftar');
}

// Simpan admin baru
$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");

try {
    $stmt->execute([$username, $hashed]);
    redirect('register.php?success=Berhasil mendaftar. Silakan login.');
} catch (PDOException $e) {
    redirect('register.php?error=Gagal menyimpan data.');
}
