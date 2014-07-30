<!DOCTYPE html> 
<html>
	<head>
	<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
	<title>Profile</title>
	<link rel='stylesheet' type='text/css' href='css/backgroundProfile.css'>
	<link rel = 'stylesheet' type = 'text/css' href = 'css/professor.css'> 
	<link rel='stylesheet' href='//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css'>
	<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
	
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script src='//code.jquery.com/jquery-1.10.2.js'></script>
	<script src='//code.jquery.com/ui/1.10.4/jquery-ui.js'></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>	
	<script type="text/javascript" src="js/professor-profile.js"></script>	

	</head>

	<body>
		<section class='topbar_bag'>
	        <?php include 'topbar.php';?>
	    </section>
		<div class = 'root'>
			<div class = 'blacksheet-main editing-mode'>
			</div>
			<div class = 'showcaser'>
				<div class = 'showcase_box'>
				</div>
			</div>
			<div class = 'main-2'>
				<!--<header class = 'professor-header-2'>
					<div class = 'resource-wrapper resources-vacant'>
						<div class = 'no-showcase'>
							<div class = 'ns-title'>You have nothing showcased</div>
							<div class = 'ns-right-pointer-icon'>

							</div>
							<a class = 'ns-btn'>
								Add a Showcase
							</a>
						</div>

						<div class='clickable_showcase_step2 showcase_step2 extra-margin-sc'>
							<form class='hdform'><input type='file' class='step2_file'></form>
							<div class='step2_content_anchor'></div>
							<div class='showcase_step2_box showcase_left_box'>
								<div class='sc_txt'>Upload a Showcase</div>
								<div class='upload_sc_pic'></div>
							</div>
							<div class='showcase_step2_box showcase_right_box'>
								<div class='sc_txt'>Link a Showcase</div>
								<div class='link_sc_pic'></div>
							</div>
						</div>

					</div>
				</header>-->
				<div class = 'prof-header-bar-alias'>
					<div class = 'personal-website-wrap'>
						<div class = 'personal-website-wrap-header'>
							<label class = 'user-info-labels' for = 'user_website'>Your Personal Website URL</label>
						</div>
						<div class = 'website-inp-wrap'>
							<input type = 'text' id = 'user_website' name = 'user_website' class = 'user_website user_inp_full' placeholder = 'http://www...'>
						</div>
					</div>
					<div class = 'orig-edit-btns'>
						
						<a class = 'cancel-edit-profile'>
							Cancel
						</a>
						<a class = 'save-edit-profile'>
							Save Changes
						</a>	
					</div>
					<span class = 'profpic-container profpic-container-edit'>
					<form enctype="multipart/form-data" class='photo_hidden_form' >
                    	<input class="photo_fileup" id="profile_pic_upload" type="file" name="img"></input>
                	</form>
						<a class='photoup_simulator'>
						<span class = 'img img-inset user-pic img-wrap-edit'>

							<div class = 'user-pic-div user-pic-div-edit'></div>

						</span>
						</a>
						<div class = 'pic-text-icon-center'>
								<div class = 'pic-text-icon'>
								</div>
								<div class = 'pic-text'>
								Change your profile photo
								</div>
						</div>
						<a class = 'upload-pic-btn'>
							Upload a New Photo
						</a>					
					</span>
				</div>
				<div class = 'profile-content-2'>
					<div class = 'user-info-wrapper-2'>
						<div class = 'user-info-editable full-name-editable'>
							<div class = 'labels-halfs'>
								<label class = 'user-info-labels user-info-labels-half' for = 'user_fname'>First name</label>
								<label class = 'user-info-labels user-info-labels-half' for = 'user_lname'>Last name</label>
							</div>
							<div class = 'inputs-halfs'>
								<input type = 'text' id = 'user_fname' name = 'user_fname' placeholder = 'First name' class = 'user_inp_half user_fname' value = ' maxlength = '15'>
								<input type = 'text' id = 'user_lname' name = 'user_lname' placeholder = 'Last name' class = 'user_inp_half user_lname' value = ' maxlength = '15'>
							</div>
						</div>
						<div class = 'user-title'>
							About
						</div>
						<div class = 'user-info-editable about-editable'>
							<textarea id = 'user_about' name = 'user_about' class = 'user_about user_inp_big' placeholder = 'Bio' maxlength = '250'></textarea>
						</div>

						<div class = 'user-title'>
							Interests
						</div>

						<div class = 'user-info-editable interest-editable'>
							<textarea id = 'user_interest' name = 'user_interest' class = 'user_interest user_inp_big' placeholder = 'Introduce your Interests' maxlength = '250'></textarea>
						</div>

						<div class = 'user-info-editable'>
							<label class = 'user-info-labels' for = 'user_school'>School</label>
							<input type = 'text' id = 'user_school' name = 'user_school' class = 'user_school user_inp_full' placeholder = 'School'>
						</div>
						<div class = 'user-info-editable '>
							<label class = 'user-info-labels' for = 'user_dept'>Department</label>
							<input type = 'text' id = 'user_dept' name = 'user_dept' class = 'user_dept user_inp_full' placeholder = 'Department' maxlength = '25'>
						</div>
						<div class = 'user-info-editable '>
							<label class = 'user-info-labels' for = 'user_dept'>Designation</label>
							<input type = 'text' id = 'user_designation' name = 'user_designation' class = 'user_dept user_inp_full' placeholder = 'Department' maxlength = '25'>
						</div>
						<div class = 'user-info-editable'>
							<label class = 'user-info-labels' for = 'user_email'>Edu Email</label>
							<input type = 'text' id = 'user_email' name = 'user_email' class = 'user_email user_inp_full' placeholder = 'School email address' maxlength = '25'>
						</div>	
						<div class = 'user-info-editable '>
							<label class = 'user-info-labels' for = 'user_loc' style = 'top:-2px'>Office Location</label>
							<input type = 'text' id = 'user_loc' name = 'user_loc' placeholder = 'Building and Office Number' class = 'user_loc user_inp_full' maxlength = '25'>
						</div>	
								
					</div>
				</div>
			</div>
			<div class = 'main'>
				<header class = 'professor-header professor-header-nothing'>
					<div class = 'resource-wrapper resources-vacant'>
	 					<div class = 'no-showcase ns-hide'>
							<div class = 'ns-title'>You have nothing showcased</div>
							<div class = 'ns-right-pointer-icon'>

							</div>
							<a class = 'ns-btn'>
								Add a Showcase
							</a>
						</div>

						<div class='clickable_showcase_step2 showcase_step2'>
							<form class='hdform'><input type='file' class='step2_file'></form>
							<div class='step2_content_anchor'></div>
							<div class='showcase_step2_box showcase_left_box'>
								<div class='sc_txt'>Upload a Showcase</div>
								<div class='upload_sc_pic'></div>
							</div>
							<div class='showcase_step2_box showcase_right_box'>
								<div class='sc_txt'>Link a Showcase</div>
								<div class='link_sc_pic'></div>
							</div>
						</div>

						<div class = 'professor-showcase' style = 'display:none'>
							<div class = 'showcase-container'>
								<div class = 'showcase-title st-one'>
									The Out of Africa Diaspora
								</div>
								<a class = 'showcase-link showcase-link-read'>
									Read Article
								</a>								
							</div>
							<div class = 'showcase-container st-two'>
								<div class = 'showcase-title'>
									Orthologs versus Paralogs
								</div>	
								<a class = 'showcase-link showcase-link-read'>
									Read Article
								</a>														
							</div>
							<div class = 'showcase-container st-three'>
								<div class = 'showcase-title'>
									The Case for Genetic Entrepreneurship
								</div>
								<a class = 'showcase-link showcase-link-download'>
									Download Article
								</a>							
							</div>
						</div>
					</div>
				</header>
				<div class = 'profile-main'>
					<a class = 'office-hours-editor oh-editor-fx'>
						Edit Office Hours
					</a>
					<div class = 'profile-options has-dropdown'>
						<h1>
							<a href = '#'>
								<span class='info_username' id='profile_name'></span>
							</a>
						</h1>
						<a class = 'user-website'>
							<span class = 'website-icon'>
							</span>
							<div class = 'website-title-hider'>
								<span class = 'website-title' title = '' id='profile_link'>
									
								</span>
							</div>
						</a>

							<span class = 'office-hours'>
								<p>OFFICE HOURS</p>
									<b id='profile_office_hours'></b>
								<span class = 'office-hours-status in-office'></span>
							</span>

					</div>
						
						<div class = 'blacksheet'>

						<div class = 'edit_office_hours_wrap'>
							<div class = 'edit_office_hours_frame'>
								<div class = 'oh_day_select'>
									<input class='oh_checkbox' id='oh_check_mon' type='checkbox'>
									<label tabindex='2' for='oh_check_mon' class='oh_checkbox_label'>Monday</label>
									<div class = 'time_select_fx'>
										<div class = 'uw_outline'>
										</div>
										<div class = 'uw_solid'>
										</div>
										<div class = 'time_select_main'>
											<input id = 'mo_off_hr_start_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'Start Time'>
											<input id = 'mo_off_hr_end_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'End Time'>
										</div>
									</div>
								</div>
								<div class = 'oh_day_select'>
									<input class='oh_checkbox' id='oh_check_tue' type='checkbox'>
									<label tabindex='2' for='oh_check_tue' class='oh_checkbox_label'>Tuesday</label>
									<div class = 'time_select_fx'>
										<div class = 'uw_outline'>
										</div>
										<div class = 'uw_solid'>
										</div>
										<div class = 'time_select_main'>
											<input id = 'tu_off_hr_start_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'Start Time'>
											<input id = 'tu_off_hr_end_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'End Time'>
										</div>
									</div>
								</div>
								<div class = 'oh_day_select'>
									<input class='oh_checkbox' id='oh_check_wed' type='checkbox'>
									<label tabindex='2' for='oh_check_wed' class='oh_checkbox_label'>Wednesday</label>
									<div class = 'time_select_fx'>
										<div class = 'uw_outline'>
										</div>
										<div class = 'uw_solid'>
										</div>
										<div class = 'time_select_main'>
											<input id = 'we_off_hr_start_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'Start Time'>
											<input id = 'we_off_hr_end_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'End Time'>
										</div>
									</div>
								</div>
								<div class = 'oh_day_select'>
									<input class='oh_checkbox' id='oh_check_thu' type='checkbox'>
									<label tabindex='2' for='oh_check_thu' class='oh_checkbox_label'>Thursday</label>
									<div class = 'time_select_fx'>
										<div class = 'uw_outline'>
										</div>
										<div class = 'uw_solid'>
										</div>
										<div class = 'time_select_main'>
											<input id = 'th_off_hr_start_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'Start Time'>
											<input id = 'th_off_hr_end_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'End Time'>
										</div>
									</div>
								</div>
								<div class = 'oh_day_select'>
									<input class='oh_checkbox' id='oh_check_fri' type='checkbox'>
									<label tabindex='2' for='oh_check_fri' class='oh_checkbox_label'>Friday</label>
									<div class = 'time_select_fx'>
										<div class = 'uw_outline'>
										</div>
										<div class = 'uw_solid'>
										</div>
										<div class = 'time_select_main'>
											<input id = 'fr_off_hr_start_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'Start Time'>
											<input id = 'fr_off_hr_end_time_24hr' class = 'ui-autocomplete-inpu set_time' name = 'event_time' autocomplete='off' placeholder = 'End Time'>
										</div>
									</div>
								</div>
										
							</div>
							<a class = 'office-hours-editor done-editing'>
								Done Editing
							</a>
						</div>

					</div>

					<div class = 'edit-profile-main-wrap'>
						<a class = 'edit-profile'>
							Edit Profile
						</a>
					
					</div>

					<span class = 'profpic-container profpic-container-real'>
						<span class = 'img img-inset user-pic'>
							<div class = 'user-pic-div user-pic-div-my' id='profile_picture'></div>
							
						</span>

					</span>

				</div>
				<div class = 'profile-content'>
					<div class = 'user-info-wrapper'>
						<h5>ABOUT</h5>
						<span class = 'profile-bio-container' id='profile_about'>
							
						</span>

						<h5 class='secondh5'>Interests</h5>
						<span class = 'profile-ints-container' id='profile_interests'>
									
						</span>

						<span class = 'user-info-piece'>
							<a>	
								<div class = 'small-icon department_icon' style = 'background-image: url(src/nyu_poly.jpg);'>
								</div>
								<div class = 'info-piece-text-wrapper'>
									<p style='float:left;'>Teaches at </p>									
									<h4 class='info_field_0' id='profile_teaches_at' style='padding-left:2px; top:-2px;'></h4>
								</div>
							</a>
						</span>

						<span class = 'user-info-piece'>
							<a>
								<div class = 'small-icon department_icon' style = 'background-image: url(src/physics_icon.png);'>
								</div>
								<div class = 'info-piece-text-wrapper'>
									<h4 class='info_field_1' id='profile_dept_name'></h4>
									
								</div>
							</a>
						</span>

						<span class = 'user-info-piece plainText'>							
								<div class = 'small-icon department_icon' style = 'background-image: url(src/designationbadges.png);'>
								</div>
								<div class = 'info-piece-text-wrapper'>
									<h4 class='info_field_1 plainText' id='profile_designation'></h4>
									
								</div>							
						</span>
						<span class = 'user-info-piece info-piece-oneline plainText'>							
								<div class = 'small-icon email_icon' style = 'background-image: url(src/email.png);'>
								</div>
								<div class = 'info-piece-text-wrapper'>
									<h4 class='info_field_0 plainText' id='profile_mail_id'></h4>							
								</div>
						</span>
						
							<span class = 'user-info-piece info-piece-oneline plainText'>								
									<div class = 'small-icon location_icon' style = 'background-image:url(src/location.png);'>
									</div>
									<div class = 'info-piece-text-wrapper'>
										<h4 class='info_field_3 plainText' id='profile_office_location'></h4>																	
									</div>
							</span>						
						<br>
						<br>
						<br>
						<div class = 'user-events'>
						</div>	
					</div>
					<div class = 'user-groups'>
						<div class = 'user-groups-tabs'>
							<div class = 'tab-active professor-tab tab-1'>
								<span class = 'prof-tab-1'>Posts</span>
								<span class = 'tab-count prof-tab-1'>4</span>
							</div>						
							<div class = 'tab-inactive professor-tab tab-2'>
								<span class='prof-tab-2'>Courses</span>
								<span class = 'tab-count prof-tab-2'>4</span>
							</div>
							<div class = 'professor-tab tab-inactive tab-3'>
								<span class='prof-tab-3'>Following</span>
								<span class = 'tab-count prof-tab-3'>175</span>							
							</div>
							<div class = 'professor-tab tab-inactive tab-4'>
								<span class='prof-tab-4'>Followers</span>
								<span class = 'tab-count prof-tab-4'>195</span>								
							</div>	
							<b class = 'tab-indicator'>
								<em class = 'caret-transform'>
								</em>
							</b>											
						</div>
						<div class = 'user-tab-discussions-content'>
							<?php 						

								if(isset($_GET['user_id'])){
									$path = 'feeds.php';
									include $path; 
								}
							?>
						</div>

						<div class = 'user-tab-groups-content'>
							<div class = 'user-groups-courses'>

						<div class = 'professor-group course-group'>
										<a class = 'group-link'>
											<div class = 'group-pic'>
											</div>
											<h3>Course name</h3>
											
										</a>	
										<div class = 'admin-group-functions'>
											<div class='gfunction'><span>course id (sec id)</span></div>
											<div class='gfunction'><span>
											MWF 2:00- 3:00 PM
											</span></div>
											<div class='gfunction'><span>47 students</span></div>
										</div>						
									</div><br/>						

							</div>
						</div>

						<div class = 'user-tab-following-content'>
							
							
							<div class = 'member'>
								<div class = 'member-person prof-member-person'>
									<div class = 'member-wrap prof-member-wrap'>
										<div class = 'person-thumb'>
											<div class = 'picwrap' style = 'background-image:url(src/dummy-pic.jpg)'></div>
											<div class = 'member-bio'>
												<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
												<strong>View Profile</strong>
											</div>
										</div>
										<h3 class = 'person-title'>
											<strong>Professor Zeroni</strong>
											<span>
												<a>NYU College of Arts and Sciences</a>
											</span>
										</h3>
										<div class = 'follow-btn'>
											<a class = 'follow'>
												Follow
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class = 'member'>
								<div class = 'member-person prof-member-person'>
									<div class = 'member-wrap prof-member-wrap'>
										<div class = 'person-thumb'>
											<div class = 'picwrap' style = 'background-image:url(src/dummy-pic.jpg)'></div>
											<div class = 'member-bio'>
												<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
												<strong>View Profile</strong>
											</div>
										</div>
										<h3 class = 'person-title'>
											<strong>Professor Zeroni</strong>
											<span>
												<a>NYU College of Arts and Sciences</a>
											</span>
										</h3>
										<div class = 'follow-btn'>
											<a class = 'follow'>
												Follow
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class = 'member'>
								<div class = 'member-person prof-member-person'>
									<div class = 'member-wrap prof-member-wrap'>
										<div class = 'person-thumb'>
											<div class = 'picwrap' style = 'background-image:url(src/dummy-pic.jpg)'></div>
											<div class = 'member-bio'>
												<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
												<strong>View Profile</strong>
											</div>
										</div>
										<h3 class = 'person-title'>
											<strong>Professor Zeroni</strong>
											<span>
												<a>NYU College of Arts and Sciences</a>
											</span>
										</h3>
										<div class = 'follow-btn'>
											<a class = 'follow'>
												Follow
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class = 'member'>
								<div class = 'member-person prof-member-person'>
									<div class = 'member-wrap prof-member-wrap'>
										<div class = 'person-thumb'>
											<div class = 'picwrap' style = 'background-image:url(src/dummy-pic.jpg)'></div>
											<div class = 'member-bio'>
												<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
												<strong>View Profile</strong>
											</div>
										</div>
										<h3 class = 'person-title'>
											<strong>Professor Zeroni</strong>
											<span>
												<a>NYU College of Arts and Sciences</a>
											</span>
										</h3>
										<div class = 'follow-btn'>
											<a class = 'follow'>
												Follow
											</a>
										</div>
									</div>
								</div>
							</div>


							
						</div>
						<div class = 'user-tab-followers-content'>
							
							<div class = 'member'>
								<div class = 'member-person prof-member-person'>
									<div class = 'member-wrap prof-member-wrap'>
										<div class = 'person-thumb'>
											<div class = 'picwrap' style = 'background-image:url(src/dummy-pic.jpg)'></div>
											<div class = 'member-bio'>
												<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
												<strong>View Profile</strong>
											</div>
										</div>
										<h3 class = 'person-title'>
											<strong>Professor Zeroni</strong>
											<span>
												<a>NYU College of Arts and Sciences</a>
											</span>
										</h3>
										<div class = 'follow-btn'>
											<a class = 'follow'>
												Follow
											</a>
										</div>
									</div>
								</div>
							</div>


							<div class = 'member'>
								<div class = 'member-person prof-member-person'>
									<div class = 'member-wrap prof-member-wrap'>
										<div class = 'person-thumb'>
											<div class = 'picwrap' style = 'background-image:url(src/dummy-pic.jpg)'></div>
											<div class = 'member-bio'>
												<span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>
												<strong>View Profile</strong>
											</div>
										</div>
										<h3 class = 'person-title'>
											<strong>Professor Zeroni</strong>
											<span>
												<a>NYU College of Arts and Sciences</a>
											</span>
										</h3>
										<div class = 'follow-btn'>
											<a class = 'follow'>
												Follow
											</a>
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