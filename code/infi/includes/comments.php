<?php
// session_start();
$_SESSION['studentid']='1';

					echo "<div class='post_comment' id='".strtotime($row1['update_timestamp'])."'>";
					echo "<div class='comment_delete'><i class='fa fa-times'></i></div>";
					echo "<img src='dummy_pic/dummypic.png' class='comment_user_icon'>";

				if($row1['studentid']!=0){
					$cowner_result=mysqli_query($con,"select name from student_1 where studentid='".$row1['studentid']."'");
					$cowner_row=mysqli_fetch_array($cowner_result);
					$comment_owner=$cowner_row['name'];
					
					// check if liked by the user and count the total likes
					$rqstulikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE studentid='".$_SESSION['studentid']."' AND replyid='".$row1['replyid']."'"); //Checks current login user liked this status or not
					$ruserlikes=mysqli_num_rows($rqstulikes);
					$rtotallikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE replyid='".$row1['replyid']."'");  // Total number of likes for the status message
					$replylikes=mysqli_num_rows($rtotallikes);				
				}
				else if($row1['profid']!=0){
						$cowner_result=mysqli_query($con,"select name from professor_1 where profid='".$row1['profid']."'");
						$cowner_row=mysqli_fetch_array($cowner_result);
						$comment_owner=$cowner_row['name'];
						
						// check if liked by the user and count the total likes
						$rqproflikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE profid='".$_SESSION['profid']."' AND replyid='".$row1['replyid']."'"); //Checks current login user liked this status or not
						$ruserlikes=mysqli_num_rows($rqproflikes);
						$rtotallikes=mysqli_query($con,"SELECT * FROM home_reply_likes WHERE replyid='".$row1['replyid']."'");  // Total number of likes for the status message
						$replylikes=mysqli_num_rows($rtotallikes);
					}
					else{
						$comment_owner="Invalid User";
					}

					echo "<div class='comment_main'><span class='comment_owner'>".$comment_owner."</span> "."<span class='comment_msg' id='".$row1['replyid']."'>".$row1['replymessage']."</span></div>";
					
					echo "<br><div class='comment_time'>".$row1['update_timestamp']."</div>";
					echo "<div class='comment_like'>";
					
					if($ruserlikes!=0) echo "<img class='-liked' src='src/liked-button.png'>";
					else echo "<img src='src/like-button.png'>";

					echo "<div class='comment_like_number'>";
					if($replylikes!=0) echo $replylikes;
					echo "</div>";

					echo $cownership=checkcowner($con,$row1['replyid']);
					// echo $_SESSION['studentid']." ".$row1['replyid']." ".$ruserlikes." ".$replylikes;

					echo "</div>";

					echo "</div>";

?>			