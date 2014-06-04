<?php

require_once("dbconfig.php");
$_SESSION['studentid']="1";

// Uncomment the below 3 lines if you are testing this page alone
// $_POST['postid'] = "209";
// $_POST['hide']='1';
// $_POST['delete']='1';
// $_POST['report']='1';
// $_POST['edit']="Post by Kaushik";
// $_POST['privacy']="Faculty";

// setting up vars
if(isset($_POST['postid'])){
	$contenttype="postid";
	$contentid=$_POST['postid'];
	$table="home_posts_likes";
	$updatetable="home_posts";
	$ucontenttype="messageid";
	$content="message";
}
else if(isset($_POST['replyid'])){
	$contenttype="replyid";
	$contentid=$_POST['replyid'];
	$table="home_reply_likes";
	$updatetable="home_reply";
	$ucontenttype="replyid";
	$content="replymessage";
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

if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];

// finish setting vars.

if($contentid!="none"){
	if(isset($_POST['like'])) like($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid);
	else if(isset($_POST['unlike'])) unlike($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid);
	else if(isset($_POST['delete'])) delete($con,$updatetable,$usertype,$userid,$contenttype,$contentid);
	else if(isset($_POST['privacy'])) updateprivacy($con,$usertype,$userid,$contenttype,$contentid,$privacy);
	else if(isset($_POST['report'])) report($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid);
	else if(isset($_POST['hide'])) hide($con,$usertype,$userid,$contenttype,$contentid);
	else if(isset($_POST['edit'])){
		$updatetext=$_POST['edit'];
		edit($con,$updatetable,$content,$updatetext,$usertype,$userid,$ucontenttype,$contentid);
	}
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
	// echo "test";
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

// Checking ownership of "post"
function checkpowner($con,$usertype,$userid,$pid){
	$pownerquery="SELECT * FROM home_posts WHERE messageid = '".$pid."'";
	$pownerresult=mysqli_query($con,$pownerquery);
	if($pownerresult->num_rows){
		while($pownerrow = mysqli_fetch_array($pownerresult)){
			if($pownerrow['profid']==0){
				$pownertype="studentid";
				$pownerid=$pownerrow['studentid'];
			}
			else{
				$pownertype = "profid";
				$pownerid = $pownerrow['profid'];
			}
		}
	}
	if ($usertype==$pownertype and $userid==$pownerid){
		return $checkpowner="true";
	}
	else return $checkpowner="false";
}

// Checking ownership of "comment"
function checkcowner($con,$usertype,$userid,$cid){
	echo $cownerquery="SELECT * FROM home_reply WHERE replyid = '".$cid."'";
	$cownerresult=mysqli_query($con,$cownerquery);
	if($cownerresult->num_rows){
		while($cownerrow = mysqli_fetch_array($cownerresult)){
			if($cownerrow['profid']==0){
				$cownertype="studentid";
				$cownerid=$cownerrow['studentid'];
			}
			else{
				$cownertype = "profid";
				$cownerid = $cownerrow['profid'];
			}
		}
	}
	if ($usertype==$cownertype and $userid==$cownerid){
		return $checkcowner="true";
	}
	else return $checkcowner="false";
}

// Deleting Starts
function delete($con,$updatetable,$usertype,$userid,$contenttype,$contentid){
	// echo "test";
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

	//checks if the current user is the owner of the post
	$checkpowner=checkpowner($con,$usertype,$userid,$pid);
	// echo $repdel;
	// deleting a comment/reply
	if($contenttype=="replyid"){
		if(($checkpowner=="true") or ($usertype==$cownertype and $userid==$cownerid)){
			$cdelquery="DELETE FROM home_reply WHERE ".$contenttype."='".$contentid."'";
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
	if($contenttype=="postid"){
		// echo "test*";
		if ($checkpowner=="true"){
						$pdelquery="DELETE FROM home_posts WHERE messageid = ".$contentid;
						$pdel=mysqli_query($con,$pdelquery);
						if($pdel) echo "success";
						else echo "delete failed";					
		}
		else echo $pdelstatus="access denied";
	}
}
// end of delete function

function updateprivacy($con,$usertype,$userid,$contenttype,$contentid,$privacy){
	// echo "test";
	$checkpowner=checkpowner($con,$usertype,$userid,$contentid);
	if ($checkpowner=="true"){
		if($privacy!=""){
			// echo $privacy;
			echo $updateprivque= "UPDATE home_posts SET visibility = '".$privacy."' WHERE messageid='".$contentid."'";
			$updateprivres=mysqli_query($con,$updateprivque);
			if($updateprivres) echo "success*";
			else echo "failed to update privacy";
		}
	}
	else echo "access denied";
}

function edit($con,$updatetable,$content,$updatetext,$usertype,$userid,$ucontenttype,$contentid){
	// echo "test";
	if($ucontenttype=="messageid"){
		$checkpowner=checkpowner($con,$usertype,$userid,$contentid);
		if ($checkpowner=="true"){
			if($updatetext!=""){
				// echo $updatetext;
				echo $utextque= "UPDATE ".$updatetable." SET  ".$content."= '".$updatetext."' WHERE ".$ucontenttype."='".$contentid."'";
				$utextres=mysqli_query($con,$utextque);
				if($utextres) echo "updatesuccess";
				else echo "failed to update text";
			}
		}
		else echo "access denied";
	}
	if($ucontenttype=="replyid"){
		$checkcowner=checkcowner($con,$usertype,$userid,$contentid);
		if ($checkcowner=="true"){
			if($updatetext!=""){
				echo $updatetext;
				echo $utextque= "UPDATE ".$updatetable." SET  ".$content."= '".$updatetext."' WHERE ".$ucontenttype."='".$contentid."'";
				$utextres=mysqli_query($con,$utextque);
				if($utextres) echo "updatesuccess";
				else echo "failed to update text";
			}
		}
		else echo "access denied";
	}
}

// Reporting Starts
function reportstatus($con,$table,$usertype,$userid,$contenttype,$contentid){
	$statusquery = "SELECT * FROM home_reports WHERE ".$usertype."='".$userid."' AND ".$contenttype."='".$contentid."'";
	$userreports = mysqli_query($con,$statusquery); //Checks if currently loggedin user reported this status or not
	$reportcount = mysqli_num_rows($userreports);
	return $reportcount;
}

function report($con,$table,$updatetable,$usertype,$userid,$contenttype,$ucontenttype,$contentid){
	// echo "test";
	$reportcount=reportstatus($con,$table,$usertype,$userid,$contenttype,$contentid);
	if($reportcount==0){
		$reportquery="INSERT INTO home_reports (".$contenttype.",".$usertype.",univid) VALUES ('".$contentid."','".$userid."','1')";
		$reportresult = mysqli_query($con,$reportquery);
		if($reportresult){
			echo "report success";
		}
		else echo "report failed";
	}
	echo $threshrepcount = checkthreshreps($con,$table,$contenttype,$contentid);
	if($threshrepcount>=2){
		$delquery="DELETE FROM home_posts WHERE ".$ucontenttype." = '".$contentid."'";
		$del=mysqli_query($con,$delquery);
		if($del) echo "success";
		else echo "delete failed";
	}
}

function checkthreshreps($con,$table,$contenttype,$contentid){
	$threshquery = "SELECT * FROM home_reports WHERE ".$contenttype."='".$contentid."'";
	$threshreports = mysqli_query($con,$threshquery); //Checks if currently loggedin user reported this status or not
	$threshrepcount = mysqli_num_rows($threshreports);
	return $threshrepcount;
}
// Reporting ends

function hide($con,$usertype,$userid,$contenttype,$contentid){
	$hidequery="INSERT INTO home_hide (".$contenttype.",".$usertype.",univid) VALUES ('".$contentid."','".$userid."','1')";
	$hideresult = mysqli_query($con,$hidequery);
	if($hideresult){
		echo "hide success";
	}
	else echo "hide failed";
}
?>