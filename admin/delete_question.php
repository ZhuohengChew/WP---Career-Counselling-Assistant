<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'admin') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_quiz.php');
} else {
    echo "Unauthorized access.";
}
?>
