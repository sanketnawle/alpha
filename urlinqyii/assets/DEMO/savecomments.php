<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST['messageid']) && $_POST['messageid']!='')
{
	$messageid=$_POST['messageid'];
	$comment=$_POST['comment'];
	$studentid=0;
	$profid=0;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$studentid=$_SESSION['student_id'];
		
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$profid=$_SESSION['professor_id'];
	}
	$update_timestamp=date("Y-m-d H:i:s");
	$sql_insert="INSERT INTO `department_reply_1` (`messageid`, `studentid`, `profid`, `replymessage`,`update_timestamp`)VALUES( '".$messageid."', '".$studentid."', '".$profid."', '".$comment."','".$update_timestamp."')";
	$comment_id=$dbObj->fireQuery($sql_insert,'insert');
	if($comment_id>0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>