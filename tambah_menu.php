<?php
    include('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
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
    </style>
</head>
<body>
    <form method="POST" action="proses_tambah.php" enctype="multipart/form-data">
        <section class="base">
            <center><h1>Tambah Menu</h1></center><br>
            <div>
                <label for="">Kategori</label>
                <select type="dropdown" name="kategori_id" autofocus="" required="">
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="1">Makanan</option>
                    <option value="2">Minuman</option>
                </select>
            </div>
            <div>
                <label for="">Nama</label>
                <input type="text" name="nama" autofocus="" required=""/>
            </div>
            <div>
                <label for="">Harga</label>
                <input type="text" name="harga" required=""/>
            </div>
            <div>
                <label for="">Foto</label>
                <input type="file" name="foto" required=""/>
            </div>
            <div>
                <label for="">Deskripsi</label>
                <input type="text" name="deskripsi"/>
            </div>
            <div>
                <label for="">Ketersediaan Stok</label>
                <select type="dropdown" name="ketersediaan_stok" required="">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <div>
                <button type="submit">Tambahkan Menu</button>
            </div>
        </section>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>