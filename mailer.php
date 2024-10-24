<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

// Aktifkan debugging (opsional)
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com"; // Host SMTP Gmail
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS Encryption
$mail->Port = 587; // Port 587 for TLS
$mail->Username = "telkozytelkom@gmail.com"; 
$mail->Password = "hcfg emqg uydj cgzm";

$mail->isHtml(true);

return $mail;
?>
