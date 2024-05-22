<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "bookingkantin";


    $koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if(!$koneksi){
        die("Koneksi Gagal");
    }
?>