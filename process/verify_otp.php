<?php
require '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Fetch OTP record
    $stmt = $pdo->prepare("SELECT * FROM otp_verifications WHERE email = ? AND otp = ? AND is_verified = 0");
    $stmt->execute([$email, $otp]);
    $record = $stmt->fetch();

    $message = "";
$messageType = ""; // success or error

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $stmt = $pdo->prepare("SELECT * FROM otp_verifications WHERE email = ? AND otp = ? AND is_verified = 0");
    $stmt->execute([$email, $otp]);
    $record = $stmt->fetch();

    if ($record) {
        $now = date('Y-m-d H:i:s');
        if ($record['otp_expiry'] >= $now) {
            $pdo->prepare("UPDATE otp_verifications SET is_verified = 1 WHERE id = ?")->execute([$record['id']]);
            $pdo->prepare("UPDATE users SET is_verified = 1 WHERE email = ?")->execute([$email]);
            $message = "✅ Your email has been verified. You may now log in.";
            $messageType = "success";
        } else {
            $message = "⚠️ OTP has expired. Please request a new one.";
            $messageType = "error";
        }
    } else {
        $message = "❌ Invalid OTP or email.";
        $messageType = "error";
    }
}

}
?>

<!-- Optional basic HTML form -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Verify OTP</title>
  <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>
<body>
  <div class="container">
    <h2>Verify Your Email</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert <?= $messageType ?>">
        <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
      <label>Email:</label>
      <input type="email" name="email" value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>" required>

      <label>Enter OTP:</label>
      <input type="text" name="otp" required maxlength="6">

      <button type="submit">Verify</button>
    </form>

    <p style="margin-top: 2rem;">
      <a href="../user/login.php" class="btn-login">← Back to Login</a>
    </p>
  </div>
</body>
</html>
