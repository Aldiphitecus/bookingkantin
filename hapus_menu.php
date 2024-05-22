<?php
    include ('koneksi.php');
    $id = $_GET['id'];
    $query = "DELETE FROM menu WHERE id = '$id'";
    $result = mysqli_query ($koneksi,$query);

    if (!$result) {
        die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
    } else {
        echo "<script>alert('Menu berhasil di hapus!');window.location='admin_depan.php';</script>";
    }
?>