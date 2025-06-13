<?php
// --- Konfigurasi Database ---
// PASTIKAN DETAIL INI SESUAI DENGAN PENGATURAN XAMPP ANDA
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Kosongkan jika tidak ada password
define('DB_NAME', 'portal_berita1');

// --- Membuat Koneksi ---
$koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// --- Cek Koneksi ---
if ($koneksi->connect_error) {
    // Tampilkan pesan error yang lebih informatif
    die("Koneksi ke database gagal. Pastikan database 'portal_berita_db' sudah dibuat dan file 'database.sql' sudah diimpor. Pesan error: " . $koneksi->connect_error);
}

// Fungsi ini tidak digunakan secara langsung untuk menampilkan berita,
// karena slug sudah dibuat di dalam file database.sql.
// Ini hanya sebagai referensi jika Anda ingin membuat fitur 'tambah berita' nanti.
function createSlug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('[^-\w]+', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('-+', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}
?>