<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'autoload.php';
$mail = new PHPMailer;
echo "new phpmailer";
$mail->isSMTP();
$mail->SMTPDebug = 2;

$mail->Host = 'mx1.hostinger.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'info@yourwebsite.com';
$mail->Password = 'Password';

$mail->setFrom('info@yourwebsite.com', '');
$mail->addReplyTo('info@yourwebsite.com', '');
$mail->addAddress('recipient@gmail.com', '');
$mail->Subject = 'This means that emails work fine.';
$mail->msgHTML("<h1>Incoming message to Houston</h1>");

if (!$mail->send()) {
echo 'error: ' . $mail->ErrorInfo;
} else {
echo 'message sent';
}
//if (!$mail->send()) {
// echo $message_error . $mail->ErrorInfo;
//} else {
// echo $message_send;
//}

?>