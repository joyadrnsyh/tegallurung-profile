<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = trim($_POST['judul']);
    $konten = trim($_POST['konten']);
    $gambar_lama = $_POST['gambar_lama'] ?? null;
    $gambar = $_FILES['gambar'];
    $nama_gambar = $gambar_lama;
    $form_url = "berita_form.php" . (!empty($id) ? "?id=$id" : "");

    if (isset($gambar) && $gambar['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/../assets/images/berita/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

        $max_file_size = 10 * 1024 * 1024; // 2MB
        if ($gambar['size'] > $max_file_size) redirect($form_url . '&error=file_size');
        
        $allowed_types = ['jpg', 'jpeg', 'png'];
        $imageFileType = strtolower(pathinfo($gambar['name'], PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowed_types)) redirect($form_url . '&error=file_type');

        $nama_gambar = time() . '_' . basename($gambar['name']);
        if (!move_uploaded_file($gambar['tmp_name'], $target_dir . $nama_gambar)) {
            redirect($form_url . '&error=upload_failed');
        }
        if ($gambar_lama && file_exists($target_dir . $gambar_lama)) unlink($target_dir . $gambar_lama);
    }

    try {
        if (empty($id)) {
            $sql = "INSERT INTO berita (judul, konten, gambar) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul, $konten, $nama_gambar]);
            $_SESSION['toast_message'] = 'Berita baru berhasil ditambahkan!';
        } else {
            $sql = "UPDATE berita SET judul = ?, konten = ?, gambar = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul, $konten, $nama_gambar, $id]);
            $_SESSION['toast_message'] = 'Berita berhasil diperbarui!';
        }
        redirect('berita.php');
    } catch (PDOException $e) {
        redirect($form_url . '&error=db_error');
    }
}