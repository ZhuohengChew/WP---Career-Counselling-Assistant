<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: index.html');
  exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Update Profile</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="content">
    <div class="dashboard-card">
      <h1>Update Profile</h1>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert success" style="color: green; margin-bottom: 1rem;">
          <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error" style="color: red; margin-bottom: 1rem;">
          <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <?php if (!empty($user['profile_pic'])): ?>
        <img src="<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile Picture"
             width="120" height="120" style="border-radius: 50%; object-fit: cover; margin-bottom: 1rem;">
      <?php endif; ?>

      <form action="update_profile.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Name" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
        <input type="password" name="password" placeholder="New password (leave blank to keep current)">
        <input type="file" name="profile_pic" accept="image/*">
        <button type="submit" class="btn">Update</button>
      </form>

      <div style="margin-top: 1.5rem;">
        <a href="dashboard.php" class="btn">Back</a>
      </div>
    </div>
  </div>
</body>
</html>
