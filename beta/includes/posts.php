<?php
		$edit_flag = NULL;
		$hidden=checkhidden($con,$row['post_id']);

		if($hidden!="true"){
			echo "<div id = '".strtotime($row['last_activity'])."'>";
				echo "<div class = 'posts new_fd' id = '".$row['post_id']."'>";
					echo "<div class = 'post_main'>";
						echo "<div class = 'post_head'>";
							echo "<div class = 'post_title'>";
								if($row['anon']!="1") echo "<a href = 'profile.php?user_id=".$row['user_id']."'>";
								else "<a>";
									echo "<div class = 'image_container'>";
										echo "<div class = 'post_user_icon' style='background:url(";
											if($row['anon'] == 0) echo get_user_dp($con,$row['user_id']);
											else echo "DefaultImages/anon.png";
											echo ")'></div>";
									echo "</div>";

									if($row['user_id']!=0){
										$powner_result=$con->query("select firstname,lastname from user where user_id='".$row['user_id']."'");
										$owner_row=$powner_result->fetch_array();
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
								
								if((!is_null($row['target_type']))AND(!is_null($row['target_id']))){
									$target_tag = tar_tag($con, $row['target_type'],$row['target_id']);
									if(!is_null($target_tag))
										echo "<span class = 'post_format'> posted to <span class = 'post_group'>".$target_tag."</span></span>";
								}

							echo "</div>";
				
							echo "<div class = 'post_time'> Posted <time class='timeago' datetime='".$create_time."'>".formattime($row['update_timestamp'])."</time> </div>";
						echo "</div>

						<!--<div class = 'post_tag'>
							<span>Computer Science</span>
						</div>-->
						<div class = 'post_msg post_lr_link_msg'>
							<span class='msg_span seemore_anchor'>";
                            $text_msg = autolink(output_sanitize($row['text_msg']));
								if(strlen($text_msg)>500){
									echo substr($text_msg,0,500)."<span class = 'txt_tail'> . . . </span><span class='pst_seemore'> see more</span>";
									echo "<span class='text_hidden'>".substr($text_msg,500)."</span>";
								}
								else echo $text_msg;
							echo "</span>";

							if($embed_link = detect_embed($text_msg)){
								echo "<p class='f_hidden_p'>".$embed_link."</p>";
 								echo "<div class = 'link-wrapper'>
										<div class = 'link-container'>
											<a class = 'link-anchor-box'>
												<div class = 'link-pic-wrap'>
													<div class='playable_wrap'>
													<div class='play_btn'></div>
													<div class = 'link-img'></div>
													</div>
													<div class = 'link-text-data'>
														<div class = 'link-text-title'> 
															<span class = 'link-text-website'>
																
															</span>
														</div>
														<div class = 'link-text-about'>
														</div>
													</div>
												</div>
											</a>
										</div>
									</div>";
							}

						echo "</div>";

						if($row['file_share_type'] == "regular"){
							if($file_up = file_up_desc($con,$row['file_id'])){
								if(substr( $file_up['type'], 0, 5 ) === "image"){
									echo "<div class='post_attachment_review'><img class='post_attachment_review_img' src='https://urlinq.com/beta/includes/getimage.php?id=".$row['file_id']."'></div>";
								}
								else echo "<div class='post_attachment_review'><img src='src/comment_attach.png' class='post_attach_head_img'><a class = 'file-download' href='javascript:download(".$row['file_id'].")'>".$file_up['name']."</a></div>";
							}
						}

						echo "<div class = 'post_edit'>
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
										<div class = 'visi_functions_option '><div class='visi_icon i_campus'></div>Campus</div>
										<hr class = 'post_options_hr'>
										</span>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_student'></div>Only Students</div>
										<hr class = 'post_options_hr'>
										</span>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_faculty'></div>Only Faculty</div>
										<hr class = 'post_options_hr'>
										</span>
										<span>
										<div class = 'visi_functions_option '><div class='visi_icon i_connections'></div>My Connections</div>
										</span>
									</div>";
								}
							echo "</div>
						</div>
					</div>";

					$count_query = $con->query("select * from reply where post_id='".$row['post_id']."'");
					$reply_count = $count_query->num_rows;
					$count_query->free_result();

					$reply_query = "select * from reply where post_id='".$row['post_id']."' ORDER BY update_timestamp DESC LIMIT 2";
					$reply_result = $con->query($reply_query);

					echo "<div class = 'comments'>";

					if($reply_count>2){
						// echo "test";
						echo "<button class='morecmt_bar'>
								Show Full Discussion 
							</button>";
					}
					if(isset($rep_row))  unset($rep_row); //unset the array if already set ****very important****
					
					if($reply_result->num_rows){
						while($res = $reply_result->fetch_array()){
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
                        <div class = 'comment_owner_container' style='position: absolute; display: none; margin-left: -51px;'>
                            <div class = 'comment_user_icon' style='background:url(".get_user_dp($con, $_SESSION['user_id']).")'></div>
                        </div>
						<input class='post_anon_val' name='anon' type='hidden' value='0'>
						<div class = 'reply_user_icon' style='background:url(".get_user_dp($con, $_SESSION['user_id']).")'></div>
						<div class = 'commentform'>
						  	<div>
								<textarea class = 'form-control postval' placeholder = 'Add a reply or upload a file' required></textarea>
						    	<div class = 'dragdrop_functions'>
						    		<div class='dragdropbox'>Drag and drop files here or Click to upload files</div>
						    		<div class='fileinputbox'><input type='file' class='fileinput' multiple></div>
						    		<div class='filelistbox'></div>
						    	</div>
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
									Add this reply
								</a>
							</div>
						</div>

					</div>
				</div>
			</div>";
	}

?>