<?php

require_once("dbconfig.php");

// Uncomment the below 3 lines if you are testing this page alone
$_SESSION['studentid']="1";
$_POST['postid'] = "196";
$_POST['like']="1";


if(isset($_POST['postid'])){
	$type="postid";
	$id=$_POST['postid'];
	$table="home_posts_likes";
}
else if(isset($_POST['replyid'])){
	$type="replyid";
	$id=$_POST['replyid'];
	$table="home_reply_likes";
}
else{
	$type="none";
	$id="none";
}

if(isset($_SESSION['studentid'])){
	$usertype="studentid";
	$userid=$_SESSION['studentid'];
}
else if(isset($_SESSION['profid'])){
	$usertype="profid";
	$userid=$_SESSION['profid'];
}

$query="SELECT * FROM ".$table." WHERE ".$usertype."='".$userid."' AND ".$type."='".$id."'";
$quserlikes=mysqli_query($con,$query); //Checks current login user liked this status or not
$userlikes=mysqli_num_rows($quserlikes);

if($userlikes==0) $status="unlike";
else $status="liked";
echo $status;

	if(isset($_POST['like'])){
		if($status=="unlike"){
			$likequery="INSERT INTO ".$table." (".$type.",".$usertype.",univid) VALUES ('".$id."','".$userid."','1')";
			$likeresult = mysqli_query($con,$likequery);
			echo "success";
		}
		else echo "failed to like";
	}

	if(isset($_POST['unlike'])){
		if($status=="liked"){
			$unlikequery = mysqli_query($con,"DELETE FROM ".$table." WHERE ".$type."='".$id."' AND ".$usertype."='".$userid."'");
			echo "success";
		}
		else "failed to unlike";
	}
	// else{
	// 	echo "Mazaak: Give me the details to fetch data";
	// }

?>