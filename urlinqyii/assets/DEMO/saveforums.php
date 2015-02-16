<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST))
{
	$message=$_POST['message'];
	$visibility=$_POST['visibility'];
	$department_id=$_POST['department_id'];
	$university_id=$_POST['university_id'];
	$student_id=0;
	$professor_id=0;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$student_id=$_SESSION['student_id'];
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professor_id=$_SESSION['professor_id'];
	}
	$update_timestamp=date("Y-m-d H:i:s");
	$sql="INSERT INTO `department_posts_1` (`studentid`,`profid`,`deptid`,`univid`,`message`,`visibility`,`update_timestamp`) VALUES
	( ".$student_id.",".$professor_id.",".$department_id.",".$university_id.", '".addslashes($message)."', '".$visibility."','".$update_timestamp."');";
	$insert_id =$dbObj->fireQuery($sql,'insert');
	if($insert_id>0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
else
{
	echo 0;
}

?>