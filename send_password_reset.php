<?php

if (!isset($_POST["email"])) {
    die("Email tidak diatur!");
}

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$conn = require __DIR__ . "/koneksi.php";

if (!$conn instanceof mysqli) {
    die("Koneksi ke database gagal!");
}

$sql = "UPDATE akun
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Persiapan statement gagal: " . $conn->error);
}

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@example.com", "TELKOZY: RESET PASSWORD");
    $mail->addAddress($email);
    $mail->Subject = "Reset Password Anda";
    
    $resetLink = "http://localhost/47-01-tubes-telkozyy/reset_password.php?token=$token";
    $mail->Body = <<<END
    <p>Halo,</p>
    <p>Kami menerima permintaan untuk mereset password akun Anda. Klik tautan di bawah ini untuk mengatur ulang password Anda:</p>
    <p><a href="$resetLink">Reset Password</a></p>
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
    <p>Terima kasih,</p>
    <p>Tim Support Telkozy</p>
    END;

    try {
        $mail->send();
        echo "<script>
                    alert('Pesan terkirim, silahkan cek email anda.');
                    window.history.back();
            </script>";
    } catch (Exception $e) {
        echo "Pesan tidak terkirim, email error: {$mail->ErrorInfo}";
    }
} else {
    echo "<script>
            alert('Email tidak ditemukan atau tidak ada perubahan.');
            window.history.back();
        </script>";
}
?>
