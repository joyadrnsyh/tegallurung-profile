<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect('dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $form_url = "user_edit.php?id=$id";

    if (empty($username)) redirect($form_url . '&status=gagal&pesan=Username tidak boleh kosong');

    try {
        $stmt_check = $pdo->prepare("SELECT id FROM admin WHERE username = ? AND id != ?");
        $stmt_check->execute([$username, $id]);
        if ($stmt_check->fetch()) {
            redirect($form_url . '&status=gagal&pesan=Username sudah digunakan');
        }

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt_update = $pdo->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
            $stmt_update->execute([$username, $hashed_password, $id]);
        } else {
            $stmt_update = $pdo->prepare("UPDATE admin SET username = ? WHERE id = ?");
            $stmt_update->execute([$username, $id]);
        }
        
        if ($id == $_SESSION['admin_id']) $_SESSION['admin_username'] = $username;

        redirect($form_url . '&status=sukses');

    } catch (PDOException $e) {
        redirect($form_url . '&status=gagal&pesan=' . urlencode($e->getMessage()));
    }
}