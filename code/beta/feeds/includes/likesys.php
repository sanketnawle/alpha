<?php

require_once("dbconfig.php");

// Uncomment the below 3 lines if you are testing this page alone
$_SESSION['studentid']="5";
$_POST['replyid'] = "220";
$_POST['delete']="1";

// setting up vars
if(isset($_POST['postid'])){
	$contenttype="postid";
	$contentid=$_POST['postid'];
	$table="home_posts_likes";
	$updatetable="home_posts";
	$ucontenttype="messageid";
}
else if(isset($_POST['replyid'])){
	$contenttype="replyid";
	$contentid=$_POST['replyid'];
	// $table="home_reply_likes";
	$updatetable="home_reply";
	$ucontenttype="replyid";
}
else{
	$contenttype="none";
	$contentid="none";
}

if(isset($_SESSION['studentid'])){
	$usertype="studentid";
	$userid=$_SESSION['studentid'];
}
else if(isset($_SESSION['profid'])){
		$usertype="profid";
		$userid=$_SESSION['profid'];
	}
	else{
		$usertype="none";
		$userid="none";
	}
// finish setting vars.

if($contentid!="none"){
	if(isset($_POST['like'])) like($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid);
	if(isset($_POST['unlike'])) unlike($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid);
	if(isset($_POST['delete'])) delete($con,$updatetable,$usertype,$userid,$contenttype,$contentid);
}

function updatelikecnt($con,$table,$updatetable,$contenttype,$ucontenttype,$contentid){
	// echo "test";
	$countquery="SELECT * FROM ".$table." WHERE ".$contenttype."='".$contentid."'";
	$totallikes=mysqli_query($con,$countquery);  // Total number of likes for the status message
	$likescount=mysqli_num_rows($totallikes);
	$updatelikequery= "UPDATE ".$updatetable." SET like_cnt = '".$likescount."' WHERE ".$ucontenttype."='".$contentid."'";
	$updatelikes=mysqli_query($con,$updatelikequery);
	// if($updatelikes) echo "success";
	// else echo "failed";
}

function likestatus($con,$table,$usertype,$userid,$contenttype,$contentid){
	$statusquery = "SELECT * FROM ".$table." WHERE ".$usertype."='".$userid."' AND ".$contenttype."='".$contentid."'";
	$userlikes = mysqli_query($con,$statusquery); //Checks if currently loggedin user liked this status or not
	$count = mysqli_num_rows($userlikes);
	if($count==0) $likestatus="unlike";
	else $likestatus="liked";
	return $likestatus;
}

function like($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid){
	// echo "test";
	$likestatus=likestatus($con,$table,$usertype,$userid,$contenttype,$contentid);
	if($likestatus=="unlike"){
		$likequery="INSERT INTO ".$table." (".$contenttype.",".$usertype.",univid) VALUES ('".$contentid."','".$userid."','1')";
		$likeresult = mysqli_query($con,$likequery);
		if($likeresult){
			updatelikecnt($con,$table,$updatetable,$contenttype,$ucontenttype,$contentid);
			echo "like success";
		}
		else echo "like failed";
	}
}

function unlike($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid){
	$likestatus=likestatus($con,$table,$usertype,$userid,$contenttype,$contentid);
	if($likestatus=="liked"){
		$unlikequery="DELETE FROM ".$table." WHERE ".$contenttype."='".$contentid."' AND ".$usertype."='".$userid."'";
		$unlikeresult = mysqli_query($con,$unlikequery);
		if($unlikeresult){
			updatelikecnt($con,$table,$updatetable,$contenttype,$ucontenttype,$contentid);
			echo "unlike success";
		}
		else echo "unlike failed";
	}
}

function delete($con,$updatetable,$usertype,$userid,$contenttype,$contentid){
	echo "test";
	if($contenttype=="replyid"){
		$cquery="SELECT * FROM ".$updatetable." WHERE ".$contenttype."='".$contentid."'";
		$cresult=mysqli_query($con,$cquery);
		if($cresult->num_rows){
			while($crow = mysqli_fetch_array($cresult)){
				$pid=$crow['messageid'];
				if($crow['profid']==0){
					$cownertype = "studentid";
					$cownerid = $crow['studentid'];
				}
				else{
					$cownertype = "profid";
					$cownerid = $crow['profid'];
				}
			}
		}
	}
	else $pid = $_POST['postid'];

	echo $pownerquery="SELECT * FROM home_posts WHERE messageid = '".$pid."'";
	$pownerresult=mysqli_query($con,$pownerquery);
	if($pownerresult->num_rows){
		while($pownerrow = mysqli_fetch_array($pownerresult)){
			if($pownerrow['profid']==0){
				echo $pownertype="studentid";
				echo $pownerid=$pownerrow['studentid'];
			}
			else{
				echo $pownertype = "profid";
				echo $pownerid = $pownerrow['profid'];
			}
		}
	}

	// deleting a comment/reply
	if($contenttype=="replyid"){
		echo "testdel";
		if (($usertype==$pownertype and $userid==$pownerid) or ($usertype==$cownertype and $userid==$cownerid)){
			$cdelquery="DELETE FROM home_reply WHERE ".$contenttype."='".$contentid."'";
			$cdel=mysqli_query($con,$cdelquery);
			if($cdel) echo "success";
			else echo "delete failed";
		}
		else echo "access denied";
	}

	if($contenttype=="postid"){

	}

}

?>