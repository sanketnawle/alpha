<?php
$_SESSION['user_id'] = 1;

require_once("dbconfig.php");
require_once("time.php");

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

// Poll for messages and hang if nothing is found, until the timeout is exhausted
while($counter > 0)
{
	// Check for new data (not illustrated)
	if(getNewData($con,$user_id))
	{
		mysqli_close($con);
		// Break out of while loop if new data is populated
		break;
	}
	else
	{
		// Otherwise, sleep for the specified time, after which the loop runs again
		usleep(MESSAGE_POLL_MICROSECONDS);

		// Decrement seconds from counter (the interval was set in μs, see above)
		$counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
	}
}
	mysqli_close($con);

// $time = "1398352086";
// $latest = date("Y-m-d H:i:s",$time);

// Uncomment the line below if you are testing this page alone
// $_POST['latest'] = "1401809930";

// echo( $_POST['latest']);

function getNewData($con,$user_id){
	$data_available = false;
	if(isset($_POST['latest'])){

		$latest = date("Y-m-d H:i:s",$_POST['latest']);

		$query = mysqli_query($con,"SELECT * FROM posts WHERE update_timestamp > '".$latest."' ORDER BY update_timestamp DESC");

		require_once('feedchecks.php');
		if(mysqli_num_rows($query)!=0){
			$data_available= true;
			while($row = mysqli_fetch_array($query)){

				if($row['post_type']=="status")	include "posts.php";
				else if($row['post_type']=="notes") include "posts_notes.php";
				else if($row['post_type']=="question") include "posts_question.php";			

			}
		}
		// else echo "nothing";
	}
	return $data_available;
}

?>