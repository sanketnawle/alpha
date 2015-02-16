<?php  

$db_host = "localhost"; 
$db_username = "campusla_UrlinqU";  
$db_pass = "PASSurlinq@word9";  
$db_name = "campusla_urlinq_demo"; 

try {
	global $pdo;
	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_username, $db_pass);
} catch (PDOException $e) {
	exit("Database error. $e");
}

?>