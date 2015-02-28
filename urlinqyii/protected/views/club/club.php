<html>
    <head>
        <script>
            var globals = {};
            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'club'; ?>';
            globals.origin_id = '<?php echo $club->group_id; ?>';
            globals.origin_name = "<?php echo $club->group_name; ?>";
            globals.user_id = '<?php echo $user->user_id; ?>';
        </script>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-59124667-1', 'auto');
          ga('send', 'pageview');

        </script>

        <title><?php echo $club->group_name; ?></title>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"> </script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>

        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_files.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_settings.css">
		<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_about.css">




        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
        
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_settings.js'></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_files.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>


        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/invite_people/invite_people.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/invite_people/invite_people.css" type = "text/css" rel = "stylesheet">



        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/time_selector/time_selector.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/time_selector/time_selector.css" type = "text/css" rel = "stylesheet">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/date_selector/date_selector.js" type="text/javascript"></script>

    </head>

    <body class = "body_group body_club">

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

                        <?php if($is_admin){ ?>
                            <form action="/post/create" id="cover_photo_form" style="padding: 0px; margin: 0px;">
                                <input type='file' class='step_6_upload' style='display:none;'>
                        <?php } ?>

                                <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $club->coverFile->file_url ?>');">
                                    <div class = "blur_section_overflow_container">
                                        <div class = "blur_section" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $club->pictureFile->file_url ?>');">
                                        </div>
                                    </div>                                         
                                    <div class = "group_name">
                                        <!--<div class = "center_admin"><div class = "admin_image"></div><div class = "admin_image"></div><div class = "admin_image"></div></div>-->
                                        <div class = "center_text">
                                            <p id = "group_name"><span id = "name_title"><?php echo $club->group_name; ?></span></p>
                                            <?php if($is_admin){ ?>
                                                <span class = "you_are_admin">
                                                    Admin
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class = "group_right_info group_info_boxes">
                                        <?php if($club->website != ''){?>
                                        <div class = "group_info_block">

                                                <?php echo $club->website; ?>

                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php if($is_admin){ ?>
                                    <div class = "upload_cover_photo_button group_info_block_new upload_cover_container">
                                        <span class="upload_cover_photo_text">Update cover</span>
                                    </div>
                                    <?php } ?>
                                </div>

                        <!--        close the cover photo dropzone form if user is an admin -->
                        <?php if($is_admin){ ?>
                            </form>
                        <?php } ?>



                        <div id="tab_bar" class = "no_select">

                            <?php if($is_member){ ?>
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
                                    <div class = "tab_amount">
                                        <?php if(count($club->files)>0){
                                            echo count($club->files);
                                        } ?>
                                    </div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab members" data-panel_id="3">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Members</div>
                                    <div class = "tab_amount">
                                        <?php if(count($club->users)>0){
                                            echo count($club->users);
                                        } ?>
                                    </div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <?php }else{ ?>

                            <div class="tab about active" data-panel_id="6">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">About this Club</div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab members" data-panel_id="3">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Members</div>
                                    <div class = "tab_amount">
                                        <?php if(count($club->users)>0){
                                            echo count($club->users);
                                        }?>
                                    </div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <?php } ?>

                            <?php if($is_admin){ ?>
                                <div class="tab analytics" data-panel_id="4">
                                    <div class="tab_content">
                                        <div class="tab_img"></div>
                                        <div class="tab_text">Analytics</div>
                                    </div>
                                    <div class="tab_wedge"></div>
                                </div>
                            <?php } ?>




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

                        <?php if($is_member){ ?>
                        <div class="panel active panel_feed" id="panel_1">
                        <?php }else{ ?>
                        <div class="panel panel_feed" id="panel_1" style="display:none;">
                        <?php } ?>
                            <div id = "planner_column" class = "planner_column_group">
                                <div id = "right_column_specs">


                                    <div class="classic_about_box" id="group_about_box">
                                        <h5>About</h5>
                                        <?php if($is_admin){?>
                                        <span class="edit_about">edit</span>
                                        <?php } ?>
                                        <div class="class_description_holder"><?php echo $club->group_desc; ?></div>

                                    </div>
                                    <div id = "fixed_element" class = "planner_group planner_club">

                                        <?php
                                        echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'club','origin_id'=>'<?php echo $club->group_id; ?>'));
                                        ?>    
                                    </div>
                                </div>



                            </div>
                            <div id = "feed_column" class = "feed_column_group">
                                <div id = "stream_holder" class = "stream_holder_home">
                                    <div id = "fbar_wrapper" class = "fbar_home">
                                        <?php echo $this->renderPartial('/partial/club_status_bar',array('user'=>$user, 'origin_type'=>'club','origin_id'=>$club->group_id, 'origin'=>$club,'is_admin'=>$is_admin)); ?>
                                    </div>

                                    <div id = "feed_wrapper" class = "feed_wrapper_home">
                                        <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/club/'.$club->group_id.'/feed', 'origin_type'=>'club','origin_id'=>$club->group_id,'is_admin'=>$is_admin)); ?>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <?php if($is_member){ ?>
                        <div class="panel tab_files" id="panel_2">
                        <?php }else{ ?>
                        <div class="panel tab_files" id="panel_2" style="display:none;">
                        <?php } ?>

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
                                        <?php if($is_admin){ ?>
                                            <div class = "admin_member_controls">
                                                <div class = "add_people_button remove" id = "remove_button">
                                                    Remove People
                                                </div>
                                            </div>
                                            <div class = "remove_state_controls">
                                                <span class ="removed_count"></span>
                                                <div class = "remove" id = "done_removing_button">
                                                    <em></em>
                                                    <span>Done</span>
                                                </div>
                                            </div>

                                        <?php } ?>
                                        <?php if($is_member){ ?>
                                        <div class = "add_people_button invite">
                                            Add Members
                                        </div>
                                        <div class = "help_div dark">
                                            <div class = "wedge">
                                            </div>
                                            <div class = "box">
                                                Add new members to join your group. If they don't already have a Urlinq account, they'll receive an email to signup.
                                            </div>
                                        </div>
                                        <?php } ?>



                                        <?php //if($is_admin) { ?>
<!--                                            <div class = "small_search fade_input_small">-->
<!--                                                <em id = "left_search_icon">-->
<!--                                                </em>-->
<!--                                                <input type = "text" name = "people_search_input" placeholder = "Invite people" class = "small_search_input">-->
<!--                                            </div>-->


                                            <div id="invite_holder" class="invite_holder">
<!--                                                <div id="create_event_invite_label">Invite people</div>-->

                                                <em class = "successful_invite_icon"></em>
                                                <input id="invite_input" name="event_invite_input" placeholder="Add a new member" class="text_input invite_input small_search_input">
                                                <em class = "invite_people_icon"></em>
                                                <div id="done_inviting_button" class="add_people_button">Done</div>
                                                <div id="create_event_invite_button" class="invite_people_button">Send Invite</div>



                                                <div id="invite_popup">


                                                </div>

                                            </div>



                                            <!--template for user that is in the invite list-->
                                            <script id="user_template" type="text/x-handlebars-template">
                                                <div class="invite_user_list_item" data-id="{{id}}" data-name="{{user_name}}" data-email="{{user_email}}" data-file_url = "{{base_url}}{{pictureFile.file_url}}">
                                                    <div class="invite_user_list_item_name invited_user_name">{{user_name}}</div>
                                                </div>
                                            </script>

                                            <!--template for user in the dropdown -->
                                            <script id="invite_user_template" type="text/x-handlebars-template">
                                                <div class="invite_user_holder" data-id="{{id}}" data-name="{{user_name}}" data-email="{{user_email}}" data-file_url = "{{base_url}}{{pictureFile.file_url}}">
                                                    <div class = "inviting_user_photo cal_user_photo" style = "background-image:url('{{base_url}}{{pictureFile.file_url}}')"></div>
                                                    <div class="invite_user_list_item_name inviting_user_name">{{user_name}}</div>


                                                </div>
                                            </script>


                                        <?php //} ?>


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

                                    <?php foreach($club->users as $member){ ?>
                                        <div class = "members_card_wrapper regular_member" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
                                            <div class = "members_card <?php if($member->isAdmin($club)) echo 'admin';?> normal_size">
                                                <div class = "members_card_img profile_link" data-user_id='<?php echo $member->user_id; ?>' style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $member->pictureFile->file_url; ?>');">

                                                    <?php if($member->user_type == 'p'){ ?>
                                                        <span class = "title">Professor</span>
                                                    <?php }elseif($member->user_type == 'a'){ ?>
                                                        <span class = "title">Admin</span>
                                                    <?php }else{ ?>
                                                        <span class = "title">Student</span>
                                                    <?php } ?>

                                                </div>
                                                <div class = "user_main_info">
                                                    <a class = "name profile_link" data-user_id='<?php echo $member->user_id; ?>'><?php echo $member->full_name(); ?></a>
                                                </div>
                                                <div class = "user_more_info">
                                                    <a href="<?php echo Yii::app()->getBaseUrl()."/department/".$member->department->department_id; ?>" class = "department_link"><?php echo $member->department->department_name; ?></a>
                                                </div>


                                                <?php if($user->user_id !== $member->user_id){ ?>
                                                <div class = "user_card_button_holder">
                                                    <?php if($is_admin){ ?>
                                                        <div class="remove_member_button">Remove</div>
                                                    <?php } ?>
                                                    <?php if($user->is_following($member->user_id)){ ?>
                                                        <div class = "follow_button_wrapper following_wrapper">
                                                            <div class = "user_follow_button following">Following</div>
                                                    <?php }else{ ?>
                                                        <div class = "follow_button_wrapper following_wrapper">
                                                            <div class = "user_follow_button">Follow</div>
                                                    <?php } ?>
                                                            <a href="mailto:<?php echo $member->user_email?>">
                                                                <div class = "user_message_button message_active">
                                                                    <em class = "white_message_icon"></em>
                                                                </div>
                                                            </a>
                                                        </div>


                                                </div>
                                                <?php }else{?>
                                                    <div class = "user_card_button_holder">
                                                        <div class = "follow_button_wrapper following_wrapper own_profile">
                                                            <div class = "user_follow_button own_profile">Me</div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
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

                        <?php if($is_admin){ ?>
                            <div class="panel tab_analytics" id="panel_4">
                                <?php echo $this->renderPartial('/club/club_analytics',array('club'=>$club, 'user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id)); ?>
                            </div>
                        <?php } ?>


                        <!-- About Tab -->
                        <?php if($is_member){ ?>
                        <div class="panel tab_about" id="panel_6">

                        <?php }else{ ?>
                        <div class="panel tab_about active" id="panel_6">
                        <?php } ?>
                            
                            <div class="tab_content_holder">
                               
                                <!-- only show to non members. when they click join, refresh or dynamically show members view with full tabs -->
                                <?php if($is_member){ ?>

                                <div class="about_tab_header_content">
                                    <div class = "about_header_sentence no_underline">
                                        <p class = "about_box_headers">GROUP INFO</p>



                                        <div class = "group_info_data">
                                            <div class = "group_display_icon" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $club->pictureFile->file_url ?>');">
                                                <?php if($is_admin){ ?>  
                                                    <a id = "edit_club_icon"><span class = "photo_edit_icon small_icon_map"></span></a>
                                                <?php } ?>
                                            </div>
                                            <h4 class = "group_name_text">
                                                <?php echo $club->group_name; ?>
                                            </h4>
                                        </div>



                                        <?php if($club->group_desc) { ?>

                                        <div class = "group_info_divider half_divider">
                                            <hr role = "separator">
                                            <div class = "group_info_divider_label" data-label = "description"> Description 
                                                <?php if($is_admin){ ?>  
                                                    <p id = "edit_club_description"><span class = "edit_icon small_icon_map"></span>Edit</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div id="group_description_holder">
                                            <div id="group_description" class = "group_info_data half_data open_look">
                                                <?php echo $club->group_desc; ?>
                                            </div>
                                            <textarea id="group_description_input" class="group_textarea" maxlength="240" placeholder="Provide a description of this group." style="display:none"></textarea>
                                        </div>
                                        <?php }else{ ?>
                                            <?php if($is_admin){ ?> 
                                                <div class = "group_info_divider half_divider">
                                                    <hr role = "separator">
                                                    <div class = "group_info_divider_label" data-label = "description"> 
                                                        <p id = "edit_club_description"><span class = "add_icon small_icon_map"></span>Edit Description</p>
                                                    </div>
                                                </div>
                                                <div id="group_description_holder">
                                                    <div id="group_description" class = "group_info_data half_data open_look inline_editable">
                                                        Provide a description of this group.
                                                        <span class = "big_edit_icon">
                                                        </span>
                                                    </div>
                                                    <textarea id="group_description_input" class="group_textarea" maxlength="240" placeholder="Provide a description of this group." style="display:none;"></textarea>
                                                </div>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if($club->mission_statement) { ?>

                                            <div class = "group_info_divider half_divider">
                                                <hr role = "separator">
                                                <div class = "group_info_divider_label" data-label = "mission"> Purpose
                                                    <?php if($is_admin){ ?>
                                                        <p id = "edit_club_mission"><span class = "edit_icon small_icon_map"></span>Edit</p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div id="group_mission_holder">
                                                <div id="group_mission" class = "group_info_data half_data open_look">
                                                    <?php echo $club->mission_statement; ?>
                                                </div>
                                                <textarea id="group_mission_input" class="group_textarea" maxlength="240" placeholder="Give your group a 240-character purpose that describes what it will be used for." style="display:none"></textarea>
                                            </div>
                                        <?php }else{ ?>
                                            <?php if($is_admin){ ?> 
                                                <div class = "group_info_divider half_divider">
                                                    <hr role = "separator">
                                                    <div class = "group_info_divider_label" data-label = "mission"> 
                                                        <p id = "edit_club_mission"><span class = "add_icon small_icon_map"></span>Edit Group Purpose</p>
                                                    </div>
                                                </div>
                                                <div id="group_mission_holder">
                                                    <div id="group_mission" class = "group_info_data half_data open_look inline_editable">
                                                        Give your group a 240-character purpose that describes what it will be used for.
                                                        <span class = "big_edit_icon">
                                                        </span>
                                                    </div>
                                                    <textarea id="group_mission_input" class="group_textarea" maxlength="240" placeholder="Give your group a 240-character purpose that describes what it will be used for." style="display:none"></textarea>
                                                </div>
                                           <?php } ?>
                                        <?php } ?>                                        
                                    </div>    
                                </div>

                                <?php }else{ ?>

                                <div class="about_tab_header">
                                    <div class = "about_header_sentence">
                                        <p>ARE YOU IN THIS GROUP?</p>
                                    </div>
                                    <div class = "about_header_body">
                                        <div class = "floatRight">
                                            <div class = "join_button group_user_action_button non_member" data-action_url="/join"><span "white_plus_sign"></span>Join Group</div>
                                        </div>
                                        <div class = "about_header_data">
                                            <p>To see this groups's feed, events, and files, sign up now <span class = "non_member_join_pointer small_icon_map"></span></p>
                                        </div> 
                                    </div>     
                                </div>

                                <div class="about_tab_header_content">
                                    <div class = "about_header_sentence no_underline non_member">
                                        <p class = "about_box_headers">GROUP INFO</p>


                                        <div class = "group_info_divider">
                                            <hr role = "separator">
                                            <div class = "group_info_divider_label" data-label = "description"> Title and Icon 
                                                <?php if($is_admin){ ?>  
                                                    <p id = "edit_club_name"><span class = "edit_icon small_icon_map"></span>Edit</p>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class = "group_info_data">
                                            <div class = "group_display_icon" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $club->pictureFile->file_url ?>');">
                                                <?php if($is_admin){ ?>  
                                                    <a id = "edit_club_icon"><span class = "photo_edit_icon small_icon_map"></span></a>
                                                <?php } ?>
                                            </div>
                                            <h4 class = "group_name_text">
                                                <?php echo $club->group_name; ?>
                                            </h4>
                                        </div>



                                        <?php if($club->group_desc) { ?>

                                        <div class = "group_info_divider half_divider">
                                            <hr role = "separator">
                                            <div class = "group_info_divider_label" data-label = "description"> Description 
                                                <?php if($is_admin){ ?>  
                                                    <p id = "edit_club_description"><span class = "edit_icon small_icon_map"></span>Edit</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class = "group_info_data half_data open_look">
                                            <?php echo $club->group_desc; ?>
                                        </div>

                                        <?php }else{ ?>
                                            <?php if($is_admin){ ?> 
                                                <div class = "group_info_divider half_divider">
                                                    <hr role = "separator">
                                                    <div class = "group_info_divider_label" data-label = "description"> 
                                                        <p id = "edit_club_description"><span class = "add_icon small_icon_map"></span>Add a description of this group</p>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if($club->mission_statement) { ?>

                                        <div class = "group_info_divider half_divider">
                                            <hr role = "separator">
                                            <div class = "group_info_divider_label" data-label = "mission"> Purpose 
                                                <?php if($is_admin){ ?>  
                                                    <p id = "edit_club_mission"><span class = "edit_icon small_icon_map"></span>Edit</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class = "group_info_data half_data open_look">
                                            <?php echo $club->mission_statement; ?>
                                        </div>

                                        <?php }else{ ?>
                                            <?php if($is_admin){ ?> 
                                                <div class = "group_info_divider half_divider">
                                                    <hr role = "separator">
                                                    <div class = "group_info_divider_label" data-label = "mission"> 
                                                        <p id = "edit_club_mission"><span class = "add_icon small_icon_map"></span>Edit Group Purpose</p>
                                                    </div>
                                                </div>
                                                <div class = "group_info_data half_data open_look inline_editable">
                                                    Give your group a 240-character purpose that describes what it will be used for. 
                                                    <span class = "big_edit_icon">
                                                    </span>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>                                        
                                    </div>    
                                </div>                                

                                <?php } ?>



                            </div>

                        </div>  

                        


                        </div>
                        
                    </div>

                </div>
            </div>
            <div id="right_panel" class = "group_responsiveness">
                <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id)); ?>
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


 <!--<!-- INCLUDE THIS AND date_selector.js and add class name date_input to your date input fields to use this -->

   <!-- <div id = "calLayer" style="display: none;">
        <section id = "mounth" class="mounth">
            <header class="minical-header">
                <h1 class="minical-h1"></h1>

                <nav role="padigation">
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
    </div>-->




<!--Include this and js/time_selector/time_selector.js to use this.
Set the class name on your input to 'time_input' -->
<div id="time_selector">
    <div class='time_selector_div' data-time='00:00:00' value="00:00:00">12:00am</div>
    <div class='time_selector_div' data-time='00:30:00' value="00:30:00">12:30am</div>

    <div class='time_selector_div' data-time='01:00:00' value="01:00:00">1:00am</div>
    <div class='time_selector_div' data-time='01:30:00' value="01:30:00">1:30am</div>

    <div class='time_selector_div' data-time='02:00:00' value="02:00:00">2:00am</div>
    <div class='time_selector_div' data-time='02:30:00' value="02:30:00">2:30am</div>

    <div class='time_selector_div' data-time='03:00:00' value="03:00:00">3:00am</div>
    <div class='time_selector_div' data-time='03:30:00' value="03:30:00">3:30am</div>

    <div class='time_selector_div' data-time='04:00:00' value="04:00:00">4:00am</div>
    <div class='time_selector_div' data-time='04:30:00' value="04:30:00">4:30am</div>

    <div class='time_selector_div' data-time='05:00:00' value="05:00:00">5:00am</div>
    <div class='time_selector_div' data-time='05:30:00' value="05:30:00">5:30am</div>

    <div class='time_selector_div' data-time='06:00:00' value="06:00:00">6:00am</div>
    <div class='time_selector_div' data-time='06:30:00' value="06:30:00">6:30am</div>

    <div class='time_selector_div' data-time='07:00:00' value="06:00:00">7:00am</div>
    <div class='time_selector_div' data-time='07:30:00' value="06:30:00">7:30am</div>


    <div class='time_selector_div' data-time='08:00:00' value="08:00:00">8:00am</div>
    <div class='time_selector_div' data-time='08:30:00' value="08:30:00">8:30am</div>

    <div class='time_selector_div' data-time='09:00:00' value="09:00:00">9:00am</div>
    <div class='time_selector_div' data-time='09:30:00' value="09:30:00">9:30am</div>

    <div class='time_selector_div' data-time='10:00:00' value="10:00:00">10:00am</div>
    <div class='time_selector_div' data-time='10:30:00' value="10:30:00">10:30am</div>

    <div class='time_selector_div' data-time='11:00:00' value="11:00:00">11:00am</div>
    <div class='time_selector_div' data-time='11:30:00' value="11:30:00">11:30am</div>


    <!-- NOON -->
    <div class='time_selector_div' data-time='12:00:00' value="12:00:00">12:00pm</div>
    <div class='time_selector_div' data-time='12:30:00' value="12:30:00">12:30pm</div>



    <div class='time_selector_div' data-time='13:00:00' value="13:00:00">1:00pm</div>
    <div class='time_selector_div' data-time='13:30:00' value="13:30:00">1:30pm</div>

    <div class='time_selector_div' data-time='14:00:00' value="14:00:00">2:00pm</div>
    <div class='time_selector_div' data-time='14:30:00' value="14:30:00">2:30pm</div>

    <div class='time_selector_div' data-time='15:00:00' value="15:00:00">3:00pm</div>
    <div class='time_selector_div' data-time='15:30:00' value="15:30:00">3:30pm</div>

    <div class='time_selector_div' data-time='16:00:00' value="16:00:00">4:00pm</div>
    <div class='time_selector_div' data-time='16:30:00' value="16:30:00">4:30pm</div>

    <div class='time_selector_div' data-time='17:00:00' value="17:00:00">5:00pm</div>
    <div class='time_selector_div' data-time='17:30:00' value="17:30:00">5:30pm</div>

    <div class='time_selector_div' data-time='18:00:00' value="18:00:00">6:00pm</div>
    <div class='time_selector_div' data-time='18:30:00' value="18:30:00">6:30pm</div>

    <div class='time_selector_div' data-time='19:00:00' value="19:00:00">7:00pm</div>
    <div class='time_selector_div' data-time='19:30:00' value="19:30:00">7:30pm</div>


    <div class='time_selector_div' data-time='20:00:00' value="20:00:00">8:00pm</div>
    <div class='time_selector_div' data-time='20:30:00' value="20:30:00">8:30pm</div>

    <div class='time_selector_div' data-time='21:00:00' value="21:00:00">9:00pm</div>
    <div class='time_selector_div' data-time='21:30:00' value="21:30:00">9:30pm</div>

    <div class='time_selector_div' data-time='22:00:00' value="22:00:00">10:00pm</div>
    <div class='time_selector_div' data-time='22:30:00' value="22:30:00">10:30pm</div>

    <div class='time_selector_div' data-time='23:00:00' value="23:00:00">11:00pm</div>
    <div class='time_selector_div' data-time='23:30:00' value="23:30:00">11:30pm</div>


</div>

</html>