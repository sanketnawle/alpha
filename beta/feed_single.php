<!DOCTYPE html>
<?php
    include "php/redirect.php";
    require_once('php/time_change.php');
   
?>
<html>

    <head>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        </script>
        <link rel = "stylesheet" type = "text/css" href = "css/home.css">
    </head>

    <script>


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
    <section class='popup_section'><?php include "popup.html";?></section>
    <section class='topbar_bag'>
        <?php include 'topbar.php';?>
    </section>

    

    <section class='content_bag'>       

    <section class='midsec'>

        <div class='midsec_indent'>

        <section class='feeds_bag'>
            <?php
            include 'feeds.php';
            ?>
        </section>
        </div>
    </section>
   
    <section class='rightbar_bag'>
        <?php include 'planner_beta.php';?>
    </section>

    <section class='leftbar_bag'>
        <?php include 'leftpanel.php';?>
    </section>

    </section>
    </body>
</html>

