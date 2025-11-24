<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../index.html');
  exit;
}

if (!isset($_SESSION['last_quiz'])) {
  echo "No results available.";
  exit;
}

$quiz_result = $_SESSION['last_quiz'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz Result</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Your Quiz Answers</h2>
    <pre style="white-space: pre-wrap;"><?php echo htmlspecialchars($quiz_result); ?></pre>

    <form action="export_pdf.php" method="post">
      <textarea name="content" hidden><?php echo htmlspecialchars($quiz_result); ?></textarea>
      <button type="submit">Download as PDF</button>
    </form>

    <br>
    <a href="../dashboard.php" class="btn">Back to Dashboard</a>
  </div>
</body>
</html>
