<!DOCTYPE html>
<?php 
     include "../includes/common_functions.php";
     include "../php/dbconnection.php";
     $university=1;
     $user_id=348;
?> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="backgroundGroup.css">
<link rel = "stylesheet" type = "text/css" href = "feedGroup.css"> 
<link rel = "stylesheet" type = "text/css" href = "group.css"> 
<link rel = "stylesheet" type = "text/css" href = "school_department.css"> 

<link rel = "stylesheet" type = "text/css" href = "leftmenu.css"><link rel="stylesheet" type="text/css" href="planner.css">
<script src='md5.js'></script>
<link rel="stylesheet" type="text/css" href="datepicker.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

 <script src="feed.js"></script> 
 <script src="school.js"></script> 
  <script src="group.js"></script> 
  <script src="leftmenu.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


<script>


$(document).ready(function() {
	var university=$('#univ_id').val();
	var user_id=$('#user_id').val();
	$('.studybtn').mouseenter(function(){
		$(".modal_loading2").css({"display":"none","opacity":"0"});
		$(".js_wrap").css({"height":"auto","opacity":"1"});
		$(".study_box_open").show();
		setTimeout(
			function(){
      		 $(".study_box_open").css({"top":"3px","height":"18px","opacity": "1"});
      		 setTimeout(
			function(){
				$(".study_box_open").css({"height":"150px"});
			},
			300)
      		},
      		400)


    });



    $('.study_box_open').mouseleave(function(){
    	
        setTimeout(
            function(){
               $(".study_box_open").css({"top":"3px","height":"0px","opacity": "0"},
               	function(){
					$(".study_box_open").hide();
               	});
            }, 
            350)



    });

    $('.group_location').mouseenter(function(){
    	$(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").show();
        $(this).closest(".group-head-top-sec").find(".modal_loading3").delay(200).animate({opacity:0},150, function(){
				$(this).closest(".group-head-top-sec").find(".location-pic-container").delay(50).css({"height":"160"});
				$(this).closest(".group-head-top-sec").find(".location_building_pic").show();

		});





    });


   	$('.group_location').mouseleave(function(){
   		$(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").hide();
   		$(this).closest(".group-head-top-sec").find(".location-pic-container").css({"height":"60px"});
   		$(this).closest(".group-head-top-sec").find(".modal_loading3").css({"opacity":"1"});
   		$(this).closest(".group-head-top-sec").find(".location_building_pic").hide();
   	});

    $(document).delegate('.study_type_btn',"click", function(){
    	
    	if(!$(this).hasClass("pressedGraybtn")){
    		$(".pressedGraybtn").find(".check").animate({left:0,opacity:0},150, function(){
    				$(this).find(".check").delay(400).hide();
    		});
    		$(".pressedGraybtn").removeClass("pressedGraybtn");
    		$(this).prepend("<em class = 'check'></em>");
    		$(this).find(".check").animate({left:16,opacity:1},200, function(){
    			$(this).closest(".js_wrap").delay(250).animate({height:0,opacity:0},300);
    			$(".modal_loading2").show();
    			$(".modal_loading2").delay(500).animate({opacity:1},100, function(){
    				setTimeout(
    					function(){
    						$(".study_box_open").css({"top":"3px","height":"0px","opacity": "0"});

    					},
    					200)
    				
    			});
    			

    		});



    		$(this).addClass("pressedGraybtn");


			if($(this).hasClass("majorType")){
    			$(".studybtn").text("My Major");
    		}
    		if($(this).hasClass("minorType")){
    			$(".studybtn").text("My Minor");
    		}
    		if($(this).hasClass("interestType")){
    			$(".studybtn").text("My Interest");
    		}


    	}




    	else{
    		$(this).find(".check").animate({left:0,opacity:0},150, function(){
    			$(this).find(".check").delay(400).hide();
    		});
    		$(this).removeClass("pressedGraybtn");
    		$(".studybtn").text("Concentrate");
    		
    	}
    	
    });


	$(document).delegate('.group-cover-pic-info',"click", function(){
		$('body,html').animate({
				scrollTop: 0
			}, 200);
	});

	$(window).scroll(function() {
		var y=$(window).scrollTop()*0.32;
		var x=$(window).scrollTop()*1;
		//alert(y);
		$(".group-cover-picture").css({"transform":"translateY("+y+"px)"});
		$(".spec-group-header-right").css({"height":y+"px"});

		if($(window).scrollTop()>=5){
			$(".info-scroll-up").css("cursor","pointer");
			$(".em_hide").css({
				"width":"12px",
				"opacity":"1"
			});
		}
		else{
			$(".info-scroll-up").css("cursor","default");
			$(".em_hide").css({
				"width":"0",
				"opacity":"0"
			});
		}


	});

	$(window).scroll(function() {

		if($(window).scrollTop()>175){
			$(".info-scroll-up").css({"position":"absolute","top":"175px"});
			$(".spec-group-header-right").css({"position":"absolute","top":"177px","left":"777px"})
		}
		else{
			$(".info-scroll-up").css({"position":"fixed","top":"50px"});
			$(".spec-group-header-right").css({"position":"fixed","top":"50px","left":"1097px"});
		}

	});

	$('.cancelBtn').click(function(){
		$(".modal_body").animate({opacity:0},300,function(){
			$(this).closest(".modal_body").hide();
			$(".modal_coverPhoto_container").css({"height":"60px","width":"320px"});
			$(".modal_content").hide();
			$(".modal_content").css("opacity","0");
			$(".main").removeClass("fe");
		});

	});

	$('.upload_cover').click(function(){
	    $(".modal_loading").show();
	    $(".modal_loading").css("opacity","1");
	    $(".main").addClass("fe");
		$(".modal_coverPhoto_body").show();
		$(".modal_coverPhoto_body").animate({opacity:1},400, function(){
			$(".modal_loading").delay(250).animate({opacity:0},100);
			$(".modal_loading").hide();
			$(".modal_content").show();
			$(".modal_content").delay(500).animate({opacity:1},200);
			$(".modal_coverPhoto_container").animate({
				height:355,
				width:520
			},500, function(){
				$(".inputPhotoName").focus();
			});
		});
		$("html, body").animate({ scrollTop: 150 }, 600);

	    return false;
	 });


	$(document).delegate(".followBtn","click",function(){
		if(!$(this).hasClass("unfollowBtn")){
			$(".study_box_open").css("left","112px");
			$(this).html("<em class = 'unfollow-icon'></em>Unfollow");
			$(this).addClass("unfollowBtn");
		}
		else{
			$(".study_box_open").css("left","88px");
			$(this).html("<em></em>Folow");
			$(this).removeClass("unfollowBtn");
		}
	});


	$(document).delegate(".tab-inactive","click",function(){
		if($(this).hasClass("tabDepartments")){
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
			}

			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}

			$(this).find(".tab-title").find(".tab-icon").removeClass("tab2-icon-inactive");
			$(this).find(".tab-title").find(".tab-icon").addClass("tab2-icon-active");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".tab-wedge-down").css("left","460px");
			$(this).removeClass("tab-inactive");
			$(this).addClass("group-tab-active");
			$(".feed-tab-content").hide();
			$(".feed-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").hide();
			$(".about-content").stop().animate({ opacity: "0"},300);
			$(".about-content").hide();
			$(".files-tab-content").stop().animate({ opacity: "0"},300);
			$(".files-tab-content").hide();
			$(".members-tab-content").stop().animate({ opacity: "0"},300);
			$(".members-tab-content").hide();
			$(".departments-tab-content").animate({ opacity: "1"},300);
			
			$.ajax({  
            		type: "POST",  
            		url: "../php/getdepartment.php",
            		datatype:"json",
            		data: { univ_id_school : university,user_id_school:user_id},
            	    success: function(response) {
                         console.log(response[0].members);

            	    }
            });	      

			
			$(".departments-tab-content").show();

		}
		if($(this).hasClass("tabmembers")){
			
			
			
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
			}
			if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
				$(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
				$(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
			}
			$(this).find(".tab-title").find(".tab-icon").removeClass("tab3-icon-inactive");
			$(this).find(".tab-title").find(".tab-icon").addClass("tab3-icon-active");
			$(".group-tab-active").addClass("tab-inactive");
			$(".group-tab-active").removeClass("group-tab-active");
			$(".tab-wedge-down").css("left","591px");
			$(this).removeClass("tab-inactive");
			$(this).addClass("group-tab-active");

			$(".feed-tab-content").stop().animate({ opacity: "0"},300);
			$(".feed-tab-content").hide();
			$(".departments-tab-content").stop().animate({ opacity: "0"},300);
			$(".departments-tab-content").hide();
			$(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
			$(".syllabus-tab-content").hide();
			$(".about-content").stop().animate({ opacity: "0"},300);
			$(".about-content").hide();
			$(".files-tab-content").stop().animate({ opacity: "0"},300);
			$(".files-tab-content").hide()
			
			$.ajax({  
            		type: "POST",  
            		url: "../php/getdepartment.php",
            		datatype:"json",
            		data: { univ_id_school : university},
            	    success: function(response) {
                        // console.log(response);

            	    }
            });	
            $(".member-tab-content")
        $(".members-tab-content").show();
			$(".members-tab-content").animate({ opacity: "1"},300);

			
			
			
		}
	});
});
$(document).ready(function() {

       window.scroll(0,175); 




});
</script>
</head>
<body>
	<input type="hidden" id="univ_id" class="univ_id" value="<?php echo $university; ?>">
	<input type="hidden" id="user_id" class="user_id" value="<?php echo $user_id; ?>">
	<div class = "root">
		<div class = "modal_coverPhoto_body modal_body">
			<div class = "modal_coverPhoto_container">
				<div class = "modal_loading">
					<img class = "modal_animation" src = "src/loadingAnimation.gif">
				</div>
				<div class = "modal_content">
					<div class = "modal_header">
						<span class = "floatL white">
							Submit Cover Photo
						</span>
						<em class = "floatR cancelBtn close">
						</em>
					</div>
					<div class = "modal_main">
						<form>
							<label for = "cover_name" class = "label_left">
								Cover Photo Name
							</label>
							<input class = "inputBig inputPhotoName" id = "cover_name" placeholder = "Enter a name for this photo...">
							<div class = "uploadedPhotoFrame">
								<div class = "noPhotoText">
									No photo uploaded
								</div>
								<div class = "photoicon">
								</div>
								
								<button class = "uploadPhotoBtn">
									Upload Photo
								</button> 
							</div>
							<div class = "btmleft">

								<button type=  "button" class = "cancelBtn grayBtn">
									Cancel
								</button> 
								<button type=  "button" class = "blueBtn">
									Submit
								</button> 
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
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
									<div class = "group-name">NYU Polytechnic School of Engineering
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

				<div class = "mid_right_sec mid_right_sec_school">
					<div class = "group-head-sec">
						<div class = "group-head-top-sec">
							<div class = "group-head-top-sec-shadow">
							</div>
							<div class = "info-scroll-up info-shower">
								<div class = "group-cover-pic-info" id="group-cover-pic-info">
									<b><?php 
									         echo get_current_semester($con,$university);  
									    ?> Time At <?php 
									                  echo ucfirst(get_alias_univ($con,$university)); 
									               ?>
									</b>
									<em class = "em_hide"></em>
								</div>
								<button class = "upload_cover">
									<i></i>
									<span>Submit Cover</span>
								</button>
								<div class = "group_location">
									<em></em>
									<span class = "group_location_name">
										<?php 
										    echo get_univ_add($con,$university);
										?>
									</span>
								</div>
								<div class = "help-div" id = "help-3">
									<div class = "help-wedge">
									</div>
									<div class = "help-box">
										Submit a photo of this school for a chance to replace its current cover photo.
									</div>
								</div>
								<div class = "location-pic-div-wrap">
									<div class = "white-wedge-up">
									</div>
									<div class = "location-pic-container">
										<div class = "modal_loading3">
											<img class = "modal_animation" src = "src/loadingAnimation.gif">
										</div>
										<img class = "location_building_pic" src = "src/polyMT6.jpg" class = "location-picture">
									</div>
								</div>
							</div>
							
							<div class = "group-cover-picture">
							</div>
						</div>
						<div class = "group-pic-frame">
							<div class = "group-pic">
							</div>
						</div>
						<div class = "group-header-left group-header-above">

							
							<div class = "group-title spec-group-title">
								<div class = "group-name group-name-mt">
									<?php  
									      echo ucwords(get_name_univ($con,$university));  
									 ?>
								</div>
								<a class = "group-id school-id">
									<em></em>
									<?php  
									      echo strtoupper(get_alias_parent_univ($con,$university));
									 ?>
								</a>
								<a class = "link_website_white" href="<?php 
									               echo get_univ_weblink($con,$university);?>" 
									               target="_blank">
									<span>Visit this school's website</span>
								</a>
							</div>	
													
						</div>

						<div class = "group-head-footer">
							<div class = "group-header-tab">
								<ul class = "group-nav">
									<li class = "group-tab">
										<a class = "tab1 tabFeed tab-anchor group-tab-active">
											<div class = "tab-title">
												SCHOOL FEED
												<span class = "tab-icon tab1-icon-active"></span>
											</div>

										</a>
									</li>
									<li class = "group-tab">
										<a class = "tabDepartments tab-anchor tab-inactive">
											<div class = "tab-title">
												DEPARTMENTS
												<span class = "tab-icon tab2-icon-inactive"></span>
											</div>
											<div class = "status tab-number">
												<span class = "badge">
													<?php echo get_department_count($con,$university);?>
												</span>
											</div>
										</a>
									</li>
									<li class = "group-tab">
										<a class = "tabmembers tab-anchor tab-inactive">
											<div class = "tab-title">
												MEMBERS
												<span class = "tab-icon tab3-icon-inactive"></span>
											</div>
											<div class = "status tab-number">
												<span class = "badge">
													<?php echo get_member_count($con,$university);?>
												</span>
											</div>
										</a>						
									</li>	
									<li class = "tab-no-badge group-tab">
										<a class = "tabc tabevents tab-anchor tab-inactive">
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
									<a class = "join disabled">
										Member
									</a>
									<div class = "help-div" id = "help-4">
										<div class = "help-wedge">
										</div>
										<div class = "help-box">
											You are a member of this school. Go to your profile page to change which school you are a part of. 
										</div>
									</div>
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
													<input type = "text" class = "inputText inviteInput" name = "Invite form" placeholder = "Invite people to join this school">
													<div class = "search-icon" title = "Search people">
													</div>
												</div>
											</div> 
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class = "members-tab-content" id ="members-tab-content">
							
								<div class = "members-search-top">
								  <form>
									<div class = "searchWrapper searchWrapperMembers">
									    <input placeholder = "Search students and faculty at <?php echo get_name_univ($con,$university);?>" class = "tabSearcher ajax">
										</input>
										<button class = "submitSearch submitSearchMembers">
									   </button>
									</div>
								</form>	
							 </div>
							<div class = "members-header">
								Professors
							</div>	
							<div class = "members-header-line">
							</div>
							

						</div>
						
						<div class = "syllabus-tab-content">
							syllabus tab
						</div>
						<div class = "departments-tab-content">
							<div class = "departmentsTabTop">
								<form>
									<div class = "searchWrapper">
										<input placeholder = "Search the departments at NYU Polytechnic" class = "tabSearcher ajax">
										</input>
									</div>
									<button class = "submitSearch">
									</button>
								</form>
							</div>
							<div class = "departmentsCards card-wrapper">
								

	                            <div class = "item department department-selector">
	                                <div class = "department ajax">
	                                    <a class = "departmentSelectWrapper">
	                                        <div class = "name">
	                                            Mechanical and Aeronautical Engineering f af ada dad a
	                                        </div>
	                                      

	                                        <div class = "imageWrapper">
	                                            <span class = "hoverMask">
	                                            </span>
	                                            <div class = "deptImage deptImage-dos">
	                                                <img class = "floatL deptImg" src = "src/aeronauticalEng.png">
	                                                <div class = "blackData">
	                                                	<span class = "group_members">
	                                                		<em class = "members-icon"></em>
	                                                		<span>250</span>

	                                                	</span>
	                                                </div>
	                                                <div class = "dept-short-wrapper">		<div>
	                                                		<span>ME</span>
	                                                	</div>
	                                                </div>
	                                            </div>
	                                            <div class = "deptBtns">
	                                            	<button class = "followBtn">
	                                            		<em></em>
	                                            		Follow
	                                            	</button>

	                                            	<button class = "studybtn">
	                                            		Concentrate
	                                            	</button>

	                                            	
	                                            	
	                                            	<div class = "study_box_open">
	                                            		<div class = "js_wrap">
															<span>I am...</span>
															<div class = "study_first_option">

																<button class = "majorType study_type_btn" type = "button">Majoring in this subject</button>
																<button class = "minorType study_type_btn" type = "button">Minoring in this subject</button>
																<button class = "interestType study_type_btn" type = "button">Interested in this subject</button>
															</div>
														</div>
														<div class = "modal_loading2">
															<img class = "modal_animation" src = "src/loadingAnimation.gif">
														</div>
													</div>
	                                            </div>
	                                        </div>
	                                    </a>
	                                </div>
	                            </div>

	                            
							</div>
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
											STUDENTS YOU KNOW IN THIS SCHOOL <span>(8)</span>
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