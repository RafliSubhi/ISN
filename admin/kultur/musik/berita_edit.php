<?php
session_start();

// Cek apakah pengguna sudah login, jika belum arahkan ke login.php
if (!isset($_SESSION['notelp'])) {
    header('Location: ../../login.php');  // Arahkan ke login.php jika belum login
    exit();
}

// Ambil data pengguna dari session
$role = $_SESSION['role'] ?? null;  // Menentukan role (admin/pemegang)
$notelp = $_SESSION['notelp'];  // Menyimpan no. telepon pengguna yang login
?>
<?php
// Menghubungkan ke database
include 'koneksi.php';

// Variabel untuk menyimpan pesan error
$errorMessage = ''; 

// Cek apakah ada ID yang diterima melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID
    $sql = mysqli_query($koneksi, "SELECT * FROM musik WHERE id = '$id'");
    $data = mysqli_fetch_array($sql);

    // Jika data tidak ditemukan, tampilkan pesan error
    if (!$data) {
        echo "Data tidak ditemukan!";
        exit;
    }

    // Proses jika form disubmit
    if (isset($_POST['submit'])) {
        // Ambil nilai input dari form
        $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
        $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
        $subjudul = mysqli_real_escape_string($koneksi, $_POST['subjudul']);
        $text = mysqli_real_escape_string($koneksi, $_POST['text']);
        
        // Jika gambar baru tidak diunggah, tetap gunakan gambar yang lama
        $imgPath = $data['img'];

        // Validasi jika ada gambar baru yang di-upload
        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $imgTmp = $_FILES['img']['tmp_name'];
            $imgName = $_FILES['img']['name'];
            $imgSize = $_FILES['img']['size'];
            $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

            // Batas ukuran file 5 MB (5 * 1024 * 1024 bytes)
            $maxFileSize = 5 * 1024 * 1024;

            // Validasi jenis file gambar
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($imgExt, $allowedExt)) {
                $errorMessage = "Hanya file gambar yang diperbolehkan (jpg, jpeg, png, gif, webp).";
            }

            // Validasi ukuran file (maksimal 5 MB)
            if ($imgSize > $maxFileSize) {
                $errorMessage = "Ukuran file terlalu besar. Maksimal 5 MB.";
            }

            // Jika format dan ukuran file valid, proses upload gambar baru
            if (empty($errorMessage)) {
                // Tentukan lokasi penyimpanan gambar
                $uploadDir = 'Up_berita/';
                $imgNewName = uniqid() . '.' . $imgExt;
                $imgPath = $uploadDir . $imgNewName;

                // Pindahkan file gambar yang di-upload ke direktori yang telah ditentukan
                if (move_uploaded_file($imgTmp, $imgPath)) {
                    // Jika gambar baru berhasil diunggah, hapus gambar lama dari server
                    if ($data['img'] && file_exists($data['img']) && $data['img'] != 'Up_berita/default.jpg') {
                        unlink($data['img']); // Menghapus gambar lama
                    }
                } else {
                    $errorMessage = "Gagal mengunggah gambar.";
                }
            }
        }

        // Jika tidak ada error, update data tgl, judul, subjudul, text, dan gambar (imgPath) di database
        if (empty($errorMessage)) {
            $updateQuery = "UPDATE musik SET tgl = '$tgl', judul = '$judul', subjudul = '$subjudul', text = '$text', img = '$imgPath' WHERE id = '$id'";

            if (mysqli_query($koneksi, $updateQuery)) {
                echo "<script>alert('Data berhasil diperbarui!'); window.location.href = '../../index.php?page=musik';</script>";
            } else {
                echo "Gagal memperbarui data: " . mysqli_error($koneksi);
            }
        }
    }
} else {
    echo "ID tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita | Admin</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Berita musik</h2>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Tanggal -->
            <div class="mb-3">
                <label for="tgl" class="form-label">Tgl</label>
                <input type="date" class="form-control" id="tgl" name="tgl" value="<?php echo isset($_POST['tgl']) ? htmlspecialchars($_POST['tgl']) : htmlspecialchars($data['tgl']); ?>" required>
            </div>

            <!-- Judul Berita -->
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo isset($_POST['judul']) ? htmlspecialchars($_POST['judul']) : htmlspecialchars($data['judul']); ?>" required>
            </div>

            <!-- Subjudul -->
            <div class="mb-3">
                <label for="subjudul" class="form-label">Sub-Judul</label>
                <input type="text" class="form-control" id="subjudul" name="subjudul" value="<?php echo isset($_POST['subjudul']) ? htmlspecialchars($_POST['subjudul']) : htmlspecialchars($data['subjudul']); ?>" required>
            </div>

            <!-- Text Berita -->
            <div class="mb-3">
                <label for="text" class="form-label">Text</label>
                <textarea class="form-control" id="text" name="text" rows="4" required><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : htmlspecialchars($data['text']); ?></textarea>
            </div>

            <!-- Input Gambar -->
            <div class="mb-3">
                <label for="img" class="form-label">Change Image (Max 5MB)</label>
                <input type="file" class="form-control" id="img" name="img" accept="image/*">
            </div>

            <!-- Preview Gambar Saat Ini -->
            <?php if (!empty($data['img'])): ?>
                <div class="mb-3">
                    <label for="img" class="form-label">Current Image</label>
                    <img src="<?php echo $data['img']; ?>" alt="Current Image" width="300">
                </div>
            <?php endif; ?>

            <!-- Tombol Submit -->
            <button type="submit" name="submit" class="btn btn-success">Update</button>
            <a href="../../index.php?page=musik" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
