<?php

require_once("dbconfig.php");
$_SESSION['user_id']="1";

// Uncomment the below 3 lines if you are testing this page alone
// $_POST['post_id'] = "f6e6ee97-f651-11e3-b732-00259022578e";
// $_POST['reply_id'] = "6655929c-f666-11e3-b732-00259022578e";
// $_POST['vote'] = "downvote";
// $_POST['like']='1';
// $_POST['delete']='1';
// $_POST['hide']='1';
// $_POST['edit']="Question by tester";
// $_POST['privacy']="student";

// setting up vars
if(isset($_POST['post_id'])){
	$contenttype="post_id";
	$contentid=$_POST['post_id'];
	$table="posts_likes";
	$updatetable="posts";
	$content="text_msg";
}
else if(isset($_POST['reply_id'])){
	$contenttype="reply_id";
	$contentid=$_POST['reply_id'];
	$votetable="reply_votes";
	$updatetable="reply";
	$content="reply_msg";
}
else{
	$contenttype="none";
	$contentid="none";
}

if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];

// finish setting vars.

if($contentid!="none"){
	if(isset($_POST['like'])) like($con,$table,$updatetable,$contenttype,$contentid);
	else if(isset($_POST['unlike'])) unlike($con,$table,$updatetable,$contenttype,$contentid);
	else if(isset($_POST['vote'])) vote($con,$votetable,$contenttype,$contentid);
	else if(isset($_POST['delete'])) delete($con,$updatetable,$contenttype,$contentid);
	else if(isset($_POST['privacy'])) updateprivacy($con,$contenttype,$contentid,$privacy);
	else if(isset($_POST['report'])) report($con,$table,$updatetable,$contenttype,$contenttype,$contentid);
	else if(isset($_POST['hide'])) hide($con,$contenttype,$contentid);
	else if(isset($_POST['seemore'])) seemore($con,$content,$updatetable,$contenttype,$contentid);
	else if(isset($_POST['edit'])){
		$updatetext=$_POST['edit'];
		edit($con,$updatetable,$content,$updatetext,$contenttype,$contentid);
	}
}

function updatelikecnt($con,$table,$updatetable,$contenttype,$contentid){
	// echo "test";
	$countquery="SELECT * FROM ".$table." WHERE ".$contenttype."='".$contentid."'";
	$totallikes=mysqli_query($con,$countquery);  // Total number of likes for the status message
	$likescount=mysqli_num_rows($totallikes);
	$updatelikequery= "UPDATE ".$updatetable." SET like_cnt = '".$likescount."' WHERE ".$contenttype."='".$contentid."'";
	$updatelikes=mysqli_query($con,$updatelikequery);
	// if($updatelikes) echo "success";
	// else echo "failed";
}

function likestatus($con,$table,$contenttype,$contentid){
	$statusquery = "SELECT * FROM ".$table." WHERE user_id='".$_SESSION['user_id']."' AND ".$contenttype."='".$contentid."'";
	$userlikes = mysqli_query($con,$statusquery); //Checks if currently loggedin user liked this status or not
	$count = mysqli_num_rows($userlikes);
	if($count==0) $likestatus="unlike";
	else $likestatus="liked";
	return $likestatus;
}

function like($con,$table,$updatetable,$contenttype,$contentid){
	$likestatus=likestatus($con,$table,$contenttype,$contentid);
	if($likestatus=="unlike"){
		$likequery="INSERT INTO ".$table." (".$contenttype.",user_id) VALUES ('".$contentid."','".$_SESSION['user_id']."')";
		$likeresult = mysqli_query($con,$likequery);
		if($likeresult){
			// updatelikecnt($con,$table,$updatetable,$contenttype,$contentid);
			echo "like success";
		}
		else echo "like failed";
	}
}

function unlike($con,$table,$updatetable,$contenttype,$contentid){
	// echo "test";
	$likestatus=likestatus($con,$table,$contenttype,$contentid);
	if($likestatus=="liked"){
		$unlikequery="DELETE FROM ".$table." WHERE ".$contenttype."='".$contentid."' AND user_id='".$_SESSION['user_id']."'";
		$unlikeresult = mysqli_query($con,$unlikequery);
		if($unlikeresult){
			// updatelikecnt($con,$table,$updatetable,$contenttype,$contentid);
			echo "unlike success";
		}
		else echo "unlike failed";
	}
}

function votestatus($con,$votetable,$contenttype,$contentid){
	$votestatus = "none"; //setting up default value

	// checking if user has voted
	$upstatusquery = "SELECT * FROM ".$votetable." WHERE user_id='".$_SESSION['user_id']."' AND ".$contenttype."='".$contentid."' AND vote_type = 'upvote'";
	$userupvotes = mysqli_query($con,$upstatusquery); //Checks if currently loggedin user liked this status or not
	if($userupvotes){
		$upcount = mysqli_num_rows($userupvotes);
		if($upcount!=0) $votestatus="upvoted";
	}
	
	// checking if user has downvoted
	if($votestatus!="upvoted"){
		$downstatusquery = "SELECT * FROM ".$votetable." WHERE user_id='".$_SESSION['user_id']."' AND ".$contenttype."='".$contentid."' AND vote_type = 'downvote'";
		$userdownvotes = mysqli_query($con,$downstatusquery); //Checks if currently loggedin user liked this status or not
		if($userdownvotes){
			$downcount = mysqli_num_rows($userdownvotes);
			if($downcount!=0) $votestatus="downvoted";
		}
	}
	return $votestatus;
}

function vote($con,$votetable,$contenttype,$contentid){
	// echo $votetable;
	$votestatus=votestatus($con,$votetable,$contenttype,$contentid);
	if($votestatus=="none"){
		$votequery="INSERT INTO ".$votetable." (".$contenttype.", user_id, vote_type) VALUES ('".$contentid."','".$_SESSION['user_id']."','".$_POST['vote']."')";
		$voteresult = mysqli_query($con,$votequery);
		if($voteresult){
			echo "vote_insert success";
		}
		else echo "vote_insert failed";
	}
	else if(($votestatus=="upvoted" AND $_POST['vote']=="upvote") OR ($votestatus=="downvoted" AND $_POST['vote']=="downvote")){
		$delvoteq = "DELETE FROM ".$votetable." WHERE ".$contenttype." = '".$contentid."' AND user_id = '".$_SESSION['user_id']."'";
		$delvote = mysqli_query($con,$delvoteq);
		if($delvote) echo "vote_del success";
		else echo "vote_del failed";
	}
	else{
		$votequery="UPDATE ".$votetable." SET vote_type = '".$_POST['vote']."' WHERE ".$contenttype." = '".$contentid."' AND user_id = '".$_SESSION['user_id']."'";
		$voteresult = mysqli_query($con,$votequery);
		if($voteresult){
			echo "vote_update success";
		}
		else echo "vote_update failed";
	}
}

// function downvote($con,$downtable,$contenttype,$contentid){
// 	$votestatus=votestatus($con,$table,$contenttype,$contentid);
// 	if($votestatus=="none"){
// 		$votequery="INSERT INTO ".$downtable." (".$contenttype.",user_id) VALUES ('".$contentid."','".$_SESSION['user_id']."')";
// 		$voteresult = mysqli_query($con,$votequery);
// 		if($voteresult){
// 			echo "downvote success";
// 		}
// 		else echo "downvote failed";
// 	}
// }

// Checking ownership of "post"
function checkpowner($con,$pid){
	$pownerquery="SELECT * FROM posts WHERE post_id = '".$pid."'";
	$pownerresult=mysqli_query($con,$pownerquery);
	if($pownerresult->num_rows){
		while($pownerrow = mysqli_fetch_array($pownerresult)){
			$pownerid=$pownerrow['user_id'];
			}
		}
	if ($_SESSION['user_id']==$pownerid){
		return $checkpowner="true";
	}
	else return $checkpowner="false";
}

// Checking ownership of "comment"
function checkcowner($con,$cid){
	$cownerquery="SELECT * FROM reply WHERE reply_id = '".$cid."'";
	$cownerresult=mysqli_query($con,$cownerquery);
	if($cownerresult->num_rows){
		while($cownerrow = mysqli_fetch_array($cownerresult)){
			$cownerid=$cownerrow['user_id'];
		}
	}
	if ($_SESSION['user_id']==$cownerid){
		return $checkcowner="true";
	}
	else return $checkcowner="false";
}

// Deleting Starts
function delete($con,$updatetable,$contenttype,$contentid){
	// echo "test";
	if($contenttype=="reply_id"){
		$cquery="SELECT * FROM ".$updatetable." WHERE ".$contenttype."='".$contentid."'";
		$cresult=mysqli_query($con,$cquery);
		if($cresult->num_rows){
			while($crow = mysqli_fetch_array($cresult)){
				$pid=$crow['post_id'];
				if($crow['user_id']==0){
					$cownerid = $crow['user_id'];
				}
			}
		}
	}
	else $pid = $_POST['post_id'];

	//checks if the current user is the owner of the post
	$checkpowner=checkpowner($con,$pid);
	// echo $repdel;
	// deleting a comment/reply
	if($contenttype=="reply_id"){
		if(($checkpowner=="true") or ($_SESSION['user_id']==$cownerid)){
			$cdelquery="DELETE FROM reply WHERE ".$contenttype."='".$contentid."'";
			$cdel=mysqli_query($con,$cdelquery);
			if($cdel){
				echo $delflag="success";
				return $delflag;
			}
			else{
				echo $delflag="delete failed";
				return $delflag;
			}
		}
		else echo "access denied";
	}

	// deleting a post
	if($contenttype=="post_id"){
		// echo "test*";
		if ($checkpowner=="true"){
						$pdelquery="DELETE FROM posts WHERE post_id = '".$contentid."'";
						$pdel=mysqli_query($con,$pdelquery);
						if($pdel) echo "success";
						else echo "delete failed";					
		}
		else echo $pdelstatus="access denied";
	}
}
// end of delete function

function updateprivacy($con,$contenttype,$contentid,$privacy){
	// echo "test";
	$checkpowner=checkpowner($con,$contentid);
	if ($checkpowner=="true"){
		if($privacy!=""){
			// echo $privacy;
			echo $updateprivque= "UPDATE posts SET privacy = '".$privacy."' WHERE post_id='".$contentid."'";
			$updateprivres=mysqli_query($con,$updateprivque);
			if($updateprivres) echo "success*";
			else echo "failed to update privacy";
		}
	}
	else echo "access denied";
}

function edit($con,$updatetable,$content,$updatetext,$contenttype,$contentid){
	// echo "test";
	if($contenttype=="post_id"){
		$checkpowner=checkpowner($con,$contentid);
		if ($checkpowner=="true"){
			if($updatetext!=""){
				// echo $updatetext;
				echo $utextque= "UPDATE ".$updatetable." SET  ".$content."= '".$updatetext."' WHERE ".$contenttype."='".$contentid."'";
				$utextres=mysqli_query($con,$utextque);
				if($utextres) echo "updatesuccess";
				else echo "failed to update text";
			}
		}
		else echo "access denied";
	}
	if($contenttype=="reply_id"){
		$checkcowner=checkcowner($con,$contentid);
		if ($checkcowner=="true"){
			if($updatetext!=""){
				$updatetext;
				$utextque= "UPDATE ".$updatetable." SET  ".$content."= '".$updatetext."' WHERE ".$contenttype."='".$contentid."'";
				$utextres=mysqli_query($con,$utextque);
				if($utextres) echo "updatesuccess";
				else echo "failed to update text";
			}
		}
		else echo "access denied";
	}
}

// Reporting Starts
function reportstatus($con,$table,$contenttype,$contentid){
	$statusquery = "SELECT * FROM posts_reports WHERE user_id='".$_SESSION['user_id']."' AND ".$contenttype."='".$contentid."'";
	$userreports = mysqli_query($con,$statusquery); //Checks if currently loggedin user reported this status or not
	$reportcount = mysqli_num_rows($userreports);
	return $reportcount;
}

function report($con,$table,$updatetable,$contenttype,$contenttype,$contentid){
	// echo "test";
	$reportcount=reportstatus($con,$table,$contenttype,$contentid);
	if($reportcount==0){
		$reportquery="INSERT INTO posts_reports (".$contenttype.",user_id) VALUES ('".$contentid."','".$_SESSION['user_id']."')";
		$reportresult = mysqli_query($con,$reportquery);
		if($reportresult){
			echo "report success";
		}
		else echo "report failed";
	}
	else echo "Already reported";
	
	echo $threshrepcount = checkthreshreps($con,$table,$contenttype,$contentid);
	if($threshrepcount>=2){
		$delquery="DELETE FROM posts WHERE ".$contenttype." = '".$contentid."'";
		$del=mysqli_query($con,$delquery);
		if($del) echo "success";
		else echo "delete failed";
	}
}

function checkthreshreps($con,$table,$contenttype,$contentid){
	$threshquery = "SELECT * FROM reports WHERE ".$contenttype."='".$contentid."'";
	$threshreports = mysqli_query($con,$threshquery); //Checks if currently loggedin user reported this status or not
	$threshrepcount = mysqli_num_rows($threshreports);
	return $threshrepcount;
}
// Reporting ends

function hide($con,$contenttype,$contentid){
	$hidequery="INSERT INTO posts_hide (".$contenttype.",user_id) VALUES ('".$contentid."','".$_SESSION['user_id']."')";
	$hideresult = mysqli_query($con,$hidequery);
	if($hideresult){
		echo "hide success";
	}
	else echo "hide failed";
}

function seemore($con,$content,$updatetable,$contenttype,$contentid){
	$seemore_query = "SELECT ".$content." from ".$updatetable." WHERE ".$contenttype."='".$contentid."'";
	$seemore_result = mysqli_query($con,$seemore_query);
	if($seemore_result){
		while($srow = mysqli_fetch_array($seemore_result)){
			if($content=="reply_msg") echo $srow['reply_msg'];
			else if($content=="text_msg") echo $srow['text_msg'];
		}
	}
}

?>