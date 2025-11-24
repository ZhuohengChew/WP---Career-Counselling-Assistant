<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        if (!$user['is_verified']) {
            header("Location: ../user/login.php?error=notverified");
            exit;
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../dashboard.php");
            exit;
        } else {
            header("Location: ../user/login.php?error=wrongpassword");
            exit;
        }
    } else {
        header("Location: ../user/login.php?error=usernotfound");
        exit;
    }
}
?>
