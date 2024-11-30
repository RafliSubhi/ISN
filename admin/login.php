<?php
// Mulai session untuk menyimpan status login
session_start();

// Sertakan file koneksi
include('koneksi.php');  // Mengimpor koneksi.php

// Cek apakah form login sudah disubmit
if (isset($_POST['login'])) {
    // Ambil input dari form
    $notelp = $_POST['notelp'];
    $password = $_POST['password'];

    // Hash password dengan MD5 sebelum digunakan dalam query
    $hashed_password = md5($password);

    // Query untuk memeriksa username dan password di tbadmin
    $sql_admin = "SELECT * FROM tbadmin WHERE notelp = ? AND password = ?";
    $stmt_admin = $koneksi->prepare($sql_admin);
    $stmt_admin->bind_param("ss", $notelp, $hashed_password);  // ss berarti string (string) untuk notelp dan hashed password
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    // Query untuk memeriksa username dan password di tbpemegang
    $sql_pemegang = "SELECT * FROM tbpemegang WHERE notelp = ? AND password = ?";
    $stmt_pemegang = $koneksi->prepare($sql_pemegang);
    $stmt_pemegang->bind_param("ss", $notelp, $hashed_password);  // ss berarti string (string) untuk notelp dan hashed password
    $stmt_pemegang->execute();
    $result_pemegang = $stmt_pemegang->get_result();

    // Periksa apakah data ditemukan di tbadmin
    if ($result_admin->num_rows > 0) {
        // Data ditemukan, login berhasil
        $row_admin = $result_admin->fetch_assoc();
        $_SESSION['notelp'] = $notelp;
        $_SESSION['role'] = 'admin';  // Menandakan role admin
        $_SESSION['id_user'] = $row_admin['id'];  // Menyimpan id user admin
        header("Location: index.php");  // Arahkan ke halaman utama setelah login
        exit();
    }
    // Periksa apakah data ditemukan di tbpemegang
    elseif ($result_pemegang->num_rows > 0) {
        // Data ditemukan, login berhasil
        $row_pemegang = $result_pemegang->fetch_assoc();
        $_SESSION['notelp'] = $notelp;
        $_SESSION['role'] = 'pemegang';  // Menandakan role pemegang
        $_SESSION['id_user'] = $row_pemegang['id'];  // Menyimpan id user pemegang
        header("Location: index.php");  // Arahkan ke halaman utama setelah login
        exit();
    } else {
        // Data tidak ditemukan
        $error_message = "Username atau password salah!";
    }

    // Tutup statement
    $stmt_admin->close();
    $stmt_pemegang->close();
}

// Tutup koneksi
$koneksi->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Memuat CSS Bootstrap dari CDN -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                <!-- Menampilkan pesan error jika login gagal -->
                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="notelp" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="notelp" name="notelp" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <small>© 2024 MyWebsite</small>
            </div>
        </div>
    </div>
</div>

<!-- Memuat JavaScript Bootstrap dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb6hfxzM9xZI6G5G5p6f9ra7xsbVnE1bm6pD5s5vb9ap+3gEwF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0C7Vn7P4y8P+u8Bhw3vA8/gqU7XB7k9VlgI5vL70RoU+z2J3" crossorigin="anonymous"></script>
</body>
</html>
