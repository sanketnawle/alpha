<?php 
$db_host = "localhost";
$db_username = "campusla";
$db_pass = "Daisy@007";
$db_name = "campusla_fullcalendar";
try {
	$dbObj = new mysqli($db_host, $db_username, $db_pass, $db_name);
} catch (Exception $e) {
	exit("Database error. $e");
}
?>