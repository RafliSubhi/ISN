<?php
session_start();

// Cek apakah pengguna sudah login, jika belum arahkan ke login.php
if (!isset($_SESSION['notelp'])) {
    header('Location: login.php');  // Arahkan ke login.php jika belum login
    exit();
}

// Ambil data pengguna dari session
$role = $_SESSION['role'] ?? null;  // Menentukan role (admin/pemegang)
$notelp = $_SESSION['notelp'];  // Menyimpan no. telepon pengguna yang login
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB ADMIN BASKET SKANSANESIA</title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- FONT-AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.cdnfonts.com/css/nirvana" rel="stylesheet">
    <!-- LOCAL CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        i {
            padding-right: 10px;
        }

        header {
            background-color: #003366;
            color: gold;
            padding: 10px 0;
        }

        .navbar {
            background-color: #001f3f;
        }

        .navbar-nav .nav-item .nav-link {
            color: black;
        }

        .navbar-nav .nav-item .nav-link:hover {
            background-color: black;
            color:white;
        }

        .header {
            text-align: center;
            background-color: #003366;
            color: gold;
            padding: 10px;
        }

        .container {
            text-align:center;
        }

        #content {
            margin-left: 0;
            padding: 20px;
            flex-grow: 1;
            background-color: #f8f9fa;
            padding-bottom: 60px;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .menu-btn {
            display: none;
        }

        @media (max-width: 992px) {
            .menu-btn {
                display: block;
                cursor: pointer;
                color: gold;
                font-size: 24px;
                z-index: 10;
                position: fixed;
                top: 20px;
                left: 20px;
            }

            .navbar-collapse {
                display: none;
                width: 100%;
            }

            .navbar-collapse.show {
                display: block;
            }

            .side-bar {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <h1>WEB PENGENDALI BERITA</h1>
            <p>untuk web I scope news</p>
        </div>
    </header>

    <!-- NAVIGATION (Navbar bawah header) -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ISCOPE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=beranda"><b>Beranda</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=ekonomi"><b>Ekonomi</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=kesehatan"><b>Kesehatan</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=kriminal"><b>Kriminal</b></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <b>Kultur</b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=entertainment"><b>Entertainment</b></a></li>
                            <li><a class="dropdown-item" href="?page=filmtv"><b>Film & Tv</b></a></li>
                            <li><a class="dropdown-item" href="?page=musik"><b>Musik</b></a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=lingkungan"><b>Lingkungan</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=olahraga"><b>Olahraga</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=politik"><b>Politik</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=seni"><b>Seni</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=sosialbudaya"><b>Sosial & Budaya</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=teknologi"><b>Teknologi</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=profil"><b></b></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <b><i class="fa-solid fa-user"></i></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=akunprofil"><b>Profil</b></a></li>
                            <?php if ($role == 'admin'): ?>
                            <li><a class="dropdown-item" href="?page=pemegang"><b>Pemegang</b></a></li>
                            <?php endif;?>
                            <li><a class="dropdown-item" href="logout.php"><b>LOGOUT</b></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR (Dihilangkan, digantikan dengan navbar responsif) -->
    <div id="content">
        <?php
        // Default page to show
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'beranda':
                    echo '<div class="alert alert-info" role="alert">Selamat Datang di Beranda!</div>';
                    break;
                    case 'ekonomi':
                        include('ekonomi/berita.php');
                        break;
                    case 'kesehatan':
                        include('kesehatan/berita.php');
                        break;
                    case 'kriminal':
                        include('kriminal/berita.php');
                        break;
                    case 'entertainment':
                        include('kultur/entertainment/berita.php');
                        break;
                    case 'filmtv':
                        include('kultur/filmtv/berita.php');
                        break;
                    case 'musik':
                        include('kultur/musik/berita.php');
                        break;
                    case 'lingkungan':
                        include('lingkungan/berita.php');
                        break;
                    case 'olahraga':
                        include('olahraga/berita.php');
                        break;
                    case 'politik':
                        include('politik/berita.php');
                        break;
                    case 'seni':
                        include('seni/berita.php');
                        break;
                    case 'sosialbudaya':
                        include('sosialbudaya/berita.php');
                        break;
                    case 'teknologi':
                        include('teknologi/berita.php');
                        break;
                    case 'akunprofil':
                        include('akunprofil.php');
                        break;
                    case 'pemegang':
                        include('pemegang.php');
                        break;
                    echo '<div class="alert alert-info" role="alert">Selamat Datang di Beranda!</div>';
                    break;
            }
        } else {
            // Tampilkan halaman beranda jika tidak ada parameter
            echo '<div class="alert alert-info" role="alert">Selamat Datang di Beranda!</div>';
        }
        ?>
    </div>


    <!-- FOOTER -->
    <footer>
        <p>&copy; <i><b>Rafli Subhi</b></i> Corporation</p>
    </footer>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- CDN JQUERY -->
    <script src="jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle navbar on mobile view
            $('.menu-btn').click(function() {
                $('.navbar-collapse').toggleClass('show');
            });
        });
    </script>
</body>

</html>