<?php
// session_start();
$_SESSION['user_id']='1';



	$cownership=checkcowner($con,$row1['reply_id']);
	echo "<div class='post_comment' id='".strtotime($row1['update_timestamp'])."'>";
	if($cownership=="reply" or $pownership=="post") echo "<div class='comment_delete'><i class='fa fa-times'></i></div>";
	echo "<img src='dummy_pic/dummypic.png' class='comment_user_icon'>";

	if($row1['user_id']!=0){
		$cowner_result=mysqli_query($con,"select firstname, lastname from user where user_id='".$row1['user_id']."'");
		$cowner_row=mysqli_fetch_array($cowner_result);
		$comment_owner=$cowner_row['firstname']." ".$cowner_row['lastname'];
					
		// check if liked by the user and count the total likes
		$rquserlikes=mysqli_query($con,"SELECT * FROM reply_likes WHERE user_id='".$_SESSION['user_id']."' AND reply_id='".$row1['reply_id']."'"); //Checks current login user liked this status or not
		$ruserlikes=mysqli_num_rows($rquserlikes);
		$rtotallikes=mysqli_query($con,"SELECT * FROM reply_likes WHERE reply_id='".$row1['reply_id']."'");  // Total number of likes for the status message
		$replylikes=mysqli_num_rows($rtotallikes);				
		}

		else{
			$comment_owner="Invalid User";
		}

		echo "<div class='comment_main'><span class='comment_owner'>";

		if($cownership=="reply"){
			if($row1['anon']=="1") echo "Anonymous (ME)";
			else echo $comment_owner;
		}
		else{
			if($row1['anon']=="1") echo "Anonymous";
			else echo $comment_owner;
		}

		echo "</span> "."<span class='comment_msg' id='".$row1['reply_id']."'>".$row1['reply_msg']."</span></div>";
					
		echo "<br><div class='comment_time'>".$row1['update_timestamp']."</div>";
		echo "<div class='comment_like'>";
					
			if($ruserlikes!=0) echo "<img class='-liked' src='src/liked-button.png'>";
			else echo "<img src='src/like-button.png'>";

				echo "<div class='comment_like_number'>";
				if($replylikes!=0) echo $replylikes;
				echo "</div>";

				// echo $_SESSION['user_id']." ".$row1['reply_id']." ".$ruserlikes." ".$replylikes;

		echo "</div>";

	echo "</div>";

?>			