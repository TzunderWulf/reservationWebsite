<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';
require_once 'validation-reservervation.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$body = file_get_contents('../templates/mail-template.html'); // use the mail template

// replace all the set up fields to actual data given in the form
$body = str_replace("{name}", $name, $body);
$body = str_replace("{reservation}", $typeReservation, $body);
$body = str_replace("{date}", $pickedDate, $body);
$body = str_replace("{time}", $pickedTime, $body);


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                       // Enable verbose debug output
    $mail->isSMTP();                                                // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
    $mail->Username   = 'email';          // SMTP username
    $mail->Password   = 'password';                           // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;             // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                         // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('example@example.com', 'Company Name');
    $mail->addAddress($email);       // Add a recipient
    $mail->addReplyTo('info@example.com', 'Information');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = $body;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    header('Location: ../confirmation.php');
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
