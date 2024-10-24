<?php
require_once 'koneksi.php';
session_start();

if (!isset($_SESSION['id_akun'])) {
    header("location: login.php");
    exit();
}

$id_kost = mysqli_real_escape_string($conn, $_GET['id_kost']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto_path'])) {
    $file_name = $_FILES['foto_path']['name'];
    $file_tmp = $_FILES['foto_path']['tmp_name'];
    $file_size = $_FILES['foto_path']['size'];
    $file_error = $_FILES['foto_path']['error'];

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    if (in_array($file_ext, $allowed_ext)) {
        if ($file_error === 0) {
            $file_new_name = uniqid('', true) . '.' . $file_ext;
            $file_destination = 'src/img/kost/' . $file_new_name;

            if (move_uploaded_file($file_tmp, $file_destination)) {
                $sql = "UPDATE kost SET foto_path = '$file_new_name' WHERE id_kost = '$id_kost'";
                if (mysqli_query($conn, $sql)) {
                    header("location: edit_kost.php?id_kost=$id_kost");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "File error: $file_error.";
        }
    } else {
        echo "Invalid file type. Allowed types: jpg, jpeg, png.";
    }
}

$sql = "SELECT * FROM kost WHERE id_kost = '$id_kost'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Error: Data not found in database.");
}

$data = mysqli_fetch_assoc($result);
?>
