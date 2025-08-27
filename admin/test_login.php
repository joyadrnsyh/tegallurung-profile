<?php
// Skrip Diagnostik Login
require_once __DIR__ . '/../core/init.php';

echo "<h1>Mulai Proses Diagnostik Login...</h1>";

$passwordYangDiketik = 'admin123'; // Ini adalah password yang seharusnya Anda ketik di form.

echo "<p>Mencoba mencari user dengan <strong>username: 'admin'</strong> di database...</p>";

try {
    // 1. Ambil data dari database
    $stmt = $pdo->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->execute(['admin']);
    $hashDariDB = $stmt->fetchColumn();

    // 2. Cek apakah user 'admin' ditemukan
    if (!$hashDariDB) {
        echo "<h2 style='color:red;'>GAGAL: Username 'admin' tidak ditemukan di database.</h2>";
        echo "<p>Pastikan Anda sudah menjalankan perintah SQL untuk memasukkan data admin.</p>";
    } else {
        echo "<h2 style='color:green;'>BERHASIL: Username 'admin' ditemukan.</h2>";
        echo "<hr>";
        echo "<h3>Sekarang, kita cek passwordnya:</h3>";
        echo "<p><strong>Password yang diketik:</strong> " . htmlspecialchars($passwordYangDiketik) . "</p>";
        echo "<p><strong>Password HASH dari DB:</strong> " . htmlspecialchars($hashDariDB) . "</p>";

        // 3. Verifikasi password
        if (password_verify($passwordYangDiketik, $hashDariDB)) {
            echo "<h2 style='color:green;'>SUKSES: Password COCOK! Seharusnya Anda bisa login.</h2>";
        } else {
            echo "<h2 style='color:red;'>GAGAL: Password TIDAK COCOK!</h2>";
            echo "<p>Ini berarti hash password di database Anda salah. Jalankan kembali perintah SQL dari saya untuk memperbaikinya.</p>";
        }
    }

} catch (PDOException $e) {
    echo "<h2 style='color:red;'>ERROR DATABASE: Tidak bisa terhubung atau query gagal.</h2>";
    echo "<p>Pesan Error: " . $e->getMessage() . "</p>";
}