<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
  $content = $_POST['content'];

  $pdf = new Dompdf();
  $pdf->loadHtml("<h2>Career Quiz Result</h2><p>" . nl2br(htmlspecialchars($content)) . "</p>");
  $pdf->setPaper('A4', 'portrait');
  $pdf->render();
  $pdf->stream("career_suggestion.pdf", ["Attachment" => true]);
  exit;
} else {
  echo "Invalid request.";
}
?>
