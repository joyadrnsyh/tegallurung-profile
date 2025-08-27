<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) {
    redirect(BASE_URL . 'admin/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $judul_foto = trim($_POST['judul_foto'] ?? '');
    $gambar_lama = $_POST['gambar_lama'] ?? null;
    $gambar = $_FILES['gambar'] ?? null;
    $nama_gambar = $gambar_lama;
    $form_url = "galeri_form.php" . (!empty($id) ? "?id=$id" : "");

    // Validasi input
    if (empty($judul_foto)) {
        redirect($form_url . '&error=empty_title');
    }

    if ($gambar && $gambar['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/../assets/images/galeri/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Validasi ukuran file
        $max_file_size = 10 * 1024 * 1024; // 2MB
        if ($gambar['size'] > $max_file_size) {
            redirect($form_url . '&error=file_size');
        }

        // Validasi tipe file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowed_types)) {
            redirect($form_url . '&error=file_type');
        }

        // Proses upload
        $nama_gambar = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', basename($gambar['name']));
        if (!move_uploaded_file($gambar['tmp_name'], $target_dir . $nama_gambar)) {
            redirect($form_url . '&error=upload_failed');
        }

        // Hapus gambar lama jika ada
        if ($gambar_lama && file_exists($target_dir . $gambar_lama)) {
            unlink($target_dir . $gambar_lama);
        }
    }

    try {
        if (empty($id)) {
            $sql = "INSERT INTO galeri (judul_foto, nama_file) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul_foto, $nama_gambar]);
            $_SESSION['toast_message'] = 'Foto baru berhasil ditambahkan!';
        } else {
            $sql = "UPDATE galeri SET judul_foto = ?, nama_file = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul_foto, $nama_gambar, $id]);
            $_SESSION['toast_message'] = 'Foto berhasil diperbarui!';
        }
        redirect('galeri.php');
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        redirect($form_url . '&error=db_error');
    }
}