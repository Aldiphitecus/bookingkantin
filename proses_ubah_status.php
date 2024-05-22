<?php
    include('koneksi.php');

    $id = $_POST['id'];
    $status_pesanan = $_POST['status_pesanan'];

    $query = "UPDATE pesanan SET status_pesanan = '$status_pesanan' WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
    } else {
        echo "<script>alert('Status sudah diubah!');window.location='pesanan_admin.php';</script>";
    }
?>