<?php

include 'common_functions.php';

function get_connected_users($from_user)
{
	GLOBAL $con;
	$connect_stmt = $con->prepare("Select to_user_id from connect where from_user_id = ?");
	$connect_stmt->bind_param("i",$from_user);
	$connect_stmt->execute();
	$connect_stmt->bind_result($toid);
	$to_id_array = array();
	while($connect_stmt->fetch())
	{
		$to_id_array[] = $toid;
	}
	$connect_stmt->close();
	return $to_id_array;
}
function isFollowing($from_user, $to_user)
{
	GLOBAL $con;
	$connect_stmt = $con->prepare("Select to_user_id from connect where from_user_id = ? and to_user_id = ?");
	$connect_stmt->bind_param("ii",$from_user, $to_user);
	$connect_stmt->execute();
	$connect_stmt->bind_result($toid);
	if($connect_stmt->fetch()
	&& $toid != null)
	{
		$connect_stmt->close();
		return true;
	}
	$connect_stmt->close();
	return false;
}

function followUnfollow($from_user, $to_user)
{
	GLOBAL $con;
	if($from_user == $to_user)
		return;
	$connect_stmt = $con->prepare("Select count(*) from connect where from_user_id = ? and to_user_id = ?");
	$connect_stmt->bind_param("ii",$from_user, $to_user);
	$connect_stmt->execute();
	$connect_stmt->bind_result($count);
	$connect_stmt->fetch();
	$connect_stmt->close();
	if($count == 0)
	{
		$connect_stmt = $con->prepare("Insert into connect (from_user_id, to_user_id) VALUES (?,?)");
		$connect_stmt->bind_param("ii",$from_user, $to_user);
		$connect_stmt->execute();
		if($connect_stmt->affected_rows == 1)
		{
			$connect_stmt->close();
			return "Followed";
		}
	}
	else {
		$connect_stmt = $con->prepare("DELETE FROM CONNECT where from_user_id = ? and to_user_id = ?");
		$connect_stmt->bind_param("ii",$from_user, $to_user);
		$connect_stmt->execute();
		if($connect_stmt->affected_rows == 1)
		{
			$connect_stmt->close();
			return "Unfollowed";
		}
	}
	return;
}

function getScope($from_user,$to_user)
{
	GLOBAL $con;
	$connect_stmt = $con->prepare("Select to_user_id from connect where from_user_id = ? and to_user_id = ?");
	if($from_user == $to_user)
		return array("student","faculty", "campus", "connections");
	$connect_stmt = $con->prepare("Select u.user_id, u.user_type, u.univ_id, un.parent_univ_id 
									 from user u JOIN university un
									   on u.univ_id = un.univ_id
									where u.user_id IN (?,?)");
									
	$connect_stmt->bind_param("ii",$from_user, $to_user);
	$connect_stmt->execute();
	$connect_stmt->bind_result($user_id, $type, $univ_id, $parent_id);
	$uarray = array(); $scope;
	while($connect_stmt->fetch())
	{
		$uarray[$user_id] = array('univ_id'=>$univ_id, 'type'=>$type, 'parent'=>$parent_id);
	}
	$connect_stmt->close();
	if($uarray[$from_user]['parent'] == $uarray[$to_user]['parent'])
	{
		 if($uarray[$from_user]['type'] == $uarray[$to_user]['type']
		 && $uarray[$from_user]['type'] == 's')
		 {
		 	$scope[] = "student";
		 }
		 if($uarray[$to_user]['type'] == 'p')
		 {
		 	$scope[] = "faculty";
		 }
		 if($uarray[$from_user]['univ_id'] == $uarray[$to_user]['univ_id'])
		 {
		 	$scope[] = "campus";
		 }
	}
	if(isFollowing($from_user, $to_user))
		$scope[] = "connections";
	
	return $scope;
}

function myFollowers($user)
{
	GLOBAL $con;
	$connect_stmt = $con->prepare("Select u.user_id, u.user_type, u.firstname, u.lastname, u.dp_flag, u.dp_link, u.dp_blob, un.univ_name
		from connect c, user u, university un where c.to_user_id = ? and c.from_user_id = u.user_id and un.univ_id = u.univ_id and u.status = 'active'");
	$connect_stmt->bind_param("i",$user);
	$connect_stmt->execute();
	$connect_stmt->store_result();
	$connect_stmt->bind_result($user_id, $type, $firstname, $lastname, $dp_flag, $dp_link, $dp_blob, $univ_name);
	$uarray = array(); 
	while($connect_stmt->fetch())
	{
		$dp_link1 = get_user_dp($con, $user_id);
		$is_following = isFollowing($user, $user_id);	
		$uarray[] = array('user_id'=>$user_id, 'type'=>$type, 'firstname'=>$firstname, 'lastname'=>$lastname, 'dp_flag'=>$dp_flag, 'dp_link'=>$dp_link1, 'dp_blob'=>$dp_blob, 'univ_name'=>$univ_name, 'is_following'=>$is_following);
	}
	$connect_stmt->free_result();
	$connect_stmt->close();	
	
	return $uarray;
}

function meFollowing($user)
{
	GLOBAL $con;
	$connect_stmt = $con->prepare("Select u.user_id, u.user_type, u.firstname, u.lastname, u.dp_flag, u.dp_link, u.dp_blob, un.univ_name
		from connect c, user u, university un where c.from_user_id = ? and c.to_user_id = u.user_id and un.univ_id = u.univ_id and u.status = 'active'");
	$connect_stmt->bind_param("i",$user);
	$connect_stmt->execute();
	$connect_stmt->store_result();
	$connect_stmt->bind_result($user_id, $type, $firstname, $lastname, $dp_flag, $dp_link, $dp_blob, $univ_name);
	$uarray = array(); 
	while($connect_stmt->fetch())
	{
		$dp_link1 = get_user_dp($con, $user_id);	
		$is_following = true;	
		$uarray[] = array('user_id'=>$user_id, 'type'=>$type, 'firstname'=>$firstname, 'lastname'=>$lastname, 'dp_flag'=>$dp_flag, 'dp_link'=>$dp_link1, 'dp_blob'=>$dp_blob, 'univ_name'=>$univ_name, 'is_following'=>$is_following);
	}
	$connect_stmt->free_result();
	$connect_stmt->close();	
	
	return $uarray;
}