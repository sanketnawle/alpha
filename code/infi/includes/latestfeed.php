<?php

require_once("dbconfig.php");

// $time = "1398352086";
// $latest = date("Y-m-d H:i:s",$time);

// Uncomment the line below if you are testing this page alone
// echo $_POST['latest'] = "1401809930";

// echo( $_POST['latest']);

if(isset($_POST['latest'])){

	$latest = date("Y-m-d H:i:s",$_POST['latest']);

	$query = mysqli_query($con,"SELECT * FROM home_posts WHERE update_timestamp > '".$latest."' ORDER BY update_timestamp DESC");

	if(mysqli_num_rows($query)!=0){
		while($row = mysqli_fetch_array($query)){

			// echo "<div id=".strtotime($row['update_timestamp']).">"; //div id stores unixtimestamp of the post

			// echo $row['update_timestamp'];

			// echo $row['messageid'] . ".  " . $row['message'];

			// echo "<br><br><br> </div>";

			include "posts.php";			

		}
	}
}
// else echo "Mazaak: Beta, For every output you expect, there must be an input given.";

?>