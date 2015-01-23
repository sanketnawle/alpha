<?php
require_once 'dbconnection.php';
require_once '../includes/common_functions.php';
require_once '../includes/follow.php';
//require_once 'redirect.php';

function get_profile_posts($profile_id, $pg)
{
	GLOBAL $con;
	define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else 
		$user_id = 1;
	
	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	$scope = getScope($user_id,$profile_id);
	//print_r($scope);
	$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.target_type, p.target_id,p.privacy
	  from posts p
	  join posts_questions pq
	  on p.post_id = pq.post_id
	  where p.user_id = ?
		 or (p.target_type = 'user'
		and p.target_id = ?)
		 or (pq.tag_type = 'user'
		and pq.tag_id = ?)
		order by last_activity DESC
		LIMIT ?,?");
	 $posts_stmt->bind_param("iiiii", $profile_id, $profile_id, $profile_id, $start_record,$limit);
	 $posts_stmt->execute();
	 $posts_stmt->bind_result($post_id, $target_type, $target_id, $privacy);
	 while($posts_stmt->fetch())
	 {
		//echo $post_id;
		if(in_array($privacy, $scope))
			$posts[] = $post_id;
	 }
	$posts_stmt->close();
	return $posts;
}