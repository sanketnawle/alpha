<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="backgroundHome.css">
<link rel = "stylesheet" type = "text/css" href = "feed.css"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <script src="feed.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

</script>
</head>
<body>
	<div class = "root">
		<div class = "top-bar">
			<div class = "top-bar-wrapper">
				<img class = "logo-h" src = "src/logo.png">


			</div>
		</div>
		<div class = "main">
			<div class = "leftsec">

			</div>
			<div class = "midsec">

				<div id = "posts">
					<div id = "123456789">

						<!--a post start-->						
						<div class = "posts" id = "226">
							<div class = "post_main">
								<div class = "post_head">

										<div class = "post_title">
											<a>
												<div class = "image_container">
													<div class = "post_user_icon"></div>
												</div>											
												<span class = "post_owner">Anita Farrington</span>
											</a>
											<!--hide below span if post not in a group-->
											<span class = "post_format">posted in <span class = "post_group">Web Programming</span>
											
										</div>
										<div class = "post_time">Started discussion 2 hours ago</div>
									<!--
										<span class = "mid-stop">&#183;</span>
										<div class = "post_seen">
											<div class = "seen_icon"></div><span>27</span>
											<div class = 'card-tag'>
												<div class = 'tag-wedge'></div>
												<div class = 'tag-box'><span></span></div>
											</div>
										</div>
									-->
								</div>
								<div class = "post_tag">
									<span>Computer Science</span>
								</div>
								<div class = "post_msg">
									<span class='msg_span'>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum... 
									</span>
									<span class='pst_seemore'>see more</span>
								</div>
								<div class = "post_edit">
									<textarea class = "edit_area"></textarea>
									<div class = "edit_toolbar">
										<button class = "edit_done">Done</button>
										<button class = "edit_cancel">Cancel</button>
									</div>
								</div>
								<div class = "post_tools">
									<div class = "post_lc">
										<div class='mf_name'></div>
										<div class = 'card-tag'>
												<div class = 'tag-wedge'></div>
												<div class = 'tag-box'><span>
													<div class='mf_liked' id='Anita' style='background: url(src/farring.png) no-repeat'></div>
												</span></div>
										</div>
										<div class = "post_like">
											<img class = "post_like_icon" src='src/like-button.png'>
											<div class = "like_number unliked">7</div>
											
										</div>
										<div class = "post_comment_btn">
											Reply
										</div>
									</div>

									
									<div class='posttool-select'>
										<span class='field'>Visible to Campus</span>

										<div class = "visi_functions_box">
											<div class = "visi_functions_option">Campus</div>
											<hr class = "post_options_hr">
											<div class = "visi_functions_option">Only Students</div>
											<hr class = "post_options_hr">
											<div class = "visi_functions_option">Only Faculty</div>
											<hr class = "post_options_hr">
											<div class = "visi_functions_option">Only Me</div>
										</div>

									</div>
									

									<div class = "post_functions">
										<div class = "post_functions_showr">
										</div>
										<div class = "post_functions_box">
											<div class = "post_functions_option option_edit">Edit this Post</div>
											<hr class = "post_options_hr">
											<div class = "post_functions_option option_delete">Delete this Post</div>
											<hr class = "post_options_hr">
											<div class = "post_functions_option option_hide">Hide this Post</div>
											<hr class = "post_options_hr">
											<div class = "post_functions_option option_report">Report this Post</div>
											
										</div>
									</div>
								</div>
							</div>
							
							<div class = "comments">

								<button class='morecmt_bar'>
									Show Full Discussion 
								</button>
								<!--a comment-->
								<div class = "post_comment" id = "12414113">
									<div class = "comment_delete">
										<i class = "fa fa-times"></i>
									</div>
									<div class = "comment_updown">
										<div class = "comment_upvote">
										</div>
										
										<div class = "score unvoted">0</div>
										
										<div class = "comment_downvote">
										</div>
									</div>

									<div class = "comment_main">
										<a>
											<div class = "comment_owner_container"><div class = "comment_user_icon"></div></div>										
											<span class = "comment_owner">Jun Lee</span>
										</a>
										<span class = "comment_msg" id = "380">The theories of borgeuoise republics and their images depicted in the media are poor representations of the entire domestic culture.
											The theories of borgeuoise republics and their images depicted in the media are poor representations of the entire domestic culture... 
											<span class='pst_seemore'>see more</span>
										
										</span>
									</div>
									<div class = "comment_time">1 hour ago</div>

								</div>
								<!--a comment end-->
							</div>
							
							<!--comment input html-->
							<div class = "postcomment">
								<form>
								<div class = "commentform">
									<div class = "reply_user_icon"></div>
									<div class = "reply_tawrapper">
										<textarea class = "form-control postval" rows = "3" placeholder = "Add to the discussion" required></textarea>
										<img class = "reply_attach" src = "src/comment_attach.png">
									</div>
									<div class = "reply_functions">
										<div class='check_wrap'>
											<input type="checkbox" id="flat_0" class='flat7c'/>
											<label for="flat7" class="flat7b">
											    <span class="move"></span>
											</label>
											<span class = "comment_anon_text">Post Anonymously</span>
										</div>
										<a class = "reply_button">
											Reply
										</a>
									</div>

								</div>
							</form>
							</div>
							<!--comment input html end-->

						</div>
						<!--a post end-->		





					</div>
				</div>	

			</div>

		</div>
	</div>

</body>


</html>