<html>


<head>
    <script>
        var globals = {};
        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        globals.origin_type = '<?php echo 'department'; ?>';
        globals.origin_id = '<?php echo $department->department_id; ?>';
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

    <title><?php echo $department->department_tag . ' - ' . $department->department_name; ?></title>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>

</head>

<body class = "body_group" id = "body_department">

<?php echo Yii::app()->runController('partial/topbar'); ?>
<div id="wrapper">





    <div id="page">


        <div id="main_panel" class = "group_responsiveness">


            <div id="content_holder">

                <div id="left_panel" class = "group_responsiveness">
                    <!--                        <section class='leftbar_bag'>-->
                    <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'department','origin_id'=>$department->department_id,'origin_name'=>$department->department_name)); ?>
                    <!--                        </section>-->
                </div>




                <div id="content_panel" class = "department_content_panel group_responsiveness">
                    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'department','origin_id'=>$department->department_id,'origin'=>$department)); ?>


                    <?php if($user->user_type == 'a' || $user->user_type == 'p'){ ?>
                        <form action="/api/uploadCoverPhoto" id="cover_photo_form" style="padding: 0px; margin: 0px;">
                        <input type='file' class='step_6_upload' style='display:none;'>
                    <?php } ?>


                        <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $department->coverFile->file_url ?>');">
                            <div class = "group_name">
                                <div class = "center_admin"><div class = "department_of">Department of</div></div>
                                <div class = "center_text"><p id = "group_name"><span id = "name_title"><?php echo $department->department_name . ' (' . $department->department_tag . ')'; ?></span></p></div>
                            </div>
                            <div class = "group_right_info group_info_boxes">
                                <div class = "group_info_block" id = "location">
                                    <em class ="small_icon_map"></em>
                                    <span><?php echo $department->school->school_name; ?></span>
                                    <?php if($user->user_type == 'a' || $user->user_type == 'p'){ ?>
                                        <div class="upload_cover_photo_button">Upload cover photo</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    <!--        close the cover photo dropzone form if user is an admin -->
                    <?php if($user->user_type == 'a' || $user->user_type == 'p'){ ?>
                        </form>
                    <?php } ?>




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
<!--                            <div id="group_user_action_button" class="member" data-action_url="/leave">-->
<!--                                <div id="group_user_action_button_text">Member</div>-->
<!--                            </div>-->
                        <?php }else{ ?>
<!--                            <div id="group_user_action_button" class="non_member" data-action_url="/join">-->
<!--                                <div id="group_user_action_button_text">Follow</div>-->
<!--                            </div>-->
                        <?php } ?>





                    </div>


                    <div class="panel active panel_feed" id="panel_1">
                        <div id = "planner_column" class = "planner_column_group planner_column_department">
                            <div id = "right_column_specs">
                                <div id = "fixed_element" class = "planner_group">
                                    <?php
                                    echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'department','origin_id'=>$department->department_id));
                                    ?>    
                                </div>
                            </div>                           
                        </div>
                        <div id = "feed_column" class = "feed_column_group">
                            <div id = "stream_holder" class = "stream_holder_home">
                                <div id = "fbar_wrapper" class = "fbar_home">
                                    <?php echo $this->renderPartial('/partial/department_status_bar',array('user'=>$user,'origin_type'=>'department','origin_id'=>$department->department_id)); ?>
                                </div>

                                <div id = "feed_wrapper" class = "feed_wrapper_home">
                                    <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/department/'.$department->department_id.'/feed', 'origin_type'=>'department','origin_id'=>$department->department_id)); ?>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="panel tab_group_info" id="panel_2">
                        <div class = "tab_content_holder">
                            <div class="tab_header"> 
                                <div class = "float_Right">

<!--                                    <span class = "sort_label">Order:</span>-->
<!--                                    <div class = "order_sort_dropdown">-->
<!--                                        <span>Courses High to Low</span>-->
<!--                                        <em class = "dropdown_arrow">-->
<!--                                        </em>-->
<!--                                    </div>-->
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
                                            <a href='<?php echo Yii::app()->getBaseUrl(true) . '/course/' . $course->course_id;?>' class = "group_link"><?php echo $course->course_name . ' (' . $course->course_tag . ')'; ?></a>
                                            <div class = "float_Right">
                                                <span class = "group_type">Course</span>
                                            </div>
                                        </div>
                                        <div class = "group_box_secondary_info_section">
                                            <div class= "info_line indent"><?php echo count($course->classes); ?> classes</div>
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

<!--                                    @todo -->
<!--                                    <div class = "add_people_button">-->
<!--                                        Add Faculty-->
<!--                                    </div>-->
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
                                                <a class = "department_link"><?php echo $department->department_name; ?></a>
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
                                            <?php } ?>
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
<!--                                    @todo -->
<!--                                    <div class = "add_people_button">-->
<!--                                        Add Students-->
<!--                                    </div>-->
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
                                                <a class = "department_link"><?php echo $department->department_name; ?></a>
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
                                                        <div class = "user_message_button message_active">
                                                            <em class = "white_message_icon">
                                                            </em>
                                                        </div>
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
            <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'department','origin_id'=>'')); ?>   
        </div>

        <!--            <div id="div1" style="height: 500px;position:relative;">-->
        <!--                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid red;">-->
        <!--                    <div id="div3" style="height:1500px;border:5px solid yellow;">hello</div>-->
        <!--                </div>-->
        <!--            </div>-->

    </div>

    <!--            --><?php //echo Yii::app()->runController('partial/rightmenu'); ?>
</div>


     <!--<!-- INCLUDE THIS AND date_selector.js and add class name date_input to your date input fields to use this -->

     <!--<!-- INCLUDE THIS AND date_selector.js and add class name date_input to your date input fields to use this -->

    <div id = "calLayer" style="display: none;">
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
    </div>




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




</body>




</html>


