<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 

if(isset($_POST['notification_id']) && $_POST['notification_id']!='')
{
	$notification_id=$_POST['notification_id'];
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student' && isset($_SESSION['student_id']) && $_SESSION['student_id']!='')
	{
		$stud_id=$_SESSION['student_id'];
		$update_notification="update student_notifications set is_deleted='Yes' where notification_id='".$notification_id."' and notify_student_id='".$stud_id."'";
		$dbObj->fireQuery($update_notification,'update');
		echo 1;
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor' && isset($_SESSION['professor_id']) && $_SESSION['professor_id']!='')
	{
		$professor_id=$_SESSION['professor_id'];
		$update_notification="update professor_notifications set is_deleted='Yes' where notification_id='".$notification_id."' and notify_professor_id='".$professor_id."'";
		$dbObj->fireQuery($update_notification,'update');
		echo 1;
	}
	
}
?>
