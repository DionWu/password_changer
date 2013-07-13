<?php
	

/* create mysqli object */
	$mysqli = new mysqli("localhost", "root", "", "fbchanger");
	

/* check if correctly connected to database */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	} 

/* Define variables from form */
	$firstname = $mysqli->real_escape_string($_POST['firstname']);
	$lastname = $mysqli->real_escape_string($_POST['lastname']);
	$email = $mysqli->real_escape_string($_POST['email']);

/* Account for case NULL */
	function get_days() {
		global $mysqli;
		$daysholder = $mysqli->real_escape_string($_POST['days']);
		if (!$daysholder) {
			$numdays = 0;
			return $numdays;
		} else {
			$numdays = $daysholder;
			return $numdays;
		};	
	};
	$days = get_days();

	function get_hours() {
		global $mysqli;
		$hoursholder = $mysqli->real_escape_string($_POST['hours']);
		if (!$hoursholder) {
			$numhours = 0;
			return $numhours;
		} else {
			$numhours = $hoursholder;
			return $numhours;
		};	
	};
	$hours = get_hours();

/* Tracking for whether task completed or not -- saves efficiency for emails */
	$completion = "no";


/* Get the start time and stop time */
	date_default_timezone_set('UTC');
	$currentDT = new DateTime();

	function get_DTstart() {
		global $currentDT;
		return $currentDT->format('Y-m-d H:i');;
	}
	$DTstart = get_DTstart();

	function get_DTstop() {
		global $currentDT, $days, $hours;
		$stopDT = $currentDT->add(new DateInterval('P' . $days . 'DT' . $hours . "H"));
		return $stopDTform= $stopDT->format('Y-m-d H:i');
	}
	$DTstop = get_DTstop();

/* generate random password and assign to user */
	function generate_password() {
		$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$pass = array();
		$alphalength = strlen($alphabet) - 1;
		for ($i=0; $i<10; $i++) {
			$rand = rand(0, $alphalength);
			$pass[] = $alphabet[$rand];
		};
		return implode($pass);
	};
	$newpassword = generate_password();


/* Insert variables into database */

	$insertdata = $mysqli->prepare("INSERT INTO `accounts` (`firstname`, `lastname`, `email`, `newpassword`, `DTstart`, `days`, `hours`, `DTstop`, `completion`) VALUES (?,?,?,?,?,?,?,?,?)");
	
	$insertdata->bind_param('sssssiiss', $firstname, $lastname, $email, $newpassword, $DTstart, $days, $hours, $DTstop, $completion);

	$insertdata->execute();


/* Automated email script */
$emailto = $email;
$emailsubject = "Your new password!";
$emailmessage = "<p>Hello " . $firstname . " " . $lastname . ", </p> 
	<p> You have taken a great step towards productivity by requesting a new password that you will never hope to memorize. Please remember that once you change your password, delete this email and never turn back! You will get so much done and feel so much better about yourself, I guarantee it.</p> 
	<p> Here is your new password : <strong>" . $newpassword . "</strong></p> 
	<p>Check back soon to get your password back!</p> 
	<p> Sincerely,</p>
	<p>The Password Changers</p>";


/* Send email to user containing new password */
function sendmail() {
		require_once 'PHPMailer-master/class.phpmailer.php';
		global $emailto, $emailsubject, $emailmessage;
		$results_messages = array();
		 
		$mail = new PHPMailer(true);
		$mail->CharSet = 'utf-8';
		 
		class phpmailerAppException extends phpmailerException {}
		 
		try {
		$to = $emailto;
		if(!PHPMailer::ValidateAddress($to)) {
		  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
		}
		$mail->IsSMTP();
		$mail->SMTPDebug  = 0;
		$mail->Host       = "dionwucom.ipage.com";
		$mail->Port       = "587";
		$mail->SMTPSecure = "none";
		$mail->SMTPAuth   = true;
		$mail->Username   = "dionwu@dionwu.com";
		$mail->Password   = "Fealty1337!";
		$mail->AddReplyTo("nomorefbpls@gmail.com", "Dion Wu");
		$mail->From       = "nomorefbpls@gmail.com";
		$mail->FromName   = "Dion Wu";
		$mail->AddAddress($emailto, "Dion");
		$mail->Subject  = $emailsubject;
$body = <<<EOT
$emailmessage;
EOT;
		$mail->WordWrap = 80;
		$mail->MsgHTML($body, dirname(__FILE__), true); //Create message bodies and embed images

		 
		try {
		  $mail->Send();
		  $results_messages[] = "Message has been sent using SMTP";
		}
		catch (phpmailerException $e) {
		  throw new phpmailerAppException('Unable to send to: ' . $to. ': '.$e->getMessage());
		}
		}
		catch (phpmailerAppException $e) {
		  $results_messages[] = $e->errorMessage();
		}

	};

/* check if correctly inserted into table */
	if (!$insertdata) {
		printf("%s\n", $mysqli->error);
		exit();
	} else {
	Echo "<p> Please check your email for your new randomly generated password. <strong>Remember</strong>, change your password to the newly generated one and resist from logging on the whichever service you use! You will get the password back after your specified duration! </p> <p> Thank you for using our service & please use us soon! </p>";
		sendmail();
	};

?>