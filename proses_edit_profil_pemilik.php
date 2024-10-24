<?php
require_once "koneksi.php";
session_start(); // Memulai session

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun'])) {
    header("location: login.php");
    exit();
}

$id_akun = $_SESSION['id_akun'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses data yang dikirim dari formulir utama
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? '');
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');

    // Cek apakah ada foto profil baru di sesi
    if (isset($_SESSION['foto_profil_baru'])) {
        $foto_profil = $_SESSION['foto_profil_baru'];
        unset($_SESSION['foto_profil_baru']); // Hapus dari sesi setelah digunakan
    } else {
        $foto_profil = ''; // Atur ke default jika tidak ada
    }

    // Update data ke database
    $sql = "UPDATE akun SET nama_lengkap = '$nama_lengkap', username = '$username', email = '$email'";
    if ($foto_profil) {
        $sql .= ", foto_profil = '$foto_profil'";
    }
    $sql .= " WHERE id_akun = '$id_akun'";

    if (mysqli_query($conn, $sql)) {
        // Redirect ke halaman profil setelah berhasil update
        header("location: profil_pemilik.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
