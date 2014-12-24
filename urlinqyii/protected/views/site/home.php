<!DOCTYPE html>

<html>

    <head>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/site/main.css">
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>

        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
    </head>

    <script>

var $ = jQuery.noConflict();
            $( document ).ready(function() {
                /*
                var lastScrollTop = 0;
                        $(window).scroll(function (event) {

                            var scrollTop = $(window).scrollTop();
                            var scrollBottom = $(window).scrollTop() + $(window).height();
                        if(scrollTop >= 0 && scrollBottom <= $(document).height()){

                        var st = $(this).scrollTop();

                        if (st > lastScrollTop) {
                            var inc = st - lastScrollTop;

                            var offset_rightbar = $(".rightbar_bag").offset();
                            
                            $(".rightbar_bag").offset({ top: inc + offset_rightbar.top });
                            
                        } else {
                                
                            var inc = st - lastScrollTop;

                            var offset_rightbar = $(".rightbar_bag").offset();

                            $(".rightbar_bag").offset({ top: inc + offset_rightbar.top });
                            
                        }
                        lastScrollTop = st;

                    }


                    });*/

                    

                        $(document).delegate(".option_report","click",function(){

                                var postid= $(this).closest(".posts").attr("id");
                                //alert(postid);

                                $(".report_popup").attr("id",postid);
                                $(".blackcanvas").stop().show();
                                $(".blackcanvas").find(".report_popup").stop().show();
                                /*
                                $.ajax({
                                        type: "POST",
                                        url: "includes/feedops.php",
                                        data: {post_id: postid, report: 1},
                                        success: function(html){ 
                                            
                                        }
                                    });
                                */
                });


                $(document).delegate(".popup_btn_1","click",function(){
                    if($(this).closest(".popup_window").hasClass("report_popup")){
                        $(".blackcanvas").hide();
                    }
                });

                $(document).delegate(".popup_btn_0","click",function(){
                    if($(this).closest(".popup_window").hasClass("report_popup")){
                        var post_id=$(this).closest(".popup_window").attr("id");
                        //alert(post_id);
                        $.ajax({
                                    type: "POST",
                                    url: "includes/feedops.php",
                                    data: {post_id: post_id, report: 1},
                                    success: function(html){ 
                                            $(".blackcanvas").hide();
                                }
                        });
                    }
                });


            });

    </script>

    <body id = "body_home">

        <?php echo Yii::app()->runController('partial/topbar');     ?>

        <div id = "wrapper">
            <div id="page">
                <div id = "main_panel">
                    <div id="content_holder">
                        <div id="left_panel">
                            <?php echo Yii::app()->runController('partial/leftmenu',array('user'=>$user)); ?>
                        </div>
                        <div id = "content_panel" class = "content_panel_home">
                            <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'home','origin_id'=>$user->user_id,'origin'=>$user)); ?>
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
                                        <?php echo $this->renderPartial('/partial/question_status_bar',array('pg_src'=>'club.php','target_type'=>'group')); ?>
                                    </div>


                                    <div id = "feed_wrapper" class = "feed_wrapper_home">
                                        <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/home/feed')); ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="right_panel">

                    RIGHT PANEL GOES HERE
                </div>               
            </div>
        </div>
    	
    </body>
</html>

