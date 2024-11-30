<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- FONT-AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.cdnfonts.com/css/nirvana" rel="stylesheet">
    <title>Data Kasir</title>
    <style>
        /* Add responsive table wrapper */
        .table-responsive {
            overflow-x: auto;
            padding-bottom: 25px;
        }

        .container {
            padding-bottom:35px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Pemegang</h2>

        <!-- Add responsive wrapper for table -->
        <div class="table-responsive">
            <form action="" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="pencarian" placeholder="Cari berdasarkan notelp..." class="form-control"
                            value="<?php echo isset($_POST['pencarian']) ? $_POST['pencarian'] : ''; ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="submit" name="dicari" value="Cari" class="btn btn-success">
                    </div>
                </div>
            </form>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Pemegang</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No.Telp</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "koneksi.php";
                    if (isset($_POST['dicari']) && !empty($_POST['pencarian'])) {
                        // Gunakan mysqli_real_escape_string untuk mengamankan input
                        $pencarian = mysqli_real_escape_string($koneksi, $_POST['pencarian']);

                        // Query pencarian kasir
                        $sql = mysqli_query($koneksi, "SELECT * FROM tbpemegang WHERE notelp LIKE '%$pencarian%' ORDER BY id DESC");
                    } else {
                        $sql = mysqli_query($koneksi, "SELECT * FROM tbpemegang");
                    }
                    $no = 1;
                    while ($data = mysqli_fetch_array($sql)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['username'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['notelp'] ?></td>
                            <td>
                                <a href="pemegang_edit.php?id=<?php echo $data['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="pemegang_hapus.php?id=<?php echo $data['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <a href="pemegang_tambah.php" class="btn btn-primary" role="button">Tambah Pemegang</a>
        </div>

    </div>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- CDN JQUERY -->
    <script src="jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>