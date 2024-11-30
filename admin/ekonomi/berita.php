<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Berita | Admin</title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- FONT-AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.cdnfonts.com/css/nirvana" rel="stylesheet">
</head>
<style>
    .container {
        padding-bottom: 35px;
    }
</style>

<body>
    <div class="container mt-2">
        <h2 class="mb-4">Berita Ekonomi</h2>

        <!-- Form Pencarian -->
        <form class="search-form mb-3" method="POST" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="pencarian" placeholder="Cari berdasarkan judul..." aria-label="Search">
                <button class="btn btn-primary btn-sm" type="submit" name="btncari">Cari</button>
            </div>
        </form>

        <!-- Membungkus tabel dengan div untuk responsivitas -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light text-center">
                    <tr>

                        <th scope="col">Tgl</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Sub-Judul</th>
                        <th scope="col">text</th>
                        <th scope="col">img</th>
                        <th scope="col">Opsi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menghubungkan ke database
                    include 'koneksi.php';

                    // Menentukan query berdasarkan input pencarian
                    if (isset($_POST['btncari']) && !empty($_POST['pencarian'])) {
                        $pencarian = $_POST['pencarian'];
                        $sql = mysqli_query($koneksi, "SELECT * FROM ekonomi WHERE judul LIKE '%" . mysqli_real_escape_string($koneksi, $pencarian) . "%'");
                    } else {
                        $sql = mysqli_query($koneksi, "SELECT * FROM ekonomi");
                    }
                    while ($data = mysqli_fetch_array($sql)) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['tgl']); ?></td>
                            <td><?php echo htmlspecialchars($data['judul']); ?></td>
                            <td><?php echo htmlspecialchars($data['subjudul']); ?></td>
                            <td><?php echo htmlspecialchars($data['text']); ?></td>
                            <td><img src="ekonomi/<?php echo htmlspecialchars($data['img']); ?>" alt="Image" width="50"></td>
                            <td class="text-center">
                                <a href="ekonomi/berita_edit.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="ekonomi/berita_hapus.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin akan menghapus data?');">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="ekonomi/berita_tambah.php" class="btn btn-primary" role="button">Tambah Berita</a>
    </div>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- CDN JQUERY -->
    <script src="../jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>