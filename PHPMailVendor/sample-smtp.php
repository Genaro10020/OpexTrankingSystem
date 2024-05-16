<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configure PHPMailer
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Configure SMTP Server
    $mail->Host = 'smtp.domain.com';
    $mail->Username = 'username@domain.com';
    $mail->Password = 'xxxxxxxx';

    // Configure Email
    $mail->setFrom('username@domain.com', 'Name');
    $mail->addAddress('tousername@domain.com');
    $mail->Subject = 'PHPMailer SMTP';
    $mail->isHTML(true);
    $mail->Body = 'This is the HTML message body <strong>in bold!</strong>';

    // send mail
    $mail->Send();
    echo 'Message has been sent using SMTP Server';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
