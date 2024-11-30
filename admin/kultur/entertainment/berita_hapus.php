<?php
// Menghubungkan ke database
include 'koneksi.php';

// Cek apakah ada ID yang diterima melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID
    $sql = mysqli_query($koneksi, "SELECT * FROM entertainment WHERE id = '$id'");
    $data = mysqli_fetch_array($sql);

    // Jika data tidak ditemukan, tampilkan pesan error
    if (!$data) {
        echo "Data tidak ditemukan!";
        exit;
    }

    // Hapus gambar dari folder Up_berita jika ada
    $imgPath = $data['img'];
    if ($imgPath && file_exists($imgPath) && $imgPath != 'Up_berita/default.jpg') {
        unlink($imgPath); // Menghapus file gambar
    }

    // Query untuk menghapus data dari database
    $deleteQuery = "DELETE FROM entertainment WHERE id = '$id'";

    if (mysqli_query($koneksi, $deleteQuery)) {
        // Jika berhasil menghapus data, alihkan ke halaman berita
        echo "<script>alert('Data berhasil dihapus!'); window.location.href = '../../index.php?page=entertainment';</script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID tidak ditemukan!";
    exit;
}
?>
