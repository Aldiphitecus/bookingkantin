<?php
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
        header("Location: login.php");
        exit();
    }
    include('koneksi.php');
    $nim_pengguna = "";
    $username = $_SESSION['username'];
    $query_nim_pengguna = "SELECT nim FROM user WHERE username = '$username'";
    $result_nim_pengguna = mysqli_query($koneksi, $query_nim_pengguna);

    if ($result_nim_pengguna) {
        $row_nim_pengguna = mysqli_fetch_assoc($result_nim_pengguna);
        $nim_pengguna = $row_nim_pengguna['nim'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>SiKantin</h2>
        <ul>
            <li><a href="dashboard_user.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
                </svg>   Menu</a></li>
            <li class="antrian"><a href="antrian_user.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg> Antrian</a></li>
            <li><a href="pesanan_user.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg> Keranjang</a></li>
            <li><a href="logout.php" onclick="return confirm('Apakah kamu yakin ingin keluar?');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                    <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                </svg> Log Out</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Antrian</h1>
        <div>
            <h3>Pesanan Selesai</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Atas Nama</th>
                        <th>NIM</th>
                        <th>Telepon</th>
                        <th>Pesanan</th>
                        <th>Kuantitas</th>
                        <th>Layanan</th>
                        <th>Harga Total</th>
                        <th>Status Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_selesai = "SELECT pesanan.id, pesanan.atas_nama, pesanan.nim, pesanan.telepon, menu.nama AS nama_menu, pesanan.kuantitas, pesanan.layanan, pesanan.harga_total, pesanan.status_pesanan FROM pesanan INNER JOIN menu ON pesanan.menu_id = menu.id WHERE pesanan.status_pesanan = 'selesai'";
                        $result_pesanan = mysqli_query($koneksi, $query_selesai);
                        
                        if (!$result_pesanan) {
                            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                        }
                        $no = 1;

                        while ($row_pesanan = mysqli_fetch_assoc($result_pesanan)){
                    ?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo $row_pesanan['atas_nama']?></td>
                        <td><?php echo $row_pesanan['nim']?></td>
                        <td><?php echo $row_pesanan['telepon']?></td>
                        <td><?php echo $row_pesanan['nama_menu']?></td>
                        <td><?php echo $row_pesanan['kuantitas']?></td>
                        <td><?php echo $row_pesanan['layanan']?></td>
                        <td><?php echo 'Rp '.number_format($row_pesanan['harga_total'], 0, ',', '.')?></td>
                        <td><?php echo $row_pesanan['status_pesanan']?></td>
                    </tr>
                    <?php
                        $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div><br>
        <div>
            <h3>Pesanan Diproses</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Atas Nama</th>
                        <th>NIM</th>
                        <th>Telepon</th>
                        <th>Pesanan</th>
                        <th>Kuantitas</th>
                        <th>Layanan</th>
                        <th>Harga Total</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_selesai = "SELECT pesanan.id, pesanan.atas_nama, pesanan.nim, pesanan.telepon, menu.nama AS nama_menu, pesanan.kuantitas, pesanan.layanan, pesanan.harga_total, pesanan.status_pesanan FROM pesanan INNER JOIN menu ON pesanan.menu_id = menu.id WHERE pesanan.status_pesanan = 'diproses'";
                        $result_pesanan = mysqli_query($koneksi, $query_selesai);
                        
                        if (!$result_pesanan) {
                            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                        }
                        $no = 1;

                        while ($row_pesanan = mysqli_fetch_assoc($result_pesanan)){
                    ?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo $row_pesanan['atas_nama']?></td>
                        <td><?php echo $row_pesanan['nim']?></td>
                        <td><?php echo $row_pesanan['telepon']?></td>
                        <td><?php echo $row_pesanan['nama_menu']?></td>
                        <td><?php echo $row_pesanan['kuantitas']?></td>
                        <td><?php echo $row_pesanan['layanan']?></td>
                        <td>Rp. <?php echo number_format($row_pesanan['harga_total'], 0, ',', '.')?></td>
                        <td><?php echo $row_pesanan['status_pesanan']?></td>
                        <td>
                            <?php if ($row_pesanan['nim'] == $nim_pengguna) { ?>
                                <a class="tombolhapuspesanan" href="hapus_pesanan_user.php?id=<?php echo $row_pesanan['id']?>" onclick="return confirm('Anda yakin membatalkan pesanan ini?')">Batalkan</a>
                            <?php } else { ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                        $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div><br>
    </div>
    <!-- <script>
        setInterval(function(){
            location.reload();
        }, 5000);
    </script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
