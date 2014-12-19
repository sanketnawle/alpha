<?php

		if ($_SESSION['user_id']!=NULL){
			// echo "test";
			$usertype = "user_id";
			$userid=$_SESSION['user_id'];
			$userlikesquery = "SELECT * FROM posts_likes WHERE user_id='".$_SESSION['user_id']."' AND post_id='".$row['post_id']."'";
			
			//; //Checks current login user liked this status or not
			if($quserlikes=mysqli_query($con,$userlikesquery))
				$userlikes=mysqli_num_rows($quserlikes);

			if($userlikes!=0){
				$like_status = "post_liked";
				$button = "liked-button.png";
			}

			else{
				$like_status = "post_like";
				$button = "like-button.png";
			}
			
			$totallikesquery = "SELECT * FROM posts_likes WHERE post_id='".$row['post_id']."'";
			if($qtotallikes=mysqli_query($con,$totallikesquery))  // Total number of likes for the status message
				$postlikes=mysqli_num_rows($qtotallikes);

			echo "<div class = 'post_like ".$like_status."'>
				<div class = 'post_like_icon'></div>";
				echo "<div class = 'like_number'>";
					if($postlikes!=0) echo $postlikes;
				echo "</div>";
			echo "</div>";

		}

?>