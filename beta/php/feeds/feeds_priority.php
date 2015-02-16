<?php
// require_once '../dbconnection.php';
// require_once '../../includes/common_functions.php';
// require_once '../../includes/follow.php';

require_once 'includes/common_functions.php';
// require_once '../redirect.php';
require_once 'includes/follow.php';

define("LIMIT", 20);
define("COURSE_WEIGHT", 0.2);
define("CONNECTIONS_WEIGHT", 0.05);
define("PERSONAL_WEIGHT", 0.15);
define("GROUP_WEIGHT", 0.1);
define("UNIV_WEIGHT", 0.1);
define("LIKE_WEIGHT", 0.01);
	
// $_POST['last_time'] = "1499690304";

// if(isset($_POST['last_time'])) $last_time = date("Y-m-d H:i:s",$_POST['last_time']);

function prioritize_posts($pg,$isLatest=FALSE,$last_time=NULL,$time=NULL){
	GLOBAL $con;
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else 
		$user_id = 47;
		
	$univ_id = isset($_SESSION['univ_id'])?$_SESSION['univ_id']:1;
	$dept_id = isset($_SESSION['dept_id'])?$_SESSION['dept_id']:1;
	$current_semester = get_current_semester($con,$univ_id);
	$result = $con->query("SELECT EXTRACT(YEAR FROM CURDATE()) AS `year`");
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		$current_year = $row['year'];
	}
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	if(!$isLatest)
	{
		if($start_record == 0)
		{
			$posts_stmt = $con->prepare("SELECT distinct(posts.post_id), posts.user_id, privacy, target_type, target_id
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
		}
		else
		{
			$posts_stmt = $con->prepare("SELECT distinct(posts.post_id), posts.user_id, privacy, target_type, target_id
						  FROM posts JOIN posts_user_inv
							ON (posts.post_id = posts_user_inv.post_id)
						 WHERE posts.last_activity < '".$last_time."'
						   AND ((posts_user_inv.user_id IN (SELECT to_user_id from connect where from_user_id = ?)
							OR posts_user_inv.user_id = ?)
							OR (target_type = 'university' and target_id = ?)
							OR (target_type = 'department' and target_id = ?)
							OR (target_type = 'class' and target_id IN (SELECT cu.class_id 
							  from courses_user cu join courses_semester cs 
								on (cu.class_id = cs.class_id) 
								where user_id = ? and cs.semester = ? and cs.`year` = ?)))
							ORDER BY last_activity DESC
							LIMIT ?,20");
		}
	}
	else
	{
		$posts_stmt = $con->prepare("SELECT distinct(posts.post_id), posts.user_id, privacy, target_type, target_id
		  from posts
		  join posts_user_inv
			on (posts.post_id = posts_user_inv.post_id)
		 where posts.`update_timestamp` >= '".$time."'
		   and ((posts_user_inv.user_id IN (SELECT to_user_id from connect where from_user_id = ?)
			or posts_user_inv.user_id = ?)
			or (target_type = 'university' and target_id = ?)
			or (target_type = 'department' and target_id = ?)
			or (target_type = 'class' and target_id IN (SELECT cu.class_id 
														  from courses_user cu join courses_semester cs 
															on (cu.class_id = cs.class_id) 
															where user_id = ? and cs.semester = ? and cs.`year` = ?)))
			order by last_activity DESC
			LIMIT ?,20");
	}
	 $posts_stmt->bind_param("iissisii", $user_id, $user_id, $univ_id, $dept_id, $user_id, 
			$current_semester, $current_year,$start_record);
	 $posts_stmt->execute();
	 $posts_stmt->bind_result($post_id, $profile_id, $privacy, $target_type, $target_id);
	 while($posts_stmt->fetch())
	 {
	 	$posts[] = array($post_id, $target_type, $target_id,'privacy'=>$privacy,'profile_id'=>$profile_id ,'priority'=>0);
	 }
	$posts_stmt->close();
	if(!$isLatest && is_array($posts) && count($posts)>0)
	{
		$_SESSION['po'] = min(array_column($posts,0));
		
		// $connection_stmt = $con->prepare("SELECT count(distinct(posts_user_inv.user_id))
											// from posts_user_inv 
											// join connect
											  // on (posts_user_inv.user_id = connect.to_user_id)
										   // where post_id = ?
											 // and from_user_id = ?");
											 
		// $like_stmt = $con->prepare("SELECT count(*) from posts_likes where post_id = ?"); 
		
		// foreach ($posts as $k=>$post)
		// {
			// $scope = getScope($user_id,$post['profile_id']);
			// if(!in_array($post['privacy'], $scope))
				// continue;
			// if($post[1]=='course')
			// {
				// $posts[$k]['priority'] += COURSE_WEIGHT; 
			// }
			// else if($post[1] == 'university')
			// {
				// $posts[$k]['priority'] += UNIV_WEIGHT;
			// }
			// else if($post[1] == 'user' || $post[1] == null)
			// {
				// $posts[$k]['priority'] += PERSONAL_WEIGHT;
			// }
			// else if($post[1] == 'group')
			// {
				// $posts[$k]['priority'] += GROUP_WEIGHT;
			// }
			// $connection_stmt->bind_param("ii", $post[0], $user_id);
			// $connection_stmt->execute();
			// $connection_stmt->bind_result($count);
			// if($connection_stmt->fetch())
			// {
				// $posts[$k]['priority'] += $count * CONNECTIONS_WEIGHT;
			// }
			// $connection_stmt->reset();
			
			// $like_stmt->bind_param("i", $post[0]);
			// $like_stmt->execute();
			// $like_stmt->bind_result($lk_cnt);
			// if($like_stmt->fetch())
			// {
				// $posts[$k]['priority'] += $lk_cnt * LIKE_WEIGHT;
			// }
			// $like_stmt->reset();
		// }
		
		//array_multisort(array_column($posts,'priority'), SORT_NUMERIC, $posts);
	}
	return array_column($posts,0);
}

function get_profile_posts($profile_id, $pg, $last_time=NULL){
	GLOBAL $con;
	//define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else
		$user_id = 1;

	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	$scope = getScope($user_id,$profile_id);
	//print_r($scope);
	if($start_record == 0){
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.target_type, p.target_id,p.privacy
				  from posts p LEFT JOIN posts_questions pq
				  ON p.post_id = pq.post_id
				  where p.user_id = ?
				  OR (p.target_type = 'user' and p.target_id = ?)
					OR (pq.tag_type = 'user' and pq.tag_id = ?)
					ORDER BY last_activity DESC	LIMIT ?,?");
	}
	else{
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.target_type, p.target_id,p.privacy
						  from posts p LEFT JOIN posts_questions pq
						  ON p.post_id = pq.post_id
						  where p.last_activity < '".$last_time."'
						  AND p.user_id = ?
						  OR (p.target_type = 'user' and p.target_id = ?)
							OR (pq.tag_type = 'user' and pq.tag_id = ?)
							ORDER BY last_activity DESC	LIMIT ?,?");
	}
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


function get_class_posts($class_id, $pg, $last_time=NULL){
	GLOBAL $con;
	//define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else
		$user_id = 1;

	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	//print_r($scope);
	if($start_record==0){
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'class' and p.target_id = ?)
			 or (pq.tag_type = 'class' and pq.tag_id = ?)
			order by last_activity DESC	LIMIT ?,?");
	}
	else{
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where p.last_activity < '".$last_time."'
			AND (p.target_type = 'class' and p.target_id = ?)
			 or (pq.tag_type = 'class' and pq.tag_id = ?)
			order by last_activity DESC	LIMIT ?,?");
	}
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

function get_club_posts($group_id, $pg, $last_time=NULL)
{
	GLOBAL $con;
	//define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else
		$user_id = 1;

	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	//print_r($scope);
	if($start_record == 0){
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'group'
			and p.target_id = ?)
			 or (pq.tag_type = 'group'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
	else{
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where p.last_activity < '".$last_time."'
			AND (p.target_type = 'group'
			and p.target_id = ?)
			 or (pq.tag_type = 'group'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
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

function get_school_posts($univ_id, $pg, $last_time=NULL)
{
	GLOBAL $con;
	//define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else
		$user_id = 1;

	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	//print_r($scope);
	if($start_record == 0){
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'school'
			and p.target_id = ?)
			 or (pq.tag_type = 'school'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
	else{
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where p.last_activity < '".$last_time."'
			AND (p.target_type = 'school'
			and p.target_id = ?)
			 or (pq.tag_type = 'school'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
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

function get_dept_posts($dept_id, $pg, $last_time=NULL)
{
	GLOBAL $con;
	//define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else
		$user_id = 1;

	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	//print_r($scope);
	if($start_record == 0){
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
	  from posts p
	  left join posts_questions pq
	  on p.post_id = pq.post_id
	  where (p.target_type = 'department'
		and p.target_id = ?)
		 or (pq.tag_type = 'department'
		and pq.tag_id = ?)
		order by last_activity DESC
		LIMIT ?,?");
	}
	else{
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where p.last_activity < '".$last_time."'
			AND  (p.target_type = 'department'
			and p.target_id = ?)
			 or (pq.tag_type = 'department'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
	$posts_stmt->bind_param("iiii", $dept_id, $dept_id, $start_record,$limit);
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
function get_course_posts($course_id, $pg, $last_time=NULL)
{
	GLOBAL $con;
	//define("LIMIT", 20);
	if(isset($_SESSION['user_id']))
		$user_id = $_SESSION['user_id'];
	else
		$user_id = 1;

	$limit = LIMIT;
	$start_record = isset($pg)?($pg-1)*LIMIT:0;
	$posts = array();
	//print_r($scope);
	if($start_record == 0){
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where (p.target_type = 'course'
			and p.target_id = ?)
			 or (pq.tag_type = 'course'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
	else{
		$posts_stmt = $con->prepare("SELECT distinct(p.post_id), p.user_id, p.target_type, p.target_id,p.privacy
		  from posts p
		  left join posts_questions pq
		  on p.post_id = pq.post_id
		  where p.last_activity < '".$last_time."'
			AND (p.target_type = 'course'
			and p.target_id = ?)
			 or (pq.tag_type = 'course'
			and pq.tag_id = ?)
			order by last_activity DESC
			LIMIT ?,?");
	}
	$posts_stmt->bind_param("ssii", $course_id, $course_id, $start_record,$limit);
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
// print_r(prioritize_posts(2,FALSE,NULL,$last_time));
// print_r(get_profile_posts(1, 1));
// print_r(get_club_posts(2, 1));
// print_r(get_department_posts(3, 1));
// print_r(get_school_posts(1,1));