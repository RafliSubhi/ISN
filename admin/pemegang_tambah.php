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
    <title>Tambah Pemegang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" 
        crossorigin="anonymous">
    <style>
        .container {
            padding-top: 40px;
        }
        
        /* Form container to center it */
        .form-container {
            max-width: 600px; /* Set a max width to prevent it from stretching too wide on larger screens */
            margin: 0 auto; /* Center horizontally */
            padding: 30px;
            background-color: #f9f9f9; /* Optional: light background color */
            border-radius: 8px; /* Optional: rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: subtle shadow effect */
        }
        
        .form-container h2 {
            text-align: center; /* Center the title */
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Include file koneksi, untuk koneksikan ke database
        require "koneksi.php";

        // Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Variabel untuk menyimpan pesan error
        $error_message = "";

        // Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = input($_POST["username"]);
            $alamat = input($_POST["alamat"]);
            $notelp = input($_POST["notelp"]);
            $password = input($_POST["password"]);

            // Sanitasi no.telepon (hapus semua karakter selain angka)
            $notelp = preg_replace("/[^0-9]/", "", $notelp);

            // Validasi nomor telepon (pastikan hanya angka setelah sanitasi)
            if (empty($notelp)) {
                $error_message = "Nomor telepon tidak boleh kosong atau mengandung karakter selain angka!";
            } else {
                // Cek apakah notelp sudah ada di database
                $query = "SELECT * FROM tbpemegang WHERE notelp = '$notelp'";
                $result = mysqli_query($koneksi, $query);

                if (mysqli_num_rows($result) > 0) {
                    // Jika notelp sudah ada, tampilkan pesan error
                    $error_message = "Nomor telepon sudah terdaftar, silakan gunakan nomor lain!";
                } else {
                    // Hash password menggunakan md5() (ini tidak disarankan untuk keamanan)
                    $hashed_password = md5($password);

                    // Query input menginput data kedalam tabel tbpemegang
                    $sql = "INSERT INTO tbpemegang (username, alamat, notelp, password) 
                            VALUES ('$username', '$alamat', '$notelp', '$hashed_password')";

                    // Mengeksekusi/menjalankan query di atas
                    $hasil = mysqli_query($koneksi, $sql);

                    // Kondisi apakah berhasil atau tidak dalam mengeksekusi query di atas
                    if ($hasil) {
                        header("Location: index.php?page=pemegang");
                        exit;
                    } else {
                        $error_message = "Data Gagal disimpan.";
                    }
                }
            }
        }
        ?>

        <div class="form-container">
            <h2>Input Data Pemegang</h2>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <!-- Form untuk input data kasir -->
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                <div class="form-group">
                    <label>Username:</label>
                    <!-- Menambahkan autocomplete="off" pada kolom input username -->
                    <input type="text" name="username" class="form-control" placeholder="Masukan Nama pemegang" required autocomplete="off" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <!-- Menambahkan autocomplete="off" pada kolom input alamat -->
                    <input type="text" name="alamat" class="form-control" placeholder="Masukan Alamat" required autocomplete="off" value="<?php echo isset($_POST['alamat']) ? $_POST['alamat'] : ''; ?>" />
                </div>
                <div class="form-group">
                    <label>No.Telp:</label>
                    <!-- Menambahkan autocomplete="off" pada kolom input no.telepon -->
                    <input type="text" name="notelp" class="form-control" placeholder="Masukan No.Telp" required autocomplete="off" value="<?php echo isset($_POST['notelp']) ? $_POST['notelp'] : ''; ?>" />
                    <small class="form-text text-muted">Masukkan nomor telepon dengan atau tanpa tanda hubung, spasi, atau tanda lainnya.</small>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <!-- Menambahkan autocomplete="off" pada kolom input password -->
                    <input type="password" name="password" class="form-control" placeholder="Masukan Password" required autocomplete="off" />
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="index.php?page=pemegang" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" 
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" 
        crossorigin="anonymous"></script>
</body>

</html>
