<!DOCTYPE html>

<html>

    <head>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/home.css">


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

    <body>
	<section class='loading_animation'>
        <?php 
		$text = "HOME"; 
		//include 'loading.php';?>
    </section>
    <section class='popup_section'><?php //include "popup.html";?></section>
    <section class='topbar_bag'>
        <?php echo Yii::app()->runController('partial/topbar'); ?>
    </section>

    

    <section class='content_bag'>       

    <section class='midsec'>

        <div class='midsec_indent'>
        <section class='fbar_bag'>
            <?php //include 'status_bar.php';?>
        </section>

        <section class='feeds_bag'>
            <?php


            echo "<div class='feed-tab-content'>";

            echo "<div class='group_fbar_wrap'>";

            echo $this->renderPartial('/partial/question_status_bar',array('pg_src'=>'club.php','target_type'=>'group'));


            echo "</div>";
            echo "<br><br>";

            echo "<div class='group_feed_wrap'>";

            echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/home/feed'));

            echo "</div>";


            echo "</div>";
            ?>
        </section>
        </div>
    </section>
   
    <section class='rightbar_bag'>
        <?php //include 'planner_beta.php'; ?>
    </section>

    <section class='leftbar_bag'>
        <?php echo Yii::app()->runController('partial/leftmenu',array('user'=>$user)); ?>
    </section>

    </section>
	
    </body>
</html>

