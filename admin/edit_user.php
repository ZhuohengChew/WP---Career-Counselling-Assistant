<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.html');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid user ID');
}

$user_id = intval($_GET['id']);

// Fetch user info
$stmt = $pdo->prepare("SELECT id, name, email, role, is_verified FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('User not found');
}

// If form submitted, process update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;

    if (!$name || !$email) {
        $error = "Name and email cannot be empty.";
    } else {
        // Check for email uniqueness except current user
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user_id]);
        if ($stmt->fetch()) {
            $error = "Email already in use by another user.";
        } else {
            // Update user
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ?, is_verified = ? WHERE id = ?");
            $stmt->execute([$name, $email, $role, $is_verified, $user_id]);

            header("Location: view_users.php?msg=User updated successfully");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit User</title>
  <link rel="stylesheet" href="style.css?v=<?= time(); ?>" />
</head>
<body>
  <div class="container">
    <h1>Edit User #<?= htmlspecialchars($user['id']) ?></h1>

    <?php if (isset($error)): ?>
      <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>
        Name:<br />
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
      </label><br />

      <label>
        Email:<br />
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      </label><br />

      <label>
        Role:<br />
        <select name="role">
          <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
          <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
      </label><br />

      <label>
        Verified:
        <input type="checkbox" name="is_verified" <?= $user['is_verified'] ? 'checked' : '' ?>>
      </label><br />

      <button type="submit">Save Changes</button>
      <a href="view_users.php">Cancel</a>
    </form>
  </div>
</body>
</html>
