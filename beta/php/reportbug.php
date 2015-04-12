<?php
include "redirect.php";
include_once("dbconnection.php");
include_once("../includes/common_functions.php");
require_once('time_change.php');
if(isset($_POST['bug_report'])&& $_POST['bug_report'] != "")
{
	$string = input_sanitize($_POST['bug_report'],$con);
	$ins_stmt = $con->prepare("INSERT INTO bug_report (user_id, bug_description) VALUES (?,?)");
	if($ins_stmt)
	{
		$ins_stmt->bind_param("is", $_SESSION['user_id'], $string);
		$ins_stmt->execute();
		if($ins_stmt->affected_rows > 0)
		{
			echo "Success";
		}
		else
		{
			die("We are facing some Issues!! How Ironic :)");
		}
	}
	else
	{
		exit("We are facing some issues!! How Ironic :)");
	}
}
?>