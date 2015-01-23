<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST['calender']) && $_POST['calender']=='calender')
{
	$student_id=$_POST['student_id'];
	if(isset($_POST['courseids']) && $_POST['courseids']!='')
	{
		$courseid=array_filter(explode(",",$_POST['courseids']));
		foreach($courseid as $cid)
		{
			$course_sql="INSERT INTO `alert_event_check` (`studid`, `eventid`, `type`) VALUES ('".$student_id."', '".$cid."', 'course');";
			$dbObj->fireQuery($course_sql,'insert');
		}
		

	}
	if(isset($_POST['deptids']) && $_POST['deptids']!='')
	{
		$deptid=array_filter(explode(",",$_POST['deptids']));
		foreach($deptid as $did)
		{
			$dept_sql="INSERT INTO `alert_event_check` (`studid`, `eventid`, `type`) VALUES ('".$student_id."', '".$did."', 'dept');";
			$dbObj->fireQuery($dept_sql,'insert');
		}
	}
	$_SESSION['calender_notified']='Yes';
	echo 1;
}
elseif(isset($_POST['student_id']) && $_POST['student_id']!='' && isset($_POST['univid']) && $_POST['univid']!='' )
{
	$univid=$_POST['univid'];
	$student_id=$_POST['student_id'];
	$upd_sql="UPDATE `student_notifications` SET `is_checked` = '1' WHERE `univ_id` ='".$univid."' and notify_student_id ='".$student_id."';";
	$updateres=$dbObj->fireQuery($upd_sql,'update');
	echo $updateres;
}
elseif(isset($_POST['professor_id']) && $_POST['professor_id']!='' && isset($_POST['univid']) && $_POST['univid']!='' )
{
	$univid=$_POST['univid'];
	$professor_id=$_POST['professor_id'];
	$upd_sql="UPDATE `professor_notifications` SET `is_checked` = '1' WHERE `univ_id` ='".$univid."' and notify_professor_id ='".$professor_id."';";
	$updateres=$dbObj->fireQuery($upd_sql,'update');
	echo $updateres;
}

?>