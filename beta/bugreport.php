<!DOCTYPE html>
<html>

    <head>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        </script>
        <link rel = "stylesheet" type = "text/css" href = "css/home.css">

        <!--css&js for leftbar-->
        <link rel="stylesheet" type="text/css" href="leftmenu.css">
        <link rel="stylesheet" type="text/css" href="css/feed.css">
        <link rel="stylesheet" type="text/css" href="css/bugreport.css">
        <link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all"/>
        <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>

    </head>

    <script>
    $(document).ready(function () {
        /**Jquery for click submit button event*/
        $(document).delegate(".rb_btn_1", "click", function () {
            /*report text*/
            var bug_report=$(".rb_des_t").val();

            /*ajax here*/
            $.ajax({
            type: "POST",
            url: "php/reportbug.php",
            data: {bug_report:bug_report},
            success: function (html) {
                $(".rb_des_t").val("");
                $(".rb_des_t").removeAttr('value');
                $(".rb_des_t").attr('placeholder','Thank you again! We recieved your feedback and our engineers are working on the problems!')
            },
            error: function (html) {
                
            }

        });
        });
    });
    </script>
    <body>
    <section class='popup_section'><?php include "popup.html";?></section>

    <!--topbar section is real-->
    <section class='topbar_bag'>
        <?php include 'topbar.php';?>
    </section>

    

    <section class='content_bag'>       
        <div class='report_board'>
            <div class='rb_head'>We Appreciate your Support and Advice!</div>
            <div class='rb_des_p'>Problem Description:</div>
            <textarea class='rb_des_t'></textarea>
            <div class='rb_footer'>
                <a href='<?php echo $_SERVER['HTTP_REFERER'];?>'><button class='rb_btn_0'>Go Back</button></a>
                <button class='rb_btn_1'>Submit</button>
            </div>
        </div>
    </section>
    </body>
</html>

