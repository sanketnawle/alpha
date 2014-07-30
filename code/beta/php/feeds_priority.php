<?php
require_once 'includes/dbconnection.php';
require_once 'includes/common_functions.php';
require_once 'php/redirect.php';
require_once '../includes/follow.php';

function prioritize_posts($pg)
{
	GLOBAL $con;
	define("LIMIT", 20);
	define("COURSE_WEIGHT", 2);
	define("CONNECTIONS_WEIGHT", 0.5);
	define("PERSONAL_WEIGHT", 1.5);
	define("GROUP_WEIGHT", 1);
	define("UNIV_WEIGHT", 1);
	define("LIKE_WEIGHT", 0.1);
	
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else 
		$user_id = 1;
	
	$univ_id = isset($_SESSION['univ_id'])?$_SESSION['univ_id']:1;
	$dept_id = isset($_SESSION['dept_id'])?$_SESSION['dept_id']:3;
	$current_semester = get_current_semester($con,$univ_id);
	$result = $con->query("SELECT EXTRACT(YEAR FROM CURDATE()) AS `year`");
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$current_year = $row['year'];
	}
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	
	$posts_stmt = $con->prepare("SELECT distinct(posts.post_id), target_type, target_id
	  from posts
	  join posts_user_inv
	    on (posts.post_id = posts_user_inv.post_id)
	 where ((posts_user_inv.user_id IN (SELECT to_user_id from connect where from_user_id = ?)
		or posts_user_inv.user_id = ?)
	    or (target_type = 'university' and target_id = ?)
		or (target_type = 'department' and target_id = ?)
		or (target_type = 'class' and target_id IN (SELECT cu.class_id 
													  from courses_user cu join courses_semester cs 
														on (cu.class_id = cs.class_id) 
														where user_id = ? and cs.semester = ? and cs.`year` = ?)))
		order by last_activity DESC
		LIMIT ?,20");
	 $posts_stmt->bind_param("iissisii", $user_id, $user_id, $univ_id, $dept_id, $user_id, 
			$current_semester, $current_year,$start_record);
	 $posts_stmt->execute();
	 $posts_stmt->bind_result($post_id, $target_type, $target_id);
	 while($posts_stmt->fetch())
	 {
	 	$posts[] = array($post_id, $target_type, $target_id,'priority'=>0);
	 }
	$posts_stmt->close();
	$connection_stmt = $con->prepare("SELECT count(distinct(posts_user_inv.user_id))
										from posts_user_inv 
										join connect
										  on (posts_user_inv.user_id = connect.to_user_id)
									   where post_id = ?
										 and from_user_id = ?");
	$like_stmt = $con->prepare("SELECT count(*) from posts_likes where post_id = ?"); 
	
	foreach ($posts as $k=>$post)
	{
		if($post[1]=='course')
		{
			$posts[$k]['priority'] += COURSE_WEIGHT; 
		}
		else if($post[1] == 'university')
		{
			$posts[$k]['priority'] += UNIV_WEIGHT;
		}
		else if($post[1] == 'user' || $post[1] == null)
		{
			$posts[$k]['priority'] += PERSONAL_WEIGHT;
		}
		else if($post[1] == 'group')
		{
			$posts[$k]['priority'] += GROUP_WEIGHT;
		}
		$connection_stmt->bind_param("ii", $post[0], $user_id);
		$connection_stmt->execute();
		$connection_stmt->bind_result($count);
		if($connection_stmt->fetch())
		{
			$posts[$k]['priority'] += $count * CONNECTIONS_WEIGHT;
		}
		$connection_stmt->reset();
		
		$like_stmt->bind_param("i", $post[0]);
		$like_stmt->execute();
		$like_stmt->bind_result($lk_cnt);
		if($like_stmt->fetch())
		{
			$posts[$k]['priority'] += $lk_cnt * LIKE_WEIGHT;
		}
		$like_stmt->reset();
	}
	
	array_multisort(array_column($posts,'priority'), SORT_NUMERIC, SORT_DESC,$posts);
	return array_column($posts,0);
}

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


function get_class_posts($class_id, $pg)
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
	//print_r($scope);
	$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
	  from posts p
	  join posts_questions pq
	  on p.post_id = pq.post_id
	  where (p.target_type = 'course'
		and p.target_id = ?)
		 or (pq.tag_type = 'course'
		and pq.tag_id = ?)
		order by last_activity DESC
		LIMIT ?,?");
	$posts_stmt->bind_param("ssii", $class_id, $class_id, $start_record,$limit);
	$posts_stmt->execute();
	$posts_stmt->store_result();
	$posts_stmt->bind_result($post_id, $profile_id, $target_type, $target_id, $privacy);
	while($posts_stmt->fetch())
	{
		if(in_array($privacy, getScope($user_id,$profile_id)))
			$posts[] = $post_id;
	}
	$posts_stmt->free_result();
	$posts_stmt->close();
	return $posts;
}

function get_clubs_posts($group_id,$pg)
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
	//print_r($scope);
	$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
	  from posts p
	  join posts_questions pq
	  on p.post_id = pq.post_id
	  where (p.target_type = 'group'
		and p.target_id = ?)
		 or (pq.tag_type = 'group'
		and pq.tag_id = ?)
		order by last_activity DESC
		LIMIT ?,?");
	$posts_stmt->bind_param("iiii", $group_id, $group_id, $start_record,$limit);
	$posts_stmt->execute();
	$posts_stmt->store_result();
	$posts_stmt->bind_result($post_id, $profile_id, $target_type, $target_id, $privacy);
	while($posts_stmt->fetch())
	{
		if(in_array($privacy, getScope($user_id,$profile_id)))
			$posts[] = $post_id;
	}
	$posts_stmt->free_result();
	$posts_stmt->close();
	return $posts;
}

function get_school_posts($univ_id, $pg)
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
	//print_r($scope);
	$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
	  from posts p
	  join posts_questions pq
	  on p.post_id = pq.post_id
	  where (p.target_type = 'university'
		and p.target_id = ?)
		 or (pq.tag_type = 'university'
		and pq.tag_id = ?)
		order by last_activity DESC
		LIMIT ?,?");
	$posts_stmt->bind_param("iiii", $univ_id, $univ_id, $start_record,$limit);
	$posts_stmt->execute();
	$posts_stmt->store_result();
	$posts_stmt->bind_result($post_id, $profile_id, $target_type, $target_id, $privacy);
	while($posts_stmt->fetch())
	{
		if(in_array($privacy, getScope($user_id,$profile_id)))
			$posts[] = $post_id;
	}
	$posts_stmt->free_result();
	$posts_stmt->close();
	return $posts;
}