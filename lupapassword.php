<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <link rel="stylesheet" href="src/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet"/>
</head>
<body>
    <div class="container-lupa-password">
        <div>
            <h1>Lupa Password?</h1>
        </div>

        <div class="cover-container">
            <div>
                <form action="send_password_reset.php" method="POST">
                    <p>Masukkan email pada isian dibawah, kami akan mengirimkan tautan untuk me-reset password anda.</p>
                    <p>Pastikan email yang anda masukkan sesuai dengan akun anda.</p>
                    <input type="email" name="email" placeholder="Email" required> <br>
                    
                    <button type="submit">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
