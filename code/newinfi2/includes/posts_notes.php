<?php
		$edit_flag = NULL;
		$hidden=checkhidden($con,$row['post_id']);

		if($hidden!="true"){
			echo "<div class='new_fd' id = '".strtotime($row['update_timestamp'])."'>";
				echo "<div class = 'posts' id = '".$row['post_id']."'>";
					echo "<div class = 'post_main'>";
						echo "<div class = 'post_head'>";
							echo "<div class = 'post_title'>";
								echo "<a>";
									echo "<div class = 'image_container'>";
										echo "<div class = 'post_user_icon'></div>";
									echo "</div>";
									
									// echo $row['post_id']."-".$row['user_id'];

									if($row['user_id']!=0){
										// echo "test";
										$powner_result=mysqli_query($con,"select firstname,lastname from user where user_id='".$row['user_id']."'");
										while($owner_row=mysqli_fetch_array($powner_result)){
											$post_owner=$owner_row['firstname']." ".$owner_row['lastname'];
										}
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
									$target_tag = tar_tag($row['target_type'],$row['target_id']);
									if(!is_null($target_tag))
										echo "<span class = 'post_format'> posted to <span class = 'post_group'>".$target_tag."</span></span>";
								}

							echo "</div>";
				
							echo "<div class = 'post_time'><span class='file_icon'></span>File shared ".formattime($row['update_timestamp'])."</div>
						</div>

						<div class = 'post_tag'>
							<span>Computer Science</span>
						</div>
						<div class = 'post_msg post_file_msg'>
							<span class='msg_span seemore_anchor'>";
								
								echo "
								<div class = 'file-wrapper'>
										<div class = 'file-container'>
											<div class = 'file-pic-wrap'>";

											if(isset($fnotes_name)) $fnotes_name=NULL;
											if(isset($fnotes_type)) $fnotes_type=NULL;
											
											// $fnotes = mysqli_prepare($con, "SELECT file_name, file_type FROM file_upload WHERE file_id = ?");
											// mysqli_bind_param($fnotes, 'i', $row['file_id']);
											// mysqli_execute($fnotes);
											// mysqli_bind_result($fnotes, $fnotes_name,$fnotes_type);

											$fnotes = mysqli_query($con, "SELECT file_name, file_type FROM file_upload WHERE file_id = ".$row['file_id']);
											if($fnotes){
												while($fnotes_row = mysqli_fetch_array($fnotes)){
													$fnotes_name = $fnotes_row['file_name'];
													$fnotes_type = $fnotes_row['file_type'];
												}
											}

											// if(mysqli_fetch($fnotes)){
												// echo $fnotes_name;
												// echo "-";
												// echo $fnotes_type;
												if((substr($fnotes_type, -12) == "presentation") OR (substr($fnotes_type, -13) == "ms-powerpoint")){
													$fnotes_type_tag = "ppt";
													$fnotes_type_name = "Microsoft Powerpoint";
												}
												else if((substr($fnotes_type, -8) == "document") OR (substr($fnotes_type, -6) == "msword")){
													$fnotes_type_tag = "doc";
													$fnotes_type_name = "Microsoft Document";
												}
												else if(substr($fnotes_type, -3) == "pdf"){
													$fnotes_type_tag = "pdf";
													$fnotes_type_name = "Portable Document Format (PDF)";
												}
												else if((substr($fnotes_type, -5) == "sheet") OR (substr($fnotes_type, -8) == "ms-excel")){
													$fnotes_type_tag = "xls";
													$fnotes_type_name = "Microsoft Excel";
												}
												else if(substr($fnotes_type, -14) == "zip-compressed"){
													$fnotes_type_tag = "zip";
													$fnotes_type_name = "Compressed File (ZIP)";
												}
												else{
													$fnotes_type_tag = "other";
													$fnotes_type_name = "Other Files";
												}
											// }
											
											// echo $fnotes_name."*";
												echo "<div class = 'file-img file-img-type-".$fnotes_type_tag."'>
													<div>
														<a class = 'file-download' href='javascript:download(".$row['file_id'].")'>
															Download
														</a>
													</div>
												</div>
												<div class = 'file-text-data'>
													<div class = 'file-text-title'>".$fnotes_name."
													</div>

													<span class='google_drive_icon'></span>

													<div class = 'file-text-type'>".$fnotes_type_name."</div>
													<div class = 'file-text-about'>";
													
													if(strlen($text_msg = autolink($row['text_msg']))>500){
														echo substr($text_msg,0,500)."<span class = 'txt_tail'> . . . </span><span class='pst_seemore'> see more</span>";
														echo "<span class='text_hidden'>".substr($text_msg,500)."</span>";
													}
													else echo $text_msg;

													echo "</div>";

												echo "</div>													
												
											</div>
										</div>
									</div>
									";


							echo "</span>
						</div>
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
