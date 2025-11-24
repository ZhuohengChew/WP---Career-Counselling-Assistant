<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'admin') {
    $question = $_POST['question'];
    $type = $_POST['type'];
    $options = $type === 'mcq' ? json_encode(array_map('trim', explode(',', $_POST['options']))) : null;

    $stmt = $pdo->prepare("INSERT INTO quizzes (question, type, options) VALUES (?, ?, ?)");
    $stmt->execute([$question, $type, $options]);

    header('Location: manage_quiz.php');
} else {
    echo "Unauthorized access.";
}
?>
