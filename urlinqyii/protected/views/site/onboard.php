<html>
    <head>
        <script>
            base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';

            user_id = '<?php echo Yii::app()->session['user_id']; ?>';
            email = '<?php echo Yii::app()->session['email']; ?>';
            first_name = '<?php echo Yii::app()->session['first_name']; ?>';
            last_name = '<?php echo Yii::app()->session['last_name']; ?>';
            user_type = '<?php echo Yii::app()->session['user_type']; ?>';



            onboarding_step = -1;
            department_id = null;
            school_id = null;

            <?php if(isset(Yii::app()->session['onboarding_step'])) { ?>



            onboarding_step = '<?php echo Yii::app()->session['onboarding_step']; ?>';
            department_id = '<?php echo Yii::app()->session['department_id']; ?>';
            school_id = '<?php echo Yii::app()->session['school_id']; ?>';

            console.log('ONBOARDING STEP: ' + onboarding_step.toString());
            console.log('department_id: ' + department_id.toString());


            <?php } ?>



            console.log('user_id: ' + user_id);
            console.log('email: ' + email);
            console.log('first_name: ' + first_name);
            console.log('last_name: ' + last_name);
            console.log('user_type: ' + user_type);


        </script>
        <title>Urlinq</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Urlinq</title>
        <link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300" rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/css/progressbar.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/semantic/packaged/css/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/css/onboard.css">
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.slimscroll.js"></script>

        <!--<script src="js/progressbar.js"></script>-->
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/semantic/packaged/javascript/semantic.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/js/onboard.js"></script>

    </head>
    <body>
        <div class="wrapper">
            <div class="progress-window">
                <div class="progress_frame">
                    <div class="progress_header">
                        <div class="progress_hint_0">Select your School</div>
                        <div class="progress_hint_2">
                            <div class="devbox">
                                <div class="wrap">
                                    <div class="progress-wrap">
                                        <div class="progress" style="width: 14%; background-color: rgb(186, 81, 228);">
                                            <!--<span class="countup"></span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress_hint_1">Step <span class="curr_step">1</span> of <span>7</span></div>
                        <div class="progress_goback" style="display: none;"></div>
                    </div>
                    <div class="progress_content">
                        <div class="content_inner">
                            <div class="content_canvas">
                                  <div class="step_0_card"><div class="card_0_info"><img class="card_0_glyph" src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/img/defaultGlyph.png"><div class="card_0_text"><div class="card_0_text_0">NYU Polytechnic School of Engineering</div><div class="card_0_text_1"></div></div><div class="green_join_btn"><em class = 'white_plus_icon'></em><span>Join</span></div></div></div><div class="step_0_card"><div class="card_0_info"><img class="card_0_glyph" src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/img/defaultGlyph.png"><div class="card_0_text"><div class="card_0_text_0">NYU Steinhardt School of Education</div><div class="card_0_text_1"></div></div><div class="green_join_btn"><em class = 'white_plus_icon'></em><span>Join</span></div></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress_footer">
                        <div class="progress_footer_glyph_0"></div>
                        <div class="next_progress blue_btn" style="display: none;">Join your School</div>
                        <div class="skip_progress" style="display: none;">or <span>skip this step</span></div>

                        <input type="text" placeholder="Search schools" class="onboard_textarea_t0 onboard_textarea_t1 onboard_textarea_t2">
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script id="school_template" type="text/x-handlebars-template">

            <div class="step_0_card school" data-school_id='{{school_id}}' data-school_name='{{school_name}}' style='background: url("{{base_url}}{{pictureFile.file_url}}") center center;'>
                <div class="card_0_info">
                    <img class="card_0_glyph" src='{{base_url}}/onboard_files/img/defaultGlyph.png'>
                    <div class="card_0_text"><div class="card_0_text_0">{{school_name}}</div><div class="card_0_text_1"></div></div>
                    <div class="green_join_btn"><em class = 'white_plus_icon'></em><span>Join</span></div>
                </div>
            </div>

    </script>


    <script id="school_template2" type="text/x-handlebars-template">

    </script>

<!--    " + cs.toString() + "</span> " + ((cs == 1) ? 'section' : 'sections') +"-->

    <script id="step_3_template" type="text/x-handlebars-template">
        <div class='step_3_card' id="course_{{course_id}}" data-course_id='{{course_id}}' data-course_name='{{course_tag}} - {{course_name}}'>
            <div class='step_3_show'>
                <img class='card_3_glyph' src='{{base_url}}{{pictureFile.file_url}}'>
                <div class='step_3_line_0'>{{course_tag}} - {{course_name}}</div>
                <div class='step_3_line_1'>
                    <div class='step_3_line_1_0'><span>{{department.department_name}}</span></div>
                    <!--<span class='adot'>&#8226;</span>-->
                    <!--<div class='member_glyph'></div>-->

                </div>
            </div>
            <div class='step_3_hide'>
                <div class='cover_line'>choose your section</div>
                <div class='step_3_card_section_detail'></div>
            </div>
        </div>
    </script>


    <script id="step_3_sub_template" type="text/x-handlebars-template">
        <div class='step_3_card_section_detail_card' data-class_id='{{class_id}}' id='class_{{class_id}}' data-professor_id='{{professor.user_id}}'>
            <input type='checkbox' class='section_check' >
            <div class='section_detail_right'>{{#if professor}}<div class='class_section_id'>professor: {{professor.firstname}} {{professor.lastname}}</div>{{/if}} {{#ifCond class_datetime '!=' 'null'}}<div class='class_datetime'>{{class_datetime}}</div>{{/ifCond}} {{#if section_id}}<div class='class_section_id'>id: {{section_id}}</div>{{/if}} {{#ifCond location '!=' ''}}<div class='class_section_id'>location: {{location}}</div>{{/ifCond}}
            </div>
        </div>
    </script>



    <script id="department_template" type="text/x-handlebars-template">
        <div class='step_0_card department' data-department_id="{{department_id}}" data-department_name="{{department_name}} ({{department_tag}})" style='background: url("{{base_url}}{{pictureFile.file_url}}") center center;'>
            <div class='card_0_info'>
                <div class='card_0_text'><div class='card_0_text_0'>{{department_name}} ({{department_tag}})</div>
                    <div class='card_0_text_1'>{{users.length}} people</div>
                </div>
                <div class='green_join_btn'><em class = 'white_plus_icon'></em><span>Join</span></div>
            </div>
        </div>
    </script>






    <script id="last_panel_template" type="text/x-handlebars-template">
        <div class='step_6_card'>
            <div class='step_6_card_r0'>

                <!--<div class='pt_upload_btn gray_btn'>Upload Profile Picture</div>-->

                <form action="/user/uploadProfileImage" class="dropzone dz-clickable files_upload_bigbox" id="profile_image_upload_form">
                    <input type='file' class='step_6_upload' style='display:none;'>

                    <!--<input class="upload_files_submit" type="submit" name="submitIT" value="Upload these Files">-->

                    <input id='profile_image_submit' type="submit" name="submitIT" value="Upload this file" style='display:none;'>
                </form>
                <div class = "update_picture_text">
                    <p>Upload your profile picture</p>
                </div>


            </div>





            {{#ifCond user_type '==' 'a'}}
                <div class='step_6_card_r1'>
                    <div class='step_6_card_r1_txt'>Faculty Type</div>
                    <div class='ui dropdown step_6_card_r1_choice'>
                        <div class='text'>Professor</div>
                        <i class='dropdown icon'></i>
                        <div class='menu admin_type_menu'>
                            <div class='item' data-value='p'>Professor</div>
                            <div class='item' data-value='a'>Administrator</div>
                        </div>
                    </div>
                </div>


                <div class='step_6_card_r2'>
                    <div class='step_6_card_r2_txt'>Office Location</div>
                    <input type='text' class='ol onboard_textarea_t0'/>
                </div>


                <div class='step_6_card_r3'>
                    <div class='step_6_card_r3_txt'>Research Interests</div>
                    <input type='text' class='as onboard_textarea_t0'/>
                </div>

            {{/ifCond}}

            {{#ifCond user_type '==' 'p'}}
                <div class='step_6_card_r1'>
                    <div class='step_6_card_r1_txt'>Faculty Type</div>
                    <div class='ui dropdown step_6_card_r1_choice'>
                        <div class='text'>Professor</div>
                        <i class='dropdown icon'></i>
                        <div class='menu' id='admin_type_menu'>
                            <div class='item' data-value='p'>Professor</div>
                            <div class='item' data-value='a'>Administrator</div>
                        </div>
                    </div>
                </div>



                <div class='step_6_card_r2'>
                    <div class='step_6_card_r2_txt'>Office Location</div>
                    <input type='text' id='office_location_input' class='ol onboard_textarea_t0'/>
                </div>

                <div class='step_6_card_r2'>
                    <div class='step_6_card_r2_txt'>Office hours</div>
                    <input type='text' id='office_hours_input' class='ol onboard_textarea_t0' placeholder="eg: 4pm - 6pm Mon, Wed"/>
                </div>


                <div class='step_6_card_r3'>
                    <div class='step_6_card_r3_txt'>Research Interests</div>
                    <input type='text' id='research_interests_input' class='as onboard_textarea_t0'/>
                </div>
            {{/ifCond}}


            {{#ifCond user_type '==' 's'}}
                <div class='step_6_card_r1'>
                    <div class='step_6_card_r1_txt'>Graduation date</div>

                    <div class='ui dropdown step_6_card_r1_choice'>
                        <div class='text'>2015</div>
                        <i class='dropdown icon'></i>
                        <div class='menu' id='graduation_date_menu' data-value='2015'>
                            <div class='item' data-value='2015'>2015</div>
                            <div class='item' data-value='2016'>2016</div>
                            <div class='item' data-value='2017'>2017</div>
                            <div class='item' data-value='2018'>2018</div>
                        </div>
                    </div>
                </div>
            {{/ifCond}}












            <div class='step_6_card_r4'><div class='step_6_card_r4_txt'>Gender</div>
                <input class='step_6_card_r4_input' type='radio' name='gender' value='M'><span>Male</span>
                <input class='step_6_card_r4_input' type='radio' name='gender' value='F'><span>Female</span>
            </div>

    </script>



    <script id="professor_class_template" type="text/x-handlebars-template">

        <div class='step_3_card professor_class' id="class_{{class_id}}" data-class_id='{{class_id}}' data-course_id='{{course_id}}' data-class_name='{{class_name}}'>
            <div class='step_3_show'>
                <img class='card_3_glyph' src='{{base_url}}{{department.pictureFile.file_url}}'>
                <!--<img class="card_3_glyph" src='{{base_url}}/onboard_files/img/defaultGlyph.png'>-->
                <div class='step_3_line_0'>{{class_name}}</div>

                {{#if class_datetime}}
                    <div class='class_datetime'><span>{{class_datetime}}</span></div>
                {{/if}}

                <div class='step_3_line_1'>
                    <div class='step_3_line_1_0'><span>{{department.department_name}}</span></div>
                    <!--<span class='adot'>&#8226;</span>-->
                    <!--<div class='member_glyph'></div>-->

                </div>
            </div>

        </div>

            <!--<div class="professor_class step_3_card" data-class_id='{{class_id}}' data-class_name='{{class_name}}' style='background: url("{{base_url}}{{pictureFile.file_url}}") center center;'>-->
                <!--<div class="professor_class_info">-->
                    <!--<div class="professor_class_text">-->
                        <!--<div class="professor_class_text_0">{{class_name}}</div>-->
                        <!--<div class="professor_class_text_1"></div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->

    </script>



</html>