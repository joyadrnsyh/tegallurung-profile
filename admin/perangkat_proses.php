<?php
require_once __DIR__ . '/../core/init.php';

if (!isset($_SESSION['admin_logged_in'])) redirect(BASE_URL . 'admin/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);
    $foto_lama = $_POST['foto_lama'] ?? null;
    $cropped_image_data = $_POST['cropped_image_data'] ?? null;
    $nama_foto = $foto_lama;

    $target_dir = __DIR__ . "/../assets/images/perangkat/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

    if (!empty($cropped_image_data)) {
        $data = explode(',', $cropped_image_data);
        $image_data = base64_decode($data[1]);
        $nama_foto = time() . '.jpg';
        
        file_put_contents($target_dir . $nama_foto, $image_data);
        
        if ($id && $foto_lama && file_exists($target_dir . $foto_lama)) {
            unlink($target_dir . $foto_lama);
        }
    }

    try {
        if (empty($id)) {
            $sql = "INSERT INTO perangkat_desa (nama, jabatan, foto) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama, $jabatan, $nama_foto]);
            $_SESSION['toast_message'] = 'Data perangkat berhasil ditambahkan!';
        } else {
            $sql = "UPDATE perangkat_desa SET nama = ?, jabatan = ?, foto = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama, $jabatan, $nama_foto, $id]);
            $_SESSION['toast_message'] = 'Data perangkat berhasil diperbarui!';
        }
        redirect('perangkat.php');
    } catch (PDOException $e) {
        die("Gagal menyimpan data: " . $e->getMessage());
    }
}