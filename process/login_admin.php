<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);

    if ($stmt->rowCount() === 1) {
        $admin = $stmt->fetch();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['name'] = $admin['name'];
            $_SESSION['role'] = 'admin';
            header("Location: ../dashboard.php");
            exit;
        } else {
            header("Location: ../admin/login.php?error=wrongpassword");
            exit;
        }
    } else {
        header("Location: ../admin/login.php?error=adminnotfound");
        exit;
    }
}
?>
