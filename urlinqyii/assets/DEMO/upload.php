<?php
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_FILES["Image"]["name"]) && $_FILES["Image"]["name"]!='')
{
	$is_success =1;
	$error='';
	$success='';
	$file_name='';
	$file_description='';
	$visibility='';
	$university_id=$_POST['university_id'];
	$department_id=$_POST['department_id'];
	$fromwhere=$_POST['fromwhere'];
	if(isset($_POST['file_name']) && $_POST['file_name']!=''){
		$file_name=$_POST['file_name'];
	}
	if(isset($_POST['file_description']) && $_POST['file_description']!=''){
		$file_description=$_POST['file_description'];
	}
	if(isset($_POST['visibility']) && $_POST['visibility']!=''){
		$visibility=$_POST['visibility'];
	}
	if(isset($_FILES["Image"]["name"]) && $_FILES["Image"]["name"]!='')
	{
		if($is_success ==1 && isset($_FILES['Image']['name']))
		{
			if($is_success == 1 && $_FILES['Image']['name'] != "")
			{
				$is_success = validateuploadfile("Image");
			}
			if($is_success == 1 && $_FILES['Image']['name'] != "")
			{
				$is_success = isuploadfile("Image");
			}
		}
		if($is_success == 1  &&  isset($_FILES['Image']['name']) && $_FILES['Image']['name'] != "")
		{
			$orignalfilename=$_FILES['Image']['name'];
			$uploadedfilename = moveuploadedfile("Image",POSTSFILE_PATH);
			$ext=get_file_extension($uploadedfilename);
			if($uploadedfilename!='')
			{
				$student_id=0;
				$professor_id=0;
				if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
				{
					$student_id=$_SESSION['student_id'];
					$userdetail=getstudentdetail($student_id);
				}
				elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
				{
					$professor_id=$_SESSION['professor_id'];
					$userdetail=getprofessordetail($professor_id);
				}
				$message=$userdetail['name'].' uploaded a '.$ext.' file, <br />'.$orignalfilename.'';
			
				$update_timestamp=date("Y-m-d H:i:s");
				if(isset($fromwhere) && $fromwhere=='home')
				{
					$sql="INSERT INTO `home_posts` (`studentid`,`profid`,`univid`,`message`,`visibility`,`update_timestamp`,`file`,`filelocation`,`file_ext`,`file_name`,`file_description`) VALUES
					( ".$student_id.",".$professor_id.",".$university_id.", '".addslashes($message)."', '".$visibility."','".$update_timestamp."','".$orignalfilename."','".$uploadedfilename."','".$ext."','".$file_name."','".$file_description."');";
					$insert_id =$dbObj->fireQuery($sql,'insert');
				}
				elseif($department_id!=0 && $university_id!=0)
				{
					$sql="INSERT INTO `department_posts_1` (`studentid`,`profid`,`deptid`,`univid`,`message`,`visibility`,`update_timestamp`,`file`,`filelocation`,`file_ext`,`file_name`,`file_description`) VALUES
					( ".$student_id.",".$professor_id.",".$department_id.",".$university_id.", '".addslashes($message)."', '".$visibility."','".$update_timestamp."','".$orignalfilename."','".$uploadedfilename."','".$ext."','".$file_name."','".$file_description."');";
					$insert_id =$dbObj->fireQuery($sql,'insert');
				}
				elseif($university_id!=0)
				{
					$sql="INSERT INTO `university_posts_1` (`studentid`,`profid`,`univid`,`message`,`visibility`,`update_timestamp`,`file`,`filelocation`,`file_ext`,`file_name`,`file_description`) VALUES
					( ".$student_id.",".$professor_id.",".$university_id.", '".addslashes($message)."', '".$visibility."','".$update_timestamp."','".$orignalfilename."','".$uploadedfilename."','".$ext."','".$file_name."','".$file_description."');";
					$insert_id =$dbObj->fireQuery($sql,'insert');
				}
				$success = 'File uploaded successfully.';
				
		}
			
	}
	}
	if(isset($_SESSION['errormsg']) && $_SESSION['errormsg']!='')
	{
		$error=$_SESSION['errormsg'];
		unset($_SESSION['errormsg']);
	}
	if($error!='')
	{
		 echo "0|||".$error;
	}
	elseif($success!='')
	{
		 echo "1|||".$success;
		 
	}
}
die;
?>