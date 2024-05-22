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
            <li><a href="admin_depan.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg> Data Menu</a></li>
                <li class="pesanan"><a href="pesanan_admin.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg> Pesanan</a></li>
                <li><a href="logout.php" onclick="return confirm('Apakah kamu yakin ingin keluar?');">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                    </svg> Log Out</a></li>
            </ul>
        </ul>
    </div>
    <div class="content">
        <h1>Pesanan</h1><br>
        <div>
            <h3>Pesanan Masuk</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Atas Nama</th>
                        <th>Telepon</th>
                        <th>Pesanan</th>
                        <th>Kuantitas</th>
                        <th>Layanan</th>
                        <th>Harga Total</th>
                        <th>Status Pesanan</th>
                        <th>Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_selesai = "SELECT pesanan.id, pesanan.atas_nama, pesanan.telepon, menu.nama AS nama_menu, pesanan.kuantitas, pesanan.layanan, pesanan.harga_total, pesanan.status_pesanan FROM pesanan INNER JOIN menu ON pesanan.menu_id = menu.id WHERE pesanan.status_pesanan = 'diproses'";
                        $result_pesanan = mysqli_query($koneksi, $query_selesai);
                        
                        if (!$result_pesanan) {
                            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                        }
                        $no = 1;

                        while ($row_pesanan = mysqli_fetch_assoc($result_pesanan)){
                    ?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo $row_pesanan['atas_nama'];?></td>
                        <td><?php echo $row_pesanan['telepon'];?></td>
                        <td><?php echo $row_pesanan['nama_menu'];?></td>
                        <td><?php echo $row_pesanan['kuantitas'];?></td>
                        <td><?php echo $row_pesanan['layanan'];?></td>
                        <td>Rp <?php echo number_format($row_pesanan['harga_total'], 0, ',', '.');?></td>
                        <form method="POST" action="proses_ubah_status.php">
                            <input type="hidden" name="id" value="<?php echo $row_pesanan['id']; ?>">
                            <td>
                            <select type="dropdown" name="status_pesanan" autofocus="" required="">
                                <option value="diproses"<?php echo ($row_pesanan['status_pesanan'] == 'diproses') ? ' selected' : ''; ?>>Diproses</option>
                                <option value="selesai"<?php echo ($row_pesanan['status_pesanan'] == 'selesai') ? ' selected' : ''; ?>>Selesai</option>
                            </select>
                            </td>
                            <td>
                                <button class="btn" type="submit">Ubah</button>
                            </td>
                        </form>
                    </tr>
                    <?php
                        $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div><br>
        <div>
            <h3>Pesanan Selesai</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Atas Nama</th>
                        <th>Telepon</th>
                        <th>Pesanan</th>
                        <th>Kuantitas</th>
                        <th>Layanan</th>
                        <th>Harga Total</th>
                        <th>Status Pesanan</th>
                        <th>Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query_selesai = "SELECT pesanan.id, pesanan.atas_nama, pesanan.telepon, menu.nama AS nama_menu, pesanan.kuantitas, pesanan.layanan, pesanan.harga_total, pesanan.status_pesanan FROM pesanan INNER JOIN menu ON pesanan.menu_id = menu.id WHERE pesanan.status_pesanan = 'selesai'";
                        $result_pesanan = mysqli_query($koneksi, $query_selesai);
                        
                        if (!$result_pesanan) {
                            die("Query Error : ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                        }
                        $no = 1;

                        while ($row_pesanan = mysqli_fetch_assoc($result_pesanan)){
                    ?>
                    <tr>
                        <td><?php echo $no?></td>
                        <td><?php echo $row_pesanan['atas_nama'];?></td>
                        <td><?php echo $row_pesanan['telepon'];?></td>
                        <td><?php echo $row_pesanan['nama_menu'];?></td>
                        <td><?php echo $row_pesanan['kuantitas'];?></td>
                        <td><?php echo $row_pesanan['layanan'];?></td>
                        <td>Rp <?php echo number_format($row_pesanan['harga_total'], 0, ',', '.');?></td>
                        <form method="POST" action="proses_ubah_status.php">
                            <input type="hidden" name="id" value="<?php echo $row_pesanan['id']; ?>">
                            <td>
                            <select type="dropdown" name="status_pesanan" autofocus="" required="">
                                <option value="diproses"<?php echo ($row_pesanan['status_pesanan'] == 'diproses') ? ' selected' : ''; ?>>Diproses</option>
                                <option value="selesai"<?php echo ($row_pesanan['status_pesanan'] == 'selesai') ? ' selected' : ''; ?>>Selesai</option>
                            </select>
                            </td>
                            <td>
                                <button class="btn" type="submit">Ubah</button>
                            </td>
                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
