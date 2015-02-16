<?php
require_once("../../includes/dbconfig.php");

$directory = 'faculty';
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
// print_r($scanned_directory);
$i=0;
foreach ($scanned_directory as $key => $value) {
	// echo substr($value, 0, -4)." ".$value."<br/>";
	$status = mysqli_query($con, "UPDATE user SET dp_link='DEMO/uploaded/faculty/".$value."' WHERE user_id=".substr($value, 0, -4));
	if($status) $i++;
	else echo "Failed uploading link for User id :".substr($value, 0, -4)."<br/>";
}
echo "<br/>****".$i." records updated****";
?>	
