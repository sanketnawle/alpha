<?php
	function validateName($name){
		//if it's NOT valid
		if(strlen($name) < 4)
			return false;
		//if it's valid
		else
			return true;
	}
	function validateEmail($email){
		return ereg("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$", $email);
	}
	function validatePasswords($pass1, $pass2) {
		//if DOESN'T MATCH
		if(strpos($pass1, ' ') !== false)
			return false;
		//if are valid
		return $pass1 == $pass2 && strlen($pass1) > 5;
	}
	function validateMessage($message){
		//if it's NOT valid
		if(strlen($message) < 10)
			return false;
		//if it's valid
		else
			return true;
	}
?>