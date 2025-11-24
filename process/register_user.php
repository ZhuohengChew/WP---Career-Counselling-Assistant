<?php
require '../includes/db.php';
require '../includes/mailer.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already registered
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Registration Failed</title>
            <link rel="stylesheet" href="../style.css">
        </head>
        <body>
            <div class="error-msg">Email already registered.</div>
        </body>
        </html>';
        exit;
    }

    // Register user
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
    if ($stmt->execute([$name, $email, $password])) {
        // Create OTP
        $otp = rand(100000, 999999);
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Insert OTP
        $otpStmt = $pdo->prepare("INSERT INTO otp_verifications (email, otp, otp_expiry) VALUES (?, ?, ?)");
        $otpStmt->execute([$email, $otp, $otp_expiry]);

        sendOtpEmail($email, $otp);

        // Show success message and redirect
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Registration Successful</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="success-msg">
                Registration successful. An OTP has been sent to your email.<br>
                Redirecting to verification page in <span id="countdown">3</span> seconds...
                <div class="loader"></div>
            </div>
            <script>
                let seconds = 3;
                const countdownEl = document.getElementById("countdown");
                const interval = setInterval(() => {
                    seconds--;
                    countdownEl.textContent = seconds;
                    if (seconds <= 0) clearInterval(interval);
                }, 1000);
            </script>
        </body>
        </html>';
        header("refresh:3;url=verify_otp.php?email=" . urlencode($email));
    } else {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Registration Failed</title>
            <link rel="stylesheet" href="../style.css">
        </head>
        <body>
            <div class="error-msg">Registration failed.</div>
        </body>
        </html>';
    }
}
?>
