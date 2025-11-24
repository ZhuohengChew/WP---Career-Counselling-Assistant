<?php
require '../includes/db.php';
require '../includes/auth.php';

$user_id = $_SESSION['user_id'];
$attempt_id = $_GET['id'] ?? null;

if (!$attempt_id) {
  die('Attempt ID is required');
}

// Verify this attempt belongs to user
$stmt = $pdo->prepare("SELECT * FROM quiz_attempts WHERE id = ? AND user_id = ?");
$stmt->execute([$attempt_id, $user_id]);
$attempt = $stmt->fetch();

if (!$attempt) {
  die('Quiz attempt not found or access denied.');
}

// Fetch responses for this attempt joined with quizzes questions
$stmt = $pdo->prepare("
  SELECT q.question, r.answer
  FROM responses r
  JOIN quizzes q ON r.quiz_id = q.id
  WHERE r.attempt_id = ?
");
$stmt->execute([$attempt_id]);
$responses = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Quiz Attempt Details</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container attempt-page">
    <h2>Quiz Attempt on <?= htmlspecialchars($attempt['timestamp']) ?></h2>
    <ul>
      <?php foreach ($responses as $resp): ?>
        <li>
          <strong><?= htmlspecialchars($resp['question']) ?></strong><br>
          <?= nl2br(htmlspecialchars($resp['answer'])) ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <a href="download_attempt_pdf.php?id=<?= $attempt_id ?>" class="btn">Download this Attempt as PDF</a>
    <br><br>
    <a href="history.php" class="btn">Back to Quiz History</a>
  </div>
</body>
</html>
