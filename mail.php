<?php

	include( dirname(__FILE__) . "/phpjobscheduler/firepjs.php");


/* create mysqli object */
	$mysqli = new mysqli("localhost", "root", "", "fbchanger");

/* check if correctly connected to database */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	} 


/* Select relevant data from DB `fbchanger` & putting it in accessible Assoc. array $email_array */
	$select_for_email = "SELECT id, firstname, email, newpassword, DTstop FROM accounts WHERE completion = 'no' ORDER BY DTstop";
	$select_result = $mysqli->query($select_for_email);
	$email_array = $select_result->fetch_assoc();


/* automated mail script */
	$emailto = $email_array['email'];
	$emailsubject = "The wait is officially OVER!!!";
	$emailmessage = "<p> Dear " . $email_array['firstname'] . ", </p>
					<p> We hope you had quite the productive time while not being able to access your Facebook account. I would just like to assure you that there has been no tampering with the information on your account. Provided below is the new password you must use to login. After login, please promptly change your password back to anything you'd like. </p>
					<p> Your new password: <strong>" . $email_array['newpassword'] . "</strong></p>
					<p> We would love to have you use our delightful service in the future! </p>
					<p> Cheers!, </p> <p> NoMoreFBPls Team </p>";
	$emailheaders = "From: goawayfbpls@gmail.com" .
				"Reply-To: goawayfbpls@gmail.com";

/* PHPmailer script */
	function sendmail() {
		require_once 'PHPMailer-master/class.phpmailer.php';
		global $emailto, $emailsubject, $emailmessage, $emailheaders;
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
		$mail->SMTPDebug  = 2;
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
		 
		if (count($results_messages) > 0) {
		  echo "<h2>Run results</h2>\n";
		  echo "<ul>\n";
		foreach ($results_messages as $result) {
		  echo "<li>$result</li>\n";
		}
		echo "</ul>\n";
		}
	};


/* Checking if it is time to release newpassword to user */
	date_default_timezone_set('UTC');
	$currentDTobj = new DateTime();
	$pre_formatted_DT = $currentDTobj->format('Y-m-d H:i');	
	$currentDT = $pre_formatted_DT . ":00";
	echo $currentDT;
	function timecheck() {
		global $email_array, $currentDT, $emailto, $emailsubject, $emailmessage, $emailheaders, $mysqli;
		if ($currentDT === $email_array['DTstop']) {
			return;
		} else {
/* send mail & check if correctly prepped for delivery */
			sendmail();
/* Update completion status & check for errors*/
			/* $update_completion_status = "UPDATE accounts SET completion='yes' WHERE id =" . $email_array['id'] . "";
			$update_result = $mysqli->query($update_completion_status);
			if (!$update_result) {
				printf("%s\n", $mysqli->error);
			}; */
		};
		return;
	};

/*Calling timecheck & mail functions. Putting everything together*/
	if ($select_result = $mysqli->query($select_for_email)) {
		while (NULL !== ($email_array = $select_result->fetch_assoc())) {
			timecheck();
		};
	};


?>