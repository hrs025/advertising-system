<?php
function send_mail($to,$subject,$body)
{
	require 'PHPMailer-master/PHPMailerAutoload.php';

	$mail = new PHPMailer;
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'nareshrupareliya70@gmail.com';                 // SMTP username
	$mail->Password = '';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('nareshrupareliya70@gmail.com', 'Happy Grocery');
	$mail->addAddress($to);     // Add a recipient
	// $mail->addAddress('ellen@example.com');               // Name is optional
	// $mail->addReplyTo('info@example.com', 'Information');
	// $mail->addCC('cc@example.com');
	// $mail->addBCC('bcc@example.com');

	// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;
	// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	    //echo 'Message could not be sent.';
	    // return 'Mailer Error: ' . $mail->ErrorInfo;
	    return 0;
	} else {
	    //echo 'Message has been sent';
	    return 1;
	}
}
?>