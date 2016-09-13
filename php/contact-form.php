<?php
session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

require 'php-mailer/class.phpmailer.php';

// Your email address
$to = 'enrique7mc@gmail.com';

$subject = $_POST['subject'];

if($to) {

	$name = $_POST['name'];
	$email = $_POST['email'];

	$fields = array(
		0 => array(
			'text' => 'Name',
			'val' => $_POST['name']
		),
		1 => array(
			'text' => 'Email address',
			'val' => $_POST['email']
		),
		2 => array(
			'text' => 'Message',
			'val' => $_POST['message']
		)
	);

	$message = "";

	foreach($fields as $field) {
		$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
	}

	$mail = new PHPMailer;

	$mail->IsSMTP();                                      // Set mailer to use SMTP

	// Optional Settings
	$mail->Host = 'box305.bluehost.com';				  // Specify main and backup server
	$mail->SMTPAuth = true;                             // Enable SMTP authentication
	$mail->Username = 'contacto@enrique7mc.com';             		  // SMTP username
	$mail->Password = 'a<4ho!AZV9rs9';                         // SMTP password
	$mail->Port       = 465;								// SMTP port
	$mail->SMTPSecure = 'ssl';                          // Enable encryption, 'ssl' also accepted

	$mail->From = $email;
	$mail->FromName = $_POST['name'];
	$mail->AddAddress($to);								  // Add a recipient
	$mail->AddReplyTo($email, $name);

	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->CharSet = 'UTF-8';

	$mail->Subject = $subject;
	$mail->Body    = $message;

	if(!$mail->Send()) {
	   $arrResult = array ('response'=>'error');
	}

	$arrResult = array ('response'=>'success');

	echo json_encode($arrResult);

} else {

	$arrResult = array ('response'=>'error');
	echo json_encode($arrResult);

}
?>
