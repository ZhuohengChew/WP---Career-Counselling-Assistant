<?php
require '../includes/db.php';
require '../includes/auth.php';
require '../vendor/autoload.php';

use Dompdf\Dompdf;

$user_id = $_SESSION['user_id'];
$attempt_id = $_GET['id'] ?? null;

if (!$attempt_id) {
  die('Attempt ID is required');
}

// Verify attempt ownership
$stmt = $pdo->prepare("SELECT * FROM quiz_attempts WHERE id = ? AND user_id = ?");
$stmt->execute([$attempt_id, $user_id]);
$attempt = $stmt->fetch();

if (!$attempt) {
  die('Attempt not found or access denied.');
}

// Fetch responses and questions
$stmt = $pdo->prepare("
  SELECT q.question, r.answer
  FROM responses r
  JOIN quizzes q ON r.quiz_id = q.id
  WHERE r.attempt_id = ?
");
$stmt->execute([$attempt_id]);
$responses = $stmt->fetchAll();

// Build HTML content for PDF
$html = "<h2>Quiz Attempt on " . htmlspecialchars($attempt['timestamp']) . "</h2><ul>";

foreach ($responses as $resp) {
  $html .= "<li><strong>" . htmlspecialchars($resp['question']) . "</strong><br>" . nl2br(htmlspecialchars($resp['answer'])) . "</li>";
}

$html .= "</ul>";

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();

$pdf->stream("quiz_attempt_{$attempt_id}.pdf", ["Attachment" => true]);
exit;
