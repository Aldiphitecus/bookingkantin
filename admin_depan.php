<?php
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header("Location: login.php");
        exit();
    }

    include('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>SiKantin</h2>
        <ul>
            <li class="menu"><a href="admin_depan.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg> Data Menu</a></li>
            <li><a href="pesanan_admin.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg> Pesanan</a></li>
            <li><a href="logout.php" onclick="return confirm('Apakah kamu yakin ingin keluar?');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                        <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                </svg> Log Out</a></li>
        </ul>
    </div>
    <div class="content">
        <center><h1>Data Menu</h1></center><br><br>
        <div>
            <center><a class="tomboltambah" href="tambah_menu.php">+ &nbsp; Tambah Menu</a></center>
            <h3>Makanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Deskripsi</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_makanan = "SELECT menu.*, kategori.nama AS nama_kategori FROM menu INNER JOIN kategori ON menu.kategori_id = kategori.id WHERE menu.kategori_id = 1 ORDER BY menu.id ASC";
                        $result_makanan = mysqli_query($koneksi, $query_makanan);
                        
                        if (!$result_makanan) {
                            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                        }
                        $no = 1;

                        while ($row_makanan = mysqli_fetch_assoc($result_makanan)){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $row_makanan['nama_kategori'];?></td>
                        <td><?php echo $row_makanan['nama'];?></td>
                        <td>Rp <?php echo number_format($row_makanan['harga'], 0, ',', '.');?></td>
                        <td><img src="gambar/<?php echo $row_makanan['foto'];?>" width="100px"></td>
                        <td><?php echo $row_makanan['deskripsi'];?></td>
                        <td><?php echo $row_makanan['ketersediaan_stok'];?></td>
                        <td>
                            <a class="tomboledit" href="edit_menu.php?id=<?php echo $row_makanan['id']?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <a class="tombolhapus" href="hapus_menu.php?id=<?php echo $row_makanan['id']?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php
                        $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div><br>
        <div>
            <h3>Minuman</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Deskripsi</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_minuman = "SELECT menu.*, kategori.nama AS nama_kategori FROM menu INNER JOIN kategori ON menu.kategori_id = kategori.id WHERE menu.kategori_id = 2 ORDER BY menu.id ASC";
                        $result_minuman = mysqli_query($koneksi, $query_minuman);
                        
                        if (!$result_minuman) {
                            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                        }
                        $no = 1;

                        while ($row_minuman = mysqli_fetch_assoc($result_minuman)){
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $row_minuman['nama_kategori'];?></td>
                        <td><?php echo $row_minuman['nama'];?></td>
                        <td>Rp <?php echo number_format($row_minuman['harga'], 0, ',', '.');?></td>
                        <td><img src="gambar/<?php echo $row_minuman['foto'];?>" width="100px"></td>
                        <td><?php echo $row_minuman['deskripsi'];?></td>
                        <td><?php echo $row_minuman['ketersediaan_stok'];?></td>
                        <td>
                            <a class="tomboledit" href="edit_menu.php?id=<?php echo $row_minuman['id']?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <a class="tombolhapus" href="hapus_menu.php?id=<?php echo $row_minuman['id']?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php
                        $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
