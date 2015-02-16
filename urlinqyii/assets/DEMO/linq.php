<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront();
if(isset($_POST['whoislogin']) && $_POST['whoislogin']=='Student')
{
	if(isset($_POST['user']) && $_POST['user']!='' && isset($_POST['action']) && $_POST['action']!='' )
	{
	$is_success=1;
	$is_error=0;
	$action=$_POST['action'];
	$user=$_POST['user'];
	$univ_id=$_POST['univ_id'];
	if($action=='student')
	{
		$linqid=$_POST['linqid'];
		/////// add linq to student tables ///////////
		$insert_linq="INSERT INTO `student_student_1` (`from_studid`,`to_studid`) VALUES ('".$user."','".$linqid."');";
		$dbObj->fireQuery($insert_linq,'insert');
		
		/// add notification about linq for another student //////
		$notification_add="INSERT INTO `student_notifications` (`univ_id`, `notify_student_id`,`student_id`,`linqed_student_id`,`message`) VALUES (".$univ_id.",".$linqid.",".$user.",".$linqid.",'LINQ');";
		$dbObj->fireQuery($notification_add,'insert');
		$message="You have successfully linqed";
		echo $is_success."|||".$message;
	
	}
	elseif($action=='professor')
	{
		$linqid=$_POST['linqid'];
		/////// add linq to student tables ///////////
		$insert_linq="INSERT INTO `student_professor_1` (`from_studid`,`to_profid`) VALUES ('".$user."','".$linqid."');";
		$dbObj->fireQuery($insert_linq,'insert');
		
		/// add notification about linq for another professor //////
		$notification_add="INSERT INTO `professor_notifications` (`univ_id`, `notify_professor_id`,`student_id`,`linqed_professor_id`,`message`) 
		VALUES (".$univ_id.",".$linqid.",".$user.",".$linqid.",'LINQ');";
		$dbObj->fireQuery($notification_add,'insert');
		$message="You have successfully linqed";
		echo $is_success."|||".$message;
	
	}
	elseif($action=='courses')
	{
		$course_id=$_POST['linqid'];
		$enrolled_time=date("Y-m-d H:i:s");
		$createdon=date("Y-m-d H:i:s");
		$totalcourses=0;
		////////// Check if student is already enrolled for 4 courses then display message /////////////
		$sem_sql="SELECT startperiod, endperiod,name FROM `semester_schedule` WHERE univid = ".$univ_id." and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP)>=MONTH(startperiod)*100+DAY(startperiod) and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP) <= MONTH(endperiod)*100+DAY(endperiod) "; 
		$sem_res=$dbObj->fireQuery($sem_sql,'select');
		if(isset($sem_res) && $sem_res!=false && count($sem_res)>0)
		{
			$startperiod=$sem_res[0]['startperiod'];
			$endperiod=$sem_res[0]['endperiod'];
			$student_id=$_SESSION['student_id'];
			$student_course_sql="select count(*) as total_course,GROUP_CONCAT( course_id ) AS current_courses from  student_courses_1 where enrolltime>='".$startperiod."' and enrolltime<='".$endperiod."' and student_id='".$user."'";
			$courses_res=$dbObj->fireQuery($student_course_sql,'select');
			$totalcourses=$courses_res[0]['total_course'];
			$current_courses=explode(",",$courses_res[0]['current_courses']);
		}
		if(in_array($course_id,$current_courses))
		{
			$message="You already enrolled in this course.";
			echo $is_error."|||".$message;
			die;
		}
		if($totalcourses<4)
		{		
		//////////// enrolled in course //////////////////
		$insert_course="INSERT INTO `student_courses_1` (`student_id`, `universityid`, `course_id`, `enrolltime`, `status`, `createdon`) 
		VALUES ( '".$user."', '".$univ_id."', '".$course_id."', '".$enrolled_time."', 'Active', '".$createdon."');";
		$dbObj->fireQuery($insert_course,'insert');
		
		///////// Get all student who follow this student /////////////
		$seclt_linq="SELECT from_studid FROM `student_student_1` where to_studid='".$user."'";
		$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
		if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
		{
			for($i=0;$i<count($seclt_linqres);$i++)
			{
				$linqed_student=$seclt_linqres[$i]['from_studid'];
				////////////add notification to all that student who follow this student //////////////
				$notification_add="INSERT INTO `student_notifications` (`univ_id`, `notify_student_id`,`student_id`,`message`,`course_id`) 
				VALUES (".$univ_id.",".$linqed_student.",".$user.",'ENROLL','".$course_id."');";
				$dbObj->fireQuery($notification_add,'insert');
			}
		}
		///////// Get all professor who follow this student /////////////
		$seclt_linq="SELECT to_profid FROM `student_professor_1` where from_studid='".$user."'";
		$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
		if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
		{
			for($i=0;$i<count($seclt_linqres);$i++)
			{
				$linqed_professor=$seclt_linqres[$i]['to_profid'];
				////////////add notification to all that student who follow this student //////////////
				$notification_add="INSERT INTO `professor_notifications` (`univ_id`, `notify_professor_id`,`student_id`,`message`,`course_id`) 
				VALUES (".$univ_id.",".$linqed_professor.",".$user.",'ENROLL','".$course_id."');";
				$dbObj->fireQuery($notification_add,'insert');
			}
		}
			$message="You have successfully enrolled in course";
			echo $is_success."|||".$message;
		}else{
			$message="Can’t add further course, you reach max limit please drop any one from your catalog";
			echo $is_error."|||".$message;
		}
		
	}
	elseif($action=='clubs')
	{
		$groupid_id=$_POST['linqid'];
		$user=$_POST['user'];
		$groups_add="INSERT INTO `groups_student_1` (`groupid`, `studid`) 
				VALUES (".$groupid_id.",".$user.");";
		$dbObj->fireQuery($groups_add,'insert');
		///////// Get all student who follow this student /////////////
		$seclt_linq="SELECT from_studid FROM `student_student_1` where to_studid='".$user."'";
		$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
		if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
		{
			for($i=0;$i<count($seclt_linqres);$i++)
			{
				$linqed_student=$seclt_linqres[$i]['from_studid'];
				////////////add notification to all that student who follow this student //////////////
				$notification_add="INSERT INTO `student_notifications` (`univ_id`, `notify_student_id`,`student_id`,`message`,`club_id`) 
				VALUES (".$univ_id.",".$linqed_student.",".$user.",'JOIN','".$groupid_id."');";
				$dbObj->fireQuery($notification_add,'insert');
			}
		}
		///////// Get all professor who follow this student /////////////
		$seclt_linq="SELECT to_profid FROM `student_professor_1` where from_studid='".$user."'";
		$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
		if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
		{
			for($i=0;$i<count($seclt_linqres);$i++)
			{
				$linqed_professor=$seclt_linqres[$i]['to_profid'];
				////////////add notification to all that student who follow this student //////////////
				$notification_add="INSERT INTO `professor_notifications` (`univ_id`, `notify_professor_id`,`student_id`,`message`,`club_id`) 
				VALUES (".$univ_id.",".$linqed_professor.",".$user.",'JOIN','".$groupid_id."');";
				$dbObj->fireQuery($notification_add,'insert');
			}
		}
		$message="You have successfully joined in club";
		echo $is_success."|||".$message;		
	}
	}

}
elseif(isset($_POST['whoislogin']) && $_POST['whoislogin']=='Professor')
{
	if(isset($_POST['user']) && $_POST['user']!='' && isset($_POST['action']) && $_POST['action']!='' )
	{
		$is_success=1;
		$is_error=0;
		$action=$_POST['action'];
		$user=$_POST['user'];
		$univ_id=$_POST['univ_id'];
		if($action=='student')
		{
			$linqid=$_POST['linqid'];
			/////// add linq to student tables ///////////
			$insert_linq="INSERT INTO `professor_student_1` (`from_profid`,`to_studid`) VALUES ('".$user."','".$linqid."');";
			$dbObj->fireQuery($insert_linq,'insert');
		
			/// add notification about linq for another student //////
			$notification_add="INSERT INTO `student_notifications` (`univ_id`,`notify_student_id`,`professor_id`,`linqed_student_id`,`message`) VALUES (".$univ_id.",".$linqid.",".$user.",".$linqid.",'LINQ');";
			$dbObj->fireQuery($notification_add,'insert');
			$message="You have successfully linqed";
			echo $is_success."|||".$message;
	
		}
		elseif($action=='professor')
		{
			$linqid=$_POST['linqid'];
			/////// add linq to professor tables ///////////
			$insert_linq="INSERT INTO `professor_professor_1` (`from_profid`,`to_profid`) VALUES ('".$user."','".$linqid."');";
			$dbObj->fireQuery($insert_linq,'insert');
		
			/// add notification about linq for another professor //////
			$notification_add="INSERT INTO `professor_notifications` (`univ_id`, `notify_professor_id`,`professor_id`,`linqed_professor_id`,`message`) 
			VALUES (".$univ_id.",".$linqid.",".$user.",".$linqid.",'LINQ');";
			$dbObj->fireQuery($notification_add,'insert');
			$message="You have successfully linqed";
			echo $is_success."|||".$message;
		}
		elseif($action=='courses')
		{
			$course_id=$_POST['linqid'];
			$course_profid='';
			/////// Check if course has already profid (numeric value) then restrict prof to add that course. /////////
			$select_cousql="select profid from course_1 where cid='".$course_id."'";
			$course_res=$dbObj->fireQuery($select_cousql,'select');
			if(isset($course_res) && $course_res!=false && count($course_res)>0)
			{
				$course_profid=$course_res[0]['profid'];
			}
			if(is_numeric($course_profid))
			{
				$message="Can’t add this course,Another professor already assigned this course";
				echo $is_error."|||".$message;
				
			}
			else
			{	
			$totalcourses=0;
			$update_course="UPDATE course_1 set profid='".$user."' where cid='".$course_id."'";
			$dbObj->fireQuery($update_course,'update');
			
			///////// Get all student who follow this student /////////////
			$seclt_linq="SELECT from_studid FROM `student_professor_1` where to_profid='".$user."'";
			$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
			if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
			{
				for($i=0;$i<count($seclt_linqres);$i++)
				{
					$linqed_student=$seclt_linqres[$i]['from_studid'];
					////////////add notification to all that student who follow this student //////////////
					$notification_add="INSERT INTO `student_notifications` (`univ_id`, `notify_student_id`,`professor_id`,`message`,`course_id`) 
					VALUES (".$univ_id.",".$linqed_student.",".$user.",'ENROLL','".$course_id."');";
					$dbObj->fireQuery($notification_add,'insert');
				}
			}
			///////// Get all professor who follow this student /////////////
			$seclt_linq="SELECT from_profid FROM `professor_professor_1` where to_profid='".$user."'";
			$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
			if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
			{
				for($i=0;$i<count($seclt_linqres);$i++)
				{
					$linqed_professor=$seclt_linqres[$i]['from_profid'];
					////////////add notification to all that student who follow this student //////////////
					$notification_add="INSERT INTO `professor_notifications` (`univ_id`, `notify_professor_id`,`professor_id`,`message`,`course_id`) 
					VALUES (".$univ_id.",".$linqed_professor.",".$user.",'ENROLL','".$course_id."');";
					$dbObj->fireQuery($notification_add,'insert');
				}
			}
			$message="You have successfully enrolled in course";
			echo $is_success."|||".$message;
			}
		
		}
		elseif($action=='clubs')
		{
		$groupid_id=$_POST['linqid'];
		$user=$_POST['user'];
		$groups_add="INSERT INTO `groups_professor_1` (`groupid`, `profid`) 
				VALUES (".$groupid_id.",".$user.");";
		$dbObj->fireQuery($groups_add,'insert');
		///////// Get all student who follow this professor /////////////
		$seclt_linq="SELECT from_studid FROM `student_professor_1` where to_profid='".$user."'";
		$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
		if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
		{
			for($i=0;$i<count($seclt_linqres);$i++)
			{
				$linqed_student=$seclt_linqres[$i]['from_studid'];
				////////////add notification to all that student who follow this student //////////////
				$notification_add="INSERT INTO `student_notifications` (`univ_id`, `notify_student_id`,`professor_id`,`message`,`club_id`) 
				VALUES (".$univ_id.",".$linqed_student.",".$user.",'JOIN','".$groupid_id."');";
				$dbObj->fireQuery($notification_add,'insert');
			}
		}
		///////// Get all professor who follow this professor /////////////
		$seclt_linq="SELECT from_profid FROM `professor_professor_1` where to_profid='".$user."'";
		$seclt_linqres=$dbObj->fireQuery($seclt_linq,'select');
		if(isset($seclt_linqres) && $seclt_linqres!=false && count($seclt_linqres)>0)
		{
			for($i=0;$i<count($seclt_linqres);$i++)
			{
				$linqed_professor=$seclt_linqres[$i]['from_profid'];
				////////////add notification to all that professor who follow this professor //////////////
				$notification_add="INSERT INTO `professor_notifications` (`univ_id`, `notify_professor_id`,`professor_id`,`message`,`club_id`) 
				VALUES (".$univ_id.",".$linqed_professor.",".$user.",'JOIN','".$groupid_id."');";
				$dbObj->fireQuery($notification_add,'insert');
			}
		}
		$message="You have successfully joined in club";
		echo $is_success."|||".$message;		
	}
		}
}
?>