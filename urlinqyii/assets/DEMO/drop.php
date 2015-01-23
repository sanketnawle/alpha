<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST['whoislogin']) && $_POST['whoislogin']=='Student')
{
	if(isset($_POST['user']) && $_POST['user']!='' && isset($_POST['action']) && $_POST['action']!='' )
	{
		
		$action=$_POST['action'];
		$user=$_POST['user'];
		$univ_id=$_POST['univ_id'];
		if($action=='student')
		{
			$linqid=$_POST['linqid'];
			/////// delete linq to student tables ///////////
			$delete_linq="DELETE FROM `student_student_1` WHERE from_studid='".$user."' and to_studid='".$linqid."'";
			$dbObj->fireQuery($delete_linq,'delete');
			echo "You have successfully urlinqed";
		
		}
		elseif($action=='professor')
		{
			$linqid=$_POST['linqid'];
			/////// delete linq to student tables ///////////
			$delete_linq="DELETE FROM `student_professor_1` where from_studid='".$user."' and to_profid ='".$linqid."'";
			$dbObj->fireQuery($delete_linq,'delete');
			echo "You have successfully urlinqed";
			/// add notification about linq for another professor //////
		}
		elseif($action=='courses')
		{
			$course_id=$_POST['linqid'];
			//////////// enrolled in course //////////////////
			$delete_course="DELETE FROM `student_courses_1` WHERE `course_id` = '".$course_id."' and student_id='".$user."' and universityid ='".$univ_id."'";
			$dbObj->fireQuery($delete_course,'delete');
			echo "You have successfully droped course";
		}
		elseif($action=='clubs')
		{
			$groupid_id=$_POST['linqid'];
			$user=$_POST['user'];
			$groups_delete="DELETE FROM `groups_student_1` WHERE `groupid` = '".$groupid_id."' AND `studid` = '".$user."'";
			$dbObj->fireQuery($groups_delete,'delete');
			echo "You have successfully joined in club";
					
		}
	}
}
elseif(isset($_POST['whoislogin']) && $_POST['whoislogin']=='Professor')
{
	if(isset($_POST['user']) && $_POST['user']!='' && isset($_POST['action']) && $_POST['action']!='' )
	{
		
		$action=$_POST['action'];
		$user=$_POST['user'];
		$univ_id=$_POST['univ_id'];
		if($action=='student')
		{
			$linqid=$_POST['linqid'];
			/////// delete linq to student tables ///////////
			$delete_linq="DELETE FROM `professor_student_1` WHERE from_profid='".$user."' and to_studid	='".$linqid."'";
			$dbObj->fireQuery($delete_linq,'delete');
			echo "You have successfully urlinqed";
		
		}
		elseif($action=='professor')
		{
			$linqid=$_POST['linqid'];
			/////// delete linq to student tables ///////////
			$delete_linq="DELETE FROM `professor_professor_1` where from_profid='".$user."' and to_profid ='".$linqid."'";
			$dbObj->fireQuery($delete_linq,'delete');
			echo "You have successfully urlinqed";
			/// add notification about linq for another professor //////
		}
		elseif($action=='courses')
		{
			$course_id=$_POST['linqid'];
			//////////// enrolled in course //////////////////
			$delete_course="UPDATE course_1 set profid=' ' WHERE `cid` = '".$course_id."' and universityid ='".$univ_id."'";
			$dbObj->fireQuery($delete_course,'update');
			echo "You have successfully droped course";
		}
		elseif($action=='clubs')
		{
			$groupid_id=$_POST['linqid'];
			$user=$_POST['user'];
			$groups_delete="DELETE FROM `groups_professor_1` WHERE `groupid` = '".$groupid_id."' AND `profid` = '".$user."'";
			$dbObj->fireQuery($groups_delete,'delete');
			echo "You have successfully joined in club";
					
		}
	}
}
?>