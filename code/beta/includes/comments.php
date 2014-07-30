<?php

	$cownership=checkcowner($con,$row1['reply_id']);

	$reply_len = strlen($reply_msg = autolink($row1['reply_msg']));
	if(77<$reply_len and $reply_len<157) $rlen_flag = "mid-len";
	else if($reply_len>156) $rlen_flag = "long-len";
	else $rlen_flag = NULL;

				echo "<div class = 'post_comment ".$rlen_flag."' id = '".strtotime($row1['update_timestamp'])."'>";

					if($cownership=="reply" or $pownership=="post"){
						echo "<div class = 'comment_delete'>
							<i class = 'fa fa-times'></i>
						</div>";
					}
					
					$vote_status=rvotestatus($con,$row1['reply_id']);
					$reply_votes = $row1['up_vote']-$row1['down_vote'];
					echo "
					<div class = 'comment_updown ".$vote_status."'>
						<div class = 'comment_upvote cmt_vote'></div>
						<div class = 'score'>".$reply_votes."</div>
						<div class = 'comment_downvote cmt_vote'></div>
					</div>";

					if($row1['user_id']!=0){
						$cowner_result=mysqli_query($con,"select firstname, lastname from user where user_id='".$row1['user_id']."'");
						$cowner_row=mysqli_fetch_array($cowner_result);
						$comment_owner=$cowner_row['firstname']." ".$cowner_row['lastname'];
									
						// check if liked by the user and count the total votes
						$rquservotes=mysqli_query($con,"SELECT * FROM reply_votes WHERE user_id='".$_SESSION['user_id']."' AND reply_id='".$row1['reply_id']."'"); //Checks current login user liked this status or not
						$ruservotes=mysqli_num_rows($rquservotes);
						$rtotalvotes=mysqli_query($con,"SELECT * FROM reply_votes WHERE reply_id='".$row1['reply_id']."'");  // Total number of votes for the status message
						$replyvotes=mysqli_num_rows($rtotalvotes);				
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
						<div class='ct_ts'>".formattime($row1['update_timestamp'])."</div>
						<div class = 'comment_msg seemore_anchor' id = '".$row1['reply_id']."'>";
						// echo $row1['post_id'];
							if($reply_len>200){
								echo substr($reply_msg,0,200)."<span class = 'txt_tail'> . . . </span><span class='pst_seemore'> see more</span>";
								echo "<span class='text_hidden'>".substr($reply_msg,200)."</span>";
							}
							else if($reply_msg==NULL AND $row1['file_id']!=NULL){
								echo "<span class='no_content_cmt'>".$comment_owner." shared a file</span>";
							}

								else echo $reply_msg;

							echo "</div>";

							// if($row1['file_id']!=NULL){
							// 	$f_query = "SELECT * from file_upload WHERE file_id = ".$row1['file_id'];
							// 	$f_res = mysqli_query($con,$f_query);
							// 	if($f_query){
							// 		while($rf_row = mysqli_fetch_array($f_res)){
							// 			$r_file_type = $rf_row['file_type'];
							// 			// if(substr( $r_file_type, 0, 5 ) === "image") echo "<div class='cmt_pic_att'><img src='data:image/jpeg;base64,".base64_encode($rf_row['file_content'])."'></div>";
							// 		}
							// 	}
							// }

							if($file_up = file_up_desc($con,$row1['file_id'])){
								if(substr( $file_up['type'], 0, 5 ) === "image"){
									echo "<div class='cmt_pic_att'><img src='includes/getimage.php?id=".$row1['file_id']."'></div>";
								}
							}
							
					echo "</div>
					
					<div class = 'comment_time'>";
						
						if($row1['file_id']!=NULL){
							echo "<div class='cmt_f_attach' title=''><img src='src/comment_attach.png'><a href='javascript:download(".$row1['file_id'].")'>".$file_up['name']."</a></div>";

						}

					echo "</div>
				</div>";

?>