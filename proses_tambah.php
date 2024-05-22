<?php
    include('koneksi.php');

    // Periksa apakah data terkirim
    if(isset($_POST['kategori_id'], $_POST['nama'], $_POST['harga'], $_POST['deskripsi'], $_POST['ketersediaan_stok'])) {
        
        // Ambil nilai dari formulir
        $kategori_id = $_POST['kategori_id'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        $ketersediaan_stok = $_POST['ketersediaan_stok'];

        // Inisialisasi variabel foto
        $foto = '';
        $nama_gambar_baru = '';

        // Periksa apakah ada file gambar yang diunggah
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = $_FILES['foto']['name'];

            // Validasi ekstensi file gambar
            $ekstensi_diperbolehkan = array('png', 'jpg');
            $x = explode('.', $foto);
            $ekstensi = strtolower(end($x));

            if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
                $file_tmp = $_FILES['foto']['tmp_name'];
                $angka_acak = rand(1, 999);
                $nama_gambar_baru = $angka_acak.'-'.$foto;
                move_uploaded_file($file_tmp, 'gambar/'.$nama_gambar_baru);
            } else {
                echo "<script>alert('Ekstensi gambar hanya bisa jpg dan png!');window.location='tambah_menu.php'</script>";
                exit; // Hentikan eksekusi jika ekstensi tidak valid
            }
        }

        // Buat query untuk memasukkan data ke dalam database
        $query = "INSERT INTO menu (kategori_id, nama, harga, foto, deskripsi, ketersediaan_stok) VALUES ('$kategori_id', '$nama', '$harga', '$nama_gambar_baru', '$deskripsi', '$ketersediaan_stok')";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
        } else {
            echo "<script>alert('Menu berhasil ditambahkan!');window.location='admin_depan.php';</script>";
        }
    } else {
        // Jika data tidak lengkap, kembalikan ke halaman tambah_menu.php
        echo "<script>alert('Data tidak lengkap!');window.location='tambah_menu.php'</script>";
    }
?>
