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
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= ucfirst($role); ?> Dashboard</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="navbar center-navbar">
    <div class="logo">Career Counselling Assistance</div>
    <nav id="nav-links">
      <a href="quiz/start.php">Chatbot</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </nav>
    <div class="nav-actions">
      <button id="toggle-theme" title="Toggle Theme">🌓</button>
      <button class="hamburger" id="hamburger">&#9776;</button>
    </div>
  </header>

  <main class="dashboard-container">
    <div class="dashboard-card">
      <h1>Welcome, <?= htmlspecialchars($name); ?>!</h1>
      <h2><?= ucfirst($role); ?> Dashboard</h2>

      <div class="dashboard-buttons">
        <?php if ($role === 'admin'): ?>
          <a href="admin/manage_quiz.php" class="btn">Manage Quizzes</a>
          <a href="admin/view_users.php" class="btn">View Users</a>
        <?php else: ?>
          <a href="quiz/start_quiz.php" class="btn">Take Career Quiz</a>
          <a href="quiz/start.php" class="btn">Consultation Chatbot</a>
          <a href="quiz/history.php" class="btn">View Quiz History</a>
          <a href="profile.php" class="btn">Update Profile</a>
        <?php endif; ?>
        <a href="logout.php" class="btn">Logout</a>
      </div>
    </div>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Career Counselling Assistant</p>
  </footer>

  <script src="theme-toggle.js"></script>
  <script src="nav.js"></script>
</body>
</html>
