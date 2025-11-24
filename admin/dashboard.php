<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo ucfirst($role); ?> Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
    <h2><?php echo ucfirst($role); ?> Dashboard</h2>

    <?php if ($role === 'admin'): ?>
      <a href="admin/manage_quiz.php" class="btn">Manage Quizzes</a>
      <a href="admin/view_users.php" class="btn">View Users</a>
    <?php else: ?>
      <a href="quiz/start.php" class="btn">Take Career Quiz</a>
      <a href="quiz/history.php" class="btn">View Quiz History</a>
      <a href="profile.php" class="btn">Update Profile</a>
    <?php endif; ?>

    <br><br>
    <a href="logout.php" class="btn">Logout</a>
  </div>
</body>
</html>
