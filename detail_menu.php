<?php
    include ('koneksi.php');
    
    $id = $_GET['id'];
    $queryMenu = mysqli_query($koneksi, "SELECT * FROM menu WHERE id='$id'");
    $menu = mysqli_fetch_array($queryMenu);

    $stok_habis = ($menu['ketersediaan_stok'] == 'habis');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Detail Menu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="sidebar">
        <h2>SiKantin</h2>
        <ul>
            <li class="menu"><a href="dashboard_user.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
                </svg>   Menu</a></li>
            <li><a href="antrian_user.php">
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
        <h1>Detail Menu</h1><br>
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-5">
                    <img src="gambar/<?php echo $menu['foto'];?>" alt="" style="width: 300px;">
                </div><br>
                <div class="col-md-7">
                    <h2><?php echo $menu['nama'];?></h2>
                    <h3 class="harga">Rp <?php echo number_format($menu['harga'], 0, ',', '.');?></h3><br>
                    <p>Deskripsi :</p>
                    <p><?php echo $menu['deskripsi'];?></p>
                    <p>Ketersediaan : <strong><?php echo $menu['ketersediaan_stok'];?></strong></p>
                    <?php if (!$stok_habis): ?>
                        <a href="buat_pesanan.php?id=<?php echo $menu['id'];?>" class="btn">Beli sekarang</a>
                        <a href="tambah_keranjang.php?id=<?php echo $menu['id'];?>" class="btn">Tambah ke keranjang</a>
                    <?php else: ?>
                        <p class="text-danger">Maaf, stok untuk menu ini telah habis.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>