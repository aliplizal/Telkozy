<?php
session_start(); // Memulai session
include 'koneksi.php';


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['as_a'];

    $sql = "SELECT * FROM akun WHERE username = '$username' AND role = '$role'";
    $result = mysqli_query($conn, $sql);

    // Jika ada username yg dimaksud
    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user["password"])) {
            // Buat session
            $_SESSION['id_akun'] = $user["id_akun"];
            $_SESSION['role'] = $user["role"];
            $_SESSION['username'] = $user["username"];
            $_SESSION['fullname'] = $user["nama_lengkap"];

            // Arahkan role ke halaman yang sudah ditentukan
            if ($_SESSION['role'] == 1) {
                header("Location:beranda_pencari.php?id=<?php  ?>");
            } elseif ($_SESSION['role'] == 2) {
                header("Location:beranda_pemkos.php");
            } else {
                echo "<p style='color: red;'>Anda tidak memiliki akses</p>";
            }
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Akun tidak ditemukan!');</script>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="src/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet" />
</head>

<body style="margin: 0px; max-height: 100vh; overflow: hidden;">
    <div class="masuk">
        <div class="box_kiri"></div>
        <div class="box_kanan">
            <h1>Masuk</h1>
            <p style="margin: 0px; margin-bottom: 20px;">sebagai</p>

            <form action="login.php" method="post">
                <select id="as_a" name="as_a">
                    <option value="1">Pencari Kost</option>
                    <option value="2">Pemilik Kost</option>
                </select> <br>
                <input type="text" id="username" name="username" placeholder="Username" required> <br>
                <input type="password" id="password" name="password" placeholder="Password" required> <br>
                <p class="lupapassword" style="font-size: 12px; margin: 0 auto; margin-top: 10px; color: #0D1B46; margin-right: 160px; font-weight: 600;">
                    <a href="lupapassword.php">Lupa Password?</a> <br>
                </p>
                <button type="submit">Masuk</button>
            </form>
            <p>Belum punya akun? <b><a href="daftar.php" class="login-text">Daftar</a></b></p>
        </div>
    </div>
</body>

</html>