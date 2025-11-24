<?php
session_start();
require '../includes/db.php'; // Make sure the DB connection file path is correct

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['suggestion'])) {
    $suggestion = trim($_POST['suggestion']);
    $user_id = $_SESSION['user_id'];

    if (!empty($suggestion)) {
        $stmt = $pdo->prepare("INSERT INTO career_suggestions (user_id, suggestion) VALUES (?, ?)");
        $stmt->execute([$user_id, $suggestion]);
        $message = "Your recommendation has been submitted successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Career Quiz (Chatbot)</title>
  <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/06/07/16/20250607161856-VE6N34IK.js"></script>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body data-theme="light">

  <a href="../dashboard.php">← Back to Dashboard</a>

  <h2>Career Quiz Assistant (Botpress)</h2>
  <p>The quiz will be conducted via chatbot below:</p>

  <script>
    window.botpress.init({
      "botId": "0223da7d-a405-4206-a35f-381b421af831",
      "configuration": {
        "version": "v1",
        "botName": "Your Career Path Assistant",
        "botDescription": "",
        "fabImage": "",
        "website": {},
        "email": {},
        "phone": {},
        "termsOfService": {},
        "privacyPolicy": {},
        "color": "#3276EA",
        "variant": "solid",
        "headerVariant": "solid",
        "themeMode": "light",
        "fontFamily": "inter",
        "radius": 4,
        "feedbackEnabled": false,
        "footer": "[⚡ by Botpress](https://botpress.com/?from=webchat)"
      },
      "clientId": "6fdf4f9d-7825-428f-9c30-31a70b9056ca"
    });
  </script>

  <form method="POST">
    <h3>Have your own career suggestion? Share it with us:</h3>
    <textarea name="suggestion" rows="4" placeholder="Type your recommendation here..." required></textarea>
    <button type="submit">Submit Suggestion</button>
    <?php if (isset($message)): ?>
      <div class="submit-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
  </form>

</body>
</html>
