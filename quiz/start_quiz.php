<?php
session_start();
require '../includes/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: ../index.html');
  exit;
}

// Fetch all quiz questions
$stmt = $pdo->query("SELECT * FROM quizzes ORDER BY id ASC");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="UTF-8">
  <title>Career Quiz</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Career Counselling Quiz</h2>
    <form action="submit_quiz.php" method="post">
      <?php foreach ($questions as $index => $q): ?>
        <div class="question-block">
          <p><strong>Q<?= $index + 1 ?>:</strong> <?= htmlspecialchars($q['question']) ?></p>

          <?php if ($q['type'] === 'mcq'): ?>
            <?php
              $options = json_decode($q['options'], true);
              foreach ($options as $opt):
            ?>
              <label>
                <input type="radio" name="responses[<?= $q['id'] ?>]" value="<?= htmlspecialchars($opt) ?>" required>
                <?= htmlspecialchars($opt) ?>
              </label><br>
            <?php endforeach; ?>

          <?php elseif ($q['type'] === 'scale'): ?>
            <input type="range" name="responses[<?= $q['id'] ?>]" min="1" max="5" value="3" required>
            <span>1 (Low) to 5 (High)</span>
          <?php endif; ?>
        </div>
        <hr>
      <?php endforeach; ?>

      <button type="submit">Submit Quiz</button>
    </form>
    <br>
    <a href="../dashboard.php" class="btn">Cancel</a>
  </div>
</body>
</html>
