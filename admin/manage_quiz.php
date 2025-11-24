<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.html');
    exit;
}

$quizzes = $pdo->query("SELECT * FROM quizzes ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Quiz Questions</title>
  <link rel="stylesheet" href="style.css?v=<?= time(); ?>" />
</head>
<body>
  <div class="container">
    <h2>Manage Quiz Questions</h2>

    <form action="add_question.php" method="POST">
      <textarea name="question" placeholder="Enter question..." required></textarea><br />

      <select name="type">
        <option value="mcq">Multiple Choice</option>
        <option value="scale">Scale (1-5)</option>
      </select><br />

      <input name="options" placeholder="MCQ options (comma-separated, only for MCQ)"><br />

      <button type="submit">Add Question</button>
    </form>

    <h3>Existing Questions</h3>
    <ul class="quiz-list">
      <?php foreach ($quizzes as $q): ?>
        <li>
          <strong>[<?= htmlspecialchars($q['type']); ?>]</strong> <?= htmlspecialchars($q['question']); ?>
          <form action="delete_question.php" method="POST" class="inline-form">
            <input type="hidden" name="id" value="<?= $q['id']; ?>" />
            <button type="submit" class="btn-delete">Delete</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    <p style="text-align: center; margin-top: 2rem;">
    <a href="../dashboard.php" class="btn-back">← Back to Admin Dashboard</a>
    </p>
  </div>
  
</body>
</html>
