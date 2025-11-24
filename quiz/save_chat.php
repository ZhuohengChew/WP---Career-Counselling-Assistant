<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

session_start();
header('Content-Type: application/json');

// Must be logged in
if (!isset($_SESSION['user_id'])) {
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$messages = $data['messages'] ?? [];

if (empty($messages)) {
  echo json_encode(["error" => "No messages"]);
  exit;
}

$user_id = $_SESSION['user_id'];
$html = "<h2>Career Chat Transcript</h2><ul>";

foreach ($messages as $msg) {
  $who = $msg['from'] === 'incoming' ? 'Bot' : 'User';
  $text = htmlspecialchars($msg['text']);
  $html .= "<li><strong>{$who}:</strong> {$text}</li>";
}
$html .= "</ul>";

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();

$filename = "chat_history_user{$user_id}_" . time() . ".pdf";
$save_path = "../uploads/{$filename}";
file_put_contents($save_path, $pdf->output());

// Optional: store filename for access in result page
$_SESSION['chat_pdf'] = $filename;

echo json_encode(["status" => "saved", "file" => $filename]);
?>
