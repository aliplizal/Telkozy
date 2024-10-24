<?php

if (!isset($_POST["token"])) {
    die("Token tidak diatur!");
}

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$conn = require __DIR__ . "/koneksi.php";

$sql = "SELECT * FROM akun WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Persiapan statement gagal: " . $conn->error);
}

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo  "<script>
            alert('Pesan terkirim, silahkan cek email anda.');
            window.history.back();
        </script>";
    die("Token tidak ditemukan");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo "<script>
            alert('Token telah kedaluwarsa');
            window.history.back();
        </script>";
    die();
}

if ($_POST["password_baru"] !== $_POST["konfirmasi_password"]) {
    echo "<script>
            alert('Password dan konfirmasi password harus cocok');
            window.history.back();
        </script>";
    die();
}

$password_hash = password_hash($_POST["password_baru"], PASSWORD_DEFAULT);

$sql = "UPDATE akun
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id_akun = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Persiapan statement gagal: " . $conn->error);
}

$stmt->bind_param("si", $password_hash, $user["id_akun"]);

$stmt->execute();
echo "<script>
            alert('Password berhasil diubah. Silahkan login.');
            window.location.href = 'login.php';
    </script>";
?>
