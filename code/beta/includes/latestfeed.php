<?php

require_once("dbconfig.php");
require_once("time.php");
require_once('../php/time_change.php');

// $time = "1398352086";
// $latest = date("Y-m-d H:i:s",$time);

// Uncomment the line below if you are testing this page alone
// $_POST['latest'] = "1401809930";

// echo( $_POST['latest']);

if(isset($_POST['latest'])){

	$latest = date("Y-m-d H:i:s",$_POST['latest']);

	$query = mysqli_query($con,"SELECT * FROM posts WHERE update_timestamp > '".$latest."' ORDER BY update_timestamp DESC");

	require_once('feedchecks.php');
	if(mysqli_num_rows($query)!=0){
		while($row = mysqli_fetch_array($query)){

			// echo "<div id=".strtotime($row['update_timestamp']).">"; //div id stores unixtimestamp of the post

			// echo $row['update_timestamp'];

			// echo $row['messageid'] . ".  " . $row['message'];

			// echo "<br><br><br> </div>";

		if($row['post_type']=="status")	include "posts.php";
		else if($row['post_type']=="notes") include "posts_notes.php";
		else if($row['post_type']=="question") include "posts_question.php";			

		}
	}
}
// else echo "Mazaak: Beta, For every output you expect, there must be an input given.";
mysqli_close($con);
?>