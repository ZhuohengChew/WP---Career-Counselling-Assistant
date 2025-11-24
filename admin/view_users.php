<?php
session_start();
require '../includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.html');
    exit;
}

// Fetch all users
$stmt = $pdo->query("SELECT id, name, email, role, is_verified, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Optional success message
$msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8" />
  <title>View Users - Admin Panel</title>
  <link rel="stylesheet" href="style.css?v=<?= time(); ?>" />
  
</head>
<body>
  <div class="container">
    <h1>Users List</h1>

    <?php if ($msg): ?>
      <p class="success-msg"><?= $msg ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Verified</th>
          <th>Created At</th>
          <th>Actions</th> <!-- Added actions column -->
        </tr>
      </thead>
      <tbody>
        <?php if (!$users): ?>
          <tr><td colspan="7">No users found.</td></tr>
        <?php else: ?>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['id']) ?></td>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
              <td><?= $user['is_verified'] ? 'Yes' : 'No' ?></td>
              <td><?= htmlspecialchars($user['created_at']) ?></td>
              <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a> |
                <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <p style="text-align: center; margin-top: 2rem;">
    <a href="../dashboard.php" class="btn-back">← Back to Admin Dashboard</a>
    </p>
  </div>
</body>
</html>
