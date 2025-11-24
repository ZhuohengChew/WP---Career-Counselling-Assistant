<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Login</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    .auth-form .button-row {
      display: flex;
      gap: 1rem;
      margin-top: 0.5rem;
    }

    .auth-form .button-row button {
      flex: 1;
    }

    .auth-error {
      color: red;
      text-align: center;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body class="auth-body">
  <div class="auth-container">
    <h2>Log in to Your Account</h2>

    <?php
      if (isset($_GET['error'])) {
        $error = $_GET['error'];
        $message = '';

        switch ($error) {
          case 'notverified':
            $message = 'Please verify your email before logging in.';
            break;
          case 'wrongpassword':
            $message = 'Incorrect password.';
            break;
          case 'usernotfound':
            $message = 'User not found.';
            break;
          default:
            $message = 'Login failed. Please try again.';
        }

        echo "<p class='auth-error'>$message</p>";
      }
    ?>

    <form action="../process/login_user.php" method="POST" class="auth-form">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>

      <div class="button-row">
        <button type="button" onclick="window.location.href='../index.html'">Back</button>
        <button type="submit">Login</button>
      </div>
    </form>

    <p class="auth-switch">Don't have an account? <a href="register.html">Register</a></p>
  </div>
</body>
</html>
