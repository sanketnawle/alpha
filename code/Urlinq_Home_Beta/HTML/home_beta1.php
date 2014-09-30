<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="fbar.css">
<link rel="stylesheet" type="text/css" href="background.css">
<link rel = "stylesheet" type = "text/css" href = "planner.css">
 <script src='md5.js'></script> 
 <link rel="stylesheet" type="text/css" href="datepicker.css"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='http://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src = "fbar.js"></script>
<script src = "planner.js"></script>

</head>
<body>
	<div class = "root">
		<div class = "top-bar">
			<div class = "top-bar-wrapper">
				<img class = "logo-h" src = "src/logo.png">
				</img>


			</div>
		</div>
		<div class = "main">
			<div class = "wrapper">
				<div class = "mainContainer">
					<div class = "leftsec">
					</div>
					<div class = "content-wrap">

						<div class = "midsec">
							<div id = "fbar" class = "fb">
								<div>
									<div class = "post fani">
										<div class = "fbtn fbtn-post">
											Post Status 
										</div>
									</div>
									<div class = "share fani">
										<div class = "fbtn fbtn-upload">
											Share Notes
										</div>							
									</div>
									<div class = "find fani">
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

									<div class = "post_state">						
										<div class ="textwrap">
											<textarea name = "message" class = "postTxtarea"placeholder = "What have you read lately?" ></textarea>
										</div>	
										<div class = "btmfbar">
											<div class = "lfloat-mods">
												<div class = "lfloat-attach">
													<a class = "attach-mod" href = "#" title = "Attach a file to your post">
														<span class = "attach-icon">
														</span>
													</a>
												</div>
												<div class = "lfloat-anon">
													<input class = "anon-checker" title = "Post anonymously" type="checkbox">
													<p class= "anon-setting">Posted by Jacob Lazarus</p>


												</div>
											</div>
											<div class="search-select">
												<span title = "Who can see this post?" class="field">
													<label class="seltext" for="open">Only Students</label><i class="icon user"></i>
												</span>
												<input id="open" type="checkbox" />
												<ul class="select">
													<li class="icon arrow selitem"></li>
													<li class="selitem">Only Faculty<i class="icon list"></i>
													</li>

													<li class="selitem">Only Students<i class="icon user"></i></li>

													<li class="selitem"><span class = "spanCampus">Campus</span><i class="icon stat"></i></li>
													<li class="selitem">Only Me<i class="icon accs"></i></li>

												</ul>
											</div>
											<div class = "post-btn">
												Post
											</div>
										</div>	
									</div>
									<div class = "upload_state">						
										<div class ="textwrap">
											<textarea name = "file_desc" class = "uploadTxtarea"placeholder = "Say something about this file..." ></textarea>
										</div>	
										<div class = "uploadMode">
											<div class = "localUpload">
												<div class = "upl_wrap">
													<div class = "upl_head">
														From Your Computer
													</div>
													<div class = "upl_btn">
														<a class = "upl_anc">
															<span class = "uplbtnText">Choose File</span>
															<div class = "_upl">
																<input type = "file" class = "_uplI" title = "Choose a file to upload" name = "file1">
															</div>
														</a>
													</div>
													<div class = "uplName">
														No file chosen
													</div>
												</div>
											</div>
											<div class = "driveUpload">
												<div class = "upl_wrap">
													<span class = "iconText">
														<img class = "icon" src = "src/drive_icon.png" width = "16" height = "16">
														<div class = "upl_head">
															From Your Drive
														</div>	
														<div class = "upl_btn2">
															<a class = "upl_anc">
																<span class = "uplbtnText">Choose File</span>
																<div class = "_upl">
																	<input type = "file" class = "_uplI" title = "Choose a file to upload" name = "file1">

																</div>
															</a>
														</div>
														<div class = "uplName">
															No file chosen
														</div>															
													</span>	
												</div>							
											</div>
										</div>
										<div class = "btmfbar2">
											<div class="search-select">
												<span title = "Who can see this post?" class="field">
													<label class="seltext" for="open">Only Students</label><i class="icon user"></i>
												</span>
												<input id="open" type="checkbox" />
												<ul class="select">
													<li class="icon arrow selitem"></li>
													<li class="selitem">Only Faculty<i class="icon list"></i>
													</li>

													<li class="selitem">Only Students<i class="icon user"></i></li>

													<li class="selitem"><span class = "spanCampus">Campus</span><i class="icon stat"></i></li>
													<li class="selitem">Only Me<i class="icon accs"></i></li>

												</ul>
											</div>
											<div class = "post-btn">
												Post 
											</div>
										</div>	
									</div>	
									<div class = "ask_state">
										<div class = "topfbar-wrap">
											<div class = "quest-wrap">
												<div class = "quest-dyn"><div class = "quest-icon"></div></div>
												<input placeholder = "What's your question? Be specific" class = "topfbar questtxt"></input>
											</div>
										</div>

										<div class = "midfbar-wrap">
											<div class = "midfbar-wrap2">
												<div class = "who-wrap">
													<div class = "who-dyn"><div class = "who-icon"></div></div>
													<div class = "midfbar-exp">
														<div class ="who-default">
															Campus
														</div>
														<input placeholder = "+ Ask experts" class = "add_who"></input>
													</div>
													<div class = "who-explain">
														<div class = "who-explain-box">
															<div class = "who-wedge">
															</div>
															<b>Ask an Expert</b>
															<p>Choose who will see your question by typing a subject area, or the name of someone at your school</p>
														</div>


													</div>
												</div>
											</div>
										</div>
										<div class = "btmfbar3">
											<div class = "lfloat-mods">
												<div class = "lfloat-attach">
													<a class = "attach-mod" href = "#" title = "Attach a file to your post">
														<span class = "attach-icon">
														</span>
													</a>
												</div>
												<div class = "lfloat-anon">
													<input class = "anon-checker" title = "Post anonymously" type="checkbox">
													<p class= "anon-setting">Posted by Anonymous</p>
												</div>
											</div>
											<div class = "post-btn">
												Post 
											</div>
										</div>	
									</div>									
								</div>


							</div>
						</div>
						<div class = "rightsec">
							<div class = "n_pf_5">
								<div class = "planner">
									<div class = "pl_head">
										<div class = "pl_head_wrap">
											<div class = "floatL">
												<div class = "text1">MY PLANNER</div>
												<i class="fa fa-caret-down"></i>
												<div class = "pl_options">
													<div class = "pl_option">View my full planner</div>
													<div class = "pl_option">View my monthly calendar</div>
													<div class = "pl_option">Hide all upcoming</div>
												</div>
											</div>
											<div class = "floatR">
												<div class = "upcomingNmbr">4 Incomplete</div>

											</div>

										</div>
									</div>
									<div class = "add_upcoming">
										<form>
											<textarea placeholder = "+ Add new Event" class = "pl_add"></textarea>
											<div class = "pl_addevnt">
												When
												<div class = "evnt_inps">
													<input class = "set_date"
													</input>

													<input placeholder = "Add a time?" class = "set_time"></input>
													<div class = "calLayer">
														<section id = "mounth" class="mounth">
												           <header class="minical-header">
												           <h1 class="minical-h1">JANUARY 2013</h1>

												           <nav role='padigation'>
												           <span class="m-prev"></span>
												           <span class="m-next"></span>
												           </nav>
												           </header>
												           
												           <article>
												           <div class="days">
												           <b>SU</b>
												           <b>MO</b>
												           <b>TU</b>
												           <b>WE</b>
												           <b>TH</b>
												           <b>FR</b>
												           <b>SA</b>
												           </div>
												           <div class="dates">
												           <span id="calcell_su_0" class="calcell disable cl_0"></span>
												           <span id="calcell_mo_1" class="calcell disable cl_1"></span>
												           
												           <span id="calcell_tu_2" class="calcell disable cl_2"></span>
												           <span id="calcell_we_3" class="calcell disable cl_3"></span>
												           <span id="calcell_th_4" class="calcell disable cl_4"></span>
												           <span id="calcell_fr_5" class="calcell disable cl_5"></span>
												           <span id="calcell_sa_6" class="calcell disable cl_6"></span>
												           <span id="calcell_su_7" class="calcell disable cl_7"></span>
												           <span id="calcell_mo_8" class="calcell disable cl_8"></span>
												           <span id="calcell_tu_9" class="calcell disable cl_9"></span>
												           <span id="calcell_we_10" class="calcell disable cl_10"></span>
												           <span id="calcell_th_11" class="calcell disable cl_11"></span>
												           <span id="calcell_fr_12" class="calcell disable cl_12"></span>
												           <span id="calcell_sa_13" class="calcell disable cl_13"></span>
												           <span id="calcell_su_14" class="calcell disable cl_14"></span>
												           <span id="calcell_mo_15" class="calcell disable cl_15"></span>
												           <span id="calcell_tu_16" class="calcell disable cl_16"></span>
												           <span id="calcell_we_17" class="calcell disable cl_17"></span>
												           <span id="calcell_th_18" class="calcell disable cl_18"></span>
												           <span id="calcell_fr_19" class="calcell disable cl_19"></span>
												           <span id="calcell_sa_20" class="calcell disable cl_20"></span>
												           <span id="calcell_su_21" class="calcell disable cl_21"></span>
												           <span id="calcell_mo_22" class="calcell disable cl_22"></span>
												           <span id="calcell_tu_23" class="calcell disable cl_23"></span>
												           <span id="calcell_we_24" class="calcell disable cl_24"></span>
												           <span id="calcell_th_25" class="calcell disable cl_25"></span>
												           <span id="calcell_fr_26" class="calcell disable cl_26"></span>
												           <span id="calcell_sa_27" class="calcell disable cl_27"></span>
												           <span id="calcell_su_28" class="calcell disable cl_28"></span>
												           <span id="calcell_mo_29" class="calcell disable cl_29"></span>
												           <span id="calcell_tu_30" class="calcell disable cl_30"></span>
												           <span id="calcell_we_31" class="calcell disable cl_31"></span>
												           <span id="calcell_th_32" class="calcell disable cl_32"></span>
												           
												           <span id="calcell_fr_33" class="disable calcell cl_33"></span>
												           <span id="calcell_sa_34" class="disable calcell cl_34"></span>
												           <span id="calcell_su_35" class="disable calcell cl_35"></span>
												           <span id="calcell_mo_36" class="disable calcell cl_36"></span>
												           <span id="calcell_tu_37" class="disable calcell cl_37"></span>
												           <span id="calcell_we_38" class="disable calcell cl_38"></span>
												           <span id="calcell_th_39" class="disable calcell cl_39"></span>
												           <span id="calcell_fr_40" class="disable calcell cl_40"></span>
												           <span id="calcell_sa_41" class="disable calcell cl_41"></span>
												           </div>
												           </article>
											           </section>
													</div>
												</div>
												<div class = "evnt_create">
													<a class = "btn_canc">Cancel</a>
													<button class = "btn_addvent" type = "submit">Add</button>
												</div>
											</div>
										</form>
									</div>
									<div class = "upcomingEvnt-wrapper">
										<div class = "pl_day">
											<div class = "fl_l"> Today May 21</div>

										</div>

										<div class = "upcoming upc-1">
											<div class = "upc-floatL">
												<div class = "current time">Now</div>
											</div>
											<div class = "upc-eventL">
												<div class = "evntName">Neurochemical Foundations of Behavior Final Exam</div>
											</div>

											<div class="toDowrapper" id="w-2-2">
							                    <div class="button-block">
							                        <button type="button">
							                            <i class="mark x"></i>
							                            <i class="mark xx"></i>
							                        </button>
							                    </div>
							                </div>  
																					
										</div>
										<div class = "upcoming upc-1">
											<div class = "upc-floatL">
												<div class = "time">11:00am</div>
											</div>
											<div class = "upc-eventL">
												<div class = "evntName">The Role of the State Paper #3: Japan’s Meiji Restoration</div>
											</div>

											<div class="toDowrapper" id="w-2-2">
							                    <div class="button-block">
							                        <button type="button">
							                            <i class="mark x"></i>
							                            <i class="mark xx"></i>
							                        </button>
							                    </div>
							                </div>  
																					
										</div>
										<div class = "pl_day">
											<div class = "fl_l"> Thursday May 22</div>

										</div>
										<div id = "one-liner" class = "upcoming upc-1">
											<div class = "upc-floatL">
												<div class = "time">12:30pm</div>
											</div>
											<div class = "upc-eventL">
												<div class = "evntName">Physics Lecture</div>
											</div>

											<div class="toDowrapper" id="w-1">
							                    <div class="button-block">
							                        <button type="button">
							                            <i class="mark x"></i>
							                            <i class="mark xx"></i>
							                        </button>
							                    </div>
							                </div>  
																					
										</div>
										<div class = "upcoming upc-1">
											<div class = "upc-floatL">
												<div class = "time">11:00am</div>
											</div>
											<div class = "upc-eventL">
												<div class = "evntName">Computational Biology Extra Credit</div>
											</div>

											<div class="toDowrapper" id="w-2-2">
							                    <div class="button-block">
							                        <button type="button">
							                            <i class="mark x"></i>
							                            <i class="mark xx"></i>
							                        </button>
							                    </div>
							                </div>  
																					
										</div>


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