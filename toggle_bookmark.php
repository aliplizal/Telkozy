<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'koneksi.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun'])) {
    echo "error";
    exit();
}

$id_akun = $_SESSION['id_akun'];
$id_kost = $_POST['id_kost'];
$action = $_POST['action'];

if ($action == "add") {
    $sql = "INSERT INTO bookmarks (id_akun, id_kost) VALUES ('$id_akun', '$id_kost')";
} else if ($action == "remove") {
    $sql = "DELETE FROM bookmarks WHERE id_akun = '$id_akun' AND id_kost = '$id_kost'";
}

if (mysqli_query($conn, $sql)) {
    echo $action == "add" ? "added" : "removed";
} else {
    echo "error";
}

mysqli_close($conn);
?>
