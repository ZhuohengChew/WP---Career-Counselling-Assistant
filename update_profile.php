<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$id = $_SESSION['user_id'];

// Sanitize input
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

$filename = null;
if (!empty($_FILES['profile_pic']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['profile_pic']['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate a unique filename
        $extension = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $uniqueName = 'user_' . $id . '_' . time() . '.' . $extension;
        $filename = $uploadDir . $uniqueName;

        // Move file to upload directory
        if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename)) {
            $_SESSION['error'] = "Failed to upload profile picture.";
            header('Location: profile.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Invalid image format. Only JPG, PNG, and GIF allowed.";
        header('Location: profile.php');
        exit;
    }
}

// Check if the email is already used by another user
$checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$checkEmail->execute([$email, $id]);
if ($checkEmail->rowCount() > 0) {
    $_SESSION['error'] = "Email is already in use by another account.";
    header('Location: profile.php');
    exit;
}

// Build update query
$sql = "UPDATE users SET name = ?, email = ?";
$params = [$name, $email];

if ($password) {
    $sql .= ", password = ?";
    $params[] = $password;
}

if ($filename) {
    $sql .= ", profile_pic = ?";
    $params[] = $filename;
}

$sql .= " WHERE id = ?";
$params[] = $id;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $_SESSION['success'] = "Profile updated successfully.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Failed to update profile. Please try again.";
}

header('Location: profile.php');
exit;
?>
