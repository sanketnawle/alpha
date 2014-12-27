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
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />


    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
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
                    <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $department->coverFile->file_url ?>');"></div>




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
                                <div class="tab_amount">180</div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>

                        <div class="tab members" data-panel_id="3">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Faculty</div>
                                <div class="tab_amount">180</div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>

                        <div class="tab members" data-panel_id="4">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Students</div>
                                <div class="tab_amount">820</div>
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


                    <div class="panel active" id="panel_1">
                        CLASS FEED GOES HERE
                    </div>

                    <div class="panel tab_group_info" id="panel_2">
                        <div id = "tab_content_holder">
                            <div id = "tab_header"> 
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
                                        <input type = "text" name = "people_search_input" placeholder = "Search courses" id = "small_search_input">
                                    </div>                                        
                                </div>
                                <div class = "header_sentence">
                                    Courses this Semester
                                </div>
                            </div>
                            <div class = "group_info_tab_content">
                                <div class = "group_box group_course_box">
                                    <div class = "float_Left group_image">
                                    </div>
                                    <div class = "group_box_main_info">
                                        <a class = "group_link">Neuroscience of Advertising</a>
                                        <div class = "float_Right">
                                            <span class = "group_type">Course</span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent">4 open classes</div>
                                        <div class= "info_line indent">Department of <a class = "department_link">Neuroscience</a></div>
                                        <div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div>
                                    </div>
                                </div>
                                <div class = "group_box group_course_box">
                                    <div class = "float_Left group_image">
                                    </div>
                                    <div class = "group_box_main_info">
                                        <a class = "group_link">Neuroscience of Advertising</a>
                                        <div class = "float_Right">
                                            <span class = "group_type">Course</span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent">4 open classes</div>
                                        <div class= "info_line indent">Department of <a class = "department_link">Neuroscience</a></div>
                                        <div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div>
                                    </div>
                                </div>
                                <div class = "group_box group_course_box">
                                    <div class = "float_Left group_image">
                                    </div>
                                    <div class = "group_box_main_info">
                                        <a class = "group_link">Neuroscience of Advertising</a>
                                        <div class = "float_Right">
                                            <span class = "group_type">Course</span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent">4 open classes</div>
                                        <div class= "info_line indent">Department of <a class = "department_link">Neuroscience</a></div>
                                        <div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div>
                                    </div>
                                </div>
                                <div class = "group_box group_course_box">
                                    <div class = "float_Left group_image">
                                    </div>
                                    <div class = "group_box_main_info">
                                        <a class = "group_link">Neuroscience of Advertising</a>
                                        <div class = "float_Right">
                                            <span class = "group_type">Course</span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent">4 open classes</div>
                                        <div class= "info_line indent">Department of <a class = "department_link">Neuroscience</a></div>
                                        <div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div>
                                    </div>
                                </div>
                                <div class = "group_box group_course_box">
                                    <div class = "float_Left group_image">
                                    </div>
                                    <div class = "group_box_main_info">
                                        <a class = "group_link">Neuroscience of Advertising</a>
                                        <div class = "float_Right">
                                            <span class = "group_type">Course</span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent">4 open classes</div>
                                        <div class= "info_line indent">Department of <a class = "department_link">Neuroscience</a></div>
                                        <div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div>
                                    </div>
                                </div>
                                <div class = "group_box group_course_box">
                                    <div class = "float_Left group_image">
                                    </div>
                                    <div class = "group_box_main_info">
                                        <a class = "group_link">Neuroscience of Advertising</a>
                                        <div class = "float_Right">
                                            <span class = "group_type">Course</span>
                                        </div>
                                    </div>
                                    <div class = "group_box_secondary_info_section">
                                        <div class= "info_line indent">4 open classes</div>
                                        <div class= "info_line indent">Department of <a class = "department_link">Neuroscience</a></div>
                                        <div class = "info_line info_about">This course explores neurotechnology and its application in the field of digital marketing and advertising. Topics covered include eye-tracking, fMRI, the reptilian brain, GSR, and behavioral economics.</div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="panel tab_members" id="panel_3">
                        <div id = "tab_content_holder">
                            <div id = "tab_header"> 
                                <div class = "float_Right">
                                    <div class = "add_people_button">
                                        Add Faculty
                                    </div>
                                    <div id = "small_search" class = "fade_input_small">
                                        <em id = "left_search_icon">
                                        </em>
                                        <input type = "text" name = "people_search_input" placeholder = "Search faculty" id = "small_search_input">
                                    </div>                                        
                                </div>
                                <div class = "header_sentence">
                                   Faculty
                                </div>
                            </div>
                            <div id = "members_tab_content">
                                <div class = "members_card_wrapper">
                                    <div class = "members_card admin normal_size" data-user_id='1'>
                                        <div class = "members_card_img">
                                            <span class = "title">Professor</span>
                                            <span class = "class_year">Senior</span>
                                        </div>
                                        <div class = "user_main_info">
                                            <a class = "name profile_link">Jacob Lazarus</a>
                                        </div>
                                        <div class = "user_more_info">
                                            <a class = "department_link">Neuroscience</a>
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
                               <div class = "members_card_wrapper">
                                    <div class = "members_card non_admin normal_size" data-user_id='1'>
                                        <div class = "members_card_img">
                                            <span class = "title">Professor</span>
                                            <span class = "class_year">Senior</span>
                                        </div>
                                        <div class = "user_main_info">
                                            <a class = "name profile_link">Jacob Lazarus</a>
                                        </div>
                                        <div class = "user_more_info">
                                            <a class = "department_link">Neuroscience</a>
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


                            </div>
                        </div> 
                    </div>

                    <div class="panel tab_members" id="panel_4">
                        <div id = "tab_content_holder">
                            <div id = "tab_header"> 
                                <div class = "float_Right">
                                    <div class = "add_people_button">
                                        Add Students
                                    </div>
                                    <div id = "small_search" class = "fade_input_small">
                                        <em id = "left_search_icon">
                                        </em>
                                        <input type = "text" name = "people_search_input" placeholder = "Search students" id = "small_search_input">
                                    </div>                                        
                                </div>
                                <div class = "header_sentence">
                                    Students
                                </div>
                            </div>
                            <div id = "members_tab_content">
                                <div class = "members_card_wrapper">
                                    <div class = "members_card admin normal_size" data-user_id='1'>
                                        <div class = "members_card_img">
                                            <span class = "title">Professor</span>
                                            <span class = "class_year">Senior</span>
                                        </div>
                                        <div class = "user_main_info">
                                            <a class = "name profile_link">Jacob Lazarus</a>
                                        </div>
                                        <div class = "user_more_info">
                                            <a class = "department_link">Neuroscience</a>
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
                               <div class = "members_card_wrapper">
                                    <div class = "members_card non_admin normal_size" data-user_id='1'>
                                        <div class = "members_card_img">
                                            <span class = "title">Professor</span>
                                            <span class = "class_year">Senior</span>
                                        </div>
                                        <div class = "user_main_info">
                                            <a class = "name profile_link">Jacob Lazarus</a>
                                        </div>
                                        <div class = "user_more_info">
                                            <a class = "department_link">Neuroscience</a>
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


