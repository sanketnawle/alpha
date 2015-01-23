<?php 
if(isset($_POST))
{
	if(isset($_POST['action']) && $_POST['action']!='')
	{
		$action=$_POST['action'];
		$university_id=$_POST['university_id'];
		$student_id=$_POST['student_id'];
		$professor_id=$_POST['professor_id'];
		if($action=='student')
		{
			$_SESSION['usertype']='Student';
			$_SESSION['student_id']=$student_id;
			header("Location:index.php?pg=home&univid=".$university_id);
			exit;
		}
		elseif($action=='professor')
		{
			$_SESSION['usertype']='Professor';
			$_SESSION['professor_id']=$professor_id;
			header("Location:index.php?pg=home&univid=".$university_id);
			exit;
		}
		else
		{
			unset($_SESSION['usertype']);
			unset($_SESSION['student_id']);
			unset($_SESSION['professor_id']);
			header("Location:index.php?pg=university&univid=".$university_id);
			exit;
		}
		
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Urlinq</title>
<script language="javascript" type="text/javascript">
function actionlogin(action,userid)
{
	document.getElementById('action').value=action;
	if(action=='student')
	{
		document.getElementById('student_id').value=userid;
	}
	else if(action=='professor')
	{
		document.getElementById('professor_id').value=userid;
	}
	document.frmlogin.submit();
}
</script>
</head>
<body>

<form action="" method="post" name="frmlogin" id="frmlogin" >
<input type="hidden" name="university_id" id="university_id" value="1" />
<input type="hidden" name="student_id" id="student_id" value="1" />
<input type="hidden" name="professor_id" id="professor_id" value="1" />
<input type="hidden" name="action" id="action" value="" />
Please click on the any below button to login into system.
<br />
<div style="float:left;width:100px;">
<a href="Javascript:void(0);" onClick="actionlogin('student',1);" >Ross</a><br />
<a href="Javascript:void(0);" onClick="actionlogin('student',2);" >Jake</a><br />
<a href="Javascript:void(0);" onClick="actionlogin('student',3);" >Shaleen</a><br />
<a href="Javascript:void(0);" onClick="actionlogin('student',4);" >Kuan</a><br />
<a href="Javascript:void(0);" onClick="actionlogin('student',5);" >Jing</a><br />
</div>
<div style="float:left;width:150px;">
<a href="Javascript:void(0);" onClick="actionlogin('professor',1);" >Lorcan M. Folan</a><br />
<a href="Javascript:void(0);" onClick="actionlogin('professor',2);" >Deshane Lyew</a><br />
<a href="Javascript:void(0);" onClick="actionlogin('professor',3);" >Naresh  Shakya</a>
</div>
<a href="Javascript:void(0);" onClick="actionlogin('noone');" >Without Login </a>
</form>
</body>
</html>
