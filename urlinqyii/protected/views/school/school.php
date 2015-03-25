<html>
<?php


$department_front_end_name = 'department';
if($school->university_id == 4){
    $department_front_end_name = 'program';
}

?>

<head>
    <script>
        var globals = {};
        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        globals.origin_type = '<?php echo 'school'; ?>';
        globals.origin_id = '<?php echo $school->school_id; ?>';
        globals.origin_name = '<?php echo $school->school_name; ?>';
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

    <title><?php echo $school->school_name; ?></title>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/location_input/location_input.js"></script>

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/school/school_main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>


    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main_groups.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>


    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
</head>

<body class = "body_group body_school">

    <?php echo Yii::app()->runController('partial/topbar'); ?>
    <div id="wrapper" class="<?php echo $user->status; ?>">
    <!--        --><?php //echo Yii::app()->runController('partial/leftmenu'); ?>

    <?php

        $departments = $school->departments;
        $clubs = $school->clubs;

    ?>


    <div id="page">


    <div id="main_panel" class = "group_responsiveness">


    <div id="content_holder">

    <div id="left_panel" class = "group_responsiveness">
        <!--                        <section class='leftbar_bag'>-->
        <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'school','origin_id'=>$school->school_id)); ?>
        <!--                        </section>-->
    </div>




    <div id="content_panel" class = "group_responsiveness">
    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'school','origin_id'=>$school->school_id,'origin'=>$school,'user'=>$user)); ?>






    <?php if($is_admin){ ?>
    <form action="/post/create" id="cover_photo_form" style="padding: 0px; margin: 0px;">
        <input type='file' class='step_6_upload' style='display:none;'>
    <?php } ?>

        <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $school->coverFile->file_url ?>');">
            <div class = "blur_section_overflow_container">
                <div class = "blur_section" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $school->pictureFile->file_url ?>');">
                </div>
            </div>
            <div class = "blur_overlay_black"></div>
            <div class = "group_name">
                <?php if($school->university_id == 1){ ?>
                <div class = "center_admin univ_art"><div class = "text"></div><div class = "university_arrow"></div></div>
                <?php }elseif($school->university_id == 4){ ?>
                <div class = "center_admin univ_art"><div class = "text touro"></div><div class = "university_arrow"></div></div>
                <?php } ?>
                <div class = "center_text"><p id = "group_name" class = "school_name"><span id = "name_title"><?php echo $school->school_name; ?></span></p></div>
            </div>
            <div class = "group_right_info group_info_boxes">
                    <?php if($school->school_location) { ?>
                    <div class = "group_info_block school_location" id = "location">
                        <em class ="small_icon_map"></em>
                        <span><?php echo $school->school_location; ?></span>
                    </div>
                    <?php } else { }?>
            </div>


            <?php if($is_urlinq_admin){ ?>
                <div class = "upload_cover_photo_button group_info_block_new upload_cover_container">
                    <div class="upload_cover_photo_text">Change cover</div>
                </div>
            <?php } ?>





        </div>


    <?php if($is_admin){ ?>
    </form>
    <?php } ?>




                <div id="tab_bar">

                    <div class="tab school_info active" data-panel_id="1">
                        <div class="tab_content">
                            <div class="tab_img"></div>
                            <div class="tab_text">School Info</div>
                        </div>
                        <div class="tab_wedge"></div>
                    </div>

                    <div class="tab departments" data-panel_id="2">
                        <div class="tab_content">
                            <div class="tab_img"></div>
                            <div class="tab_text"><?php echo ucfirst($department_front_end_name); ?>s</div>
                            <div class = "tab_amount"><?php echo count($departments); ?></div>
                        </div>
                        <div class="tab_wedge"></div>
                    </div>

                    <div class="tab clubs" data-panel_id="3">
                        <div class="tab_content">
                            <div class="tab_img"></div>
                            <div class="tab_text">Groups</div>
                            <div class = "tab_amount"><?php echo count($clubs); ?></div>
                        </div>
                        <div class="tab_wedge"></div>
                    </div>

                    <div class="tab members" data-panel_id="4">
                        <div class="tab_content">
                            <div class="tab_img"></div>
                            <div class="tab_text">Members</div>
                            <div class = "tab_amount"><?php echo count($school->users); ?></div>
                        </div>
                        <div class="tab_wedge"></div>
                    </div>




                    <!-- #group_user_action_button performs either join/leave or follow/unfollow depending on context -->
                    <?php if($user->school_id == $school->school_id){ ?>
                        <div id="group_user_action_button" class = "my_school_btn">
                            <div id="group_user_action_button_text">My School</div>
                        </div>
                        <div class="help_div light" id="help_4">
                            <div class="wedge">
                            </div>
                            <div class="box">
                                This is your primary school. Change this information by editing your profile. 
                            </div>
                        </div>
                    <?php } ?>



                    <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'school','origin_id'=>$school->school_id)); ?>

                </div>


                <div class="panel active panel_feed" id="panel_1">
                    <div id = "planner_column" class = "planner_column_group">
                        <div id = "right_column_specs">
                            <div id = "fixed_element" class = "planner_group">
                                <div class = "about_box">
                                    <h5>About</h5>

                                    <?php if($school->founded) { ?>
                                        <p class = "founded_text"><span class = "founded_icon"></span>Founded in <?php echo $school->founded; ?></p>
                                    <?php } else { }?>

                                    <?php if($school->school_description) { ?>
                                        <p class = "school_about"><?php echo $school->school_description; ?></p>
                                    <?php } else { }?>

                                    <div class = "about_section_group_links">
                                        <div class = "about_section_border_top"></div>
                                        <?php if($school->twitter_link) { ?>
                                            <a target="_blank" class = "social_icon_link" href = "<?php echo $school->twitter_link; ?>"><em class = "twitter_icon"></em></a>
                                        <?php } else { }?>
                                        <?php if($school->fb_link) { ?>
                                            <a target="_blank" class = "social_icon_link" href = "<?php echo $school->fb_link; ?>"><em class = "fb_icon"></em></a>
                                        <?php } else { }?>
                                        <?php if($school->weblink) { ?>
                                            <a target="_blank" class = "weblink" href = "<?php echo $school->weblink; ?>">web</a>
                                        <?php } else { }?>
                                    </div>
                                </div>
                            </div>
                        </div>                           
                    </div>
                    <div id = "feed_column" class = "feed_column_group">
                        <div id = "stream_holder" class = "stream_holder_home">
                            <div id = "fbar_wrapper" class = "fbar_home">
                                <?php echo $this->renderPartial('/partial/school_status_bar',array('user'=>$user,'origin_type'=>'school','origin_id'=>$school->school_id,'pg_src'=>'school.php','target_type'=>'school','is_admin'=>false,'origin'=>$school)); ?>
                            </div>

                            <div id = "feed_wrapper" class = "feed_wrapper_home">
                                <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/school/'.$school->school_id.'/feed', 'origin_type'=>'school','origin_id'=>$school->school_id,'is_admin'=>false)); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel tab_group_info" id="panel_2">
                    <div class="tab_content_holder">
                        <div class="tab_header"> 
                            <div class = "float_Right">
                                <!--<span class = "sort_label">Order:</span>
                                <div class = "order_sort_dropdown">
                                    <span>Followers High to Low</span>
                                    <em class = "dropdown_arrow">
                                    </em>
                                </div>-->
                                <div class = "small_search" class = "fade_input_small">
                                    <em id = "left_search_icon">
                                    </em>
                                    <input type = "text" name = "people_search_input" placeholder = "Search <?php echo $department_front_end_name; ?>s" class = "name_search_input people_search_input small_search_input">
                                </div>                                        
                            </div>
                            <div class = "header_sentence">
                                <?php echo ucfirst($department_front_end_name); ?>s at <?php echo $school->school_name; ?>
                            </div>
                        </div>
                        <div class = "group_info_tab_content tab_content">


                            <?php foreach($departments as $department) { ?>
                                <div class = "group_box group_course_box" data-name="<?php echo $department->department_name; ?>">
                                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/' . $department_front_end_name . '/' . $department->department_id ;?>">
                                        <div class = "float_Left group_image" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $department->coverFile->file_url; ?>')">
                                            <div class = "department_alias"><?php echo $department->department_tag ;?></div>
                                        </div>
                                    </a>
                                    <div class = "group_box_main_info">
                                        <a href="<?php echo Yii::app()->getBaseUrl(true) . '/' . $department_front_end_name . '/' . $department->department_id ;?>" class = "group_link"><?php echo $department->department_name; ?></a>
                                        <div class = "float_Right">
                                            <span class = "group_type"><?php echo ucfirst($department_front_end_name); ?></span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent"><span><?php echo count($department->admins);?> faculty </span><b>&#183;</b><span> <?php echo count($department->students);?> students</span></div>
                                        <div class= "info_line indent"><?php echo count($department->courses); ?> courses</div>
<!--                                        <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">--><?php //echo $department->department_description?><!--</div></div></div>-->
                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="panel tab_group_info" id="panel_3">
                    <div class="tab_content_holder">
                        <div class="tab_header"> 
                            <div class = "float_Right">
                                <!--<span class = "sort_label">Order:</span>
                                <div class = "order_sort_dropdown">
                                    <span>Members High to Low</span>
                                    <em class = "dropdown_arrow">
                                    </em>
                                </div>-->
                                <div class = "small_search" class = "fade_input_small">
                                    <em id = "left_search_icon">
                                    </em>
                                    <input type = "text" name = "name_search_input people_search_input" placeholder = "Search clubs and groups" class = "small_search_input name_search_input people_search_input">
                                </div>                                        
                            </div>
                            <div class = "header_sentence">
                                Groups at <?php echo $school->school_name; ?>
                            </div>
                        </div>



                        <div class = "group_info_tab_content tab_content">
                        <?php foreach($school->clubs as $club){?>


                                <div class = "group_box group_course_box club_box" data-name="<?php echo $club->group_name; ?>">
                                    <a href="<?php echo Yii::app()->getBaseUrl(true) . '/club/' . $club->group_id; ?>">
                                        <div class = "float_Left group_image" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $club->coverFile->file_url; ?>')">
                                            <div class = "group_link"><?php echo $club->group_name; ?></div>
                                            <span class = "group_type group_with_button"></span>

                                        </div>
                                    </a>
                                    <div class = "group_box_main_info">

                                        <div class = "float_Right">
<!--                                                <div class = "group_bar_button_holder">-->
<!--                                                    <div class = "join_button_wrapper">-->
<!--                                                        <div class = "group_join_button nonmember"><em class = "dark_add_icon"></em>Join Club</div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent"><?php echo count($club->members); ?> members</div>
                                        <div class= "info_line indent info_line_events"><span></span><?php echo count($club->events); ?> events this month</div>
                                        <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about"><?php echo $club->group_desc;?></div></div></div>
                                    </div>
                                </div>




                        <?php } ?>

                        </div>




                    </div>                
                </div>

                <div class="panel tab_members" id="panel_4">
                    <div class="tab_content_holder">
                        <div class="tab_header">
                            <div class = "float_Right">
                                <!--<div class = "add_people_button">
                                    Add People
                                </div>-->
                                <div class = "small_search members_lift_search" class = "fade_input_small">
                                    <em id = "left_search_icon">
                                    </em>
                                    <input type = "text" name = "people_search_input" placeholder = "Search people" class = "name_search_input small_search_input" id="school_users_search_input">
                                </div>
                            </div>
                            <div class = "header_sentence">
                                Members of <?php echo $school->school_name; ?>
                            </div>
                        </div>
                        <div class = "members_tab_content tab_content">

                            <?php
                            $members = $school->users;
                            $members_count = count($members);
                            if($members_count > 50){
                                $members_count = 50;
                            }
                            ?>
                            <?php for($i = 0; $i < $members_count; $i++){?>
                                <?php $member = $members[$i]; ?>
                                <div class = "members_card_wrapper" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
                                    <div class = "members_card admin normal_size">
                                        <div class = "members_card_img profile_link" data-user_id='<?php echo $member->user_id; ?>' style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $member->pictureFile->file_url; ?>');">

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
                                            <a class = "name profile_link" data-user_id='<?php echo $member->user_id; ?>'><?php echo $member->full_name(); ?></a>
                                        </div>
                                        <div class = "user_more_info">
                                            <?php if($member->department){ ?>
                                                <a class = "department_link"><?php echo $member->department->department_name; ?></a>
                                            <?php } ?>
                                        </div>
                                        <?php if($user->user_id !== $member->user_id){ ?>
                                        <div class = "user_card_button_holder">

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
                                                    <div class = "follow_button_wrapper following_wrapper">
                                                        <div class = "user_follow_button own_profile">Me</div>
                                                    </div>
                                                </div>
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
        <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'school','origin_id'=>$school->school_id)); ?>
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