<?php
// require_once("dbconfig.php");

// $_SESSION['studentid']='1';

// $pid='209';
// $cid='254';

function checkpowner($con,$pid){
	$usertype="none";
	if(isset($_SESSION['studentid'])) if($_SESSION['studentid']!='0'){
		$usertype='studentid';
		$userid=$_SESSION['studentid'];
	}
	else if(isset($_SESSION['profid'])) if($_SESSION['profid']!='0'){
		$usertype='profid';
		$userid=$_SESSION['profid'];
	}

	if($usertype!="none"){
		$pownerquery="SELECT * FROM home_posts WHERE messageid= '".$pid."' and ".$usertype."=".$userid ;
		$pownerresult=mysqli_query($con,$pownerquery);
		if((mysqli_num_rows($pownerresult))>0) return $pownership='post';
		// else echo 'none';
	}
	// else echo "Mazaak: define user before action";
	return $pownership='none';
}

function checkcowner($con,$cid){
	$usertype="none";
	if(isset($_SESSION['studentid'])) if($_SESSION['studentid']!='0'){
		$usertype='studentid';
		$userid=$_SESSION['studentid'];
	}
	else if(isset($_SESSION['profid'])) if($_SESSION['profid']!='0'){
		$usertype='profid';
		$userid=$_SESSION['profid'];
	}

	if($usertype!="none"){
		$cownerquery="SELECT * FROM home_reply WHERE replyid= '".$cid."' and ".$usertype."=".$userid ;
		$cownerresult=mysqli_query($con,$cownerquery);
		if((mysqli_num_rows($cownerresult))>0) return $cownership='reply';
		// else echo 'none';
	}
	// else echo "Mazaak: define user before action";
	return $cownership='none';
}

// echo $pownership=checkpowner($con,$pid);
// echo $cownership=checkcowner($con,$cid);
?>