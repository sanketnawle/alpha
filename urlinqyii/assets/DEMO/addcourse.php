<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Urlinq - Course</title>
<link href="css/popup.css" rel="stylesheet" type="text/css"/> 
</head>
<?php 
if(isset($_SESSION["POSTDATA"]))
{
	$_REQUEST = unserialize($_SESSION["POSTDATA"]);	
}
$course_title = "";
$course_desc = "";
$course_img="";
$department_name = "";
$professors_name = "";
$professors_img="";
extract($_REQUEST,EXTR_IF_EXISTS);	
if(isset($_POST['btnsubmit']))
{
	$is_success = 1;
	$course_title=addslashes($_POST['course_title']);
	$course_desc=addslashes($_POST['course_desc']);
	$department_name=addslashes($_POST['department_name']);
	$professors_name=addslashes($_POST['professors_name']);
	if($course_title==''){$is_success = 0;$_SESSION["errormsg"] = "Please enter course name.";}
	if($is_success == 1 && $course_desc==''){$is_success = 0;$_SESSION["errormsg"] = "Please enter course description.";}
	if($is_success == 1 && $_FILES['course_img']['name'] == "")
	{
		$is_success =0;
		$_SESSION["errormsg"] = "Please upload course image.";
	}
	if($is_success == 1 && $department_name==''){$is_success = 0;$_SESSION["errormsg"] = "Please enter department name.";}
	if($is_success == 1 && $professors_name==''){$is_success = 0;$_SESSION["errormsg"] = "Please enter professors name.";}
	if($is_success == 1 && $_FILES['professors_img']['name'] == "")
	{
		$is_success =0;
		$_SESSION["errormsg"] = "Please upload professor image.";
	}
	
	if($is_success == 1 && $_FILES['course_img']['name'] != "")
	{
		$is_success = validateuploadfile("course_img");
		if($is_success == 0)
		{
			$_SESSION["errormsg"] = "Please upload course image.";
		}
	}
	if($is_success == 1 && $_FILES['course_img']['name'] != "")
	{
		$is_success = isuploadimagefile("course_img");
		if($is_success == 0)
		{
			$_SESSION["errormsg"] = "Please provide valid image file. Supported images are GIF,PNG,JPG,JPEG";
		}
	}
	if($is_success == 1  &&  isset($_FILES['course_img']['name']) && $_FILES['course_img']['name'] != "")
	{
			$uploadedcoursefilename = moveuploadedfile("course_img",COURSE_PATH);
			if($uploadedcoursefilename == 0)
			{
				$is_success = 0;
			}
			
	}
	if($is_success == 1 && $_FILES['professors_img']['name'] != "")
	{
		$is_success = validateuploadfile("professors_img");
		if($is_success == 0)
		{
			$_SESSION["errormsg"] = "Please upload professor image.";
		}
	}
	if($is_success == 1 && $_FILES['professors_img']['name'] != "")
	{
		$is_success = isuploadimagefile("professors_img");
		if($is_success == 0)
		{
			$_SESSION["errormsg"] = "Please provide valid image file. Supported images are GIF,PNG,JPG,JPEG";
		}
	}
	if($is_success == 1  &&  isset($_FILES['professors_img']['name']) && $_FILES['professors_img']['name'] != "")
	{
			$uploadedprofessorfilename = moveuploadedfile("professors_img",PROFESSOR_PATH);
			if($uploadedprofessorfilename == 0)
			{
				$is_success = 0;
			}
			
	}
	if($is_success==1)
	{
		$insert_course_query="INSERT INTO `courses` (`course_title`,`course_desc`,`course_img`,`department_name`,`professors_name`,`professors_img`,`createdon`) 
		VALUES ('".$course_title."','".$course_desc."','".$uploadedcoursefilename."','".$department_name."','".$professors_name."','".$uploadedprofessorfilename."',NOW());";
		$courseId=$dbObj->fireQuery($insert_course_query,"insert");
		$_SESSION["successmsg"] = "Course saved successfully.";
		?>
		<script language="javascript" type="text/javascript">
		 top.frames.location.reload(false);
		</script>
		<?php
	}
}
$errormsg = getErrorMessage();
$succesmsg = getSuccessMessage();
?>
<body>

<form name="frmaddedit" id="contactForm" method="post" action="<?php echo $SITE_URL; ?>addcourse.php" enctype="multipart/form-data">
<h2>Add Course</h2>
<div class="clear"></div>
<div class="container01">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="error_msg01">
		<?php echo displayErrorMessage(); ?>
		<?php echo displaySuccessMessage(); ?>
        </td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
			    <tr>
					<td align="right">Course Name :</td>
					<td align="left"><input type="text" placeholder="Please enter course name" required="required" name="course_title" id="course_title" value="<?php echo $course_title; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right" valign="top">Course Description :</td>
					<td align="left">
					<textarea name="course_desc" id="course_desc" placeholder="Please enter course description" required="required" rows="10" cols="50" style="width:100%;"><?php echo $course_desc; ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="right" valign="top">Course Image :</td>
					<td align="left">
					<input type="file" name="course_img" id="course_img" placeholder="Please upload image" required="required"/>
					</td>
				</tr>
				<tr>
					<td align="right">Department Name :</td>
					<td align="left"><input type="text" placeholder="Please enter department name" required="required" name="department_name" id="department_name" value="<?php echo $department_name; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">Professor Name :</td>
					<td align="left"><input type="text" placeholder="Please enter professor name" required="required" name="professors_name" id="professors_name" value="<?php echo $professors_name; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right" valign="top">Professor Image :
					</td>
					<td align="left">
					<input type="file" placeholder="Please upload image" required="required" name="professors_img" id="professors_img"/>&nbsp;
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
					<div id="formButtons">
					<input type="submit" class="btn_submit" name="btnsubmit" id="btnsubmit" value="Save" />
					<input type="reset" id="cancel" name="cancel" value="Cancel" onclick="Javascript: parent.$.fn.colorbox.close()" />
					</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
<div class="clear"></div>
</form>
</body>
</html>
