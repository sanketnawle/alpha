<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST))
{
	$message=$_POST['message'];
	// The Regular Expression filter
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	// Check if there is a url in the text
	if(preg_match($reg_exUrl, $message, $url)) 
	{
		   // make the urls hyper links
		   $message=preg_replace($reg_exUrl, "<a href=".$url[0].">".$url[0]."</a> ", $message);
	}
	$visibility=$_POST['visibility'];
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
	$sql="INSERT INTO `home_posts` (`studentid`,`profid`,`univid`,`message`,`visibility`,`update_timestamp`) VALUES
	( ".$student_id.",".$professor_id.",".$university_id.", '".addslashes($message)."', '".$visibility."','".$update_timestamp."');";
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