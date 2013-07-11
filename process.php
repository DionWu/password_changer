<?php
	
/* */

/* Define variables from form */
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
/* Account for case NULL */
	function get_days() {
		$daysholder = $_POST['days'];
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
		$hoursholder = $_POST['hours'];
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

	

/* create mysqli object */
	$mysqli = new mysqli("localhost", "root", "", "fbchanger");
	

/* check if correctly connected to database */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	} 

	$insertdata = "INSERT INTO `accounts` (`firstname`, `lastname`, `email`, `password`, `newpassword`, `DTstart`, `days`, `hours`, `DTstop`, `completion`) VALUES ('" . $firstname . "' , '". $lastname ."', '". $email ."', '". $password ."', '". $newpassword ."', '". $DTstart ."', '". $days ."', '". $hours ."', '". $DTstop ."', '". $completion ."')";
	
	$insertresult = $mysqli->query($insertdata);

	
/* check if correctly inserted into table */
	if (!$insertresult) {
		printf("%s\n", $mysqli->error);
		exit();
	};


	Echo "Thank you for using our service! You will get your password back after the time you have selected has elapsed!";


?>