<?php
require 'includes/db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = ?");
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
        $pdo->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE verification_token = ?")
            ->execute([$token]);
        echo "Email verified successfully. You can now <a href='user/login.html'>login</a>.";
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>
