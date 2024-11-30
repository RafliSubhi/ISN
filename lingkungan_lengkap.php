<?php
// Menghubungkan ke database
include 'koneksi.php';

// Cek jika ada ID yang diterima melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berita berdasarkan ID
    $sql = mysqli_query($koneksi, "SELECT * FROM lingkungan WHERE id = '$id'");
    $data = mysqli_fetch_array($sql);

    // Jika data tidak ditemukan, tampilkan pesan error
    if (!$data) {
        echo "Berita tidak ditemukan!";
        exit;
    }
} else {
    echo "ID berita tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Lengkap | lingkungan <?php echo htmlspecialchars($data['judul']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Background putih dan teks hitam */
        body {
            background-color: white;
            color: black;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Gambar dengan rasio asli namun ukuran disesuaikan dan gambar di tengah */
        .card-img-top {
            width: 100%; /* Lebar gambar mengikuti kontainer */
            height: auto; /* Menjaga rasio gambar asli */
            object-fit: contain; /* Menjaga proporsi gambar tanpa memotong */
            object-position: center; /* Menjaga posisi gambar tetap terpusat */
            margin: 0 auto; /* Menjaga gambar tetap di tengah */
            display: block; /* Menjadikan gambar sebagai elemen blok agar bisa diatur posisinya */
            margin-bottom: 20px; /* Memberikan jarak antara gambar dan teks */
        }

        /* Mengatur header h1, h6, h5 agar rata kiri dan lebih sempit */
        h1, h6, h5 {
            text-align: left;
            font-weight: lighter; /* Mengatur font weight agar lebih ringan */
        }

        h1 {
            font-size: 2rem; /* Menyempitkan ukuran font h1 */
        }

        h6 {
            font-size: 1.2rem; /* Menyempitkan ukuran font h6 */
        }

        h5 {
            font-size: 1.4rem; /* Menyempitkan ukuran font h5 */
        }

        /* Tanggal dengan latar belakang kuning */
        .card-subtitle mark {
            background-color: yellow;
            color: black;
        }

        /* Pengaturan teks konten */
        .card-text {
            color: black;
            text-align: justify; /* Membuat teks justify */
            margin-top: 20px; /* Memberikan jarak atas antara gambar dan teks */
        }

        /* Tombol dengan warna biru */
        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Footer card */
        .card-footer {
            background-color: #f8f9fa;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container mt-3 col-9 mb-5">
        <h1 class="card-title"><?php echo htmlspecialchars($data['judul']); ?></h1>
        <h6 class="card-subtitle mb-3 mt-2">
            <mark><?php echo htmlspecialchars($data['tgl']); ?></mark>
        </h6>
        <img src="admin/lingkungan/<?php echo htmlspecialchars($data['img']); ?>" class="card-img-top" alt="Image">

        <h5 class="card-text"><?php echo nl2br(htmlspecialchars($data['text'])); ?></h5>
        <a href="index.php?page=lingkungan" class="btn btn-secondary">Kembali</a>
    </div>
</body>

</html>
