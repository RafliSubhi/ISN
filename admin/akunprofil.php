<?php
// Memulai session untuk mengecek apakah pengguna sudah login


// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['role']) || !isset($_SESSION['notelp'])) {
    // Jika tidak ada session yang valid, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Menghubungkan ke database
require 'koneksi.php';

// Mendapatkan informasi pengguna dari session
$notelp = $_SESSION['notelp'];
$role = $_SESSION['role'];  // Role dapat 'admin' atau 'pemegang'

// Mendeklarasikan variabel untuk username
$username = '';

// Mengambil data pengguna berdasarkan role yang login
if ($role == 'admin') {
    // Query untuk mendapatkan data admin termasuk username
    $sql_admin = "SELECT username, notelp FROM tbadmin WHERE notelp = ?";
    $stmt_admin = $koneksi->prepare($sql_admin);
    $stmt_admin->bind_param("s", $notelp);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $row_admin = $result_admin->fetch_assoc();
        $username = $row_admin['username'];  // Menyimpan username admin
    } else {
        // Jika tidak ditemukan data, arahkan ke halaman login
        header("Location: login.php");
        exit();
    }

    $stmt_admin->close();
} elseif ($role == 'pemegang') {
    // Query untuk mendapatkan data pemegang termasuk username
    $sql_pemegang = "SELECT username, notelp FROM tbpemegang WHERE notelp = ?";
    $stmt_pemegang = $koneksi->prepare($sql_pemegang);
    $stmt_pemegang->bind_param("s", $notelp);
    $stmt_pemegang->execute();
    $result_pemegang = $stmt_pemegang->get_result();

    if ($result_pemegang->num_rows > 0) {
        $row_pemegang = $result_pemegang->fetch_assoc();
        $username = $row_pemegang['username'];  // Menyimpan username pemegang
    } else {
        // Jika tidak ditemukan data, arahkan ke halaman login
        header("Location: login.php");
        exit();
    }

    $stmt_pemegang->close();
} else {
    // Jika role tidak valid, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- FONT-AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.cdnfonts.com/css/nirvana" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-bottom: 70px;
        }

        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h2 {
            font-size: 2rem;
            color: #003366;
        }

        .profile-details {
            list-style-type: none;
            padding-left: 0;
        }

        .profile-details li {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .profile-details li strong {
            color: #003366;
        }

        .btn-custom {
            background-color: #003366;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="profile-container">
            <div class="profile-header">
                <i class="fa-solid display-4 fa-user"></i>
                <br>&nbsp;
                <h2>Profil Anda</h2>
            </div>
            <ul class="profile-details">
                <li><strong>Role: </strong><?php echo htmlspecialchars($role); ?></li>
                <li><strong>No. Telepon: </strong><?php echo htmlspecialchars($notelp); ?></li>
                <li><strong>Username: </strong><?php echo htmlspecialchars($username); ?></li>
                <li class="text-center"><a href="akunprofil_ubah.php" class="btn btn-warning"><b>Ubah Profil</b></a></li>
            </ul>
            <div class="text-center">
                <a href="index.php" class="btn btn-custom">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- CDN JQUERY -->
    <script src="jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
