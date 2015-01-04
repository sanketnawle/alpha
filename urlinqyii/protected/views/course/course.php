<html>


    <head>
        <script>
            var globals = {};
            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'course'; ?>';

            globals.origin_id = '<?php echo $course->course_id; ?>';

        </script>


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_files.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
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
                    <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'course','origin_id'=>$course->course_id,'origin_name'=>$course->course_name)); ?>
                    <!--                        </section>-->
                </div>




                <div id="content_panel">
                    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'course','origin_id'=>$course->course_id,'origin'=>$course)); ?>
                    <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $course->pictureFile->file_url ?>');"></div>




                    <div id="tab_bar">

                        <div class="tab feed active" data-panel_id="1">
                            <div class="tab_content">
                                <div class="tab_img"></div>
                                <div class="tab_text">Open Classes</div>
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

                        <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'course','origin_id'=>$course->course_id)); ?>


                    </div>


                    <div class="panel active" id="panel_1">
                        CLASS FEED GOES HERE
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
        <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'class','origin_id'=>'')); ?>

        </div>
        <!--        <div id="right_menu_panel">-->
        <!---->
        <!--        </div>-->

    </body>




</html>