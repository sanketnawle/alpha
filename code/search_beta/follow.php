<?php
include_once 'includefiles.php';
function get_connected_users($from_user)
{
	global $con;
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
	global $con;
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
	return false;
	$connect_stmt->close();
}

function followUnfollow($from_user, $to_user)
{
	if($from_user == $to_user)
		return;
	global $con;
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

function scope($from_user,$to_user)
{
	if($from_user == $to_user)
		return array("student","faculty", "campus", "connections");
	global $con;
	$connect_stmt = $con->prepare("Select u.user_id, u.user_type, u.univ_id, un.parent_univ_id 
									 from user u JOIN university un
									where u.user_id IN (?,?)");
	$connect_stmt->bind_param("ii",$from_user, $to_user);
	$connect_stmt->execute();
	$connect_stmt->bind_result($user_id, $type, $univ_id, $parent_id);
	$uarray = array(); $scope;
	while($connect_stmt->fetch())
	{
		$uarray[$user_id] = array('univ_id'=>$univ_id, 'type'=>$type, 'parent'=>$parent_id);
	}
	if($uarray[$from_user]['parent'] == $uarray[$to_user]['parent'])
	{
		 if($uarray[$from_user]['type'] == $uarray[$to_user]['type']
		 && $uarray[$from_user]['type'] == 's')
		 {
		 	$scope[] = "student";
		 }
		 elseif($uarray[$to_user]['type'] == 'p')
		 {
		 	$scope[] = "faculty";
		 }
		 elseif($uarray[$from_user]['univ_id'] == $uarray[$to_user]['univ_id'])
		 {
		 	$scope[] = "campus";
		 }
	}
	if(isFollowing($from_user, $to_user))
		$scope[] = "connections";
	
	return $scope;
}
