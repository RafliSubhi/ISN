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
require "koneksi.php";

// Fetch the existing data when editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tbpemegang WHERE id = '$id'");
    $data = mysqli_fetch_array($query);
}

// Initialize error message variable
$error_message = "";

// Update data
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $password = $_POST['password'];

    // Check if the phone number is already taken (excluding the current user's phone number)
    $query = mysqli_query($koneksi, "SELECT * FROM tbpemegang WHERE notelp = '$notelp' AND id != '$id'");
    if (mysqli_num_rows($query) > 0) {
        $error_message = "Nomor telepon sudah digunakan, silakan gunakan nomor lain.";
    } else {
        // Check if the password is being changed
        if (empty($password)) {
            // If password is not changed, keep the old password
            $password = $data['password'];
        } else {
            // Hash the new password if it's being updated
            $password = md5($password);
        }

        // Update query - make sure to include notelp, even if password isn't updated
        $query = mysqli_query($koneksi, "UPDATE tbpemegang SET username = '$username', alamat = '$alamat', notelp = '$notelp', password = '$password' WHERE id = '$id'");

        if ($query) {
            // Redirect after successful update
            header("Location: index.php?page=pemegang");
            exit;
        } else {
            $error_message = "Gagal mengupdate data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemegang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }
        .form-container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            color: #003366;
        }
        .alert-danger {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container form-container">
    <h2>Edit Pemegang</h2>
    
    <!-- Display error message if exists -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group mb-3">
            <label for="username">Username Pemegang:</label>
            <input type="text" name="username" class="form-control" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : $data['username']; ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" class="form-control" id="alamat" value="<?php echo isset($_POST['alamat']) ? $_POST['alamat'] : $data['alamat']; ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="notelp">No. Telepon:</label>
            <input type="text" name="notelp" class="form-control" id="notelp" value="<?php echo isset($_POST['notelp']) ? $_POST['notelp'] : $data['notelp']; ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Ubah Password:</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password baru jika ingin mengganti">
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php?page=pemegang" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
