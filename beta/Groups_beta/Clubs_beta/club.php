<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="backgroundGroup.css">
<link rel="stylesheet" type="text/css" href="club.css">
<link rel = "stylesheet" type = "text/css" href = "feedGroup.css"> 
<link rel = "stylesheet" type = "text/css" href = "group.css"> 
<link rel = "stylesheet" type = "text/css" href = "leftmenu.css"><link rel="stylesheet" type="text/css" href="planner.css">
<script src='md5.js'></script>
<link rel="stylesheet" type="text/css" href="datepicker.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

 <script src="feed.js"></script> 
    <script src="club.js"></script> 
  <script src="leftmenu.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


<script>


</script>
</head>
<body>
	<div class = "root">
		<div class = "top-bar">
			<div class = "top-bar-wrapper">
				<ul class = "noselect nav">
					<li class = "burger-wrap">
						<a id = "burger" class = "burger popover-target">
							<img src = "src/logo.png" class = "logo">
							<img src = "src/burger_closed.png" class = "burger">
						</a>
					</li>
				</ul>

			</div>
		</div>
		<div class = "main">
			<div class = "leftsec">
				<div id = "tray" class = "leftmenu">
					<div class = "group_search">
						<input type = "text" placeholder = "Search your courses & clubs" class = "search_groups" id = "tray_search">
						<i class = "icon_search"></i>
						<a class = "join-group">
							<i class = "add-icon"></i>
						</a>
					</div>
					<div class = "search-results">
						<!-- Show dynamic search as you type results here from user's groups list -->
					</div>

					<div class = "groups_list">
						<div class = "course-groups-list sub-list">
							<div class = "sub-list-header">
								<span>COURSES</span>

							</div>
							<a class = "group course-group">
								<div class = "group-pic"></div>
								<div class = "details">
									<div class = "group-name">Computational Biology
									</div>
									<div class = "group-admin">
										<strong class = "admin-title">Professor</strong>
										<span class = "admin-name">Garrigan</span>
									</div>
								</div>
								<div class = "badge">
								</div>
							</a>
							<a class = "group course-group">
								<div class = "group-pic" style = "background-image:url(src/philosophy.jpeg)"></div>
								<div class = "details">
									<div class = "group-name">Moral Philosophy
									</div>
									<div class = "group-admin">
										<strong class = "admin-title">Professor</strong>
										<span class = "admin-name">FitzPatrick</span>
									</div>
								</div>
								<div class = "badge">
								</div>
							</a>	
							<a class = "group course-group">
								<div class = "group-pic" style = "background-image:url(src/neuroscience.jpg)"></div>
								<div class = "details">
									<div class = "group-name">Neurochemical Foundations of Behavior
									</div>
									<div class = "group-admin">
										<strong class = "admin-title">Professor</strong>
										<span class = "admin-name">Miller</span>
									</div>
								</div>
								<div class = "badge">
								</div>
							</a>
							<a class = "group course-group">
								<div class = "group-pic" style = "background-image:url(src/economics.jpg)"></div>
								<div class = "details">
									<div class = "group-name">Microeconomics
									</div>
									<div class = "group-admin">
										<strong class = "admin-title">Professor</strong>
										<span class = "admin-name">Landsburg</span>
									</div>
								</div>
								<div class = "badge">
								</div>
							</a>
							<a class = "group course-group">
								<div class = "group-pic" style = "background-image:url(src/bigdata.jpg)"></div>
								<div class = "details">
									<div class = "group-name">Big Data Computer Systems
									</div>
									<div class = "group-admin">
										<strong class = "admin-title">Professor</strong>
										<span class = "admin-name">Shen</span>
									</div>
								</div>
								<div class = "badge">
								</div>
							</a>					
						</div>
						<div class = "clubs-groups-list sub-list">
							<div class = "sub-list-header">
								<span>CLUBS</span>

							</div>							
							<a class = "group club-group">

							</a>
							<a class = "group club-group">

							</a>								
						</div>
					</div>
				</div>

			</div>
			<div class = "main-mid-sec">
				<div class = "urGroupStickyHeader">
					<div class = "stickyHeaderWrap">
						<div class = "back">
							<div class = "group-sticky-left">
								<div class = "group-icon-frame">
									<div class = "group-icon">
									</div>
								</div>
								<div class = "group-btn group-return">
									Neurochemical Foundations of Behavior
								</div>
								<div class = "group-btn group-nav">
									Group Feed
									<span class = "right-down-arrow">
									</span>
								</div>
							</div>
							<div class = "group-sticky-right">
								<div class = "group-sticky-fx group-sticky-discuss">
									<a class = "sticky-fx">
										<span class = "sticky-fx-cont">
											<div class = "sticky-fx-icon fx-icon1">
											</div>
											<div class = "fx-title">
												Start Discussion
											</div>
										</span>
									</a>
								</div>
								<div class = "group-sticky-fx group-sticky-file">
									<a class = "sticky-fx">
										<span class = "sticky-fx-cont">
											<div class = "sticky-fx-icon fx-icon2">
											</div>
											<div class = "fx-title">
												Share File
											</div>
										</span>
									</a>
								</div>
								<div class = "group-sticky-fx group-sticky-ask" style = "border-right:none">
									<a class = "sticky-fx">
										<span class = "sticky-fx-cont">
											<div class = "sticky-fx-icon fx-icon3">
											</div>
											<div class = "fx-title">
												Ask Question
											</div>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "mid_right_sec">
					<div class = "group-head-sec club-head-sec">
						<div class = "group-head-top-sec">
							<div class = "group-head-top-sec-shadow">
							</div>
							<div class ="imagesContainer">
								<div class = "clubPhoto clubPhoto1">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
								<div class = "clubPhoto clubPhoto2">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
								<div class = "clubPhoto clubPhoto3">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
								<div class = "clubPhoto clubPhoto4">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
								<div class = "clubPhoto clubPhoto5">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
								<div class = "clubPhoto clubPhoto6">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
								<div class = "clubPhoto clubPhoto7">
									<a class = "clubPhotoVis">
										<div class = "BigClubPic">
										</div>
										<b class = "clubPhotoShadow">
										</b>
									</a>
								</div>
							</div>
							<div class = "club-pic-frame">
								<div class = "club-pic">
								</div>
							</div>
							<div class = "group-header-left club-header-left">

								
								<div class = "group-title club-title">
									<div class = "group-name">
										 Republicans Society of Rochester
									</div>
									<a class = "group-id">
										RSR
									</a>
								</div>	
								<div class = "club-leader">
									<a>
										<div class = "leader-icon-frame">
											<div class = "leader-icon">
											</div>
										</div>
										<span class = "club-leader-info-title">
											Sarth Desai
										</span>			
									</a>	
									<div class = "invite-btn">
										<span class = "mail-icon">
										</span>
										Invite to Urlinq
									</div>			
								</div>														
							</div>

						</div>
						<div class = "group-head-footer">
							<div class = "group-header-tab">
								<ul class = "group-nav">
									<li class = "group-tab">
										<a class = "tab1 tab-anchor group-tab-active">
											<div class = "tab-title">
												GROUP FEED
												<span class = "tab-icon tab1-icon-active"></span>
											</div>
											<div class = "status tab-number">
												<span class = "badge">
													2
												</span>
											</div>
										</a>
									</li>
									<li class = "group-tab">
										<a class = "tab2 tab-anchor tab-inactive">
											<div class = "tab-title">
												MEMBERS
												<span class = "tab-icon tab2-icon-inactive"></span>
											</div>
											<div class = "status tab-number">
												<span class = "badge">
													84
												</span>
											</div>
										</a>
									</li>
									<li class = "group-tab">
										<a class = "tab3 tab-anchor tab-inactive">
											<div class = "tab-title">
												FILES/PHOTOS
												<span class = "tab-icon tab3-icon-inactive"></span>
											</div>
											<div class = "status tab-number">
												<span class = "badge">
													22
												</span>
											</div>
										</a>						
									</li>	
									<li class = "tab-no-badge group-tab">
										<a class = "tabc tab-anchor tab-inactive">
											<div class = "tab-title">
												EVENTS
												<span class = "tab-icon tabc-icon-inactive"></span>
											</div>
										</a>
									</li>							
								</ul>
							</div>
							<div class = "group-footer-functions">
								<div class = "join-button">
									<a class = "join joined">
										Enrolled
									</a>
								</div>
							</div>
						</div>
						<div class = "tab-wedge-down">
						</div>

					</div>
					<div class = "midsec">
						<div class = "feed-tab-content">
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
															<span class = "post_owner">Professor Farrington</span>
														</a>
														<!--hide below span if post not in a group-->
														<span class = "post_format">made an announcement </span>
														
													</div>
													<div class = "post_time">Anouncement made 2 hours ago</div><span class = "mid-stop">&#183;</span>
													<div class = "post_seen">
														<div class = "seen_icon"></div><span>27</span>
														<div class = 'card-tag'>
															<div class = 'tag-wedge'></div>
															<div class = 'tag-box'><span></span></div>
														</div>
													</div>
											</div>
											<div class = "post_tag">
												<span>Biology</span>
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
													<div class = "post_like">
														<div class = "post_like_icon"></div>
														<div class = "like_number unliked">7</div>
													</div>
													<div class = "post_comment_btn">
														Comment
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
													<span class = "comment_msg" id = "380"><p>The theories of borgeuoise republics and their images depicted in the media are poor representations of the entire domestic culture.
														The theories of borgeuoise republics and their images depicted in the media are poor representations of the entire domestic culture... 
														<span class='pst_seemore'>see more</span>
													</p>
													</span>
												</div>
												<div class = "comment_time">1 hour ago</div>

											</div>
											<!--a comment end-->
										</div>
										
										<!--comment input html-->
										<div class = "postcomment">
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
										</div>
										<!--comment input html end-->

									</div>
									<!--a post end-->		





								</div>
							</div>	
							<div class = "feed-tab-rightsec">
								<div class = "group-about">
									<div class = "box-header">
										<span class = "bh-t1">
											RECENT EVENT
										</span>
										<span class = "midline-dot">
											&#183;
										</span>
										<a style = "font-weight:600;" class = "bh-t2">
											Upload a file
										</a>
									</div>
									<div class = "box-content content-file">
										<a class = "file-download">
										<div class = "file-icon">
										</div>
										<div class= "file-name">
											Who is Ross Kopelman?
										</div>
										</a>
										<div class ="file-created">
											<a class = "file-creator">Jacob Lazarus</a> <span> uploaded July 8th</span>
										</div>
									</div>
									<div class = "box-header">
										<span class = "bh-t1">
											ABOUT
										</span>
										
									</div>
									<div class = "box-content content-about">Urlinq should strive for an "intimate" connection with customers' feelings. "We will truly understand their needs better than any other company," Lazarus wrote.</div>
									<div class = "box-header">
										<a class = "bh-t2">
											Invite email list
										</a>
									</div>
									<div class = "box-content content-invite">
										<form rel = "" method = "post">
											<input type = "hidden" autocomplete = "off">
											<i class = "plusIcon"></i>
											<div class = "invite-input-wrap">
												<div class = "innerWrap">
													<input type = "text" class = "inputText inviteInput" name = "Invite form" placeholder = "Invite people to join this course">
													<div class = "search-icon" title = "Search people">
													</div>
												</div>
											</div> 
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class = "members-tab-content">
							<div class = "members-search-top">
								<input type = "text" class = "inputText searchMembers" name = "Search Users" placeholder = "Search the members of this course...">
								<span class = "search-icon">
								</span>
								<div class = "invite-users">
									Invite email list
								</div>
							</div>
							<div class = "members-header">
								Professors and TAs (2)
							</div>
							<div class = "members-header-line">
							</div>
							<div class = "members-list-wrap">
								<div class = "member">
									<div class = "member-person prof-member-person">
										<div class = "member-wrap prof-member-wrap">
											<div class = "person-thumb">
												<div class = "picwrap" style = "background-image:url(src/dummy-pic.jpg)"></div>
												<div class = "member-bio">
													<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
													<strong>View Profile</strong>
												</div>
											</div>
											<h3 class = "person-title">
												<strong>Professor Zeroni</strong>
												<span>
													<a>NYU College of Arts and Sciences</a>
												</span>
											</h3>
											<div class = "follow-btn">
												<a class = "follow">
													Follow
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class = "member">
									<div class = "member-person ta-member-person">
										<div class = "member-wrap ta-member-wrap">
											<div class = "person-thumb">
												<div class = "picwrap" style = "background-image:url(src/dummy-pic.jpg)"></div>
												<div class = "member-bio">
													<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
													<strong>View Profile</strong>
												</div>
											</div>
											<h3 class = "person-title">
												<strong>TA Hector Zeroni</strong>
												<span>
													<a>NYU School of Engineering</a>
												</span>
											</h3>
											<div class = "follow-btn">
												<a class = "follow">
													Follow
												</a>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							
							<div class = "members-header members-students">
								Students (22)
							</div>
							<div style = "width: 853px"class = "members-header-line">
							</div>
							<div class = "members-list-wrap student-member-list">
								<div class = "member">
									<div class = "member-person">
										<div class = "member-wrap">
											<div class = "person-thumb">
												<div class = "picwrap" style = "background-image:url(src/dummy-pic.jpg)"></div>
												<div class = "member-bio">
													<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
													
													<strong>View Profile</strong>
												</div>
											</div>
											<h3 class = "person-title">
												<strong>TA Hector Zeroni</strong>
												<span>
													<a>NYU School of Engineering</a>
												</span>
											</h3>
											<div class = "follow-btn">
												<a class = "follow">
													Follow
												</a>
											</div>
											
										</div>
									</div>
								</div>
								
								<div class = "member">
									<div class = "member-person">
										<div class = "member-wrap">
											<div class = "person-thumb">
												<div class = "picwrap" style = "background-image:url(src/dummy-pic.jpg)"></div>
												<div class = "member-bio">
													<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
													<strong>View Profile</strong>

												</div>
											</div>
											<h3 class = "person-title">
												<strong>TA Hector Zeroni</strong>
												<span>
													<a>NYU School of Engineering</a>
												</span>
											</h3>
											<div class = "follow-btn">
												<a class = "follow">
													Follow
												</a>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class = "files-tab-content">
							<div class = "files-search-top">
								<input name = "sb-files" type = "hidden">
								<label for = "sort" class = "sortByLabel">
									Sort By
								</label> 
								<select class = "sortByDropdown" name = "sort" id = "sort">
									<option value = "filetype-rank">File Type</option>
									<option value = "recent-rank">Recent Uploads</option>
									<option value = "popularity-rank">Popularity
								</select>
								<input type = "text" class = "inputText searchMembers searchFiles" name = "Search Files" placeholder = "Search the files uploaded to this course...">
								<span class = "search-icon search-icon-files">
								</span>
								<div class = "invite-users upload-files">
									Upload A New File
								</div>
								
							</div>
							<div class = "members-header members-students">
								Powerpoints (5)
							</div>
							

							<div style = "width: 828px"class = "members-header-line">
							</div>
							<div class = "files-type-content">
								<div class = "file">
									<div class = "file-cont">
										<div class = "file-wrap">
											<div class = "file-thumb-wrap">
												<div class = "file-thumb">

												</div>	
												<div class = "file-thumb-cover">
													<div class = "file-download2">
														Download
													</div>
												</div>
											</div>
											<div class = "file-info-area">
												<h4 class = "file-title">
													The First Lecture
												</h4>
												<span class = "file-date">
													33 days ago
												</span>
												<div class = "file-info-areabtm">
													<span class = "file-creator">
														Kuan Wang 
													</span>
													uploaded
													<div class = "file-desc">
														This is Kuan's first lecture on morality and the interactions within a classroom.
													</div>
													<span class = "file-data">
														<b class = "file-data1-icon">
														</b>
														<span class = "file-data-val">
															10
														</span>
														<b class = "file-data2-icon">
														</b>
														<span class = "file-data-val">15
														</span>
													</span>
													<div class = "download-btn1">
														Download
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> 
								<div class = "file">
									<div class = "file-cont">
										<div class = "file-wrap">
											<div class = "file-thumb-wrap">
												<div class = "file-thumb">

												</div>	
												<div class = "file-thumb-cover">
													<div class = "file-download2">
														Download
													</div>
												</div>
											</div>
											<div class = "file-info-area">
												<h4 class = "file-title">
													The First Lecture
												</h4>
												<span class = "file-date">
													33 days ago
												</span>
												<div class = "file-info-areabtm">
													<span class = "file-creator">
														Kuan Wang 
													</span>
													uploaded
													<div class = "file-desc">
														This is Kuan's first lecture on morality and the interactions within a classroom.
													</div>
													<span class = "file-data">
														<b class = "file-data1-icon">
														</b>
														<span class = "file-data-val">
															10
														</span>
														<b class = "file-data2-icon">
														</b>
														<span class = "file-data-val">15
														</span>
													</span>
													<div class = "download-btn1">
														Download
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> 
								<div class = "file">
									<div class = "file-cont">
										<div class = "file-wrap">
											<div class = "file-thumb-wrap">
												<div class = "file-thumb">

												</div>	
												<div class = "file-thumb-cover">
													<div class = "file-download2">
														Download
													</div>
												</div>
											</div>
											<div class = "file-info-area">
												<h4 class = "file-title">
													The First Lecture
												</h4>
												<span class = "file-date">
													33 days ago
												</span>
												<div class = "file-info-areabtm">
													<span class = "file-creator">
														Kuan Wang 
													</span>
													uploaded
													<div class = "file-desc">
														This is Kuan's first lecture on morality and the interactions within a classroom.
													</div>
													<span class = "file-data">
														<b class = "file-data1-icon">
														</b>
														<span class = "file-data-val">
															10
														</span>
														<b class = "file-data2-icon">
														</b>
														<span class = "file-data-val">15
														</span>
													</span>
													<div class = "download-btn1">
														Download
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> 
								<div class = "file">
									<div class = "file-cont">
										<div class = "file-wrap">
											<div class = "file-thumb-wrap">
												<div class = "file-thumb">

												</div>	
												<div class = "file-thumb-cover">
													<div class = "file-download2">
														Download
													</div>
												</div>
											</div>
											<div class = "file-info-area">
												<h4 class = "file-title">
													The First Lecture
												</h4>
												<span class = "file-date">
													33 days ago
												</span>
												<div class = "file-info-areabtm">
													<span class = "file-creator">
														Kuan Wang 
													</span>
													uploaded
													<div class = "file-desc">
														This is Kuan's first lecture on morality and the interactions within a classroom.
													</div>
													<span class = "file-data">
														<b class = "file-data1-icon">
														</b>
														<span class = "file-data-val">
															10
														</span>
														<b class = "file-data2-icon">
														</b>
														<span class = "file-data-val">15
														</span>
													</span>
													<div class = "download-btn1">
														Download
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> 

							</div>
						</div>
						<div class = "syllabus-tab-content">
							<?php include 'analytics.html';?>
						</div>
						<div class = "about-content">
							<div class = "about-tab-leftsec">
								<div class = "about-tab-about about-tab-block">
									<div class = "tab-block-header">
										<div class = "block-head-left">
											About
										</div>
										<div class = "block-head-right">
											<a class = "edit-about">
												Edit
												<i class = "edit-icon">

												</i>
											</a>
										</div>
									</div>
									<div class = "tab-block-content">
										Receive a potato-salad themed haiku written by me, your name carved into a potato that will be used in the potato salad, a signed jar of mayonnaise, the potato salad recipe, hang out in the kitchen with me while I make the potato salad, choose a potato-salad-appropriate ingredient to add to the potato salad, receive a bite of the potato salad, a photo of me making the potato salad, a 'thank you' posted to our website and I will say your name out loud while making the potato salad.
									</div>
								</div>
								<div class = "about-tab-members about-tab-block">
									<div class = "tab-block-header">
										<div class = "block-head-left">
											STUDENTS YOU KNOW IN THIS COURSE <span>(8)</span>
										</div>
										
									</div>
									<div class = "tab-block-content tab-block-content-scroll">
										<div class = "members-scrollwrap">
											<ul class = "people-you-know">
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<span class = "grade">Grad</span>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>
												<li class = "people-box">
													<div class = "person-pic-wrap">
                               						</div>
                               						<div class = "person-title-wrap">
					                                    <p>Kushal Kadaba</p>
					                                </div>
					                                <div class = "after-click-effect"></div>
												</li>

											</ul>

										</div>
										<a class = "ddbox-hor-scroller hor-scroller-left">
					                        <div class = "ddbox-hor-scroller-cont">
					                        </div>
					                        <i class = "ddbox-hor-scroll-icon-left">
					                        </i>
					                    </a>
					                    <a class = "ddbox-hor-scroller hor-scroller-right">
					                        <div class = "ddbox-hor-scroller-cont">
					                        </div>
					                        <i class = "ddbox-hor-scroll-icon-right">
					                        </i>
					                    </a>

									</div>

								</div>
								<div class = "about-tab-prof about-tab-block">
									<a class = "prof-header"><div class = "tab-block-header">
										<div class = "block-head-left">
											PROFESSOR GARRIGAN
										</div>
										
									</div></a>
								</div>
								<div class = "about-tab-ratings about-tab-block">
									<div class = "tab-block-header">
										<div class = "block-head-left">
											COURSE REVIEWS <span>(28)</span> <span class = "tab-block-view">View all</span>
										</div>

										
									</div>
									<div class = "tab-block-content tab-block-content-reviews">
										<div class = "tab-block-topsec">
											<div class = "tab-block-left">
												<div class = "reviews-average">
													<div class = "reviews-sec-header-2">Average Rating<span> (28 students reviewed)</span></div>
													<h2>4.6</h2>
													<div class = "reviews-rating">
														<div class = "rating-stars-filled">
															<div class = "rating_star">
																<img class = "img" src = "src/filled_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/filled_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/filled_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/filled_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/filled_star.png">
															</div>
														</div>
														<div class = "rating-stars-empty">
															<div class = "rating_star">
																<img class = "img" src = "src/empty_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/empty_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/empty_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/empty_star.png">
															</div>
															<div class = "rating_star">
																<img class = "img" src = "src/empty_star.png">
															</div>
														</div>
													</div>
												</div>
												
												
											</div>
											<div class = "tab-block-right">
											
												<div class = "reviews-distribution">
													<div class = "reviews-sec-header">Distribution</div>
													<div class = "lfloat dist-stars">
														<div class = "star-dist">
															5 &#9733;
														</div>
														<div class = "star-dist">
															4 &#9733;
														</div>
														<div class = "star-dist">
															3 &#9733;
														</div>
														<div class = "star-dist">
															2 &#9733;
														</div>
														<div class = "star-dist">
															1 &#9733;
														</div>
													</div>
													<div class = "rfloat dist-bars">
														<div class = "dist-bar-wrap">
															<div class = "bar-dist"></div>
															<div class = "bar-val">9</div>
														</div>
														<div class = "dist-bar-wrap">
															<div class = "bar-dist"></div>
															<div class = "bar-val">7</div>
														</div>
														<div class = "dist-bar-wrap">
															<div class = "bar-dist"></div>
															<div class = "bar-val">5</div>
														</div>
														<div class = "dist-bar-wrap">
															<div class = "bar-dist"></div>
															<div class = "bar-val">2</div>
														</div>
														<div class = "dist-bar-wrap">
															<div class = "bar-dist"></div>
															<div class = "bar-val">5</div>
														</div>
													</div>
												</div>
												<div class = "create-review-btn">
													Write a Review
												</div>
											</div>
										</div>
										<div class = "tab-block-reviewssec">
											<div class = "tab-block-create-review">
												<div class = "create-rating-stars-filled">
													<div class = "rating_star r_s_ur rating_star_unrated rating_star_unrated1">
														<img class = "img" src = "src/filled_star.png">

													</div>
													<div class = "rating_star r_s_ur rating_star_unrated rating_star_unrated2">
														<img class = "img" src = "src/filled_star.png">

													</div>
													<div class = "rating_star r_s_ur rating_star_unrated rating_star_unrated3">
														<img class = "img" src = "src/filled_star.png">

													</div>
													<div class = "rating_star r_s_ur rating_star_unrated rating_star_unrated4">
														<img class = "img" src = "src/filled_star.png">

													</div>
													<div class = "rating_star r_s_ur rating_star_unrated rating_star_unrated5">
														<img class = "img" src = "src/filled_star.png">

													</div>

												</div>

												

												<div class = "grade_stars">
													<div class = "rating_star grey_star r_s_ur grating_star_unrated1">
														<img class = "img" src = "src/filled_star.png">
														
													</div>
													<div class = "rating_star grey_star r_s_ur grating_star_unrated2">
														<img class = "img" src = "src/filled_star.png">
														
													</div>
													<div class = "rating_star grey_star r_s_ur grating_star_unrated3">
														<img class = "img" src = "src/filled_star.png">
														
													</div>
													<div class = "rating_star grey_star r_s_ur grating_star_unrated4">
														<img class = "img" src = "src/filled_star.png">
														
													</div>
													<div class = "rating_star grey_star r_s_ur grating_star_unrated5">
														<img class = "img" src = "src/filled_star.png">
														
													</div>
												</div>


												<div class = "create-rating-stars-empty">
													<div class = "r_s_ur rating_star rating_star_empty1">
														<img class = "img" src = "src/empty_star.png">
													</div>
													<div class = "r_s_ur rating_star rating_star_empty2">
														<img class = "img" src = "src/empty_star.png">
													</div>
													<div class = "r_s_ur rating_star rating_star_empty3">
														<img class = "img" src = "src/empty_star.png">
													</div>
													<div class = "r_s_ur rating_star rating_star_empty4">
														<img class = "img" src = "src/empty_star.png">
													</div>
													<div class = "r_s_ur rating_star rating_star_empty5">
														<img class = "img" src = "src/empty_star.png">
													</div>
												</div>
												<div class = "help-div" id = "help-star-1">
													<div class = "help-star-wedge">
													</div>
													<div class = "help-star-box">
														Poor
													</div>
												</div>
												<div class = "help-div" id = "help-star-2">
													<div class = "help-star-wedge">
													</div>
													<div class = "help-star-box">
														Fair
													</div>
												</div>
												<div class = "help-div" id = "help-star-3">
													<div class = "help-star-wedge">
													</div>
													<div class = "help-star-box">
														Good
													</div>
												</div>

												<div class = "help-div" id = "help-star-4">
													<div class = "help-star-wedge">
													</div>
													<div class = "help-star-box">
														Very Good
													</div>
												</div>
												<div class = "help-div" id = "help-star-5">
													<div class = "help-star-wedge">
													</div>
													<div class = "help-star-box">
														Excellent
													</div>
												</div>
												
												
											</div>
											<div class = "tab-block-review">
												<div class = "review-pic">
												</div>
												<div class = "review-rightsec">
													<div class = "reviewer-name">
														Jacqueline Herssens
													</div>
													<div class = "reviewer-rating">
													</div>
													<div class = "review-text">
														Neurochemical Foundations of Behavior.... in the title of this establishment alone, you have everything that a student interested in psychology and medicine should love and recognize as awesome. Of all the courses I took in college, this one was definitely the greatest. For sure a "must take" class in the Neuro department. Professor Miller is the absolute best!
													</div>
													<div class = "review-actions">
														<button class = "like-btn"></button>
														<span class = "midline-dot">
															&#183;
														</span>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
									
								
							</div>
							<div class = "about-tab-rightsec">
								<div class = "group-about group-about-2">
									<div class = "box-header">
										<span class = "bh-t1">
											RECENT UPLOAD
										</span>
										<span class = "midline-dot">
											&#183;
										</span>
										<a style = "font-weight:600;" class = "bh-t2">
											Upload a file
										</a>
									</div>
									<div class = "box-content content-file">
										<a class = "file-download">
										<div class = "file-icon">
										</div>
										<div class= "file-name">
											Who is Ross Kopelman?
										</div>
										</a>
										<div class ="file-created">
											<a class = "file-creator">Jacob Lazarus</a> <span> uploaded July 8th</span>
										</div>
									</div>

									<div class = "box-header">
										<a class = "bh-t2">
											Invite email list
										</a>
									</div>
									<div class = "box-content content-invite">
										<form rel = "" method = "post">
											<input type = "hidden" autocomplete = "off">
											<i class = "plusIcon"></i>
											<div class = "invite-input-wrap">
												<div class = "innerWrap">
													<input type = "text" class = "inputText inviteInput" name = "Invite form" placeholder = "Invite people to join this course">
													<div class = "search-icon" title = "Search people">
													</div>
												</div>
											</div> 
										</form>
									</div>
								</div>
								<div class = "group-about-subjects">
									<div class = "box-header">
										Course <strong> Topics</strong>
										<span class = "help-icon-right">
										</span>
										<div class = "help-div" id = "help-1">
											<div class = "help-wedge">
											</div>
											<div class = "help-box">
												Add up to 10 topics that are covered in this course. Drag subjects up or down to order them as you like.
											</div>
										</div>
									</div>
									<div class = "group-subjects-wrap">
										<ul id = "sortable" class = "group-subjects ui-sortable">
											<li class = "ui-state-default subject">
												Genomics
											</li>
											<li class = "ui-state-default subject">
												Statistical Biology
											</li>
											<li class = "ui-state-default subject">
												Biological Algorithms
											</li>
											<li class = "ui-state-default subject">
												Data Mining  
											</li>
											<li class = "ui-state-default subject">
												Neural Networks  
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>


</html>