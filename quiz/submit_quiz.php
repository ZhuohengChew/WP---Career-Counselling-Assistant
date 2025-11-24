<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['responses'])) {
    header("Location: ../index.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$responses = $_POST['responses']; // Expected as associative array: quiz_id => answer

$pdo->beginTransaction();

try {
    // Save the quiz attempt
    $attempt = $pdo->prepare("INSERT INTO quiz_attempts (user_id) VALUES (?)");
    $attempt->execute([$user_id]);
    $attempt_id = $pdo->lastInsertId();

    // Prepare to insert responses
    $stmt = $pdo->prepare("INSERT INTO responses (attempt_id, quiz_id, answer) VALUES (?, ?, ?)");

    // Collect question-answer pairs for PDF
    $questionAnswerPairs = [];

    foreach ($responses as $quiz_id => $answer) {
        // Save each response to DB
        $stmt->execute([$attempt_id, $quiz_id, $answer]);

        // Fetch question text
        $qstmt = $pdo->prepare("SELECT question FROM quizzes WHERE id = ?");
        $qstmt->execute([$quiz_id]);
        $question = $qstmt->fetchColumn();

        $questionAnswerPairs[] = "Q: $question\nA: $answer";
    }

    // Store quiz answers in session
    $_SESSION['last_quiz'] = implode("\n\n", $questionAnswerPairs);

    // Commit DB transaction
    $pdo->commit();

    // Redirect to result page
    header('Location: result.php');
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
