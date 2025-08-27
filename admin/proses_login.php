<?php
require_once __DIR__ . '/../core/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(BASE_URL . 'admin/index.php');

$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) redirect(BASE_URL . 'admin/index.php?error=empty_fields');

try {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_level'] = $admin['level'];
        redirect(BASE_URL . 'admin/dashboard.php');
    } else {
        redirect(BASE_URL . 'admin/index.php?error=invalid_credentials');
    }
} catch (PDOException $e) {
    die("Error database saat login: " . $e->getMessage());
}