<html>
<head>


    <script>
        var globals = {};

        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        globals.origin_type = '<?php echo 'search'; ?>';
        globals.origin_id = '<?php echo $user->user_id; ?>';
    </script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">


    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main_search.css">

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_courses.css">



    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
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
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
    


    <script>
        base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";
        q = "<?php echo $q ?>";
    </script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/search_new.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js"> </script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/protected/js/search.js"> </script>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>

 
    </script>
</head>

<body class = "body_searchpage">

    <?php echo Yii::app()->runController('partial/topbar'); ?>
    <div id="wrapper" class = "wrapper_searchpage">
        <div id="page" class = "page_search page_search_all_members_results">
            <div class = "black_background_row" style="display: none !important; ">
            </div>
            <div class = "horizontal_scroll_holder" id="users" style="display: none !important;">
                <div class = "horizontal_scroll_holder_search" id = "horizontal_scroll_holder" style="display: none;">
                        <!-- horizontal scroll members cards -->
                    <div class = "horiz-area">
                        <div class = "horiz-wrapper">
                            <div class = "horiz-mask">
                                <div class = "content-area">
                                    <div class = "ContentSlider">



                                    </div>

                                </div>
                            </div>
                            <div class = "arrow_disabled arrow_container arrow_prev">
                                <a class = "ar_disabled ar_left">

                                </a>
                            </div>
                            <div class = "arrow_container arrow_next">
                                <a id = "ar_right" class = "ar_right">
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                        
                </div>                
            </div>
            <div id="main_panel" class = "main_panel_search">
                <div id="content_holder" class = "content_holder_search">
                    <div id = "left_panel_search" class = "left_panel_search search_filter_holder">
                        <div class = "search_filter_container">
                            <div class = "filter_header">
                                <div class = "float_Right">
                                    <span></span>
                                    <div class = "help_div dark">
                                        <div class = "wedge">
                                        </div>
                                        <div class = "box">
                                            Results from the NYU academic network
                                        </div>
                                    </div>
                                </div>
                                <span class = "filter_header_sentence">
                                    University Search
                                </span>
                            </div>
                            <div class = "members_all_filter filter_section" data-filter_id="1" data-filter="all">
                                <div class = "filter_name no_name_marginbtm">
                                    <span class = "filter_on_indicator">Showing </span><span>All Results</span>
                                </div>
                            </div>
                            <div class = "not_members_all_filter filter_section" data-filter_id="2" data-filter="courses">
                                <div class = "float_Right">
                                    <em class = "search_icon">
                                    </em>
                                    <span class = "search_filter_count">600</span>
                                </div>
                                <div class = "filter_name">
                                    <span class = "filter_on_indicator">Showing </span><span>Courses</span>
                                </div>
                                <div class = "filter_inputs">
                                    <div class = "filter_dropdown">
                                        <span>School</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <div class = "dropdown_popout popout_down">
                                    </div> 
                                    <div class = "filter_dropdown">
                                        <span>Department</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <input type = "text" class = "filter_textinput" name = "professor_name" placeholder = "Narrow by professor...">
                                </div>
                            </div>
                            <div class = "not_members_all_filter filter_section" data-filter_id="3" data-filter="clubs">
                                <div class = "float_Right">
                                    <em class = "search_icon">
                                    </em>
                                    <span class = "search_filter_count">400</span>
                                </div>
                                <div class = "filter_name">
                                    <span class = "filter_on_indicator">Showing </span><span>Clubs</span>
                                </div>
                                <div class = "filter_inputs">
                                    <div class = "filter_dropdown last">
                                        <span>School</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                </div>
                            </div>
                            <div class = "not_members_all_filter filter_section" data-filter_id="4" data-filter="departments">
                                <div class = "float_Right">
                                    <em class = "search_icon">
                                    </em>
                                    <span class = "search_filter_count">50</span>
                                </div>
                                <div class = "filter_name">
                                    <span class = "filter_on_indicator">Showing </span><span>Departments</span>
                                </div>
                                <div class = "filter_inputs">
                                    <div class = "filter_dropdown last">
                                        <span>School</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                </div>
                            </div>
                            <div class = "members_all_filter filter_section" data-filter_id="5" data-filter="faculty">
                                <div class = "float_Right">
                                    <em class = "search_icon">
                                    </em>
                                    <span class = "search_filter_count">850</span>
                                </div>
                                <div class = "filter_name">
                                    <span class = "filter_on_indicator">Showing </span><span>Faculty</span>
                                </div>
                                <div class = "filter_inputs">
                                    <div class = "filter_dropdown">
                                        <span>School</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <div class = "filter_dropdown last">
                                        <span>Department</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                </div>
                            </div>
                            <div class = "members_all_filter filter_section" data-filter_id="6" data-filter="students">
                                <div class = "float_Right">
                                    <em class = "search_icon">
                                    </em>
                                    <span class = "search_filter_count">520</span>
                                </div>
                                <div class = "filter_name">
                                    <span class = "filter_on_indicator">Showing </span><span>Students</span>
                                </div>
                                <div class = "filter_inputs">
                                    <div class = "filter_dropdown">
                                        <span>School</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <div class = "filter_dropdown">
                                        <span>Major/Study</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>
                                    <div class = "dropdown_popout popout_up">
                                    </div>                                     
                                    <div class = "filter_dropdown last">
                                        <span>Class Year</span>
                                        <em class = "dropdown_arrow">
                                        </em>
                                    </div>                                    
                                </div>
                            </div>
                            <div class = "not_members_all_filter filter_section" data-filter_id="7" data-filter="events">
                                <div class = "float_Right">
                                    <em class = "search_icon">
                                    </em>
                                    <span class = "search_filter_count">85</span>
                                </div>
                                <div class = "filter_name no_name_marginbtm">
                                    <span class = "filter_on_indicator">Showing </span><span>Events</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "content_panel" class = "content_panel_search">

                        <div class = "search_results_main">
                            <div class = "search_results_header">
                                <span class = "search_results_header_sentence">
                                    Search Results for <span class = "query">'Economics' </span><span class = "results_count"></span>
                                </span>
                            </div>




                            <div class='search_result_panel group_info_tab_content tab_content' id="courses">


                            </div>


                            <div class='search_result_panel group_info_tab_content tab_content' id="clubs">


                            </div>


                            <div class='search_result_panel group_info_tab_content tab_content' id="departments">


                            </div>


                            <div class='search_result_panel ' id="faculty">


                            </div>


                            <div class='search_result_panel' id="students">


                            </div>

                            <div class='search_result_panel' id="events">


                            </div>








                        </div>
                    </div>
                </div>
            </div>





            <div id="right_panel">
                <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'search','origin_id'=>'')); ?>   
            </div>



        </div>
    </div>



<script id="user_template" type="text/x-handlebars-template">

    <div class = "members_card_wrapper slide" data-user_id='{{user_id}}' data-school_id='{{school_id}}' data-department_id='{{department_id}}'>
        <div class = "members_card admin normal_size" data-user_id='1'>
            <div class = "members_card_img">
                {{#ifCond user_type '==' 's'}}
                    <span class = "title">Student</span>
                {{/ifCond}}

                {{#ifCond user_type '==' 'p'}}
                    <span class = "title">Professor</span>
                {{/ifCond}}

                {{#ifCond user_type '==' 'a'}}
                    <span class = "title">Admin</span>
                {{/ifCond}}



                <span class = "class_year">Senior</span>
            </div>
            <div class = "user_main_info">
                <a class = "name profile_link" data-user_id="{{user_id}}">{{fullname}}</a>
            </div>
            <div class = "user_more_info">
                <a class = "department_link">{{department_name}}</a>
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


</script>




<script id="course_template" type="text/x-handlebars-template">

    <div class = "group_box group_course_box" data-course_id='{{course_id}}' data-name="{{course_name}}" data-school_id='{{school_id}}' data-school_id='{{professor_id}}'>
        <div class = "float_Left group_image" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true); ?>{{pictureFile.file_url}}');">
        </div>
        <div class = "group_box_main_info">
            <a href='<?php echo Yii::app()->getBaseUrl(true); ?>/course/{{course_id}}' class = "group_link">{{course_name}}</a>
            <div class = "float_Right">
                <span class = "group_type">Course</span>
            </div>
        </div>
        <div class = "group_box_secondary_info_section">
            <div class= "info_line indent">4 open classes</div>
            <div class= "info_line indent">Department of <a class = "department_link" href="<?php echo Yii::app()->getBaseUrl(true); ?>/department/{{department.department_id}}">{{department.department_name}}</a></div>
            <div class = "info_line info_about">{{course_desc}}</div>
        </div>
    </div>

</script>


<script id="club_template" type="text/x-handlebars-template">

    <div class = "group_box group_course_box club_box" data-group_id='{{group_id}}' data-school_id='{{school_id}}'>
        <div class = "float_Left group_image">
            <a class = "group_link">{{group_name}}</a>
            <span class = "group_type group_with_button">Club</span>

        </div>
        <div class = "group_box_main_info">

            <div class = "float_Right">
                <div class = "group_bar_button_holder">
                    <div class = "join_button_wrapper">
                        <div class = "group_join_button nonmember"><em class = "white_add_icon"></em>Join Club</div>
                    </div>
                </div>
            </div>
        </div>
        <div class = "group_box_secondary_info_section">
            <div class= "info_line indent">35 members</div>
            <div class= "info_line indent info_line_events"><span></span>5 events this month</div>
            <div class = "about_scroll_container"><span class = "scroll_gif"></span><div class = "info_line info_about"><div class = "about">{{group_desc}}</div></div></div>
        </div>
    </div>

</script>


<script id="department_template" type="text/x-handlebars-template">
    <div class="group_box group_course_box">
        <div class="float_Left group_image">
            <div class="department_alias">
                CBE
            </div>
        </div>
        <div class="group_box_main_info">
            <a class="group_link">{{department_name}}</a>
            <a class="group_link">{{school.school_name}</a>
            <div class="float_Right">
                <span class="group_type">Department</span>
            </div>
        </div>
        <div class="group_box_secondary_info_section">
            <div class="info_line indent"><span>{{faculty_count}} faculty </span><b>·</b><span> {{student_count}} student{{#ifCond student_count '!=' 1}}s{{else}}{{/ifCond}}</span></div>
            <div class="info_line indent">{{course_count}} courses</div>
        </div>
    </div>

</script>

<script id="vertical_course_results" type="text/x-handlebars-template">
    <div class="course vert-results-wrapper">

        <div class=results-top-sec>
            <div class="result-header">
                <a href = {{url}}>{{name}}</a>
            </div>
            <div class="result-header-right"></div>
            <div class="results-main-sec">
                <p class="description">
                    {{description}}
                </p>
                <div class="lower-info-keys">
                    <div class="info-key admin">
                        {{admin_key}}
                    </div>
                    <div class="info-key subject">
                        {{department_key}}
                    </div>
                    <div class="info-key members">
                        {{members_key}}
                    </div>
                </div>
                <div class="lower-info">
                    <div class="info-piece admin">
                        {{admin_value}}
                    </div>
                    <div class="info-piece subject">
                        <a href = "{{department_url}}">{{department_value}}</a>
                    </div>
                    <div class="info-piece members">
                        {{members_value}}
                    </div>
                    <div class="result-bottom">
                        <div class="course-schedule"></div>
                        <div class="course-bottom-functions"><div class="join-button">
                            <!--<a class="followCourse sign-up" data-value="BMS3314"></a>-->
                            </div></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</script>

<!--Club Search Results-->
<script id="vertical_club_results" type="text/x-handlebars-template">
    <div class="person vert-results-wrapper">
        <a class="person-result-image" href="clubs.php?group_id=17">
            <div style="background-image: url({{imgurl}});" class="img"></div>
        </a>
        <div class="person-main">
            <div class="person-header">
                <div class="result-header">
                    <a href="{{cluburl}}"><h2>{{name}}</h2></a>
                    <a href="department.php?dept_id="><p></p></a>
                </div>
                <div class="result-header-right">
                    <div class="result-functions-wrapper">
                        <div class="prof-tooltip tooltip">
                            <div class="tool-wedge"></div>
                            <div class="prof-tool-box tool-box">
                                <span>Add This Professor To My Bookmarks</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="person-result-main">
                <a href="school.php?univ_id="><div class="person-info">
                        <div style="background-image: url(DefaultImages/school.png);" class="title-limit"></div>
                        <h4></h4>
                    </div>
                </a>
                <div class="person-info">
                    <div class="title-limit mail"></div>
                <a href="mailto:idmclub@polyidm.com"><h4>idmclub@polyidm.com</h4></a>
                </div></div>
            <div class="person-bottom-functions"><div class="link-button"><a class="link link-up" data-value="17">Follow</a></div></div>
        </div>
    </div>
</script>

<!--Department Search Results-->
<script id="vertical_dept_results" type="text/x-handlebars-template">
    <div class="person vert-results-wrapper">
        <a class="person-result-image" href="clubs.php?group_id=17">
            <div style="background-image: url({{imgurl}});" class="img"></div>
        </a>
        <div class="person-main">
            <div class="person-header">
                <div class="result-header">
                    <a href="{{cluburl}}"><h2>{{name}}</h2></a>
                    <a href="department.php?dept_id="><p></p></a>
                </div>
                <div class="result-header-right">
                    <div class="result-functions-wrapper">
                        <div class="prof-tooltip tooltip">
                            <div class="tool-wedge"></div>
                            <div class="prof-tool-box tool-box">
                                <span>Add This Professor To My Bookmarks</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="person-result-main">
                <a href="school.php?univ_id="><div class="person-info">
                        <div style="background-image: url(DefaultImages/school.png);" class="title-limit"></div>
                        <h4></h4>
                    </div>
                </a>
                <div class="person-info">
                    <div class="title-limit mail"></div>
                </div></div>
            <div class="person-bottom-functions"><div class="link-button"><a class="link link-up" data-value="17">Follow</a></div></div>
        </div>
    </div>



</body>









        <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div> -->

        <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
       <!--</div>-->
       <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
       <!--</div>-->
       <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
       <!--</div>-->
       <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
       <!--</div>-->
       <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
       <!--</div>-->
       <!--<div class = "members_card_wrapper slide">-->
            <!--<div class = "members_card admin normal_size" data-user_id='1'>-->
                <!--<div class = "members_card_img">-->
                    <!--<span class = "title">Professor</span>-->
                    <!--<span class = "class_year">Senior</span>-->
                <!--</div>-->
                <!--<div class = "user_main_info">-->
                    <!--<a class = "name profile_link">Jacob Lazarus</a>-->
                <!--</div>-->
                <!--<div class = "user_more_info">-->
                    <!--<a class = "department_link">Neuroscience</a>-->
                <!--</div>-->
                <!--<div class = "user_card_button_holder">-->
                    <!--<div class = "follow_button_wrapper following_wrapper">-->
                        <!--<div class = "user_follow_button following">Following</div>-->
                        <!--<div class = "user_message_button message_active">-->
                            <!--<em class = "white_message_icon">-->
                            <!--</em>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
       <!--</div>  -->







</html>
