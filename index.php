<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I SCOPE NEWS</title>
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Body & Layout */
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #ffffff;
            color: #333333;
        }

        /* Header Styling */
        header {
            background-color: white;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 30px 0;
            text-align: center;
            position: relative;
        }

        .letter {
            display: inline-block;
            background-color: #000;
            color: white;
            font-size: 1.4rem;
            width: 40px;
            text-align: center;
            line-height: 40px;
            padding: 0.5px 0;
            margin: 0 5px;
        }

        header h3 {
            position: relative;
            z-index: 1;
            font-size: 2.5rem;
            font-weight: bold;
        }

        /* Footer Styling */
        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 10px;
            position: bottom;
            bottom: 0;
            width: 100%;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: #333333;
            transition: color 0.3s ease, border-bottom 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: black;
            color: white;
            border-bottom: 2px solid white;
        }

        .navbar-nav .nav-item.active .nav-link {
            font-weight: bold;
            border-bottom: 2px solid black;
        }

        .navbar-brand {
            color: #333333;
        }

        .navbar-toggler-icon {
            color: #333333;
        }

        /* Pencarian */
        .navbar .search-form input {
            border-radius: 20px;
            padding: 8px;
            width: 200px;
            border: 1px solid #32CD32;
            background-color: #f0f0f0;
        }

        .navbar .search-form input:focus {
            border-color: #32CD32;
            background-color: #ffffff;
        }

        /* Content Styling */
        #content {
            background-color: #f8f9fa;
            flex-grow: 1;
            padding: 20px;
        }

        .alert-info {
            background-color: #e7f7e7;
            color: #2e2e2e;
        }

        /* Flexbox card for equal height */
        .card-deck {
            display: flex;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            margin-bottom: 20px;
        }

        .card-body {
            flex-grow: 1;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            header h1 {
                font-size: 2rem;
            }

            .navbar .search-form input {
                width: 150px;
            }
        }
        mark {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <h3 class="letter">I</h3>
        <h3 class="letter">S</h3>
        <h3 class="letter">N</h3>
    </header>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="">ISCOPE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item <?php echo ($_GET['page'] == 'beranda' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=beranda"><b>Beranda</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'ekonomi' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=ekonomi"><b>Ekonomi</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'kesehatan' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=kesehatan"><b>Kesehatan</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'kriminal' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=kriminal"><b>Kriminal</b></a>
                    </li>
                    <li class="nav-item dropdown <?php echo ($_GET['page'] == 'kultur' ? 'active' : ''); ?>">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <b>Kultur</b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=entertainment"><b>Entertainment</b></a></li>
                            <li><a class="dropdown-item" href="?page=filmtv"><b>Film & TV</b></a></li>
                            <li><a class="dropdown-item" href="?page=musik"><b>Musik</b></a></li>
                        </ul>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'lingkungan' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=lingkungan"><b>Lingkungan</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'olahraga' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=olahraga"><b>Olahraga</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'politik' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=politik"><b>Politik</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'seni' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=seni"><b>Seni</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'sosialbudaya' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=sosialbudaya"><b>SosialBudaya</b></a>
                    </li>
                    <li class="nav-item <?php echo ($_GET['page'] == 'teknologi' ? 'active' : ''); ?>">
                        <a class="nav-link" href="?page=teknologi"><b>Teknologi</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div id="content">
        <?php
        include "koneksi.php"; // Menghubungkan dengan file koneksi.php

        // Fungsi untuk mengambil berita terbaru berdasarkan kategori
        function get_latest_news($category) {
            global $koneksi;
            $sql = "SELECT judul, subjudul, img, tgl, jenis FROM $category ORDER BY tgl DESC LIMIT 1";
            $result = $koneksi->query($sql);
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        }

        // Kategori yang ingin ditampilkan
        $categories = ['ekonomi', 'kesehatan', 'kriminal', 'lingkungan', 'entertainment', 'musik', 'filmtv', 'olahraga', 'sosialbudaya', 'seni', 'teknologi'];

        // Ambil berita terbaru untuk setiap kategori
        $latest_news = [];
        foreach ($categories as $category) {
            $latest_news[$category] = get_latest_news($category);
        }

        $koneksi->close();

        // Default page content or dynamically loaded pages
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'beranda':
                    echo '<div class="alert alert-info" role="alert">Selamat Datang di Beranda!</div>';
                    ?>
                    <!-- Berita Terbaru Campuran -->
                    <div class="container">
                        <h2>Berita Terbaru</h2>
                        
                        <div class="row card-deck">
                            <?php foreach ($latest_news as $category => $news): ?>
                                <?php if ($news): ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php echo ucfirst($category); ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($news['judul']); ?></h5>
                                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($news['subjudul']); ?></h6>
                                                <p class="card-text"><?php echo htmlspecialchars(substr($news['jenis'], 0, 150)) . '...'; ?></p>
                                                <a href="?page=<?php echo $category; ?>" class="btn btn-primary">Baca Selengkapnya</a>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <mark><?php echo date('d M Y', strtotime($news['tgl'])); ?></mark>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'ekonomi':
                    include('ekonomi.php');
                    break;
                case 'kesehatan':
                    include('kesehatan.php');
                    break;
                case 'kriminal':
                    include('kriminal.php');
                    break;
                case 'lingkungan':
                    include('lingkungan.php');
                    break;
                case 'olahraga':
                    include('olahraga.php');
                    break;
                case 'politik':
                    include('politik.php');
                    break;
                case 'seni':
                    include('seni.php');
                    break;
                case 'teknologi':
                    include('teknologi.php');
                    break;
                case 'sosialbudaya':
                    include('sosialbudaya.php');
                    break;
                case 'entertainment':
                    include('entertainment.php');
                    break;
                case 'filmtv':
                    include('filmtv.php');
                    break;
                case 'musik':
                    include('musik.php');
                    break;
                default:
                    echo '<div class="alert alert-warning" role="alert">Halaman tidak ditemukan.</div>';
            }
        } else {
            echo '<div class="alert alert-info" role="alert">Selamat Datang di Beranda!</div>';
        }
        ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <strong>I SCOPE NEWS</strong> Corporation</p>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
