<!DOCTYPE html>

<html>

    <head>
        <script>


            var globals = {};


            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'user'; ?>';
            globals.origin_id = '<?php echo $user->user_id; ?>';




        </script>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
          <title>Urlinq</title>

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/site/main.css">
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/home/home_adjustments.css">
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>

        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/reminders/reminders.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">


    </head>


    <body id = "body_home">

        <?php echo Yii::app()->runController('partial/topbar');     ?>

        <div id = "wrapper">
            <div id="page">
                <div id = "main_panel">
                    <div id="content_holder">
                        <div id="left_panel">
                            <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'home','origin_id'=>'')); ?>
                        </div>
                        <div id = "content_panel" class = "content_panel_home">
                            <?php echo $this->renderPartial('/partial/nav_bar',array('user' => $user, 'origin_type'=>'home','origin_id'=>$user->user_id,'origin'=>$user)); ?>
                            <div id = "planner_column" class = "planner_column_home">
                                <div id = "right_column_specs">
                                    <div id = "fixed_element">
                                        <?php
                                        echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'home','origin_id'=>''));
                                        ?>    
                                    </div>
                                </div>                           
                            </div>
                            <div id = "feed_column" class = "feed_column_home">
                                <div id = "stream_holder" class = "stream_holder_home">
                                    <div id = "fbar_wrapper" class = "fbar_home">
                                        <?php echo $this->renderPartial('/partial/question_status_bar',array('user'=>$user,'origin_type'=>'user','origin_id'=>$user->user_id )); ?>
                                    </div>

                                    <div id = "filter_wrapper" class = "filter_bar filter_bar_home">
                                        <div class = "filter_wrapper_left">
                                            <span><h5 class = "feed_header">Home Feed</h5></span>
                                        </div>
                                        <div class = "filter_wrapper_right">
                                            <span class = "filters_header">Filters:</span>
                                            <span class = "filter_type active">Faculty posts</span>
                                            <span class = "filter_type active">Student posts</span>
                                            <span class = "filter_type active">Question</span>
                                            <span class = "filter_type active">Notes</span>
                                            <span class = "filter_type active">Events</span>
                                        </div>
                                    </div>

                                    <div id = "feed_wrapper" class = "feed_wrapper_home">
                                        <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/home/feed', 'origin_type'=>'user', 'origin_id'=>$user->user_id)); ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="right_panel" class = "group_responsiveness">
                    <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'home','origin_id'=>$user->user_id)); ?>
                </div>
            </div>
        </div>
        
    </body>
</html>

