<?php

require_once("dbconfig.php");
require_once("time.php");

// Uncomment the line below if you are testing this page alone
// echo $_POST['last_time'] = "1399690304";


if(isset($_POST['last_time'])){

	// echo "********************<br>";
	$last_time = date("Y-m-d H:i:s",$_POST['last_time']);
	// echo "********************<br>";

	if(isset($_GET['user_id'])) $query = "SELECT * FROM posts WHERE update_timestamp < '".$last_time."' AND user_id = ".$_GET['user_id']." ORDER BY update_timestamp DESC LIMIT 10";
	else $query = "SELECT * FROM posts WHERE update_timestamp < '".$last_time."' ORDER BY update_timestamp DESC LIMIT 10";
	$result = mysqli_query($con,$query);
	
	require_once('feedchecks.php');
	while($row = mysqli_fetch_array($result)){

		// echo $row['update_timestamp'];
		// echo "<div id=".strtotime($row['update_timestamp']).">"; //This shows no.of secs since Jan1,1970

		// echo $row['messageid'] . ".  " . $row['message'];

		// echo "<br><br><br> </div>";

		if($row['post_type']=="status")	include "posts.php";
		else if($row['post_type']=="notes") include "posts_notes.php";
		else if($row['post_type']=="question") include "posts_question.php";
	}
}
// else{
// 	echo "Mazaak: Beta, For every output you expect, there must be an input given.";
// }
mysqli_close($con);
?>