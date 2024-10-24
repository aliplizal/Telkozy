<?php
require 'koneksi.php';

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['id_akun'])) {
  header("location: login.php");
  exit();
}

if (!isset($_GET['id_kost'])) {
  echo "ID Kost tidak ditemukan";
  exit();
}

$id_akun = $_SESSION['id_akun'];
$id_kost = $_GET['id_kost'];

// Mengambil status bookmark
$is_bookmarked = false;
$sql_bookmark = "SELECT * FROM bookmarks WHERE id_akun = '$id_akun' AND id_kost = '$id_kost'";
$result_bookmark = mysqli_query($conn, $sql_bookmark);
if ($result_bookmark && mysqli_num_rows($result_bookmark) > 0) {
  $is_bookmarked = true;
}

// Mengambil detail kost
$sql_kost = "SELECT * FROM kost WHERE id_kost = '$id_kost'";
$result_kost = mysqli_query($conn, $sql_kost);
if ($result_kost && mysqli_num_rows($result_kost) > 0) {
  $kost = mysqli_fetch_assoc($result_kost);
} else {
  echo "Kost tidak ditemukan";
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>INFO KOST PENCARI</title>
  <link rel="stylesheet" href="src/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
  <header>
    <img class="logo" src="src/img/logo.png" alt="TELKOZY" />
    <h1 class="telkozy">Telkozy</h1>
  </header>

  <div class="container">
    <div class="container-detail">
      <div class="box-foto-kost">
        <div class="foto-kost">
          <img src="src/img/kost/<?= htmlspecialchars($kost['foto_path']) ?>" alt="Foto Kost">
        </div>
        <i id="heart-icon" class="<?= $is_bookmarked ? 'ph-fill ph-heart' : 'ph ph-heart' ?>" onclick="toggleHeart(<?= $id_kost ?>)"></i>
      </div>

      <div class="informasi-kost">
        <h1 class="judul" style="font-size: 40px;"><?= htmlspecialchars($kost['nama_kost']) ?></h1>
        <p class="lokasi" style="font-size: 25px;">
          <i class="ph ph-map-pin" style="font-size: 25px;"></i>
          <?= htmlspecialchars($kost['nama_daerah']) ?> |
          <button><?= htmlspecialchars($kost['tipe_kost']) ?></button>
        </p>
        <h2 class="harga" style="font-size: 25px;">Rp<?= number_format($kost['harga'], 0, ',', '.') ?> <span>/bulan</span></h2>
        <hr>
        <h1 style="font-size: 30px;">Kontak</h1>
        <a href="https://wa.me/<?= htmlspecialchars($kost['kontak']) ?>" style="font-size: 25px; text-decoration: none;">
          <i class="ph-bold ph-whatsapp-logo" style="font-size: 25px; margin-right: 10px; color: #075e54;"></i>
          <?= htmlspecialchars($kost['kontak']) ?>
        </a>
        <p style="font-size: 23px;">Untuk informasi lebih lengkap, hubungi kontak yang tertera diatas</p>
        <hr>
        <h1 style="font-size: 30px;">Alamat</h1>
        <p style="font-size: 23px;"><?= htmlspecialchars($kost['alamat']) ?></p>
      </div>
    </div>

    <div class="container-deskripsi">
      <h1 style="font-size: 30px">Telusuri di Maps</h1>
      <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.302829481536!2d107.62621597499694!3d-6.973554043027138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e9ac8949d3e9%3A0xc78153049c4b4078!2sGedung%201%20Asrama%20Putra%20Telkom%20University!5e0!3m2!1sid!2sid!4v1715701087888!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="maps"></iframe>
      </div>
      <hr>
      <div class="detail">
        <h1 style="font-size: 30px">Detail</h1>
        <p>Berikut fasilitas-fasilitas yang dimiliki dari kost ini</p>
        <ul>
          <?php
          $fasilitas = explode(",", $kost['deskripsi']);
          foreach ($fasilitas as $fasilitas_item) {
            echo "<li>" . htmlspecialchars($fasilitas_item) . "</li>";
          }
          ?>
        </ul>
      </div>
    </div>

  </div>

  <footer>
    <div class="footer-content">
      <h3>Telkozy</h3>
      <p>Mitra terpercaya Anda dalam menemukan pilihan kos terbaik. Hubungi kami di platform media sosial untuk informasi lebih lanjut.</p>
      <ul class="socials">
        <li><a href="#"><i class="ph ph-facebook-logo"></i></a></li>
        <li><a href="#"><i class="ph ph-twitter-logo"></i></a></li>
        <li><a href="#"><i class="ph ph-instagram-logo"></i></a></li>
      </ul>
    </div>
    <div class="footer-bottom">
      <p>© 2024 Telkozy. All rights reserved.</p>
    </div>
  </footer>

  <script>
    let currentIndex = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;
        if (index >= totalSlides) currentIndex = 0;
        if (index < 0) currentIndex = totalSlides - 1;
        document.querySelector('.carousel-inner').style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    function nextSlide() {
        currentIndex++;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex--;
        showSlide(currentIndex);
    }

    function toggleHeart(kostId) {
        const heartIcon = document.getElementById('heart-icon');
        const isFilled = heartIcon.classList.contains('ph-fill');

        // Toggle the icon class immediately for a responsive UI
        heartIcon.classList.toggle('ph-fill');
        heartIcon.classList.toggle('ph-heart');

        // Send the new status to the server
        fetch('toggle_bookmark.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_kost=${kostId}&action=${isFilled ? 'remove' : 'add'}`,
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'added' || result === 'removed') {
                console.log('Bookmark status updated successfully.');
            } else {
                console.error('Failed to update bookmark status.');
                // Revert the icon class change if the operation failed
                heartIcon.classList.toggle('ph-fill');
                heartIcon.classList.toggle('ph-heart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert the icon class change if there's an error
            heartIcon.classList.toggle('ph-fill');
            heartIcon.classList.toggle('ph-heart');
        });
    }

    showSlide(currentIndex);
  </script>
</body>

</html>
