<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
require_once("dbconnection.php");
include_once("../includes/follow.php");
include_once("../includes/common_functions.php");

if(isset($_SESSION['user_id']))
	$user_id = $_SESSION['user_id'];

$admin_array = array();
$user_array = array();
$is_admin = false;

if(isset($_POST['group_id'])){
		
	$group=$_POST['group_id'];

	$get_group_mem_query = "SELECT gu.user_id, gu.is_admin, u.firstname, u.lastname, u.user_type, u.univ_id, 
								   un.univ_name
							  FROM group_users gu JOIN user u
								ON (gu.user_id = u.user_id)
							  JOIN university un
								ON (u.univ_id = un.univ_id)
							 WHERE gu.group_id = ?";
	
	$get_mem_stmt = $con->prepare($get_group_mem_query);
	if($get_mem_stmt)
	{
		$get_mem_stmt->bind_param("i",$group);
		$get_mem_stmt->execute();
		$get_mem_stmt->bind_result($g_user_id, $g_is_admin, $g_firstname, $g_lastname, $g_user_type,
				$g_univ_id, $g_univ_name);
		while($get_mem_stmt->fetch())
		{			
			if($g_is_admin)
			{
				$admin_array[]=array('user_id'=>$g_user_id, 'is_admin'=>$g_is_admin, 'firstname'=>$g_firstname,
						'lastname'=>$g_lastname, 'type'=>$g_user_type, 'univ_id'=>$g_univ_id,
						'univ_name'=>$g_univ_name);
				if ($user_id == $g_user_id){
					$is_admin = true;
				}
			}
			else
			{
				$user_array[]=array('user_id'=>$g_user_id, 'is_admin'=>$g_is_admin, 'firstname'=>$g_firstname,
						'lastname'=>$g_lastname, 'type'=>$g_user_type, 'univ_id'=>$g_univ_id,
						'univ_name'=>$g_univ_name);
			}
		}
		$get_mem_stmt->close();
	}
}
if(isset($_POST['class_id'])){
	$class=$_POST['class_id'];

	$get_class_mem_query = "SELECT cu.user_id, cu.is_admin, u.firstname, u.lastname, u.user_type, u.univ_id,
								   un.univ_name
							  FROM courses_user cu JOIN user u
								ON (cu.user_id = u.user_id)
							  JOIN university un
								ON (u.univ_id = un.univ_id)
							 WHERE cu.class_id = ?";

	$get_mem_stmt = $con->prepare($get_class_mem_query);
	if($get_mem_stmt)
	{
		$get_mem_stmt->bind_param("i",$group);
		$get_mem_stmt->execute();
		$get_mem_stmt->bind_result($g_user_id, $g_is_admin, $g_firstname, $g_lastname, $g_user_type,
				$g_univ_id, $g_univ_name);
		while($get_mem_stmt->fetch())
		{
			if($g_is_admin)
			{
				$admin_array[]=array('user_id'=>$g_user_id, 'is_admin'=>$g_is_admin, 'firstname'=>$g_firstname,
						'lastname'=>$g_lastname, 'type'=>$g_user_type, 'univ_id'=>$g_univ_id,
						'univ_name'=>$g_univ_name);
			}
			else
			{
				$user_array[]=array('user_id'=>$g_user_id, 'is_admin'=>$g_is_admin, 'firstname'=>$g_firstname,
						'lastname'=>$g_lastname, 'type'=>$g_user_type, 'univ_id'=>$g_univ_id,
						'univ_name'=>$g_univ_name);
			}
		}
		$get_mem_stmt->close();
	}
}
if(isset($_POST['univ_id'])){
	$univ_id=$_POST['univ_id'];
	$get_univ_mem_query = "SELECT u.user_id, u.firstname, u.lastname, u.user_type, u.univ_id,
								   un.univ_name
							  FROM user u JOIN university un
								ON (u.univ_id = un.univ_id)
							 WHERE u.univ_id = ?";

	$get_mem_stmt = $con->prepare($get_univ_mem_query);
	if($get_mem_stmt)
	{
		$get_mem_stmt->bind_param("i",$group);
		$get_mem_stmt->execute();
		$get_mem_stmt->bind_result($g_user_id, $g_firstname, $g_lastname, $g_user_type,
				$g_univ_id, $g_univ_name);
		while($get_mem_stmt->fetch())
		{
			if($g_user_type == 'p')
			{
				$admin_array[]=array('user_id'=>$g_user_id, 'is_admin'=>$g_is_admin, 'firstname'=>$g_firstname,
						'lastname'=>$g_lastname, 'type'=>$g_user_type, 'univ_id'=>$g_univ_id,
						'univ_name'=>$g_univ_name);
			}
			else
			{
				$user_array[]=array('user_id'=>$g_user_id, 'is_admin'=>$g_is_admin, 'firstname'=>$g_firstname,
						'lastname'=>$g_lastname, 'type'=>$g_user_type, 'univ_id'=>$g_univ_id,
						'univ_name'=>$g_univ_name);
			}
		}
		$get_mem_stmt->close();
	}
}
	
	foreach ($admin_array as &$row)
	{
		$row['dp_link'] = get_user_dp($con, $row['user_id']);
		$row['follow'] = isFollowing($user_id, $row['user_id'])?"true":"false";
		$row['interest'] = FetchUserInterests($row['user_id']);		
	}
	foreach ($user_array as &$row)
	{
		$row['dp_link'] = get_user_dp($con, $row['user_id']);
		$row['follow'] = isFollowing($user_id, $row['user_id'])?"true":"false";
		$row['interest'] = FetchUserInterests($row['user_id']);		
	}
$con->close();

include 'club_members_tab.php';