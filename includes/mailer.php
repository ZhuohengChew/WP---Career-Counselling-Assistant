<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendOtpEmail($toEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'chewheng@graduate.utm.my';
        $mail->Password   = 'xcgb huki lnmy lkxo'; // Use App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('chewheng@graduate.utm.my', 'Career Counselling Assistant');
        $mail->addAddress($toEmail);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Verification Code';
        $mail->Body = "
            <p>Hello,</p>
            <p>Your OTP code is: <strong>$otp</strong></p>
            <p>This code is valid for 10 minutes. If you did not request this, please ignore this email.</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
