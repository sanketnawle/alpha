<?php

// require_once("dbconfig.php");

// Uncomment the below 3 lines if you are testing this page alone
// $_SESSION['studentid']=1;
// $_SESSION['profid']=1;
// $_POST['postid'] = "92";
// $_POST['commentid']=strtotime("2014-04-01 19:23:41");
// $postid="92";
// $row['messageid'] = $postid;

// checkplikes();
// echo "test";

function checkplikes($postid){
	global $con;

	if($postid){
		// echo "test";
		if ($_SESSION['studentid']!=0){
			echo "test";
			$usertype = "studentid";
			$userid=$_SESSION['studentid'];
			$qstulikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE studentid='".$_SESSION['studentid']."' AND postid='".$row['messageid']."'"); //Checks current login user liked this status or not
			echo $userlikes=mysqli_num_rows($qstulikes);
			$qtotallikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE postid='".$row['messageid']."'");  // Total number of likes for the status message
			echo $postlikes=mysqli_num_rows($qtotallikes);
		}
		if ($_SESSION['profid']!=0){
			$usertype = "profid";
			$userid=$_SESSION['profid'];
			$qproflikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE profid='".$_SESSION['profid']."' AND postid='".$row['messageid']."'"); //Checks current login user liked this status or not
			echo $userlikes=mysqli_num_rows($qproflikes);
			$qtotallikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE postid='".$row['messageid']."'");  // Total number of likes for the status message
			echo $postlikes=mysqli_num_rows($qtotallikes);
		}
	}
}

function checkclikes(){
	if($row1['replyid']) $replyid=$row1['replyid'];
	if(isset($replyid)){
		if ($_SESSION['studentid']!=0){
			$usertype = "studentid";
			$userid=$_SESSION['studentid'];
			$rqstulikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE studentid='".$_SESSION['studentid']."' AND replyid='".$row['messageid']."'"); //Checks current login user liked this status or not
			$ruserlikes=mysqli_num_rows($rqstulikes);
			$rtotallikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE replyid='".$row1['replyid']."'");  // Total number of likes for the status message
			$replylikes=mysqli_num_rows($rtotallikes);
		}
		if ($_SESSION['profid']!=0){
			$usertype = "profid";
			$userid=$_SESSION['profid'];
			$rqproflikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE profid='".$_SESSION['profid']."' AND replyid='".$row['messageid']."'"); //Checks current login user liked this status or not
			$ruserlikes=mysqli_num_rows($rqproflikes);
			$rtotallikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE replyid='".$row1['replyid']."'");  // Total number of likes for the status message
			$replylikes=mysqli_num_rows($rtotallikes);
		}
	}
}

function updatelikes(){
	if(isset($_POST['plike'])){
		$postid=$_POST['postid'];
		checkplikes();
		if($userlikes==0){
			$likequery = mysqli_query($con,"INSERT INTO home_posts_likes (postid,".$usertype.",univid) VALUES ('".$postid."','".$userid."','1')");
			// if($likequery) echo "success";
			// else printf("Mazaak: %s\n", $con->error); //MySQL Error
		}
	}

	if(isset($_POST['clike'])){
		$replyid=$_POST['replyid'];
		checkclikes();
		if($ruserlikes==0){
			$rlikequery = mysqli_query($con,"INSERT INTO home_reply_likes (replyid,".$usertype.",univid) VALUES ('".$_POST['replyid']."','".$userid."','1')");
			// if($likequery) echo "success";
			// else printf("Mazaak: %s\n", $con->error); //MySQL Error
		}
	}

	if(isset($_POST['punlike'])){
		$postid=$_POST['postid'];
		checkplikes();
		if($userlikes!=0){
			$unlikequery = mysqli_query($con,"DELETE FROM home_posts_likes WHERE postid='".$_POST['postid']."' AND ".$usertype."='".$userid."'");
		}
	}

	if(isset($_POST['cunlike'])){
		$replyid=$_POST['replyid'];
		checkclikes();
		if($ruserlikes!=0){
			$runlikequery = mysqli_query($con,"DELETE FROM home_reply_likes WHERE replyid='".$_POST['replyid']."' AND ".$usertype."='".$userid."'");
		}
	}

	// else{
	// 	echo "Mazaak: Give me the details to fetch data";
	// }
}

?>

