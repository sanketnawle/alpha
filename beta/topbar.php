<?php
require_once('includes/common_functions.php');
include("php/dbconnection.php");
$dp_link = get_dp($con, $_SESSION['user_id'], "user");
$user_info = get_user_info($con, $_SESSION['user_id']);
if (is_array($user_info)) {
    $firstname = $user_info['firstname'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>-->
    <link rel="stylesheet" type="text/css" href="css/topbar.css">
    <link rel="stylesheet" type="text/css" href="css/waiting_animation.css">
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>

    <script src="js/preload_img.js"></script>

</head>
<script>

$(document).ready(function () {


    var d = new Date();
    var t = d.getDate();
    var nm = "'img/calendar-icons/" + t + ".png'";
    $(".cal_icon").attr("src", "img/calendar-icons/" + t + ".png");


    $(document).delegate(".topbar_search_input", "click", function () {
        //$(".graph_search").show();
    });


    $(document).delegate(".topbar_search_input", "keydown", function () {
        $(".graph_search").show();
        $(".topbar_search_input").css({"border-bottom-left-radius": "0px", "border-bottom-right-radius": "0px"});
    });

    $(document).delegate(".topbar_qicon img", "click", function () {
        $(".graph_search").show();
        $(".card-tag").hide();
        $(".topbar_search_input").css({"border-bottom-left-radius": "0px", "border-bottom-right-radius": "0px"});
    });

    $(document).delegate(".gs_col", "mousedown", function () {
        $(this).addClass("gs_on_active");
    });

    $(document).delegate(".gs_col", "mouseup", function () {
        $(this).removeClass("gs_on_active");
    });


    $(document).click(function (event) {

        var $target = $(event.target);
        var $container = $(".topbar");
        if (!$container.is($target) && ($container.has($target).length === 0)) {

            if ($(".c_noti_window").find(".complete_tab_noti").hasClass("active_pe_tab")) {
                $(".topbar").find(".complete_tab_noti").click();
            }
            if ($(".c_noti_window").find(".incomplete_tab_noti").hasClass("active_pe_tab")) {
                $(".topbar").find(".incomplete_tab_noti").click();
            }


            cidiv_flag = 0;
            gidiv_flag = 0;
            sidiv_flag = 0;
            $(".ci_div").hide();
            $(".gi_div").hide();
            $(".si_div").hide();
        }

    });

    $(document).delegate(".topbar_qicon img", "mouseover", function () {
        $(this).closest(".search_input_wrapper").find(".card-tag").stop().show();
    });

    /*
     $(document).delegate(".card-tag","mouseover",function(){
     $(this).stop().show();
     });
     */

    $(document).delegate(".topbar_qicon img", "mouseout", function () {
        $(this).closest(".search_input_wrapper").find(".card-tag").delay(1).hide(0);
    });

    /*
     $(document).delegate(".card-tag","mouseout",function(){
     $(this).delay(1).hide(0);
     });
     */

    var cidiv_flag = 0;
    var gidiv_flag = 0;
    var sidiv_flag = 0;
    $(document).delegate(".topbar_cal", "click", function () { 
		
		/*var fileref=document.createElement("link");
		fileref.setAttribute("rel", "stylesheet");
		fileref.setAttribute("type", "text/css");
		fileref.setAttribute("href", "css/loading.css");*/
		$('head').append('<link rel="stylesheet" type="text/css" href="css/loading.css">');
		var html = "<div class='loading_container' style='background: #eee'><div class='loading_spinner_cover' style='margin-top: 0px'><div class=loading-spinner></div></div>"
		html = html + "<div class='loading_text_cover'><div class='loading_text'>LOADING</div></div></div>";
		$(".c_noti_window").find(".c_noti_content").empty();
		$(".c_noti_content").append(html);
		
        //alert("beforesuccess");
        gidiv_flag = 0;
        sidiv_flag = 0;
        $(".gi_div").hide();
        $(".si_div").hide();

        if (cidiv_flag == 0) {
            var $rt = $(".c_noti_window");
            $.ajax({
                type: "POST",
                url: "tb_calnotification_fetch.php",
                success: function (html) {
                    //alert("aftersuccess");					
                    setTimeout(function () {
                        $rt.find(".c_noti_content").html(html);
						$('link[rel=stylesheet][href~="css/loading.css"]').remove();
                    }, 1000);


                }
            });
            $(".ci_div").show();
            cidiv_flag = 1;
        } else {
            if ($(".c_noti_window").find(".complete_tab_noti").hasClass("active_pe_tab")) {
                $(".topbar").find(".complete_tab_noti").click();
            }
            if ($(".c_noti_window").find(".incomplete_tab_noti").hasClass("active_pe_tab")) {
                $(".topbar").find(".incomplete_tab_noti").click();
            }

            cidiv_flag = 0;
            $(".ci_div").hide();
        }
    });

//getNewNotifications("kuan");
    $(document).delegate(".topbar_noti", "click", function () {
        cidiv_flag = 0;
        sidiv_flag = 0;
        $(".ci_div").hide();
        $(".si_div").hide();
        if (gidiv_flag == 0) {
            var $rt = $(".noti_window");
            getNotifications("kuan");
            $(".gi_div").show();
            gidiv_flag = 1;
        } else {
            gidiv_flag = 0;
            $(".gi_div").hide();
        }
    });


    $(document).delegate(".topbar_prof", "click", function () {
        cidiv_flag = 0;
        gidiv_flag = 0;
        $(".ci_div").hide();
        $(".gi_div").hide();
        if (sidiv_flag == 0) {
            $(".si_div").show();
            sidiv_flag = 1;
        } else {
            sidiv_flag = 0;
            $(".si_div").hide();
        }
    });


    $(document).delegate(".topbar_search_input", "keydown", function (e) {

        if (e.which == 13) {
            var q = $(".topbar_search_input").val().trim();
            //alert(inputval);
            if (q != "") {
                var data = 1;
                window.location = "search_beta.php?q=" + q;

            }

            return false;
        }
    });

    setTimeout(function () {
        countcalNotification();
    }, 5000);
    setInterval(function () {
        countcalNotification();
    }, 30000);

    setTimeout(function () {
        getNewNotifications();
    }, 5000);
    setInterval(function () {
        getNewNotifications();
    }, 30000);

    function countcalNotification() {
        $.ajax({
            type: "POST",
            url: "php/check_new_notifications.php",
            success: function (html) {
                if (html != "0") {
                    $(".rednoti").find("span").text(html);
                    $(".rednoti").show();
                }
            },
            error: function (x, t, e) {

            }
        });
    }


    function getNewNotifications(type) {
        //alert("a");
        /*$.ajax({
         type: "GET",
         url: "newNotifications.php",
         async: true,
         cache: false,

         success: function(data){
         //Display message here
         //alert(data);
         $(".noti_icon").find("p").text(data);

         if (data != 0)
         {
         //should be the number displayed. $("#nots").prepend(data);
         $(".noti_icon").find("p").text(data);

         }
         setTimeout("getNewNotifications('latest')",30000);
         },

         error: function(XMLHttpRequest,textStatus,errorThrown) {
         // alert("error: "+textStatus + " "+ errorThrown );
         setTimeout("getNewNotifications('latest')",30000);
         }
         });*/
    }


});

function LoadHome() {
    window.location = 'home.php';
}
</script>

<body>

<div class="topbar">
    <div class="topbar_wrapper">
        <div class='topbar_left'>
            <img class="topbar_logo" src="img/logo.png" onclick="LoadHome();"/>
        </div>


        <div class='topbar_righttool'>
            <!--<a href='php/logout.php'>test logout</a>-->
            <div class='topbar_cal'>
                <!--
                <img class='cal_icon' src='img/calendar.png'>
                -->
                <div class="cal_icon2">
                </div>
                <div class='rednoti'><span></span></div>
            </div>

            <!--<div class='topbar_noti'>
                <div class="noti_icon2">
                </div>
            </div>-->
            <div class="topbar_prof">
                <div style="background-image: url(<?php echo $dp_link ?>);" class="prof-limit">
                </div>
                <div class="topbar_user_name">
                    <?php echo $firstname; ?>
                </div>
            </div>
        </div>

        <div class='noti_includediv'>
            <div class='ci_div'>
                <?php include 'tb_calnotification.php'; ?>
            </div>
            <div class='gi_div'>
                <?php include 'tb_notification.html'; ?>
            </div>
            <div class='si_div'>
                <?php include 'tb_settings.php'; ?>
            </div>
        </div>


        <div class='topbar_search'>
            <div class="topbar_search_container">
                <div class="notop_padding">
                    <div class="search_main_div">
                        <form name="search" method="get">
                            <div class="search_input_wrapper">
                                <input class='topbar_search_input' placeholder='Search groups and faculty...'>
                                <i class="topbar_searchicon">
                                </i>
                                <!--
                                <div class='topbar_qicon'><img src='src/question.png'>
                                <div class = "card-tag">
                                    <div class = "tag-wedge"></div>
                                    <div class = "tag-box">
                                        <span>Show search options</span>
                                    </div>
                                </div>
                                </div>
                                -->
                            </div>

                        </form>
                    </div>
                </div>


            </div>
        </div>


    </div>
</div>

</body>


</html>


					