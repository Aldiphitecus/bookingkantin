<?php
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
        header("Location: login.php");
        exit();
    }
    include('koneksi.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM menu WHERE id = '$id'";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query Error: " . mysqli_errno($koneksi) ."." . mysqli_error($koneksi));
        }

        $data = mysqli_fetch_assoc($result);

        if (!count($data)) {
            echo "<script>alert('Data produk dengan ID " . $id . " tidak ditemukan pada tabel.'); window.location='admin_depan.php'; </script>";
        }
    } else {
        echo "<script>alert('Masukkan ID yang ingin diubah'); window.location='admin_depan.php'; </script>";
    }

    $data_pengguna = array();

    $username = $_SESSION['username'];
    $query_pengguna = "SELECT * FROM user WHERE username = '$username'";
    $result_pengguna = mysqli_query($koneksi, $query_pengguna);

    if ($result_pengguna) {
        $data_pengguna = mysqli_fetch_assoc($result_pengguna);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .base {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .base div {
            margin-bottom: 15px;
        }

        .base label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .base input[type="text"],
        .base input[type="file"],
        .base select[type="dropdown"],
        .base button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .base input[type="text"],
        .base input[type="file"] {
            margin-top: 3px;
        }

        .base button {
            background-color: #45a049;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .base button:hover {
            background-color: #3e8740;
        }

        .base button:focus {
            outline: none;
        }

        .center {
            text-align: center;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <form method="POST" action="proses_pesanan.php" enctype="multipart/form-data">
        <section class="base">
            <center><h1>Buat Pesanan</h1></center><br>
            <div>
                <label for="">Atas Nama</label>
                <input type="text" name="atas_nama" autofocus="" readonly required="" value="<?php echo $data_pengguna['nama'];?>"/>
            </div>
            <div>
                <label for="">NIM</label>
                <input type="text" name="nim" autofocus="" readonly required="" value="<?php echo $data_pengguna['nim'];?>"/>
            </div>
            <div>
                <label for="">Nomor Telepon</label>
                <input type="text" name="telepon" autofocus="" required=""/>
            </div>
            <div>
                <label for="">Kuantitas</label>
                <input type="text" name="kuantitas" autofocus="" required="" value="1"/>
            </div>
            <div>
            <label for="">Layanan Pemesanan</label>
                <select type="dropdown" name="layanan" required="">
                    <option value="" disabled selected>Pilih Layanan</option>
                    <option value="ditempat">Makan/Minum Ditempat</option>
                    <option value="dibungkus">Dibungkus</option>
                </select><br>
            </div>
            <h3>Pesanan Anda</h3>
            <div>
                <label for="">Menu yang dipesan</label>
                <input type="hidden" name="menu_id" value="<?php echo $data['id'];?>"/>
                <input type="text" readonly required value="<?php echo $data['nama'];?>"/>
                <img src="gambar/<?php echo $data['foto'];?>" alt="">
            </div>
            <div>
                <label for="">Harga</label>
                <input type="text" name="harga" readonly required value="Rp <?php echo number_format($data['harga'], 0, ',', '.');?>"/>
            </div>
            <div>
                <label for="">Total Harga</label>
                <input type="hidden" name="harga_total" readonly required /> <!-- Tetapkan nilai tanpa format mata uang -->
                <span id="formatted_total"></span> <!-- Menampilkan nilai yang diformat di antarmuka -->
            </div>
            <div>
                <button type="submit">Pesan menu</button>
            </div>
        </section>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function hitungTotal() {
            var harga = <?php echo $data['harga'];?>;
            var kuantitas = document.getElementsByName('kuantitas')[0].value;
            var total = harga * kuantitas;
            document.getElementsByName('harga_total')[0].value = total; // Set nilai tanpa format mata uang

            // Format nilai total dengan mata uang
            var formattedTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
            document.getElementById('formatted_total').textContent = formattedTotal; // Menampilkan nilai yang diformat di antarmuka
        }

        document.getElementsByName('kuantitas')[0].addEventListener('input', hitungTotal);
        hitungTotal();
    </script>
</body>
</html>