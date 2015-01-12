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

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300" rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/css/progressbar.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/semantic/packaged/css/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/css/onboard.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
                            <div class="content_canvas"><div class="step_0_card"><div class="card_0_info"><img class="card_0_glyph" src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/img/defaultGlyph.png"><div class="card_0_text"><div class="card_0_text_0">NYU Stern School of Business</div><div class="card_0_text_1">32 people</div></div><div class="green_join_btn"><span>Join</span></div></div></div><div class="step_0_card"><div class="card_0_info"><img class="card_0_glyph" src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/img/defaultGlyph.png"><div class="card_0_text"><div class="card_0_text_0">NYU Polytechnic School of Engineering</div><div class="card_0_text_1">32 people</div></div><div class="green_join_btn"><span>Join</span></div></div></div><div class="step_0_card"><div class="card_0_info"><img class="card_0_glyph" src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/img/defaultGlyph.png"><div class="card_0_text"><div class="card_0_text_0">NYU Steinhardt School of Education</div><div class="card_0_text_1">32 people</div></div><div class="green_join_btn"><span>Join</span></div></div></div></div>
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
</html>