<?php
require_once("dbconfig.php");

$_SESSION['user_id']='1';

// $pid='209';
// $cid='254';

function checkpowner($con,$pid){
		$pownerquery="SELECT * FROM posts WHERE post_id= '".$pid."' and user_id = ".$_SESSION['user_id'] ;
		$pownerresult=mysqli_query($con,$pownerquery);
		if((mysqli_num_rows($pownerresult))>0) return $pownership='post';
		// else echo 'none';

	return $pownership='none';
}

function checkcowner($con,$cid){
		$cownerquery="SELECT * FROM reply WHERE reply_id= '".$cid."' and user_id = ".$_SESSION['user_id'] ;
		$cownerresult=mysqli_query($con,$cownerquery);
		if((mysqli_num_rows($cownerresult))>0) return $cownership='reply';
		// else echo 'none';

	return $cownership='none';
}

function checkhidden($con,$pid){
		$hidque="SELECT * FROM posts_hide WHERE post_id= '".$pid."' and user_id = ".$_SESSION['user_id'] ;
		$hidres=mysqli_query($con,$hidque);
		if((mysqli_num_rows($hidres))>0) return $hidden='true';
		// else echo 'none';

	return $hidden='false';
}

				function rvotestatus($con,$replyid){
					$votestatus = "none"; //setting up default value

					// checking if user has voted
					$upstatusquery = "SELECT * FROM reply_votes WHERE user_id='".$_SESSION['user_id']."' AND reply_id='".$replyid."' AND vote_type = '1'";
					$userupvotes = mysqli_query($con,$upstatusquery); //Checks if currently loggedin user liked this status or not
					if($userupvotes){
						$upcount = mysqli_num_rows($userupvotes);
						if($upcount!=0) $votestatus="upvoted";
					}
	
					// checking if user has downvoted
					if($votestatus!="upvoted"){
						$downstatusquery = "SELECT * FROM reply_votes WHERE user_id='".$_SESSION['user_id']."' AND reply_id='".$replyid."' AND vote_type = '-1'";
						$userdownvotes = mysqli_query($con,$downstatusquery); //Checks if currently loggedin user liked this status or not
						if($userdownvotes){
							$downcount = mysqli_num_rows($userdownvotes);
							if($downcount!=0) $votestatus="downvoted";
						}
					}
					return $votestatus;
				}

// echo $pownership=checkpowner($con,$pid);
// echo $cownership=checkcowner($con,$cid);
// echo $hidden=checkhidden($con,$pid);
?>