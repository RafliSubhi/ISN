<?
include "koneksi.php";
?>
<?php
// Mulai sesi
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Hapus cookie jika ada (misalnya cookie "remember me")
if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, '/'); // Menghapus cookie
}

// Atur header untuk mencegah caching di browser
header('Cache-Control: no-cache, no-store, must-revalidate'); // Menghindari caching
header('Pragma: no-cache'); // Menghindari caching
header('Expires: 0'); // Menghindari caching

// Alihkan ke halaman login.php
header('Location: login.php');
exit;
?>
