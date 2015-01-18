<html>
    <head>
        <script>
            var globals = {};
            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'club'; ?>';
            globals.origin_id = '<?php echo $club->group_id; ?>';
            globals.origin_name = '<?php echo $club->group_name; ?>';
        </script>


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
            <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"> </script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>

        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_files.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_settings.css">
		<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_about.css">


        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_files.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>

    </head>

    <body class = "body_group">

    <?php echo Yii::app()->runController('partial/topbar'); ?>
    <div id="wrapper">



        <div id="page">


            <div id="main_panel" class = "group_responsiveness">


                <div id="content_holder">

                    <div id="left_panel" class = "group_responsiveness">

                        <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id,'origin_name'=>$club->group_name)); ?>

                    </div>




                    <div id="content_panel" class = "group_responsiveness">
                        <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'club','origin_id'=>$club->group_id,'origin'=>$club)); ?>
                        <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $club->coverFile->file_url ?>');">
                            <div class = "group_name">
                                <!--<div class = "center_admin"><div class = "admin_image"></div><div class = "admin_image"></div><div class = "admin_image"></div></div>-->
                                <div class = "center_text"><p id = "group_name"><span id = "name_title"><?php echo $club->group_name; ?></span></p></div>
                            </div>
                            <div class = "group_right_info group_info_boxes">
                                <div class = "group_info_block" id = "location">
                                    <em class ="small_icon_map"></em>
                                    <span>301 Latttimore Hall, Box 270076, Rochester, New York 14627</span>
                                </div>
                            </div>
                        </div>




                        <div id="tab_bar">

                            <div class="tab feed active" data-panel_id="1">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Club Feed</div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab materials" data-panel_id="2">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Files/Photos</div>
                                    <div class = "tab_amount"><?php echo count($club->files);?></div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab members" data-panel_id="3">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Members</div>
                                    <div class = "tab_amount"><?php echo count($club->members); ?></div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab analytics" data-panel_id="4">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Analytics</div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>




                            <!-- #group_user_action_button performs either join/leave or follow/unfollow depending on context -->
                            <?php if($is_member){ ?>
                                <div id="group_user_action_button" class="member" data-action_url="/leave">
                                    <div id="group_user_action_button_text">Member</div>
                                </div>
                            <?php }else{ ?>
                                <div id="group_user_action_button" class="non_member" data-action_url="/join">
                                    <div id="group_user_action_button_text">Join</div>
                                </div>
                            <?php } ?>

                            <div id="tab_more_button">
                                <div id="tab_more_button_image"></div>
                                <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id)); ?>
                            </div>

                            

                        </div>


                        <div class="panel active panel_feed" id="panel_1">
                            <div id = "planner_column" class = "planner_column_group">
                                <div id = "right_column_specs">
                                    <div id = "fixed_element" class = "planner_group">
                                        <?php
                                        echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'club','origin_id'=>'<?php echo $club->group_id; ?>'));
                                        ?>    
                                    </div>
                                </div>                           
                            </div>
                            <div id = "feed_column" class = "feed_column_group">
                                <div id = "stream_holder" class = "stream_holder_home">
                                    <div id = "fbar_wrapper" class = "fbar_home">
                                        <?php echo $this->renderPartial('/partial/club_status_bar',array('user'=>$user, 'origin_type'=>'club','origin_id'=>$club->group_id)); ?>
                                    </div>

                                    <div id = "feed_wrapper" class = "feed_wrapper_home">
                                        <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/club/'.$club->group_id.'/feed', 'origin_type'=>'club','origin_id'=>$club->group_id)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel tab_files" id="panel_2">
                        <!--<form action="/file-upload" class="dropzone" id="my-awesome-dropzone">-->
                        <div class="tab_content_holder">
                        <div class="tab_header">
                            <div id = "tabnav">
                                <div class = "tabnav_right float_Right">
                                    <div class = "small_search fade_input_small">
                                        <em id = "files_tab_sprites" class = "left_search_icon search_icon">
                                        </em>
                                        <input type = "text" name = "files_search_input" placeholder = "Search files" class = "small_search_input file_search_input">
                                    </div>
                                </div>
                                <ul class = "tabnav_tabs">
                                    <li class = "files_subtab class_files active" data-panel_id = "1" data-file_list_type="club">
                                        <div class = "tabnav_tab">
                                            <span>Club Files</span>
                                        </div>
                                    </li>
                                </ul>
                                <div class = "tab_floater_bar_half">
                                    <div class = "action">
                                        <a id = "upload_text_button">
                                            <em id = "files_tab_sprites" class = "upload_icon">
                                            </em>
                                            <span>Upload</span>
                                        </a>
                                        <span class = "drag_hint"><i> or </i>drag &#38; drop to add files</span>
                                    </div>
                                    <div class = "action">
                                        <a id = "new_folder_button">
                                            <em id = "files_tab_sprites" class = "new_folder_icon">
                                            </em>
                                            <span>New Folder</span>
                                        </a>
                                    </div>
                                </div>
                            </div>



                            <div class = "files_sort">
                                <div id = "name_sorter" data-sort = "files_by_name" data-ascending = "true" class = "active sortable_column_header">
                                    <span>Name</span>
                                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                                </div>
                                <div id = "kind_sorter" data-sort = "files_by_kind" data-ascending = "false" class = "sortable_column_header">
                                    <span>Type</span>
                                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                                </div>
                                <div id = "date_sorter" data-sort = "files_by_date" data-ascending = "false" class = "sortable_column_header">
                                    <span>Date</span>
                                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                                </div>
                                <div id = "views_sorter" data-sort = "files_by_views" data-ascending = "false" class = "sortable_column_header">
                                    <span>Downloads</span>
                                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                                </div>
                            </div>
                            <div id = "files_header_bottom_line">
                            </div>
                        </div>
                        <div class = "files_sub_panel active class_files" id ="files_sub_panel_1" data-file_list_type="club">
                            <ol class = "files_list club" data-file_list_type="club">



                                <script id="file_template" type="text/x-handlebars-template">
                                    <li class = "file" data-file_id="{{file_id}}" data-name="{{original_name}}" data-file_type="{{file_type}}" data-date="{{created_timestamp}}" data-download_count="{{download_count}}">
                                        <div class = "filename_col">
                                            <div class = "files_tab_sprites upload_sprite {{file_type}}"></div>
                                            <a class = "filename" data-file_type="{{file_type}}" href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'>{{original_name}}</a>
                                        </div>
                                        <div class = "kind">
                                            <span class = "category">{{file_type}}</span>
                                        </div>
                                        <div class = "date">
                                            <span class = "relevant_date">{{created_timestamp}}</span>
                                            <div id = "hidden_datepicker" class = "files_tab_datepicker"></div>
                                        </div>
                                        <div class = "views">
                                            <span class = "viewcount">
                                            {{download_count}}
                                            </span>
                                        </div>

                                        <?php if($is_admin){ ?>
                                            <div class='remove_file_div'>remove</div>
                                        <?php } ?>

                                    </li>
                                </script>


                            </ol>
                        </div>





                        <form action="<?php echo Yii::app()->getBaseUrl(true);?>/class/fileUpload" class="dropzone dz-clickable files_upload_bigbox tab_files" id="demo-upload">
                            <div class="bigbox_bigmessage">
                            </div>
                            <input type="hidden" name="id" value="<?php echo $club->group_id; ?>">


                            <input class="upload_files_submit" type="submit" name="submitIT" value="Submit data and files!">
                        </form>





                        </div>
                            <!--</form>-->
                        </div>

                        <div class="panel tab_members" id="panel_3">
                            <div class="tab_content_holder">
                                <div class="tab_header"> 
                                    <div class = "float_Right">
                                        <div class = "add_people_button">
                                            Add People
                                        </div>
                                        <div class = "small_search fade_input_small">
                                            <em id = "left_search_icon">
                                            </em>
                                            <input type = "text" name = "people_search_input" placeholder = "Search people" class = "name_search_input small_search_input">
                                        </div>                                        
                                    </div>
                                    <div class = "header_sentence">
                                        Club Members
                                    </div>
                                </div>
                                <div class = "members_tab_content tab_content">

                                    <?php foreach($club->members as $member){ ?>
                                        <div class = "members_card_wrapper" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
                                            <div class = "members_card admin normal_size">
                                                <div class = "members_card_img profile_link" user_id='<?php echo $member->user_id; ?>' style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $member->pictureFile->file_url; ?>');">

                                                    <?php if($member->user_type == 'p'){ ?>
                                                        <span class = "title">Professor</span>
                                                    <?php }elseif($member->user_type == 'a'){ ?>
                                                        <span class = "title">Admin</span>
                                                    <?php }else{ ?>
                                                        <span class = "title">Student</span>
                                                    <?php } ?>

                                                    <span class = "class_year">Senior</span>
                                                </div>
                                                <div class = "user_main_info">
                                                    <a class = "name profile_link" user_id='<?php echo $member->user_id; ?>'><?php echo $member->full_name(); ?></a>
                                                </div>
                                                <div class = "user_more_info">
                                                    <a class = "department_link"><?php echo $member->department->department_name; ?></a>
                                                </div>



                                                <div class = "user_card_button_holder">

                                                    <?php if($user->is_following($member->user_id)){ ?>
                                                        <div class = "follow_button_wrapper following_wrapper">
                                                            <div class = "user_follow_button following">Following</div>
                                                    <?php }else{ ?>
                                                        <div class = "follow_button_wrapper following_wrapper">
                                                            <div class = "user_follow_button">Follow</div>
                                                    <?php } ?>
                                                            <div class = "user_message_button message_active">
                                                                <em class = "white_message_icon">
                                                                </em>
                                                            </div>
                                                        </div>


                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>


<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Club Admin</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card non_admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div>-->


                                </div>
                            </div>                      
                        </div>

                        <div class="panel tab_analytics" id="panel_4">
                            PANEL 4
                        </div>
                        
                        <!-- INSERTING NEW PANELS HERE STARTING WITH ID = panel_5  -->
				        <div class="panel tab_settings" id="panel_5">
				        	<div class="tab_content_holder">
				        		<div class="tab_header">
				        			<img class="tab_settings_icon" src="../assets/settings_imgs/gear.png">
					        		<div class="header_sentence">Club Settings</div>
				        		</div>
				        		<div class="settings_tab_content">
				        			<div class="admin_settings_wrapper">
				        				<div class="admin_settings">
				        					<div class="header">
				        						<p>Administrative Settings</p>
				        					</div>
				        					<div class="row">
				        						<div class="text">
				        							<p>Is this class open to the public?</p>
				        						</div>
				        						<div class="status">
				        							<p>Public</p>
				        						</div>
				        						<div class="edit">
				        							<img src="../assets/settings_imgs/bluePen.png">
				        							Edit
				        						</div>
				        					</div>
				        					<div class="row">
				        						<div class="text">
				        							<p>Who can see the members of this class?</p>
				        						</div>
				        						<div class="status">
				        							<p>Anyone</p>
				        						</div>
				        						<div class="edit">
				        							<img src="../assets/settings_imgs/bluePen.png">
				        							Edit
				        						</div>
				        					</div>
										</div>
				        			</div>
				           			<div class="personal_notification_settings_wrapper">
					        			<div class="personal_notification_settings">
					        				<div class="header">
					        					<p>Personal Notification Settings</p>
					        				</div>
					        				<div class="row_no_click">
					        					<p id="left_text">Notifications are OFF for this class</p>
					        					<div id="right_slider">
						        					<div class="switch">
														<input id="cmn-toggle" class="cmn-toggle cmn-toggle-round" type="checkbox">
														<label for="cmn-toggle"></label>
													</div>
					        					</div>
					        				</div>
					        			</div>
				        			</div>
				        			<div class="admins_wrapper">
				        				<div class="admins">
				        					<div class="header">
				        						<p>Club Admins</p>
				        					</div>
				        					<div class="row">
				        						<img class="admins_image" src="../assets/dummy-pic.jpg">
				        						<p class="admins_name">Professor Larry Herman</p>
				        						<img class="admins_delete" src="../assets/settings_imgs/delete.png">
				        					</div>
				        					<div class="row">
				        						<img class="admins_image" src="../assets/farring.png">
				        						<p class="admins_name">Jeffery Bigham</p>
				        						<img class="admins_delete" src="../assets/settings_imgs/delete.png">
				        					</div>
				        					<form>
				        						<input class="add_admin" type="text" placeholder="Add a new admin to this class">
				        						<img id="add_admin_img" src="../assets/settings_imgs/add-icon.png">
				        					</form>
				        				</div>
				        			</div>
				        		</div>
				        	</div>
				        </div>
				        
				        <!-- About Tab -->
				        <div class="panel tab_about" id="panel_6">
				        	<div class="tab_content_holder">
				        	
				        		<div class="tab_header">
				        			<img class="tab_about_icon" src="../assets/about_icon.png">
					        		<div class="header_sentence">About this Club - Brazilian Jiu Jitsu</div>
				        		</div>
				        		
				        		<div class="about_tab_content">
				        		
				        			<div class="description_wrapper">
				        				<div class="description">
				        					<div class="description_header">
				        						<p>Club Description</p>
				        					</div>
				        					<div class="description_blurb">
				        						<p>The Brazilian Jiu-Jitsu club meets weekly in Coles Gym to instruct members on the modern art of fighting, calming the soul, and strengthening the heart.</p>
				        					</div>
				        					<div class="description_info_row">
				        						<img class="description_time_img" src="../assets/settings_imgs/clock.png">
				        						<p class="description_time_p">Monday 08:00 am - 09:20 am, Wednesday 08:00 am - 09:20 am</p>
											</div>
											<div class="description_info_row">
				        						<img class="description_location_img" src="../assets/settings_imgs/location.png">
				        						<p class="description_location_p">Class Location</p>
											</div>
											<div class="description_info_row">
				        						<img class="description_department_img" src="../assets/settings_imgs/department.png">
				        						<p class="description_department_p">Department of Biomedical Engineering</p>
											</div>
										</div>
				        			</div>
				        			
				           			<div class="recent_events_wrapper">
					        			<div class="recent_events">
					        				<div class="header">
					        					<p>Most Recent Events</p>
					        				</div>	
					        				<div class="recent_events_content">
					        				</div>				        										        			
					        			</div>
				        			</div>
				        			
				        			<div class="people_you_know_wrapper">
				        				<div class="people_you_know">
				        					<div class="header">
				        						<p>Friends in this club</p>
				        					</div>
				        				</div>
				        			</div>
				        			
				        		</div>
				        	</div>
				        </div>
				        
				        <div class="panel tab_calendar" id="panel_7">
				        	This will be a calendar
				        </div>
                        
                        

                    </div>

                </div>
            </div>
            <div id="right_panel" class = "group_responsiveness">
                <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'club','origin_id'=>'')); ?>   
            </div>

    <!--            <div id="div1" style="height: 500px;position:relative;">-->
    <!--                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid red;">-->
    <!--                    <div id="div3" style="height:1500px;border:5px solid yellow;">hello</div>-->
    <!--                </div>-->
    <!--            </div>-->

        </div>

    </div>
<!--        <div id="right_menu_panel">-->
<!---->
<!--        </div>-->

    </body>




</html>