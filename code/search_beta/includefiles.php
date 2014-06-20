<?php 
$db_host = "localhost";
$db_username = "campusla_UrlinqU";
$db_pass = "mArCh3!!1992X";
$db_name = "campusla_urlinq_beta";
try {
	$dbObj = new mysqli($db_host, $db_username, $db_pass, $db_name);
} catch (Exception $e) {
	exit("Database error. $e");
}
function get_connected_users($from_user)
{
	global $dbObj;
	$connect_stmt = $dbObj->prepare("Select to_user_id from connect where from_user_id = ?");
	$connect_stmt->bind_param("i",$from_user);
	$connect_stmt->execute();
	$connect_stmt->bind_result($toid);
	$to_id_array = array();
	while($connect_stmt->fetch())
	{
		$to_id_array[] = $toid;
	}
	return $to_id_array;
}
?>