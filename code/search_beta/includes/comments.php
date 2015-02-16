<?php

$_SESSION['user_id']='1';

	$cownership=checkcowner($con,$row1['reply_id']);

				echo "<div class = 'post_comment' id = '".strtotime($row1['update_timestamp'])."'>";

					if($cownership=="reply" or $pownership=="post"){
						echo "<div class = 'comment_delete'>
							<i class = 'fa fa-times'></i>
						</div>";
					}
					
					$vote_status=rvotestatus($con,$row1['reply_id']);
					$reply_votes = $row1['up_vote']-$row1['down_vote'];
					echo "<div class='fr_cmt'>
					<div class = 'comment_updown ".$vote_status."'>
						<div class = 'comment_upvote cmt_vote'></div>
						<div class = 'score'>".$reply_votes."</div>
						<div class = 'comment_downvote cmt_vote'></div>
					</div></div>";

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

					else $comment_owner="Invalid User";

					echo "<div class = 'comment_main'>
						<a>
							<div class = 'comment_owner_container'>
								<div class = 'comment_user_icon'></div>
							</div>
							<span class = 'comment_owner'>";

								if($cownership=="reply"){
									if($row1['anon']=="1") echo "Anonymous (ME)";
									else echo $comment_owner;
								}
								else{
									if($row1['anon']=="1") echo "Anonymous";
									else echo $comment_owner;
								}

							echo "</span>
						</a>
						<div class = 'comment_msg seemore_anchor' id = '".$row1['reply_id']."'>";
						// echo $row1['post_id'];
							if(strlen($reply_msg = $row1['reply_msg'])>100) echo substr($reply_msg,0,200)." . . . <span class='pst_seemore'> see more</span>";
							else echo $reply_msg;
							echo "</div>
					</div>
					
					<div class = 'comment_time'><div class='ct_ts'>".$row1['update_timestamp']."</div>";
						
						if($row1['file_id']!=0){
							echo "<div class='cmt_f_attach' title=''><img src='src/comment_attach.png'><a href=''>sdafsdaffg</a></div>";
						}

					echo "</div>
				</div>";

?>

