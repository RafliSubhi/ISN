<?php
require "koneksi.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tbpemegang WHERE id = '$id'");
    
    if ($query) {
        header("Location: index.php?page=pemegang");
    }
}
?>