<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */


// require '../vendor/autoload.php';
include "PHPMailer.php";
include "SMTP.php";
//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.naver.com';
//Use `$mail->Host = gethostbyname('smtp.gmail.com');`
//if your network does not support SMTP over IPv6,
//though this may cause issues with TLS

//Set the SMTP port number:
// - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
// - 587 for SMTP+STARTTLS
$mail->Port = 465;

//Set the encryption mechanism to use:
// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
$mail->SMTPSecure = "ssl";

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

$mail->CharSet='UTF-8';
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'winsomed96';

//Password to use for SMTP authentication
$mail->Password = 'R5Z4J2N1BKT3';

//Set who the message is to be sent from
//Note that with gmail you can only use your account address (same as `Username`)
//or predefined aliases that you have configured within your account.
//Do not use user-submitted addresses in here
$mail->setFrom('winsomed96@naver.com', 'TopTraderCommunity');

//Set an alternative reply-to address
//This is a good place to put user-submitted addresses
$mail->addReplyTo('winsomed96@naver.com', 'TopTraderCommunity');

//Set who the message is to be sent to
$mail->addAddress('winsomed96@daum.net', '한호성');

//Set the subject line
$mail->Subject = '메일 테스트 입니다.';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

// $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
$mail->msgHTML("메일 평1문입니다.");
//Replace the plain text body with one created manually
// $mail->AltBody = '메일 평문입니다.';

//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
