<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['forgot'])){	
	$_SESSION['forgot']=1;
}
?>