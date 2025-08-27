<?php
require_once __DIR__ . '/../core/init.php';

// Proteksi halaman admin
if (!isset($_SESSION['admin_logged_in'])) {
    redirect(BASE_URL . 'admin/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama_umkm = trim($_POST['nama_umkm']);
    $nama_pemilik = trim($_POST['nama_pemilik']);
    $deskripsi = trim($_POST['deskripsi']);
    $id_rt = $_POST['id_rt'];
    $foto_lama = $_POST['foto_lama'] ?? null;
    $foto = $_FILES['foto'];
    $nama_foto = $foto_lama;

    // URL untuk redirect jika terjadi error
    $form_url = "umkm_form.php" . (!empty($id) ? "?id=$id" : "");

    // Logika Upload Foto (jika ada file baru)
    if (isset($foto) && $foto['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/../assets/images/umkm/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Validasi ukuran dan tipe file
        $max_file_size = 10 * 1024 * 1024; // 10MB
        if ($foto['size'] > $max_file_size) {
            redirect($form_url . '&error=file_size');
        }
        
        $allowed_types = ['jpg', 'jpeg', 'png'];
        $imageFileType = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowed_types)) {
            redirect($form_url . '&error=file_type');
        }

        // Pindahkan file yang diupload
        $nama_foto = time() . '_' . basename($foto['name']);
        if (!move_uploaded_file($foto['tmp_name'], $target_dir . $nama_foto)) {
            redirect($form_url . '&error=upload_failed');
        }

        // Hapus foto lama jika ada
        if ($foto_lama && file_exists($target_dir . $foto_lama)) {
            unlink($target_dir . $foto_lama);
        }
    }

    try {
        if (empty($id)) {
            // Proses Tambah (Create)
            $sql = "INSERT INTO umkm (nama_umkm, nama_pemilik, deskripsi, id_rt, foto) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama_umkm, $nama_pemilik, $deskripsi, $id_rt, $nama_foto]);
            $_SESSION['toast_message'] = 'Data UMKM baru berhasil ditambahkan!';
        } else {
            // Proses Update
            $sql = "UPDATE umkm SET nama_umkm = ?, nama_pemilik = ?, deskripsi = ?, id_rt = ?, foto = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama_umkm, $nama_pemilik, $deskripsi, $id_rt, $nama_foto, $id]);
            $_SESSION['toast_message'] = 'Data UMKM berhasil diperbarui!';
        }
        redirect('umkm.php');
    } catch (PDOException $e) {
        redirect($form_url . '&error=db_error');
    }
}