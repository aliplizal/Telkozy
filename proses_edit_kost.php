<?php
require_once "koneksi.php";
session_start();

if (!isset($_SESSION['id_akun'])) {
    header("location: login.php");
    exit();
}

$id_kost = mysqli_real_escape_string($conn, $_GET['id_kost']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kost = mysqli_real_escape_string($conn, $_POST['nama_kost']);
    $nama_daerah = mysqli_real_escape_string($conn, $_POST['nama_daerah']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    $tipe_kost = mysqli_real_escape_string($conn, $_POST['tipe_kost']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $sql = "UPDATE kost SET nama_kost='$nama_kost', nama_daerah='$nama_daerah', kontak='$kontak', tipe_kost='$tipe_kost', harga='$harga', alamat='$alamat', deskripsi='$deskripsi' WHERE id_kost='$id_kost'";

    if (mysqli_query($conn, $sql)) {
        header("Location: profil_pemilik.php?id_kost=$id_kost");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
