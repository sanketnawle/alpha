<?php

	require_once("includes/dbconfig.php");
	require_once("includes/time.php");
	include_once('php/feeds/feeds_priority.php');
	require_once('includes/feedchecks.php');
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}

	// Uncomment the line below if you are testing this page alone
	// echo $_POST['last_time'] = "1399690304";
	
	if(isset($_POST['last_time'])) $last_time = date("Y-m-d H:i:s",$_POST['last_time']);
	else $last_time = date("Y-m-d H:i:s",000000000);

	if(isset($_POST['pg'])){
		if(isset($_POST['user_id'])){
			$arr = get_profile_posts($_POST['user_id'], $_POST['pg'], $last_time);
		}
		elseif(isset($_POST['class_id'])){
			$arr = get_class_posts($_POST['class_id'], $_POST['pg'], $last_time);
		}
		elseif(isset($_POST['course_id'])){
			$arr = get_course_posts($_POST['course_id'], $_POST['pg'], $last_time);
		}
		elseif(isset($_POST['club_id'])){
			$arr = get_club_posts($_POST['club_id'], $_POST['pg'], $last_time);
		}
		elseif(isset($_POST['dept_id'])){
			$arr = get_dept_posts($_POST['dept_id'], $_POST['pg'], $last_time);
		}
		elseif(isset($_POST['univ_id'])){
			$arr = get_school_posts($_POST['univ_id'], $_POST['pg'], $last_time);
		}
		else{
			$arr = prioritize_posts($_POST['pg'], FALSE, $last_time);
		}
	}

	if(isset($arr)&&count($arr)>0){
		$result = $con->query("SELECT * FROM posts WHERE post_id IN (".implode(",", $arr).")");

		// if(isset($_POST['last_time'])){

		// 	// echo "********************<br>";
		// 	$last_time = date("Y-m-d H:i:s",$_POST['last_time']);
		// 	// echo "********************<br>";

		// 	if(isset($_GET['user_id'])) $query = "SELECT * FROM posts WHERE update_timestamp < '".$last_time."' AND user_id = ".$_GET['user_id']." ORDER BY update_timestamp DESC LIMIT 10";
		// 	else $query = "SELECT * FROM posts WHERE update_timestamp < '".$last_time."' ORDER BY update_timestamp DESC LIMIT 10";
		// 	$result = mysqli_query($con,$query);
			

			while($row = $result->fetch_array()){

				if($row['post_type']=="status")	include "includes/posts.php";
				else if($row['post_type']=="notes") include "includes/posts_notes.php";
				else if($row['post_type']=="question") include "includes/posts_question.php";
			}
		// else{
		// 	echo "Mazaak: Beta, For every output you expect, there must be an input given.";
		// }

		$con->close();
	}
?>