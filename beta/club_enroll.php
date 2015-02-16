<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/25/14
 * Time: 10:56 AM
 */

//database connection file
require_once 'dbconnection.php';
session_start();

if(isset($_POST['admin']))
{
	if (isset($_SESSION['user_id'])) {
	    $user_id = $_POST['user_id'];
	}
	if (isset($_POST['group_id'])) {
	    $group_id = $_POST['group_id'];
	}
	updateAdmin($user_id, $group_id);
}
elseif(isset($_POST['delete']))
{
	if (isset($_POST['user_id'])) {
		$user_id = $_POST['user_id'];
	}
	if (isset($_POST['group_id'])) {
		$group_id = $_POST['group_id'];
	}
	enrollWithdraw($group_id, $user_id);
}
else
{
	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}
	if (isset($_POST['group_id'])) {
		$group_id = $_POST['group_id'];
	}
	enrollWithdraw($group_id, $user_id);
}


function enrollWithdraw($group_id, $user_id)
{
	GLOBAL $con;
    $get_enroll_query = "SELECT COUNT(GU.user_id) as total FROM group_users GU
     WHERE GU.group_id = ? AND GU.user_id = ?";
    $enroll_stmt = $con->prepare($get_enroll_query);
    if($enroll_stmt)
    {
    	$enroll_stmt->bind_param('ii', $group_id, $user_id);
    	$enroll_stmt->execute();
    	$enroll_stmt->bind_result($total);
    	$enroll_stmt->fetch();
    	$enroll_stmt->close();
    }
    
    if ($total == 0) {
        $enroll_stmt = $con->prepare("INSERT INTO group_users (group_id,user_id,is_admin,color_id) 
        							  VALUES (?,?,?,?)");
        $admin = 0;
        $color_id = rand(3,12);
        if($enroll_stmt)
        {
        	$enroll_stmt->bind_param('iiii', $group_id, $user_id,$admin, $color_id);
        	$enroll_stmt->execute();
        	$enroll_stmt->close();
        }
      } 
      else 
      {
        $remove_user_query = $con->prepare("DELETE FROM group_users WHERE group_id = ? AND user_id = ?");
        if($remove_user_query)
        {
        	$remove_user_query->bind_param('ii', $group_id, $user_id);
        	$remove_user_query->execute();
        	$remove_user_query->close();
        }
    }
}

function updateAdmin($user_id, $group_id)
{
	GLOBAL $con;
	$get_enroll_query = "SELECT is_admin FROM group_users GU 
			WHERE GU.group_id = ? AND GU.user_id = ?";
	$enroll_stmt = $con->prepare($get_enroll_query);
	if($enroll_stmt)
	{
		$enroll_stmt->bind_param('ii', $group_id, $_SESSION['user_id']);
		$enroll_stmt->execute();
		$enroll_stmt->bind_result($is_admin);
		$enroll_stmt->fetch();
		$enroll_stmt->reset();
		//return false if the function is called by a non-admin.
		if(!$is_admin)
			return false;
		else
		{
			//check if the user is an admin  
			$enroll_stmt->bind_param('ii', $group_id, $user_id);
			$enroll_stmt->execute();
			$enroll_stmt->bind_result($is_admin);
			$enroll_stmt->fetch();
			$enroll_stmt->reset();
			if($is_admin)
			{
				//only demote the user to a normal member if there is more than one admin
				$check_admin_count = $con->prepare("SELECT count(*) from group_users where is_admin = 1 
						and group_id = ?");
				$check_admin_count->bind_param("i", $group_id);
				$check_admin_count->execute();
				$check_admin_count->bind_result($admin_count);
				$check_admin_count->fetch();
				$check_admin_count->close();
				if($admin_count>1)
				{
					//kick the admin down the influence ladder
					$update_admin = $con->prepare("UPDATE group_users SET is_admin = 0 
						WHERE group_id = ? AND user_id = ?");
					$update_admin->bind_param('ii', $group_id, $user_id);
					$update_admin->execute();
					$update_admin->close();
				}
			}
			else 
			{
				//this guy sucked up to be raised to this position
				$update_admin = $con->prepare("UPDATE group_users SET is_admin = 1
						WHERE user_id = ? AND group_id = ?");
				$update_admin->bind_param('ii', $user_id, $group_id);
				$update_admin->execute();
				$update_admin->close();
			}
		}
		$enroll_stmt->close();
	}
}	
?>