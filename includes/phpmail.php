<?php 



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
//require './vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

function sendMail($to, $subject, $body, $fromEmail, $fromName, $smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpSecure = 'ssl') {
    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        // Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host       = $smtpHost; // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = $smtpUsername; // SMTP username
        $mail->Password   = $smtpPassword; // SMTP password
        $mail->SMTPSecure = $smtpSecure; // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = $smtpPort; // TCP port to connect to

        // Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Plain text version of the body for non-HTML email clients

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

       

