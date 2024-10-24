<?php
require_once 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Error: ID tidak ditemukan dalam URL.");
    }

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto_profil']['tmp_name'];
        $fileName = $_FILES['foto_profil']['name'];
        $fileSize = $_FILES['foto_profil']['size'];
        $fileType = $_FILES['foto_profil']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = uniqid() . '.' . $fileExtension;

        $uploadFileDir = './src/img/profil/';
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $_SESSION['foto_profil_baru'] = $newFileName;

            // Update profile picture in database (optional)
            // $sql = "UPDATE akun SET foto_profil = '$newFileName' WHERE id_akun = '$id'";
            // mysqli_query($conn, $sql);

            header('Location: edit_profil_pencari.php?id=' . $id);
            exit();
        } else {
            die("Error: Gagal memindahkan file yang diupload.");
        }
    } else {
        die("Error: Tidak ada file yang diupload atau terjadi kesalahan saat mengupload.");
    }
} else {
    die("Error: Metode request tidak valid.");
}
