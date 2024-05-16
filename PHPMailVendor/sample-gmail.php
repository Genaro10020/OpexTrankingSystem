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

    // Configure Gmail SMTP Server
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'username@gmail.com';
    $mail->Password = 'xxxxxxxx';

    // Configure Email
    $mail->setFrom('username@gmail.com', 'Name');
    $mail->addAddress('tousername@domain.com');
    $mail->Subject = 'PHPMailer Gmail';
    $mail->isHTML(true);
    $mail->Body = 'This is the HTML message body <strong>in bold!</strong>';

    // send mail
    $mail->Send();
    echo 'Message has been sent using Gmail SMTP Server';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
