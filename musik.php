<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISCOPE | musik | NEWS</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .team-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Flex container untuk baris, memastikan elemen dalam baris punya tinggi yang sama */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        /* Setiap item akan menyesuaikan tinggi agar konsisten */
        .team-item {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .content {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            font-family: 'Times New Roman', Times, serif;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .content h3,
        .content h5 {
            margin: 0 0 10px;
            color: white;
            word-wrap: break-word; /* Membuat teks membungkus jika terlalu panjang */
            overflow-wrap: break-word; /* Mendukung berbagai browser untuk membungkus kata */
            white-space: normal; /* Menjamin teks bisa terputus ke baris baru */
        }

        .content p {
            font-size: 14px;
            color: white;
        }

        .content a {
            text-decoration: none;
            color: white; /* Menjadikan teks link berwarna putih */
        }

        .content a:hover {
            text-decoration: underline; /* Menambahkan garis bawah pada hover */
            text-decoration-color: white; /* Mengatur warna garis bawah menjadi merah */
        }

        mark {
            background: yellow;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h3>Berita musik</h3>
            <hr>
        </div>

        <div class="row">
            <?php
            // Menghubungkan ke database
            include 'koneksi.php';

            // Mengambil data berita musik dari database
            $sql = mysqli_query($koneksi, "SELECT * FROM musik ORDER BY tgl DESC");
            
            // Menampilkan berita satu per satu
            while ($data = mysqli_fetch_array($sql)) {
            ?>
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="team-item">
                        <img src="admin/kultur/musik/<?php echo htmlspecialchars($data['img']); ?>" alt="Berita musik">
                        <div class="content bg-dark">
                            <a href="musik_lengkap.php?id=<?php echo $data['id']; ?>">
                                <h3><b><?php echo htmlspecialchars($data['judul']); ?></b></h3>
                                <h5><?php echo htmlspecialchars($data['subjudul']); ?></h5>
                                <p><mark><?php echo $data['tgl']; ?> | <?php echo htmlspecialchars($data['jenis']); ?></mark></p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>

</html>
