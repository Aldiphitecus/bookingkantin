<?php
session_start();

if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_depan.php");
    } elseif ($_SESSION['role'] === 'user') {
        header("Location: dashboard_user.php");
    }
    exit();
}

include("koneksi.php");

$username = "";
$password = "";
$err = "";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == '' or $password == '') {
        $err .= "<li>Silahkan masukkan username dan password</li>";
    }
    
    if (empty($err)) {
        $sql_admin = "SELECT * FROM admin WHERE username = '$username'";
        $sql_user = "SELECT * FROM user WHERE username = '$username'";
        
        $q_admin = mysqli_query($koneksi, $sql_admin);
        $q_user = mysqli_query($koneksi, $sql_user);
        
        $r_admin = mysqli_fetch_array($q_admin);
        $r_user = mysqli_fetch_array($q_user);
        
        if ($r_admin && $r_admin['password'] == md5($password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'admin';
            header("Location: admin_depan.php"); // Redirect to admin dashboard
            exit();
        } elseif ($r_user && $r_user['password'] == md5($password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            $_SESSION['nama'] = $r_user['nama'];
            header("Location: dashboard_user.php"); // Redirect to user dashboard
            exit();
        } else {
            $err .= "<li>Akun Tidak Ditemukan atau kata sandi salah</li>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="app">
        <h3 class="login-title">Halaman Login</h3><br>
        <?php
        if (!empty($err)) {
            echo '<div class="error"><ul>' . $err . '</ul></div>';
        }
        ?>
        <form action="" method="POST">
            <input type="text" name="username" class="input" placeholder="Isikan Username"/><br>
            <input type="password" name="password" class="input" placeholder="Isikan Password"/><br>
            <input type="submit" name="login" value="Login"/>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
