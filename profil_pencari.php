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
require 'koneksi.php';

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

$sql_bookmarks = "SELECT b.id_kost, k.nama_kost, k.nama_daerah, k.tipe_kost, k.harga, k.foto_path
                  FROM bookmarks b
                  JOIN kost k ON b.id_kost = k.id_kost
                  WHERE b.id_akun = '$id_akun'";
$result_bookmarks = mysqli_query($conn, $sql_bookmarks);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PROFIL PENCARI</title>
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
            <button><a href="edit_profil_pencari.php?id=<?= $id_akun; ?>">Edit Profil</a></button>
            <button><a href="logout.php">Logout</a></button>
        </div>
    </div>

    <div class="bookmark">
        <hr>
        <div class="bookmark-judul">
            <i class="ph-fill ph-heart"></i>
            <p>Tersimpan</p>
        </div>
          
        <div class="bookmark-kost">
            <?php if ($result_bookmarks && mysqli_num_rows($result_bookmarks) > 0): ?>
                <?php while ($row_bookmark = mysqli_fetch_assoc($result_bookmarks)): ?>
                    <div class="bookmark-per-kost">
                        <a href="info_kost_pencari.php?id_kost=<?= $row_bookmark['id_kost'] ?>">
                            <div>
                                <img src="src/img/kost/<?= $row_bookmark['foto_path'] ?>" alt="">
                            </div>

                            <i class="ph-fill ph-heart"></i>

                            <div class="bookmark-deskripsi">
                                <h1 class="judul" style="font-size: 17px;"><?= $row_bookmark['nama_kost'] ?></h1>
                                <p class="lokasi" style="font-size: 17px;"><?= $row_bookmark['nama_daerah'] ?> |<button><?= $row_bookmark['tipe_kost'] ?></button></p>
                                <h2 class="harga" style="font-size: 17px;">Rp<?= number_format($row_bookmark['harga'], 0, ',', '.') ?> <span>/bulan</span></h2>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
        </div>
        <div class="kost-kosong">
        <?php else: ?>
                <p>Tidak ada bookmark yang ditemukan.</p>
            <?php endif; ?>
        </div>    
    </div>
</body>
</html>
