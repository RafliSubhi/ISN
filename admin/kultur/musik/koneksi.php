<?php
// Konfigurasi untuk menghubungkan ke database
$host = 'localhost';  // Server database (biasanya localhost untuk pengembangan lokal)
$username = 'root';   // Username untuk login ke MySQL (default untuk XAMPP, Laragon, dll)
$password = '';       // Password untuk user 'root' (kosong jika menggunakan default di localhost)
$database = 'iscope_news'; // Nama database yang akan digunakan

$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // Jika koneksi berhasil, Anda bisa menambahkan log atau proses lainnya di sini
    // echo "Koneksi berhasil!";
}
?>
