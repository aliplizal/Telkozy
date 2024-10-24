<?php
require_once 'koneksi.php';
session_start();

if (!isset($_SESSION['id_akun'])) {
    header("location: login.php");
    exit();
}

if (!isset($_GET['id_kost']) || empty($_GET['id_kost'])) {
    die("Error: ID not found in URL.");
}

$id_kost = mysqli_real_escape_string($conn, $_GET['id_kost']);

$sql = "SELECT * FROM kost WHERE id_kost = '$id_kost'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Error: Data not found in database.");
}

$data = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kost</title>
    <link rel="stylesheet" href="src/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <header>
        <img class="logo" src="src/img/logo.png" alt="TELKOZY" />
        <h1 class="telkozy">Telkozy</h1>
    </header>

    <div class="container-edit-kost">
        <div class="top">
            <div class="edit-kost">
                <div class="image-kost" data-toggle="modal" data-target="#editPhotoModal">
                    <input type="file" id="fileInput" style="display: none;" accept="image/*">

                    <?php if (!empty($data['foto_path'])): ?>
                    <img src="src/img/kost/<?= $data['foto_path']; ?>" alt="" id="profileImage">
                    <?php endif; ?>

                    <div class="overlay">
                        <div class="text">Edit Kost</div>
                    </div>
                </div>
            </div>
            
            <div class="informasi-kost-edit">
                <form method="POST" action="proses_edit_kost.php?id_kost=<?= $data['id_kost']; ?>">
                    <label for="nama_kost"><h1>Nama Kost</h1></label> <br>
                    <input type="text" name="nama_kost" value="<?= htmlspecialchars($data['nama_kost']); ?>"> <br>
                    <label for="nama_daerah"><h1>Nama Daerah</h1></label> <br>
                    <select name="nama_daerah" id="">
                        <option value="Sukapura" <?= $data['nama_daerah'] == 'Sukapura' ? 'selected' : ''; ?>>Sukapura</option>
                        <option value="Sukabirus" <?= $data['nama_daerah'] == 'Sukabirus' ? 'selected' : ''; ?>>Sukabirus</option>
                        <option value="PGA" <?= $data['nama_daerah'] == 'PGA' ? 'selected' : ''; ?>>PGA</option>
                        <option value="Ciganitri" <?= $data['nama_daerah'] == 'Ciganitri' ? 'selected' : ''; ?>>Ciganitri</option>
                        <option value="PBB" <?= $data['nama_daerah'] == 'PBB' ? 'selected' : ''; ?>>PBB</option>
                        <option value="Mangga Dua" <?= $data['nama_daerah'] == 'Mangga Dua' ? 'selected' : ''; ?>>Mangga Dua</option>
                    </select> <br>
                    <label for="kontak"><h1>Kontak</h1></label> <br>
                    <input type="text" name="kontak" value="<?= htmlspecialchars($data['kontak']); ?>"> <br>
                    <label for="tipe_kost"><h1>Tipe Kost</h1></label> <br>
                    <select name="tipe_kost" id="">
                        <option value="Umum" <?= $data['tipe_kost'] == 'Umum' ? 'selected' : ''; ?>>Umum</option>
                        <option value="Putra" <?= $data['tipe_kost'] == 'Putra' ? 'selected' : ''; ?>>Putra</option>
                        <option value="Putri" <?= $data['tipe_kost'] == 'Putri' ? 'selected' : ''; ?>>Putri</option>
                    </select> <br>
                    <label for="harga"><h1>Harga</h1></label> <br>
                    <input type="text" name="harga" value="<?= htmlspecialchars($data['harga']); ?>"> <br>
            </div>
        </div>
        
        <div class="bottom">
            <div class="deskripsi-kost">
                <div class="flex" style="display: flex;">
                    <div>
                        <label for="alamat"><h1>Alamat</h1></label> <br>
                        <textarea name="alamat"><?= htmlspecialchars($data['alamat']); ?></textarea> <br>
                    </div>
                    <div>
                        <label for="deskripsi"><h1>Deskripsi</h1></label> <br>
                        <textarea name="deskripsi"><?= htmlspecialchars($data['deskripsi']); ?></textarea> <br>
                    </div>
                </div>
                <div class="submit">
                    <button class="submit" type="submit">Selesai</button>
                </div>
            </div>
        </div>
                </form>
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
          <form id="uploadPhotoForm" action="upload_foto_kost.php?id_kost=<?= $data['id_kost']; ?>" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                  <input type="file" id="modalFileInput" name="foto_path" accept="image/*">
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
