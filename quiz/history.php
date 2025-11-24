<?php
require '../includes/db.php';
require '../includes/auth.php';

$user_id = $_SESSION['user_id'];

// Fetch quiz attempts for this user, ordered by timestamp desc
$stmt = $pdo->prepare("SELECT id, timestamp FROM quiz_attempts WHERE user_id = ? ORDER BY timestamp DESC");
$stmt->execute([$user_id]);
$attempts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Quiz History</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container history-page">
    <h2>My Quiz Attempts</h2>
    <ul>
      <?php foreach ($attempts as $attempt): ?>
        <li>
          <strong><?= htmlspecialchars($attempt['timestamp']) ?></strong>
          &nbsp;|&nbsp;
          <a href="view_attempt.php?id=<?= $attempt['id'] ?>">View Details</a>
          &nbsp;|&nbsp;
          <a href="download_attempt_pdf.php?id=<?= $attempt['id'] ?>">Download PDF</a>
        </li>
      <?php endforeach; ?>
    </ul>
    <a href="../dashboard.php" class="btn">Back to Dashboard</a>
  </div>
</body>
</html>
