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
<?php
// Memulai session untuk mengecek apakah pengguna sudah login
session_start();

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

// Menyimpan variabel untuk username, error message, dan password
$username = '';
$error_message = '';
$password = ''; // Variabel untuk password baru

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

// Proses jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = trim($_POST['username']);
    $new_notelp = trim($_POST['notelp']);
    $new_password = trim($_POST['password']); // Password baru (satu kolom)
    
    // Validasi input
    if (empty($new_username) || empty($new_notelp)) {
        $error_message = "Username dan No. Telepon harus diisi.";
    } else {
        // Update data di database
        if (!empty($new_password)) {
            // Jika password diubah, enkripsi password baru menggunakan MD5
            $hashed_password = md5($new_password);
            if ($role == 'admin') {
                $sql_update = "UPDATE tbadmin SET username = ?, notelp = ?, password = ? WHERE notelp = ?";
                $stmt_update = $koneksi->prepare($sql_update);
                $stmt_update->bind_param("ssss", $new_username, $new_notelp, $hashed_password, $notelp);
            } elseif ($role == 'pemegang') {
                $sql_update = "UPDATE tbpemegang SET username = ?, notelp = ?, password = ? WHERE notelp = ?";
                $stmt_update = $koneksi->prepare($sql_update);
                $stmt_update->bind_param("ssss", $new_username, $new_notelp, $hashed_password, $notelp);
            }
        } else {
            // Jika password tidak diubah, update tanpa mengganti password
            if ($role == 'admin') {
                $sql_update = "UPDATE tbadmin SET username = ?, notelp = ? WHERE notelp = ?";
                $stmt_update = $koneksi->prepare($sql_update);
                $stmt_update->bind_param("sss", $new_username, $new_notelp, $notelp);
            } elseif ($role == 'pemegang') {
                $sql_update = "UPDATE tbpemegang SET username = ?, notelp = ? WHERE notelp = ?";
                $stmt_update = $koneksi->prepare($sql_update);
                $stmt_update->bind_param("sss", $new_username, $new_notelp, $notelp);
            }
        }

        // Eksekusi query update
        if ($stmt_update->execute()) {
            // Update berhasil, arahkan kembali ke halaman profil
            $_SESSION['notelp'] = $new_notelp; // Update session notelp jika no telepon diubah
            header("Location: index.php?page=akunprofil");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat memperbarui profil.";
        }
        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.cdnfonts.com/css/nirvana" rel="stylesheet">
    <style>
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

        .form-group {
            margin-bottom: 20px;
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
                <h2>Ubah Profil Anda</h2>
            </div>

            <!-- Tampilkan error jika ada -->
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <!-- Formulir untuk mengubah profil -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="notelp">No. Telepon</label>
                    <input type="text" class="form-control" id="notelp" name="notelp" value="<?php echo htmlspecialchars($notelp); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Ubah Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="index.php?page=akunprofil" class="btn btn-secondary">Kembali ke Profil</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
