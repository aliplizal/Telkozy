<?php
require_once 'koneksi.php';
session_start();

// Memeriksa apakah parameter 'id' ada dalam URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID tidak ditemukan dalam URL.");
}

$id = mysqli_real_escape_string($conn, $_GET['id']); // Menghindari SQL injection

$sql = "SELECT id_akun, nama_lengkap, username, email, foto_profil FROM akun WHERE id_akun = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Error: Data tidak ditemukan di database.");
}

$data = mysqli_fetch_assoc($result);

// Jika ada gambar yang baru diupload, gunakan gambar tersebut
if (isset($_SESSION['foto_profil_baru'])) {
    $foto_profil = $_SESSION['foto_profil_baru'];
} else {
    $foto_profil = $data['foto_profil'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="src/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body style="font-family: 'Baloo 2', cursive;">
    <header>
        <img class="logo" src="src/img/logo.png" alt="TELKOZY" />
        <h1 class="telkozy">Telkozy</h1>
    </header>

    <div class="container-edit-profil">
        <div class="edit-foto">
            <h1 style="margin: 0px auto; margin: 25px 0px; font-weight: 700; font-size: 33px;">Edit Profil</h1>
            <h2 style="font-weight: 600;">Foto</h2>
            <div class="image-container" data-toggle="modal" data-target="#editPhotoModal">
                <input type="file" id="fileInput" style="display: none;" accept="image/*">
                <img src="src/img/profil/<?= $foto_profil; ?>" alt="" id="profileImage">
                <div class="overlay">
                    <div class="text">Edit Foto</div>
                </div>
            </div>
        </div>

        <div class="identitas-edit">
            <form action="proses_edit_profil_pemilik.php?id=<?= $data['id_akun']; ?>" method="post">
                <label for="nama_lengkap">
                    <h2 style="font-weight: 600;">Nama Lengkap</h2>
                </label> <br>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']); ?>"> <br>

                <label for="username">
                    <h2 style="font-weight: 600;">Username</h2>
                </label> <br>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($data['username']); ?>"> <br>

                <label for="email">
                    <h2 style="font-weight: 600;">Email</h2>
                </label><br>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($data['email']); ?>"> <br>

                <button type="submit">Selesai</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">Upload Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="uploadPhotoForm" action="upload_foto.php?id=<?= $data['id_akun']; ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="file" id="modalFileInput" name="foto_profil" accept="image/*">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="savePhotoButton">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('profileImage').addEventListener('click', function() {
            $('#editPhotoModal').modal('show');
        });

        document.getElementById('savePhotoButton').addEventListener('click', function() {
            const fileInput = document.getElementById('modalFileInput');
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            $('#uploadPhotoForm').submit(); // Submit form
        });
    </script>
</body>

</html>
