<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function sendOTP($email,$otp) {
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'codenewbie221@gmail.com';                 // SMTP username
		$mail->Password = 'zzxx1123';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom('from@example.com', 'Mailer');
		$mail->addAddress($email);     // Add a recipient             // Name is optional
		$mail->addReplyTo('info@example.com', 'Information');

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'OTP LAI LIAO';
		$mail->Body    = 'Here is your OTP to reset your password: ' . $otp .'.' ;


		
		$mail->isSMTP(); // $mail->Body = $body; etc
		$mail->smtpConnect([
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			]
		]);
		
		$result = $mail->send();
		echo 'Please check your email for the OTP to reset your password';
		echo "<br>";
		echo 'Please enter the OTP in 5 Minutes or it will expire';
		
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		
	}
	return $result;
}