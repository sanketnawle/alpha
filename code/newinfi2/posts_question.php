<?php
		$edit_flag = NULL;
		$hidden=checkhidden($con,$row['post_id']);

		if($hidden!="true"){
			echo "<div id = '".strtotime($row['update_timestamp'])."'>";
				echo "<div class = 'posts' id = '".$row['post_id']."'>";
					echo "<div class = 'post_main'>";
						echo "<div class = 'post_head'>";
							echo "<div class = 'post_title'>";
								echo "<a>";
									echo "<div class = 'image_container'>";
										echo "<div class = 'post_user_icon'></div>";
									echo "</div>";

									if($row['user_id']!=0){
										$powner_result=mysqli_query($con,"select firstname,lastname from user where user_id='".$row['user_id']."'");
										$owner_row=mysqli_fetch_array($powner_result);
										$post_owner=$owner_row['firstname']." ".$owner_row['lastname'];
									}
									else $post_owner = "Invalid User";

									$pownership = checkpowner($con,$row['post_id']);

									echo "<span class = 'post_owner'>";

										if($pownership=="post"){
											$edit_flag = "privacy_canedit";
											if($row['anon']=="1") echo "Anonymous (ME)";
											else echo $post_owner;
										}
										else{
											if($row['anon']=="1") echo "Anonymous";
											else echo $post_owner;
										}

									echo "</span>";
								echo "</a>";
								echo "<!--hide below span if post not in a group-->";
								echo "<span class = 'post_format'> posted in <span class = 'post_group'>Web Programming</span></span>";
							echo "</div>";
				
							echo "<div class = 'post_time'>Question asked ".formattime($row['update_timestamp'])."
							<span class = 'asked_experts'>to <a><span class = 'experts_icon'></span><span class = 'experts_name'>Computer Science</span></a></span>
							</div>
						</div>

						<div class = 'post_tag'>
							<span>Computer Science</span>
						</div>

						<div class='question_title_span'>
							".$row['text_msg']."
						</div>

						<div class = 'post_msg'>
							<span class='msg_span seemore_anchor'>";
								if(strlen($text_msg = $row['text_msg'])>100){
									echo substr($text_msg,0,500)."<span class = 'txt_tail'> . . . </span><span class='pst_seemore'> see more</span>";
									echo "<span class='text_hidden'>".substr($text_msg,500)."</span>";
								}
								else echo $text_msg;
							echo "</span>
						</div>

						<div class='post_attachment_review'><img class='post_attachment_review_img' src='dummy_pic/IMG_0205.JPG'></div>

						<div class = 'post_edit'>
							<textarea class = 'edit_area'></textarea>
							<div class = 'edit_toolbar'>
								<button class = 'edit_done'>Done</button>
								<button class = 'edit_cancel'>Cancel</button>
							</div>
						</div>
						<div class = 'post_tools'>
							<div class = 'post_lc'>
								<!--<div class='mf_name'></div>-->
								<!--<div class = 'card-tag'>
									<div class = 'tag-wedge'></div>
									<div class = 'tag-box'>
										<span>
											<div class='mf_liked' id='Anita' style='background: url(src/farring.png) no-repeat'></div>
										</span>
									</div>
								</div>-->";

								include "postlikes.php";

								echo "<div class = 'post_comment_btn'>
									Reply
								</div>
							</div>

							<div class='posttool-select ".$edit_flag."'>
								
								<span class='field'>
									<img class='vstt_icon' src='img/privacy_icons/privacy_status/".$row['privacy']."_status.png'>
									<div class='vstt_wedgeDown'></div>
									<div class = 'card-tag'>
										<div class = 'tag-wedge'></div>
										<div class = 'tag-box'>
											<span>Visible to ".$row['privacy']."</span>
										</div>									
									</div>

								</span>";
								if($pownership=="post"){
									echo "<div class = 'visi_functions_box'>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
										<hr class = 'post_options_hr'>
										</span>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
										<hr class = 'post_options_hr'>
										</span>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
										<hr class = 'post_options_hr'>
										</span>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
										</span>
									</div>";
								}
							echo "</div>

							<div class = 'post_functions'>
								<div class = 'post_functions_showr'>
								</div>	
								<div class = 'post_functions_box'>";
									if($pownership=="post"){
										echo "<div class = 'post_functions_option option_edit'>Edit this Post</div>
										<hr class = 'post_options_hr'>
										<div class = 'post_functions_option option_delete'>Delete this Post</div>";
									}
									else {
										echo "<div class = 'post_functions_option option_hide'>Hide this Post</div>
										<hr class = 'post_options_hr'>
										<div class = 'post_functions_option option_report'>Report this Post</div>";
									}
								echo "</div>
							</div>
						</div>
					</div>";

					$count_query = mysqli_query($con,"select * from reply where post_id='".$row['post_id']."'");
					$reply_count = mysqli_num_rows($count_query);
					mysqli_free_result($count_query);

					$reply_query = "select * from reply where post_id='".$row['post_id']."' ORDER BY update_timestamp DESC LIMIT 2";
					$reply_result = mysqli_query($con,$reply_query);

					echo "<div class = 'comments'>";

					if($reply_count>2){
						// echo "test";
						echo "<button class='morecmt_bar'>
								Show Full Discussion 
							</button>";
					}
					if(isset($rep_row))  unset($rep_row); //unset the array if already set ****very important****
						if($reply_result->num_rows){

							while($res = mysqli_fetch_array($reply_result)){
								$rep_row[] = $res;
							}

							$rev_row = array_reverse($rep_row,true);
							foreach ($rev_row as $row1) {
								// echo $row1['reply_id'];
								if(isset($_POST['last_time'])) include "comments.php";
								else include "includes/comments.php";
							}

						}
						else echo "<div id='0000000000'></div>";

					echo "</div>
									
					<div class = 'postcomment'>

						<input class='post_anon_val' name='anon' type='hidden' value='0'>

						<div class = 'commentform'>
							<div class = 'reply_user_icon'></div>
							<div class = 'reply_tawrapper'>
								<textarea class = 'form-control postval' rows = '3' placeholder = 'Add to the discussion' required></textarea>
								<img class = 'reply_attach' src = 'src/comment_attach.png'>
								<form enctype='multipart/form-data'><input type='file' name='file' class='upload_feed_hack'></form>
							</div>
							<div class = 'reply_functions'>
								<div class='check_wrap'>
									<input type='checkbox' id='flat_0' class='flat7c'/>
									<label for='flat7' class='flat7b'>
									    <span class='move'></span>
									</label>
									<span class = 'comment_anon_text'>Post Anonymously</span>
								</div>
								<a class = 'reply_button'>
									Reply
								</a>
							</div>
							<div class='feed_upload_textprompt'></div>
						</div>

					</div>
				</div>
			</div>";
	}

?>
