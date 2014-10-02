<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

require_once("dbconnection.php");

if(isset($_SESSION['user_id']))
	$user_id = $_SESSION['user_id'];

$is_admin = false;

if(isset($_POST['group_id'])){
		
	$group=$_POST['group_id'];

	$get_group_header_query = "SELECT count(*), is_admin FROM group_users WHERE group_id = ? and user_id = ?";
	$get_group_header_stmt = $con->prepare($get_group_header_query);
	if($get_group_header_stmt != null) {
	    $get_group_header_stmt->bind_param("ii",$group,$user_id); 
	    $get_group_header_stmt->execute();    
	    $get_group_header_stmt->bind_result($is_member, $is_admin); 
	    $get_group_header_stmt->fetch();  
	    $get_group_header_stmt->close();
	}
	
	if ($is_admin == "1")
	{
		if (isset($_POST['group_name']))
		{
			$get_group_header_query = "UPDATE groups SET group_name = ? WHERE group_id = ?";
			$get_group_header_stmt = $con->prepare($get_group_header_query);
			if($get_group_header_stmt != null) {		

			    $get_group_header_stmt->bind_param("si", $_POST['group_name'], $group); 
			    $get_group_header_stmt->execute();     		
			    
			    if ($get_group_header_stmt->affected_rows > 0)
			    {
			    	echo $_POST['group_name'];
			    }
			    else {
					echo "0";
			    }
			    $get_group_header_stmt->close();
			}
		}

		if (isset($_POST['group_desc']))
		{
			$get_group_header_query = "UPDATE groups SET group_desc = ? WHERE group_id = ?";
			$get_group_header_stmt = $con->prepare($get_group_header_query);
			if($get_group_header_stmt != null) {
			    $get_group_header_stmt->bind_param("si", $_POST['group_desc'], $group); 
			    $get_group_header_stmt->execute();     
			    if ($get_group_header_stmt->affected_rows > 0)
			    {
			    	echo $_POST['group_desc'];
			    }
			    $get_group_header_stmt->close();
			}
		}
	}
}

$con->close();

?>