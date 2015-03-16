<html>
    <?php
        $department_front_end_name = 'department';
        if($course->school->university_id == 4){
            $department_front_end_name = 'program';
        }
    ?>

    <head>
        <script>
            var globals = {};
            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'course'; ?>';

            globals.origin_id = '<?php echo $course->course_id; ?>';
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

        <title><?php echo $course->course_name; ?></title>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/location_input/location_input.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>

        <!--these are for feed and fbar in the profile-->
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css">


        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/render_post.js"> </script>

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>
        <!--BELOW ARE SCRIPTS AND LINKS FOR DROPDOWN MENU API -->
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropit.js'></script>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/dropit.css" type="text/css" />
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/jquery.autosize.js'></script>
        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/ness.js"> </script>
        <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/embedly.js"> </script>
        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js"> </script>
        <script>
            moment().format();
        </script>
        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/feed.js"> </script>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/feed/feed.css"> </link>

        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">


        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/lightbox.min.js" type="text/javascript"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/lightbox.css" type = "text/css" rel = "stylesheet">
 


    </head>

    <body class = "body_group">

        <?php echo Yii::app()->runController('partial/topbar'); ?>
        <div id="wrapper" class="<?php echo $user->status; ?>">
        <!--        --><?php //echo Yii::app()->runController('partial/leftmenu'); ?>




        <div id="page">


        <div id="main_panel" class = "group_responsiveness">


            <div id="content_holder">

                <div id="left_panel">
                    <!--                        <section class='leftbar_bag'>-->
                    <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'course','origin_id'=>$course->course_id,'origin_name'=>$course->course_name)); ?>
                    <!--                        </section>-->
                </div>




                <div id="content_panel" class = "course_content_panel group_responsiveness">
                    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'course','origin_id'=>$course->course_id,'origin'=>$course,'user'=>$user)); ?>



                    <?php if($is_admin){ ?>
                    <form action="/post/create" id="cover_photo_form" style="padding: 0px; margin: 0px;">
                        <input type='file' class='step_6_upload' style='display:none;'>
                    <?php } ?>

                    <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $course->pictureFile->file_url ?>');">
                        <div class = "blur_section_overflow_container">
                            <div class = "blur_section" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $course->pictureFile->file_url ?>');">
                            </div>
                        </div>                            
                        <div class = "group_name">
                            <div class = "center_text"><p id = "group_name" class = "school_name"><span id = "name_title"><?php echo $course->course_name; if($course->course_tag != ''){ echo ' (' . $course->course_tag . ')'; } ?></span></p></div>
                        </div>

                        <?php if($is_admin){ ?>
                        <div class = "upload_cover_photo_button group_info_block_new upload_cover_container">
                            <div class="upload_cover_photo_text">Change cover</div>
                            <div id="set_to_parents_photo" style="cursor:pointer;">SET TO PARENTS IMG</div>
                        </div>
                        <?php } ?>

                    </div>


                    <?php if($is_admin){ ?>
                    </form>
                    <?php } ?>



                    <div id="tab_bar">

                        <div class="tab classes active" data-panel_id="1">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Open Classes</div>
                            </div>
                            <div class="tab_wedge"></div>
                        </div>






                        <!-- #group_user_action_button performs either join/leave or follow/unfollow depending on context -->



                    </div>


                    <div class="panel active" id="panel_1">
                        <div class = "tab_content_holder">
                            <div class ="tab_header ">
                                <div class = "group_right_info group_info_boxes course_info_box">
                                    <div class = "group_info_block course_description" id = "professors">
                                        <?php echo $course->course_desc; ?>

                        
                                        <?php if($course->course_credits) { ?>
                                        <h4 class = "course_credits"><span class ="cred_icon"></span><span class = "cred_val"><?php echo $course->course_credits; ?></span> <span class = "cred_name">Credits</span></h4>
                                        <?php } else { }?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab_header tab_header_course"> 
                                <div class = "float_Center courses_list">
                                    <span class = "sort_label">Order:</span>
                                    <div class = "order_sort_dropdown">
                                        <span>Class Size High to Low</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <div class = "small_search fade_input_small">
                                        <em id = "left_search_icon">
                                        </em>
                                        <input type = "text" name = "people_search_input" placeholder = "Search classes by section" class = "name_search_input small_search_input">
                                    </div>                                        
                                </div>
                            </div>
                            <div class = "group_info_tab_content tab_content">


                                <?php foreach($course->classes as $class){ ?>
                                    <?php $class_students = $class->students; ?>
                                    <div class = "group_box group_course_box" data-class_id="<?php echo $class->class_id; ?>" data-section_id="<?php echo $class->section_id; ?>" data-name="<?php echo $class->class_name; ?>" data-student_count="<?php echo count($class_students ); ?>">
                                        <a href='<?php echo Yii::app()->getBaseUrl(true) . '/class/' . $class->class_id;?>'>
                                            <div class = "float_Left group_image" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $class->pictureFile->file_url; ?>');">
                                            </div>
                                        </a>
                                        <div class = "group_box_main_info">
                                            <a href='<?php echo Yii::app()->getBaseUrl(true) . '/class/' . $class->class_id;?>' class = "group_link"><?php echo $class->class_name; ?></a>
                                            <div class = "float_Right">
                                                <span class = "group_type">Class</span>
                                            </div>
                                        </div>
                                        <div class = "group_box_secondary_info_section">

                                            <div class= "info_line indent">Section: <?php echo $class->section_id; ?></div>
                                            <?php if($class->class_datetime){ ?>
                                                <div class= "info_line indent">Time: <?php echo $class->class_datetime; ?></div>
                                            <?php } ?>
                                            <div class= "info_line indent"><?php echo count($class_students); ?> students</div>
                                            <?php $professor = $class->professor; ?>
                                            <?php if($professor){ ?>
                                                <div class="info_line indent profile_link" data-user_id="<?php echo $class->professor->user_id; ?>"><?php echo $class->professor->firstname . ' ' . $class->professor->lastname; ?></div>
                                            <?php } ?>
                                            <div class= "info_line indent"><?php echo ucfirst($department_front_end_name); ?> of <a class = "department_link" href="<?php echo Yii::app()->getBaseUrl(true) . '/' . $department_front_end_name . '/' . $class->department->department_id; ?>"><?php echo $class->department->department_name; ?></a></div>
                                            <div class = "info_line info_about">
                                                <?php foreach($class_students as $student){ ?>

                                                    <div class='class_student' style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $student->pictureFile->file_url ; ?>')">

                                                    </div>

                                                <?php } ?>
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

        <div id="right_panel" class = "group_responsiveness">
            <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'course','origin_id'=>'')); ?>   
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
        <?php echo $this->renderPartial('/partial/feed_templates',array('origin_type'=>'user', 'user_id'=>$user->user_id,'is_admin'=>false)); ?>
    </body>




</html>