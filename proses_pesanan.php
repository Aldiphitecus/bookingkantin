<?php
    include('koneksi.php');

    if(isset($_POST['atas_nama'], $_POST['telepon'], $_POST['nim'], $_POST['menu_id'], $_POST['kuantitas'], $_POST['layanan'], $_POST['harga_total'])){
        
        $atas_nama = $_POST['atas_nama'];
        $telepon = $_POST['telepon'];
        $nim = $_POST['nim'];
        $menu_id = $_POST['menu_id'];
        $kuantitas = $_POST['kuantitas'];
        $layanan = $_POST['layanan'];
        $harga_total = $_POST['harga_total'];

        $query = "INSERT INTO pesanan(atas_nama, telepon, nim, menu_id, kuantitas, layanan, harga_total) VALUES('$atas_nama', '$telepon', '$nim', '$menu_id', '$kuantitas', '$layanan', '$harga_total')";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
        } else {
            echo "<script>alert('Pesanan berhasil!');window.location='antrian_user.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak lengkap!');window.location='detail_menu.php'</script>";
    }
?>