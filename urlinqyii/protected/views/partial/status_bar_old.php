<div id = "fbar" class = "fb"> -->
					<div class='fbar-head'>
						<div class = "post fani fani-hover">
							<div class = "fbtn fbtn-post">
								<?php
								$pg_src = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1);
								if($pg_src == "home.php" || $pg_src=="profile.php")	echo "Post Status";
								else echo "Start Discussion";
								?>
							</div>
						</div>
						<div class = "share fani fani-hover">
							<div class = "fbtn fbtn-upload">
								Share Notes
							</div>							
						</div>
						<div class = "find fani fani-hover">
							<div class = "fbtn fbtn-ask">
								Ask Question
							</div>							
						</div>
					</div>

					<div class = "post-sec">
						<div class = "wedge1a">
						</div>

						<div class = "wedge2a">
						</div>

						<div class = "wedge3a">
						</div>

						<div class = "post_state fbar_anchor">						
							<div class ="textwrap">
								<textarea name = "message" class = "postTxtarea autogrowth_textarea"placeholder = "What have you read lately?" ></textarea>
							</div>	
							<div class = "btmfbar controlpad">
								<div class='fbar_errorprompt'></div>
								<div class = "lfloat-mods">
									<div class = "lfloat-attach">
										<a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
										</a>
									</div>
									<div class="upload_textprompt"></div>

                <form class="attach_form">
                  <input type="file" name='file' class="upload_hack">
                  <button class="upload_button">Upload</button>
              </form>

								</div>

									<div class = "lfloat-anon">
										<div class='check_wrap fbarcheck_wrap'>
											<input type='checkbox' id='flat_0' class='flat7c'/>
												<label for='flat7' class='flat7b_fbar'>
									    			<span class='move'></span>
												</label>
												<span class = 'comment_anon_text'>Post Anonymously</span>
											<input type='hidden' value='0' class='post_anon_val'>
										</div>

										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field_fbar'>
													<img class='vstt_icon' src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Visible to campus</span>
													</div>									
												</div>
												</span>
												<div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

									</div>

								
								<div class = "post-btn btn-1">
									Post
								</div>
							</div>	
						</div>
						<div class = "upload_state fbar_anchor">						
							<div class ="textwrap">
								<textarea name = "file_desc" class = "uploadTxtarea autogrowth_textarea" placeholder = "Say something about this file..." ></textarea>
							</div>	
							<div class = "uploadMode">
								<div class = "localUpload">
									<div class = "upl_wrap">
										<form>
										<div class = "upl_head">
											From Your Computer
										</div>
										<div class = "upl_btn">
											<a class = "upl_anc">
												<span class = "uplbtnText">Choose File</span>
												<div class = "_upl">
													<input type = "file" class = "_uplI" title = "Choose a file to upload" name = "file">
												</div>
											</a>
										</div>
										<div class = "uplName">
											No file chosen
										</div>
									</form>
									</div>
								</div>
								<div class = "driveUpload">
									<input type='hidden' val='' class='googleuploadinfoarchive_fbar'>
									<div class = "upl_wrap">
										<span class = "iconText">
											<img class = "icon" src = "<?php echo Yii::app()->getBaseUrl(true); ?>/assets/drive_icon.png" width = "16" height = "16">
											<div class = "upl_head">
												From Your Drive
											</div>	
											<div class = "upl_btn2">
												<a class = "upl_anc" id='pick'>
													<span class = "uplbtnText">Choose File</span>
												</a>
											</div>
											<div class = "uplName drive_link" title=''>
												No file chosen
											</div>															
										</span>	
									</div>							
								</div>
							</div>
							<div class = "btmfbar2 controlpad">
								<div class='fbar_errorprompt'></div>
								<div class="search-select">
									
								</div>
								<div class = "lfloat-anon">

										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'/>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field_fbar'>
													<img class='vstt_icon' src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Visible to campus</span>
													</div>									
												</div>
												</span>
												<div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

								</div>

								<div class = "post-btn btn-2">
									Post 
								</div>
							</div>	
						</div>	
						<div class = "ask_state fbar_anchor">
							<div class = "topfbar-wrap">
								<div class = "quest-wrap">
									
									<input placeholder = "What's your question? Be specific" class = "topfbar questtxt">
								</div>
							</div>

							<div class ="textwrap2">
								<textarea name = "q_desc" class = "askTxtArea autogrowth_textarea"placeholder = "Add more details about this question... (Optional)" ></textarea>
							</div>	
							<div class = "midfbar-wrap">
								<div class = "midfbar-wrap2">
									<div class = "who-wrap">
										<div class = "who-dyn"><div class = "who-icon"></div></div>
										<div class = "midfbar-exp">
											
											<input placeholder = "+ Ask experts" class = "add_who">
										</div>
										

										<div class="tag-option">

											<div class="tag-section tagsec-r">
												
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class = "btmfbar3 controlpad">
								<div class='fbar_errorprompt'></div>
								<div class = "lfloat-mods">
									<div class = "lfloat-attach">
										<a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
										</a>
									</div>
									<div class="upload_textprompt"></div>
			  <form class="attach_form">
                  <input type="file" name='file' class="upload_hack">
                  <button class="upload_button">Upload</button>
              </form>
									
								</div>
								<div class = "lfloat-anon">
										<div class='check_wrap fbarcheck_wrap'>
											<input type='checkbox' id='flat_0' class='flat7c'/>
												<label for='flat7' class='flat7b_fbar'>
									    			<span class='move'></span>
												</label>
												<span class = 'comment_anon_text'>Post Anonymously</span>
												<input type='hidden' value='0' class='post_anon_val'>
										</div>


										<div class='select_wrap'>
											<input type='hidden' class='visi_val' value='campus'/>
											<div class='posttool-select privacy_canedit'>
								
												<span class='field_fbar'>
													<img class='vstt_icon' src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Visible to campus</span>
													</div>									
												</div>
												</span>
												<div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus' style='background-image:url(img/privacy_icons/privacy_dropdown/campus_normal.png);'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student' style='background-image:url(img/privacy_icons/privacy_dropdown/class_normal.png);'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty' style='background-image:url(img/privacy_icons/privacy_dropdown/faculty_normal.png);'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections' style='background-image:url(img/privacy_icons/privacy_dropdown/connections_normal.png);'></div>My Connections</div>
													</span>
												</div>
											</div>
										</div>

								</div>

								<div class = "post-btn btn-3">
									Post 
								</div>
							</div>	
						</div>									
					</div>
					</div>
