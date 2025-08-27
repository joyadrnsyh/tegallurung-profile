<?php
require_once __DIR__ . '/../core/init.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect(BASE_URL . 'admin/dashboard.php');
}

$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'empty_fields': $error_message = 'Username dan Password tidak boleh kosong!'; break;
        case 'invalid_credentials': $error_message = 'Kombinasi Username atau Password salah!'; break;
        default: $error_message = 'Terjadi kesalahan tidak diketahui.'; break;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/style.css">
</head>
<body class="login-page">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4 col-md-6">
                <div class="card login-card shadow-lg" data-aos="zoom-in">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="card-title text-center fw-bold mb-4">Admin Panel</h2>
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error_message); ?></div>
                        <?php endif; ?>
                        <form action="proses_login.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-lg fw-bold">Login</button></div>
                            <div class="text-center mt-4"><a href="<?= BASE_URL; ?>" class="text-decoration-none">&larr; Kembali ke Situs</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>AOS.init({ duration: 600, once: true });</script>
</body>
</html>