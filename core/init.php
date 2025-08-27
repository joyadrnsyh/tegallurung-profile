<?php
// Memulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_tgl');

// 2. URL Dasar Website
define('BASE_URL', 'http://localhost/tegallurung-profile/');

// 3. Koneksi Database dengan PDO
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Jangan tampilkan detail error di production, cukup log dan tampilkan pesan umum
    die("Koneksi ke database gagal. Silakan coba lagi nanti.");
    // Untuk debugging (non-production), aktifkan ini:
    // die("Koneksi gagal: " . $e->getMessage());
}

// 4. Fungsi Bantuan

/**
 * Melakukan redirect ke URL tertentu
 */
function redirect(string $url): void {
    header("Location: $url");
    exit();
}

/**
 * Batasi jumlah kata dari sebuah string
 */
function limit_text(string $text, int $limit): string {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
