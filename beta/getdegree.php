<?php
/*
This will handle the ajax call from signup_school_select.php
and save type,year,gender,type_pro  of the user in sessions 
type is grad or under grad
type_pro is for professor i.e administrator or professor,researcher
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['type'])){
	$_SESSION['type']=$_POST['type'];
}else if(isset($_POST['year'])){
	$_SESSION['year']=$_POST['year'];
}else if(isset($_POST['gender'])){
	$_SESSION['gender']=$_POST['gender'];
}else if(isset($_POST['type_pro'])){
	$_SESSION['type_pro']=$_POST['type_pro'];
	echo $_POST['type_pro'];
}
?>