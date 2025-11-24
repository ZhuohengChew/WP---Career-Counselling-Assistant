<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.html');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid user ID');
}

$user_id = intval($_GET['id']);

// Prevent admin deleting themselves (optional safety check)
if ($user_id == $_SESSION['user_id']) {
    die('You cannot delete your own account.');
}

// Delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

header('Location: view_users.php?msg=User deleted successfully');
exit;
