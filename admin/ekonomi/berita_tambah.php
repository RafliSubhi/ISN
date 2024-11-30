<?php
session_start();

// Cek apakah pengguna sudah login, jika belum arahkan ke login.php
if (!isset($_SESSION['notelp'])) {
    header('Location: ../login.php');  // Arahkan ke login.php jika belum login
    exit();
}

// Ambil data pengguna dari session
$role = $_SESSION['role'] ?? null;  // Menentukan role (admin/pemegang)
$notelp = $_SESSION['notelp'];  // Menyimpan no. telepon pengguna yang login
?>
<?php
include 'koneksi.php'; // Include database connection

// Variabel untuk menyimpan pesan error
$errorMessage = ''; 

// Menyimpan data input yang telah dimasukkan
$tgl = $judul = $subjudul = $text = ''; // Inisialisasi variabel inputan

// Cek apakah ada ID yang diterima melalui URL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl = isset($_POST['tgl']) ? htmlspecialchars($_POST['tgl']) : '';
    $judul = isset($_POST['judul']) ? htmlspecialchars($_POST['judul']) : '';
    $subjudul = isset($_POST['subjudul']) ? htmlspecialchars($_POST['subjudul']) : '';
    $text = isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '';
    $jenis = 'ekonomi'; // Default value for jenis
    $img = ''; // Placeholder for image path

    // Handle image upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        // Check file size (max 5 MB)
        $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
        if ($_FILES['img']['size'] > $maxFileSize) {
            $errorMessage = "Ukuran file terlalu besar. Maksimum ukuran file adalah 5 MB.";
        } else {
            // Check file type (only allow image formats)
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];  // Added 'image/webp' here
            $fileMimeType = mime_content_type($_FILES['img']['tmp_name']);
            
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                $errorMessage = "Format file tidak didukung. Hanya file JPEG, PNG, GIF, atau WEBP yang diperbolehkan.";
            } else {
                // Image upload to 'Up_berita/' folder
                $uploadDir = 'Up_berita/';
                $imageName = time() . '_' . basename($_FILES['img']['name']); // Unique file name
                $imagePath = $uploadDir . $imageName;

                // Check if the upload directory exists, if not, create it
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Move the uploaded file to 'Up_berita/' folder
                if (move_uploaded_file($_FILES['img']['tmp_name'], $imagePath)) {

                    // Prepare SQL query with prepared statements
                    $stmt = mysqli_prepare($koneksi, "INSERT INTO ekonomi (tgl, judul, subjudul, text, img, jenis) VALUES (?, ?, ?, ?, ?, ?)");

                    // Check if preparing statement failed
                    if ($stmt === false) {
                        die('MySQL prepare failed: ' . mysqli_error($koneksi));
                    }

                    // Bind parameters (ssssss = 5 string parameters + 1 string for jenis)
                    mysqli_stmt_bind_param($stmt, "ssssss", $tgl, $judul, $subjudul, $text, $imagePath, $jenis);

                    // Execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // If execution is successful, redirect
                        header("Location: ../index.php?page=ekonomi");
                        exit;
                    } else {
                        // If execution failed, output error
                        $errorMessage = "Query execution failed: " . mysqli_stmt_error($stmt);
                    }

                    // Close the prepared statement
                    mysqli_stmt_close($stmt);
                } else {
                    $errorMessage = "Terjadi kesalahan saat mengunggah file.";
                }
            }
        }
    } else {
        $errorMessage = "Tidak ada file yang diunggah atau terjadi kesalahan saat pengunggahan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita | Admin</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Berita Ekonomi</h2>

        <!-- Display error message if any -->
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger">
                <?= $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tgl" class="form-label">Tgl</label>
                <input type="date" class="form-control" name="tgl" value="<?= $tgl; ?>" required>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" name="judul" value="<?= $judul; ?>" required>
            </div>
            <div class="mb-3">
                <label for="subjudul" class="form-label">Sub-Judul</label>
                <input type="text" class="form-control" name="subjudul" value="<?= $subjudul; ?>" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Text</label>
                <textarea class="form-control" name="text" rows="4" required><?= $text; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Img</label>
                <h5>Max 5mb</h5>
                <input type="file" class="form-control" name="img" accept="image/jpeg, image/png, image/gif, image/webp" required>
            </div>

            <!-- Hidden field for jenis -->
            <input type="hidden" name="jenis" value="ekonomi">

            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="../index.php?page=ekonomi" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
