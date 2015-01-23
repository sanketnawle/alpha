<?php
	require_once("includes/dbconfig.php");
	require_once("includes/time.php");
	include_once('php/feeds/feeds_priority.php');
	require_once('includes/feedchecks.php');

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if(isset($_POST['latest_feed_id'])){
		getNewSingleFeed($con, $_POST['latest_feed_id']);
	}
	else{
		// How often to poll, in microseconds (1,000,000 μs equals 1 s)
		define('MESSAGE_POLL_MICROSECONDS', 3000000);

		// How long to keep the Long Poll open, in seconds
		define('MESSAGE_TIMEOUT_SECONDS', 50);

		// Timeout padding in seconds, to avoid a premature timeout in case the last call in the loop is taking a while
		define('MESSAGE_TIMEOUT_SECONDS_BUFFER', 5);

		// Hold on to any session data you might need now, since we need to close the session before entering the sleep loop
		$user_id = $_SESSION['user_id'];

		// Close the session prematurely to avoid usleep() from locking other requests
		session_write_close();

		// Automatically die after timeout (plus buffer)
		set_time_limit(MESSAGE_TIMEOUT_SECONDS+MESSAGE_TIMEOUT_SECONDS_BUFFER);

		// Counter to manually keep track of time elapsed (PHP's set_time_limit() is unrealiable while sleeping)
		$counter = MESSAGE_TIMEOUT_SECONDS;

		// Getting current DB time
		$time_db = $con->query("SELECT now()");
		$row_t = $time_db->fetch_array();
		$time_lat = $row_t['now()'];
		//echo $time_lat;
		// Poll for messages and hang if nothing is found, until the timeout is exhausted
		while($counter > 0)
		{
			// Check for new data (not illustrated)
			if(getNewData($con,$user_id,$time_lat))
			{
				$con->close();
				// Break out of while loop if new data is populated
				break;
			}
			else
			{
				session_write_close();
				
				// Otherwise, sleep for the specified time, after which the loop runs again
				usleep(MESSAGE_POLL_MICROSECONDS);

				// Decrement seconds from counter (the interval was set in μs, see above)
				$counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
			}
		}
			$con->close();

		// $time = "1398352086";
		// $latest = date("Y-m-d H:i:s",$time);

		// Uncomment the line below if you are testing this page alone
		// $_POST['latest'] = "1401809930";

		// echo( $_POST['latest']);
	}

	function getNewData($con, $user_id, $time_lat){
		$data_available = false;

		$arr = prioritize_posts(1, TRUE, NULL, $time_lat);
		// print_r($arr);
		if(is_array($arr) && count($arr)>0){
			
			// echo "test";
			$query = $con->query("SELECT * FROM posts WHERE post_id IN (".implode(",", $arr).")");
			
			if($query->num_rows!=0){
				$data_available= true;
				while($row = $query->fetch_array()){
					// echo $row['post_id'];
					if($row['post_type']=="status")	include "includes/posts.php";
					else if($row['post_type']=="notes") include "includes/posts_notes.php";
					else if($row['post_type']=="question") include "includes/posts_question.php";		

				}
			}
			// else echo "nothing";
		}
		return $data_available;
	}

	function getNewSingleFeed($con, $post_id){
		$result = $con->query("SELECT * FROM posts WHERE post_id=".$post_id);
		if($result->num_rows!=0){
			while($row = $result->fetch_array()){
				if($row['post_type']=="status")	include "includes/posts.php";
				else if($row['post_type']=="notes") include "includes/posts_notes.php";
				else if($row['post_type']=="question") include "includes/posts_question.php";		

			}
		}
	}

?>