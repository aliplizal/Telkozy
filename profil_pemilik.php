<?php
session_start(); // Memulai session

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun'])) {
    header("location: login.php");
    exit();
}

// Mengambil id dari user
$id_akun = $_SESSION['id_akun'];

// Menghubungkan ke database
require_once 'koneksi.php';

// Mengambil data pengguna dari database
$sql = "SELECT nama_lengkap, username, foto_profil FROM akun WHERE id_akun = '$id_akun'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_lengkap = $row['nama_lengkap'];
    $username = $row['username'];
    $foto_profil = $row['foto_profil'];
} else {
    die("Error: Data pengguna tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PROFIL PEMILIK</title>
    <link rel="stylesheet" href="src/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
<header>
    <img class="logo" src="src/img/logo.png" alt="TELKOZY" />
    <h1 class="telkozy">Telkozy</h1>
</header>

<div class="container-profil-pencari">
    <div class="foto-profil">
        <?php if (!empty($foto_profil)): ?>
            <img src="src/img/profil/<?= $foto_profil ?>" alt="Foto Profil" />
        <?php else: ?>
            <div class="foto-profil">
                <img src="" alt="">
            </div>
        <?php endif; ?>
    </div>

    <div class="identitas-akun">
        <h1 style="margin: 0;"><?= $nama_lengkap ?></h1>
        <p style="margin: 0;">@<?= $username ?></p>
        <button><a href="edit_profil_pemilik.php?id=<?= $id_akun; ?>">Edit Profil</a></button>
        <button><a href="logout.php">Logout</a></button>
    </div>
</div>

<div class="bookmark">
    <hr>
    <div class="bookmark-judul">
        <i class="ph-fill ph-house" style="color: #9B1111;"></i>
        <p>Kost Anda</p>
    </div>
    <div class="bookmark-kost">
        <?php
        // Ambil data kost dari database untuk menampilkan informasi
        $sql_kost = "SELECT * FROM kost WHERE id_akun = '$id_akun'";
        $result_kost = mysqli_query($conn, $sql_kost);

        if ($result_kost && mysqli_num_rows($result_kost) > 0) {
            while ($row_kost = mysqli_fetch_assoc($result_kost)) {
                // Ambil informasi kost
                $id_kost = $row_kost['id_kost'];
                $nama_kost = $row_kost['nama_kost'];
                $nama_daerah = $row_kost['nama_daerah'];
                $tipe_kost = $row_kost['tipe_kost'];
                $harga = $row_kost['harga'];
                ?>
                <div class="bookmark-per-kost">
                    <a href="info_kost_pencari.php?id_kost=<?= $id_kost; ?>">
                        <div>
                            <!-- Jika ada foto, tampilkan, jika tidak, tampilkan placeholder -->
                            <?php if (!empty($row_kost['foto_path'])) : ?>
                                <img src="src/img/kost/<?= $row_kost['foto_path']; ?>" alt="">
                            <?php else : ?>
                                <img src="placeholder_image.jpg" alt="Placeholder Image">
                            <?php endif; ?>
                        </div>

                        <div class="bookmark-deskripsi">
                            <h1 class="judul" style="font-size: 17px;"><?= $nama_kost; ?></h1>
                            <p class="lokasi" style="font-size: 17px;"><?= $nama_daerah; ?> | <button><?= $tipe_kost; ?></button></p>
                            <h2 class="harga" style="font-size: 17px;">Rp<?= number_format($harga, 0, ',', '.'); ?> <span>/bulan</span></h2>
                        </div>
                    </a>
                </div>
            <?php
            }
        } else {
            echo "Tidak ada data kost yang ditemukan.";
        }
        ?>
    </div>
</div>
</body>
</html>
