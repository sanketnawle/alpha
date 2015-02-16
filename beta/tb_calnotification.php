<!DOCTYPE html> 



<html>



    <head>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">

        </script>-->



        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>







        <link rel="stylesheet" type="text/css" href="css/tb_calnotification.css">



    </head>



    <script>



        $(document).ready(function() {

            $(document).delegate(".c_noti_gen", "mouseover", function(e) {

                $(this).find(".c_notievent_time").hide();

                $(this).find(".c_noti_remove").show();

            });



            $(document).delegate(".c_noti_gen", "mouseout", function(e) {

                $(this).find(".c_noti_remove").hide();

                $(this).find(".c_notievent_time").show();

            });





            $(document).delegate(".c_noti_remove", "mouseover", function() {

                $(this).find(".c_card-tag").stop().show();

            });



            $(document).delegate(".c_noti_remove", "mouseout", function() {

                $(this).find(".c_card-tag").delay(1).hide(0);

            });



            $(document).delegate(".c_remove_icon", "click", function() {

                //alert("a");

                var info = $(this).closest(".c_noti_gen").find(".c_notievent_des").attr("id").split("_");

                var event_id = info[0];

                var type = info[1];

                //alert(info);



                var url= "php/hide_notifications.php";

                if($(this).closest(".c_noti_gen").hasClass("c_noti_complete")||$(this).closest(".c_noti_gen").hasClass("c_noti_incomplete")){

                url= "php/hide_events_notifs.php";

                }

                $.ajax({

                    type: "POST",

                    url: url,

                    data: {event_id: event_id, type: type},

                    success: function(html) {

                        //alert(html);

                    }

                });



                $(this).closest(".c_noti_gen").hide();

                return false;

            });



            $(document).delegate(".c_remove_icon", "mouseover", function() {

                $(this).css({"background-image": "url(img/hide-hover.png)"});

            });



            $(document).delegate(".c_remove_icon", "mouseout", function() {

                $(this).css({"background-image": "url(img/hide.png)"});

            });



            $(document).delegate(".past_events_tab", "click", function() {

                $(this).closest(".tabs").find(".active_pe_tab").removeClass("active_pe_tab");

                if (!$(this).hasClass("active_pe_tab")) {

                    $(this).find(".little-glyph").addClass("active_glyph");

                    $(this).addClass("active_pe_tab");

                    $(".past_events_tab").css("border-right-color", "rgba(87, 87, 87, 0.7)");

                }

            });

            $(document).delegate(".active_pe_tab", "click", function() {

                $(this).removeClass("active_pe_tab");

                $(this).find(".little-glyph").removeClass("active_glyph");

                $(".past_events_tab").css("border-right-color", "#e9eaed");

            });



            $(document).delegate(".cal_noti_see", "click", function() {

                $(".active_pe_tab").removeClass("active_pe_tab");

                $(".little-glyph").removeClass("active_glyph");

                $(".past_events_tab").css("border-right-color", "#e9eaed");

            });



            $(document).delegate(".c_follow_bt", "click", function() {



                if (!$(this).hasClass("unclickable_bt")) {



                    $(this).addClass("unclickable_bt");



                    var $rt = $(this).closest(".c_noti_gen");

                    var info = $rt.find(".c_notievent_des").attr("id");

                    alert(info);

                    var infoarr = info.split("_");

                    var event_id = infoarr[0];

                    var type = infoarr[1];

                    alert(event_id);

                    alert(type);

                    $.ajax({

                        type: "POST",

                        url: "php/update_choice_event.php",

                        data: {event_id: event_id, type: type},

                        success: function(html) {

                            alert(html);

                        }

                    });



                    var txtadded = "accepted";

                    if ($(this).hasClass("add_to_cal_txt")) {

                        txtadded = "added";

                        $(this).css({"padding-left": "6px", "padding-right": "6px"});

                    }

                    $(this).text(txtadded);



                    return false;

                }

            });



            var notiload = 'yes';

            var heightOffset = 20;

            $(".c_noti_content").scroll(function() {

                if (notiload == 'yes') {

                    //alert("as");



                    if ($(this).scrollTop() + heightOffset + $(this).innerHeight() >= $(this).prop("scrollHeight")) {

                        //alert(heightOffset);

                        //alert("a");

                        notiload = 'no';

                        var info = $(".c_noti_content").children().last().find(".c_notievent_des").attr('id').split("_");



                        var event_id = info[0];

                        var type = info[1];

                        var timestamp = info[2];



                        var url = "tb_calnotification_fetch.php";

                        if (ctn_flag == 1) {

                            url = "php/completed_notifications";

                        }

                        if (ictn_flag == 1) {

                            url = "php/incomplete_notifications";

                        }





                        var $ref = $(this);

                        var pullrequest = $.ajax({

                            type: "POST",

                            url: url,

                            cache: false,

                            data: {event_id: event_id, type: type, timestamp: timestamp},

                            datatype: "html"

                        });

                        pullrequest.done(function(html) {

                            //alert("a");

                            $ref.last().append(html);

                            notiload = 'yes';

                        });



                    }

                }

            });





            var ctn_flag = 0;

            $(document).delegate(".complete_tab_noti", "click", function() {



                if (ctn_flag == 0) {

                    $(".c_noti_content").scrollTop(0);

                    ictn_flag = 0;

                    ctn_flag = 1;

                    $.ajax({

                        type: "POST",

                        url: "php/completed_notifications.php",

                        success: function(html) {

                            $(".c_noti_content").html(html);

                        }

                    });

                } else {

                    $(".c_noti_content").scrollTop(0);

                    ctn_flag = 0;

                    ictn_flag = 0;

                    $.ajax({

                        type: "POST",

                        url: "tb_calnotification_fetch.php",

                        success: function(html) {

                            $(".c_noti_content").html(html);

                        },

                        error: function(html){

                            alert("error in loading");

                        }

                    });

                }



            });



            var ictn_flag = 0;

            $(document).delegate(".incomplete_tab_noti", "click", function() {

                if (ictn_flag == 0) {

                    $(".c_noti_content").scrollTop(0);

                    ictn_flag = 1;

                    ctn_flag = 0;

                    $.ajax({

                        type: "POST",

                        url: "php/incomplete_notifications.php",

                        success: function(html) {

                            $(".c_noti_content").html(html);

                        }

                    });

                } else {

                    $(".c_noti_content").scrollTop(0);

                    ictn_flag = 0;

                    ctn_flag = 0;

                    $.ajax({

                        type: "POST",

                        url: "tb_calnotification_fetch.php",

                        success: function(html) {

                            $(".c_noti_content").html(html);

                        },

                        error: function(html){

                            alert("error in loading");

                        }

                    });

                }

            });



            $(document).delegate(".unseen_notifications", "click", function() {

                $(this).find(".c_noti_gen").css({"background-color": "white"});

                $(this).removeClass("unseen_notifications");

                //alert("b");

                var info = $(this).find(".c_notievent_des").attr("id").split("_");

                var event_id = info[0];

                var type = info[1];

                //alert("a");

                $.ajax({

                    type: "POST",

                    url: "php/mark_one_notification.php",

                    data: {event_id: event_id, type: type},

                    success: function(html) {



                    },

                    error: function(html) {



                    }

                });

            });





            $(document).delegate(".c_seen_all", "click", function() {

                $(".unseen_notifications").css({"background-color": "white"});

                $(".unseen_notifications").removeClass("unseen_notifications");



                $.ajax({

                    type: "POST",

                    url: "php/mark_seen_notifications.php",

                    success: function(html) {

                        //alert(html);

                    },

                    error: function(html) {

                        //alert(html);

                    }

                });

            });



            $(document).delegate(".back_to_noti", "click", function() {



                        if($(".c_noti_window").find(".complete_tab_noti").hasClass("active_pe_tab")){

                        $(".topbar").find(".complete_tab_noti").click();

                    }

                        if($(".c_noti_window").find(".incomplete_tab_noti").hasClass("active_pe_tab")){

                        $(".topbar").find(".incomplete_tab_noti").click();

                    }



            });

/*

            $(document).click(function(event){

                var $target= $(event.target);

                var $container= $(".c_noti_window");

                if(!$container.is($target)&&($container.has($target).length===0)){

                    ictn_flag = 0;

                    ctn_flag = 0;

                    $(".past_events_tab").removeClass("active_pe_tab");

                }

            });*/





        });







    </script>



    <body>

        <div class='c_noti_wedge'></div>

        <div class='c_noti_window'>



            <div class='c_noti_head'>



                <span class='back_to_noti'>Calendar Notifications<span>



                        <a class='c_seen_all'>Mark as Seen</a>



                        </div>







                        <div class='tabs'>



                            <div class = "past_events_tab complete_tab_noti tab-first tab inactive_pe_tab">



                                Complete <b class = "little-glyph complete"></b>



                            </div>



                            <div class = "past_events_tab incomplete_tab_noti tab inactive_pe_tab">



                                Incomplete <b class = "little-glyph incomplete"></b>



                            </div>



                        </div>











                        <div class='c_noti_content '>

							

                        </div>











                        <div class = "calnoti_footer">



                            <a href="calendar_beta.php?plnr=1">



                                <span>See Calendar</span>



                            </a>



                        </div>



                        </div>



                        </body>





                        </html>





