<?php 
require("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = mysqli_real_escape_string($conn, $_POST['sebagai']); // Capture the role value

    // Memastikan username tidak ada sebelumnya
    $sql_cek_username = "SELECT username FROM akun WHERE username= '$username'";
    $result = mysqli_query($conn, $sql_cek_username);

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                    alert('Username sudah terdaftar, mohon buat username yang berbeda');
                    window.history.back();
                </script>";
        exit();
    }

    // Memastikan email tidak ada sebelumnya
    $sql_cek_username = "SELECT email FROM akun WHERE email= '$email'";
    $result = mysqli_query($conn, $sql_cek_username);

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                    alert('Email sudah terdaftar, mohon buat email yang berbeda');
                    window.history.back();
                </script>";
        exit();
    }

    // Periksa apakah password dan confirm_password sesuai
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
              </script>";
    } else {
        // Hash password setelah konfirmasi
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO akun (nama_lengkap, username,email, password, role) VALUES ('$nama_lengkap', '$username', '$email', '$password_hashed', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            echo "<script>
                    alert('Daftar berhasil. Silahkan login');
                    window.location.href = 'login.php';
                </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="src/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet"/>
</head>

<body style="margin: 0px; max-height: 100vh; overflow: hidden ;"> 
    <div class="daftar" style="font-size: 20px;">
    <div class="box_kiri">
    </div>

    <div class="box_kanan">
        <h1>Daftar</h1>
        <p style="margin: 0px; margin-bottom: 20px;">sebagai</p> 

        <form action="" method="post">
            <select id="sebagai" name="sebagai" required>
                <option value="1">Pencari Kost</option>
                <option value="2">Pemilik Kost</option>
            </select>
            <br>
            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required> <br>
            <input type="text" id="username" name="username" placeholder="Username" required> <br>
            <input type="email" id="email" name="email" placeholder="Email" required> <br>
            <input type="password" id="password" name="password" placeholder="Password" required> <br>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required> <br>
            <button type="submit" class="daftar" name="daftar">Daftar</button>
        </form>

        <p>Sudah punya akun?<b> <a href="login.php" class="login-text">Masuk</a></b></p>
    </div>
    </div>
</body>
</html>
