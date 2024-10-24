<?php

if (!isset($_GET["token"])) {
    die("Token tidak diatur!");
}

$token = $_GET["token"];
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
    die("Token tidak ditemukan");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token telah kedaluwarsa");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="src/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet"/>
</head>
<body>
    <div class="container-lupa-password">
        <div>
            <h1>Reset Password</h1>
        </div>
        
        <div class="cover-container">
            <div>
                <form action="proses_reset_password.php" method="POST">

                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <p>Masukkan password baru dan konfirmasi password baru:</p>
                    <input type="password" name="password_baru" placeholder="Password Baru" required> <br>
                    <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password Baru" required> <br>
                    
                    <button type="submit">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
