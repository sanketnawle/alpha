<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
for($i=1;$i<256;$i++){
	$imagename= $i.".jpg";
	echo "<br />===>".$update_sql="update professor_1 SET profilepic='".$imagename."',location='/uploaded/faculty' where profid=".$i."";
	$dbObj->fireQuery($update_sql,'update');
}
////// Remove the image form tha prodid which don't have image
$update_non_img_sql="update professor_1 set profilepic='NULL' where profid IN (2,22,25,42,54,55,56,57,58,59,64,71,78,80,110,111,148,152,162,164,179,181,182,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,221,222,223,224,225,234)";
$dbObj->fireQuery($update_non_img_sql,'update');

$update_sql="update professor_1 set profilepic='140.jpeg' where profid=140";
$dbObj->fireQuery($update_sql,'update');

?>