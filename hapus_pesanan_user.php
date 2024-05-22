<?php
    include ('koneksi.php');
    $id = $_GET['id'];
    $query = "DELETE FROM pesanan WHERE id = '$id'";
    $result = mysqli_query ($koneksi,$query);

    if (!$result) {
        die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
    } else {
        echo "<script>alert('Pesanan berhasil dibatalkan!');window.location='antrian_user.php';</script>";
    }
?>