<html>


<head>
    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        origin_type = '<?php echo 'school'; ?>';

        origin_id = '<?php echo $school->school_id; ?>';

    </script>


    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />


    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main_groups.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_files.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>
</head>

<body>

    <?php echo Yii::app()->runController('partial/topbar'); ?>
    <div id="wrapper">
    <!--        --><?php //echo Yii::app()->runController('partial/leftmenu'); ?>




    <div id="page">


    <div id="main_panel">


    <div id="content_holder">

    <div id="left_panel">
        <!--                        <section class='leftbar_bag'>-->
        <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'school','origin_id'=>$school->school_id)); ?>
        <!--                        </section>-->
    </div>




    <div id="content_panel">
    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'school','origin_id'=>$school->school_id,'origin'=>$school)); ?>
    <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $school->coverFile->file_url ?>');">

        <div class = "group_name">
            <div class = "center_text">NYU College of Arts and Sciences</div>
        </div>

    </div>




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
                            <div class="tab_text">Departments</div>
                            <div class = "tab_amount">92</div>
                        </div>
                        <div class="tab_wedge"></div>
                    </div>

                    <div class="tab clubs" data-panel_id="3">
                        <div class="tab_content">
                            <div class="tab_img"></div>
                            <div class="tab_text">Clubs</div>
                            <div class = "tab_amount">92</div>
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
                    </div>


                    <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'school','origin_id'=>$school->school_id)); ?>

                </div>


                <div class="panel active" id="panel_1">
                    SCHOOL INFO GOES HERE
                </div>


                <div class="panel tab_group_info" id="panel_2">
                    <div class="tab_content_holder">
                        <div class="tab_header"> 
                            <div class = "float_Right">
                                <span class = "sort_label">Order:</span>
                                <div class = "order_sort_dropdown">
                                    <span>Followers High to Low</span>
                                    <em class = "dropdown_arrow">
                                    </em>
                                </div>
                                <div id = "small_search" class = "fade_input_small">
                                    <em id = "left_search_icon">
                                    </em>
                                    <input type = "text" name = "people_search_input" placeholder = "Search people" class = "people_search_input small_search_input">
                                </div>                                        
                            </div>
                            <div class = "header_sentence">
                                Departments
                            </div>
                        </div>
                        <div class = "group_info_tab_content">
                            <div class = "group_box group_course_box">
                                <div class = "float_Left group_image">
                                    <div class = "department_alias">
                                        CBE
                                    </div>
                                </div>
                                <div class = "group_box_main_info">
                                    <a class = "group_link">Chemical and Biomedical Engineering</a>
                                    <div class = "float_Right">
                                        <span class = "group_type">Department</span>
                                    </div>
                                </div>
                                <div class = "group_box_secondary_info_section">
                                    <div class= "info_line indent"><span>120 faculty </span><b>&#183;</b><span> 560 students</span></div>
                                    <div class= "info_line indent">25 courses</div>
                                    <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel tab_group_info" id="panel_3">
                    <div class="tab_content_holder">
                        <div class="tab_header"> 
                            <div class = "float_Right">
                                <span class = "sort_label">Order:</span>
                                <div class = "order_sort_dropdown">
                                    <span>Members High to Low</span>
                                    <em class = "dropdown_arrow">
                                    </em>
                                </div>
                                <div id = "small_search" class = "fade_input_small">
                                    <em id = "left_search_icon">
                                    </em>
                                    <input type = "text" name = "people_search_input" placeholder = "Search clubs" id = "small_search_input">
                                </div>                                        
                            </div>
                            <div class = "header_sentence">
                                Clubs
                            </div>
                        </div>
                        <div class = "group_info_tab_content">
                            <div class = "group_box group_course_box club_box">
                                <div class = "float_Left group_image">
                                    <a class = "group_link">NYU Cheese Club</a>
                                    <span class = "group_type group_with_button">Club</span>

                                </div>
                                <div class = "group_box_main_info">
                                    
                                    <div class = "float_Right">
                                        <div class = "group_bar_button_holder">
                                            <div class = "join_button_wrapper">
                                                <div class = "group_join_button">Join Club</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "group_box_secondary_info_section">
                                    <div class= "info_line indent">35 members</div>
                                    <div class= "info_line indent info_line_events"><span></span>5 events this month</div>
                                    <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics. This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, </div></div></div>
                                </div>
                            </div>
                            <div class = "group_box group_course_box club_box">
                                <div class = "float_Left group_image">
                                    <a class = "group_link">NYU Cheese Club</a>
                                    <span class = "group_type group_with_button">Club</span>

                                </div>
                                <div class = "group_box_main_info">
                                    
                                    <div class = "float_Right">
                                        <div class = "group_bar_button_holder">
                                            <div class = "join_button_wrapper">
                                                <div class = "group_join_button">Join Club</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "group_box_secondary_info_section">
                                    <div class= "info_line indent">35 members</div>
                                    <div class= "info_line indent info_line_events"><span></span>5 events this month</div>
                                    <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics. This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, </div></div></div>
                                </div>
                            </div>
                            <div class = "group_box group_course_box club_box">
                                <div class = "float_Left group_image">
                                    <a class = "group_link">NYU Cheese Club</a>
                                    <span class = "group_type group_with_button">Club</span>

                                </div>
                                <div class = "group_box_main_info">
                                    
                                    <div class = "float_Right">
                                        <div class = "group_bar_button_holder">
                                            <div class = "join_button_wrapper">
                                                <div class = "group_join_button">Join Club</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "group_box_secondary_info_section">
                                    <div class= "info_line indent">35 members</div>
                                    <div class= "info_line indent info_line_events"><span></span>5 events this month</div>
                                    <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics. This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, </div></div></div>
                                </div>
                            </div>
                            <div class = "group_box group_course_box club_box">
                                <div class = "float_Left group_image">
                                    <a class = "group_link">NYU Cheese Club</a>
                                    <span class = "group_type group_with_button">Club</span>

                                </div>
                                <div class = "group_box_main_info">
                                    
                                    <div class = "float_Right">
                                        <div class = "group_bar_button_holder">
                                            <div class = "join_button_wrapper">
                                                <div class = "group_join_button">Join Club</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "group_box_secondary_info_section">
                                    <div class= "info_line indent">35 members</div>
                                    <div class= "info_line indent info_line_events"><span></span>5 events this month</div>
                                    <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics. This club explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, </div></div></div>
                                </div>
                            </div>
                            <div class = "group_box group_course_box club_box">
                                <div class = "float_Left group_image">
                                    <a class = "group_link">NYU Cheese Club</a>
                                    <span class = "group_type group_with_button">Club</span>

                                </div>
                                <div class = "group_box_main_info">
                                    
                                    <div class = "float_Right">
                                        <div class = "group_bar_button_holder">
                                            <div class = "join_button_wrapper">
                                                <div class = "group_join_button">Join Club</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "group_box_secondary_info_section">
                                    <div class= "info_line indent">35 members</div>
                                    <div class= "info_line indent info_line_events"><span></span>5 events this month</div>
                                    <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">This club explores neurotechnology and its application in the field of dig</div></div></div>
                                </div>
                            </div>



                        </div>
                    </div>                
                </div>

                <div class="panel tab_members" id="panel_4">
                    <div class="tab_content_holder">
                        <div class="tab_header">
                            <div class = "float_Right">
                                <div class = "add_people_button">
                                    Add People
                                </div>
                                <div class = "small_search" class = "fade_input_small">
                                    <em id = "left_search_icon">
                                    </em>
                                    <input type = "text" name = "people_search_input" placeholder = "Search people" class = "people_search_input small_search_input" id="school_users_search_input">
                                </div>
                            </div>
                            <div class = "header_sentence">
                                Members
                            </div>
                        </div>
                        <div class = "members_tab_content">


                            <?php foreach($school->users as $member){ ?>
                                <div class = "members_card_wrapper" data-user_id='<?php echo $member->user_id; ?>' data-user_name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
                                    <div class = "members_card admin normal_size">
                                        <div class = "members_card_img" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $member->pictureFile->file_url; ?>');">

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
                                            <a class = "name profile_link"><?php echo $member->full_name(); ?></a>
                                        </div>
                                        <div class = "user_more_info">
                                            <a class = "department_link"><?php echo $user->department->department_name; ?></a>
                                        </div>
                                        <div class = "user_card_button_holder">
                                            <div class = "follow_button_wrapper following_wrapper">
                                                <div class = "user_follow_button following">Following</div>
                                                <div class = "user_message_button message_active">
                                                    <em class = "white_message_icon">
                                                    </em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>


    </div>

    </div>
    </div>

    <div id="right_panel">

        RIGHT PANEL GOES HERE
    </div>

    <!--            <div id="div1" style="height: 500px;position:relative;">-->
    <!--                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid red;">-->
    <!--                    <div id="div3" style="height:1500px;border:5px solid yellow;">hello</div>-->
    <!--                </div>-->
    <!--            </div>-->

    </div>
    <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'school','origin_id'=>'')); ?>

    </div>
    <!--        <div id="right_menu_panel">-->
    <!---->
    <!--        </div>-->

</body>




</html>