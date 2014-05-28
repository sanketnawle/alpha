<?php

require_once("dbconfig.php");
$_SESSION['studentid']="1";
// Uncomment the line below if you are testing this page alone
// $_POST['last_time'] = "1397690304";


if(isset($_POST['last_time'])){

	// echo "********************<br>";
	$last_time = date("Y-m-d H:i:s",$_POST['last_time']);
	// echo "********************<br>";

	$query = mysqli_query($con,"SELECT * FROM home_posts WHERE update_timestamp < '".$last_time."' ORDER BY update_timestamp DESC LIMIT 10");
	while($row = mysqli_fetch_array($query)){

		// echo $row['update_timestamp'];
		// echo "<div id=".strtotime($row['update_timestamp']).">"; //This shows no.of secs since Jan1,1970

		// echo $row['messageid'] . ".  " . $row['message'];

		// echo "<br><br><br> </div>";

		include "posts.php";		
	}
}
// else{
// 	echo "Mazaak: Beta, For every output you expect, there must be an input given.";
// }
mysqli_close($con);
?>