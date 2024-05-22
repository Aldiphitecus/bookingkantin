<?php
    include('koneksi.php');

    $id = $_POST['id'];
    // $kategori_id = $_POST['kategori_id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto']['name'];
    $deskripsi = $_POST['deskripsi'];
    $ketersediaan_stok = $_POST['ketersediaan_stok'];

    if ($foto != "") {
        $ekstensi_diperbolehkan = array('png', 'jpg');
        $x = explode('.', $foto);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['foto']['tmp_name'];
        $angka_acak = rand(1, 999);
        $nama_gambar_baru = $angka_acak.'-'.$foto;

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            move_uploaded_file($file_tmp, 'gambar/'.$nama_gambar_baru);

            $query = "UPDATE menu SET nama = '$nama', deskripsi = '$deskripsi', harga = '$harga', ketersediaan_stok = '$ketersediaan_stok', foto = '$nama_gambar_baru'"; // Corrected query syntax
            $query .= " WHERE id = '$id'"; // Corrected concatenation of WHERE clause
            $result = mysqli_query($koneksi, $query);
            
            if (!$result) {
                die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
            } else {
                echo "<script>alert('Menu berhasil diubah!');window.location='admin_depan.php';</script>";
            }
        } else {
            echo "<script>alert('Ekstensi gambar hanya bisa jpg dan png!');window.location='edit_menu.php'</script>";
        }
    } else {
        // Jika tidak ada gambar baru diunggah, maka lakukan pembaruan tanpa mengubah gambar
    $query = "UPDATE menu SET nama = '$nama', deskripsi = '$deskripsi', harga = '$harga', ketersediaan_stok = '$ketersediaan_stok'";
    $query .= " WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);
    
    if (!$result) {
        die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
    } else {
        echo "<script>alert('Menu berhasil diubah!');window.location='admin_depan.php';</script>";
    }
}
?>
