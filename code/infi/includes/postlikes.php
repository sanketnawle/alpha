<?php

		if ($_SESSION['studentid']!=0){
			// echo "test";
			$usertype = "studentid";
			$userid=$_SESSION['studentid'];
			$qstulikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE studentid='".$_SESSION['studentid']."' AND postid='".$row['messageid']."'"); //Checks current login user liked this status or not
			$userlikes=mysqli_num_rows($qstulikes);
			if($userlikes!=0) echo "<img src='src/liked-button.png'>";
			else echo "<img src='src/like-button.png'>";
			$qtotallikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE postid='".$row['messageid']."'");  // Total number of likes for the status message
			$postlikes=mysqli_num_rows($qtotallikes);
			if($postlikes!=0) echo "<div class='like_number'>".$postlikes."</div>";
		}
		if ($_SESSION['profid']!=0){
			$usertype = "profid";
			$userid=$_SESSION['profid'];
			$qproflikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE profid='".$_SESSION['profid']."' AND postid='".$row['messageid']."'"); //Checks current login user liked this status or not
			$userlikes=mysqli_num_rows($qproflikes);
			if($userlikes!=0) echo "<img src='src/liked-button.png'>";
			else echo "<img src='src/like-button.png'>";
			$qtotallikes=mysqli_query($con,"SELECT * FROM home_posts_likes WHERE postid='".$row['messageid']."'");  // Total number of likes for the status message
			$postlikes=mysqli_num_rows($qtotallikes);
			if($postlikes!=0) echo "<div class='like_number'>".$postlikes."</div>";
		}

?>