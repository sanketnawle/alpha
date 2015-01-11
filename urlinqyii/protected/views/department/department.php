<html>


<head>
    <script>
        var globals = {};
        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        globals.origin_type = '<?php echo 'department'; ?>';
        globals.origin_id = '<?php echo $department->department_id; ?>';

    </script>


    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>


    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />



    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>

</head>

<body>

<?php echo Yii::app()->runController('partial/topbar'); ?>
<div id="wrapper">





    <div id="page">


        <div id="main_panel">


            <div id="content_holder">

                <div id="left_panel">
                    <!--                        <section class='leftbar_bag'>-->
                    <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'department','origin_id'=>$department->department_id,'origin_name'=>$department->department_name)); ?>
                    <!--                        </section>-->
                </div>




                <div id="content_panel">
                    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'department','origin_id'=>$department->department_id,'origin'=>$department)); ?>
                    <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $department->coverFile->file_url ?>');">
                        <div class = "group_name">
                            <div class = "center_text"><p id = "group_name"><?php echo $department->department_name; ?></p></div>
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
                                <div class="tab_text">Department Feed</div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>

                        <div class="tab courses" data-panel_id="2">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Courses</div>
                                <div class="tab_amount"><?php echo count($department->courses); ?></div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>

                        <div class="tab members" data-panel_id="3">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Faculty</div>
                                <div class="tab_amount"><?php echo count($department->admins);?></div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>

                        <div class="tab members" data-panel_id="4">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Students</div>
                                <div class="tab_amount"><?php echo count($department->students);?></div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>




                        <!-- #group_user_action_button performs either join/leave or follow/unfollow depending on context -->
                        <?php if($is_following ){ ?>
                            <div id="group_user_action_button" class="member" data-action_url="/leave">
                                <div id="group_user_action_button_text">Member</div>
                            </div>
                        <?php }else{ ?>
                            <div id="group_user_action_button" class="non_member" data-action_url="/join">
                                <div id="group_user_action_button_text">Follow</div>
                            </div>
                        <?php } ?>

                        <div id="tab_more_button">
                            <div id="tab_more_button_image"></div>
                        </div>

                        <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'department','origin_id'=>$department->department_id)); ?>


                    </div>


                    <div class="panel active panel_feed" id="panel_1">
                        <div id = "planner_column" class = "planner_column_group planner_column_department">
                            <div id = "right_column_specs">
                                <div id = "fixed_element" class = "planner_group">
                                    <?php
                                    echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'department','origin_id'=>'<?php echo $department->department_id; ?>'));
                                    ?>    
                                </div>
                            </div>                           
                        </div>
                        <div id = "feed_column" class = "feed_column_group">
                            <div id = "stream_holder" class = "stream_holder_home">
                                <div id = "fbar_wrapper" class = "fbar_home">
                                    <?php echo $this->renderPartial('/partial/department_status_bar',array('user'=>$user,'origin_type'=>'department','origin_id'=>'','pg_src'=>'department.php','target_type'=>'department')); ?>
                                </div>

                                <div id = "feed_wrapper" class = "feed_wrapper_home">
                                    <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/department/<?php echo $department->department_id; ?>/feed')); ?>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="panel tab_group_info" id="panel_2">
                        <div class = "tab_content_holder">
                            <div class="tab_header"> 
                                <div class = "float_Right">
                                    <span class = "sort_label">Order:</span>
                                    <div class = "order_sort_dropdown">
                                        <span>Courses High to Low</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <div class = "small_search fade_input_small">
                                        <em id = "left_search_icon">
                                        </em>
                                        <input type = "text" name = "people_search_input" placeholder = "Search courses" class = "name_search_input small_search_input">
                                    </div>                                        
                                </div>
                                <div class = "header_sentence">
                                    Courses this Semester
                                </div>
                            </div>
                            <div class = "group_info_tab_content tab_content">

                                <?php foreach($department->courses as $course){ ?>
                                    <div class = "group_box group_course_box" data-name="<?php echo $course->course_name; ?>">
                                        <div class = "float_Left group_image" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $course->pictureFile->file_url; ?>');">
                                        </div>
                                        <div class = "group_box_main_info">
                                            <a class = "group_link"><?php echo $course->course_name; ?></a>
                                            <div class = "float_Right">
                                                <span class = "group_type">Course</span>
                                            </div>
                                        </div>
                                        <div class = "group_box_secondary_info_section">
                                            <div class= "info_line indent">4 open classes</div>
                                            <div class= "info_line indent">Department of <a class = "department_link" href="<?php echo Yii::app()->getBaseUrl(true) . '/department/' . $course->department->department_id; ?>"><?php echo $course->department->department_name; ?></a></div>
                                            <div class = "info_line info_about"><?php echo $course->course_desc; ?></div>
                                        </div>
                                    </div>

                                <?php } ?>


                            </div>
                        </div>
                    </div>

                    <div class="panel tab_members" id="panel_3">
                        <div class = "tab_content_holder">
                            <div class = "tab_header">
                                <div class = "float_Right">
                                    <div class = "add_people_button">
                                        Add Faculty
                                    </div>
                                    <div class = "small_search" class = "fade_input_small">
                                        <em id = "left_search_icon">
                                        </em>
                                        <input type = "text" name = "people_search_input" placeholder = "Search people" class = "name_search_input small_search_input" id="department_admins_search_input">
                                    </div>                                        
                                </div>
                                <div class = "header_sentence">
                                   Faculty
                                </div>
                            </div>
                            <div class = "members_tab_content tab_content" id="department_admins_members_tab_content">

                                <?php foreach($department->admins as $member){ ?>
                                    <div class = "members_card_wrapper" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
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
                                                <a class = "department_link"><?php echo $department->department_name; ?></a>
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



                            </div>
                        </div> 
                    </div>

                    <div class="panel tab_members" id="panel_4">
                        <div class = "tab_content_holder">
                            <div class = "tab_header">
                                <div class = "float_Right">
                                    <div class = "add_people_button">
                                        Add Students
                                    </div>
                                    <div class = "small_search" class = "fade_input_small">
                                        <em id = "left_search_icon">
                                        </em>
                                        <input type = "text" name = "people_search_input" placeholder = "Search people" class = "name_search_input small_search_input" id="department_students_search_input">
                                    </div>                                        
                                </div>
                                <div class = "header_sentence">
                                    Students
                                </div>
                            </div>
                            <div class = "members_tab_content tab_content" id="department_students_members_tab_content">
                                <?php foreach($department->students as $member){ ?>
                                    <div class = "members_card_wrapper" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
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
                                                <a class = "department_link"><?php echo $department->department_name; ?></a>
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

    <!--            --><?php //echo Yii::app()->runController('partial/rightmenu'); ?>
</div>

</body>




</html>


