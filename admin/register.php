<?php
require_once __DIR__ . '/../core/init.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect(BASE_URL . 'admin/dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <form action="proses_register.php" method="POST" class="login-form">
            <h2>Daftar Admin Baru</h2>

            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
            <p><a href="index.php">Kembali ke Login</a></p>
        </form>
    </div>
</body>
</html>
