<!DOCTYPE html>
<html>
<head>
    <title>Urlinq Calendar</title>
    <script>
        window.base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";
        window.views_url = base_url + "/assets/calendar/views";
        window.css_url = base_url + "/css/calendar";


        var globals = {};


        globals.base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";



    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-59124667-1', 'auto');
      ga('send', 'pageview');

    </script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>


    <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/embedly.js"> </script>

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main_search.css">

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_courses.css">

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>



    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css">





    <!--BELOW ARE SCRIPTS AND LINKS FOR DROPDOWN MENU API -->

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/jquery.autosize.js'></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/ness.js"> </script>
       <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js"> </script>
    <script>
        moment().format();
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/render_post.js"> </script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/feed.js"> </script>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/feed/feed.css"> </link>

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">


    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropit.js'></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/dropit.css" type="text/css" />

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

    <!-- global show event functions -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/global/show_events.js"></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/invite_people/invite_people.js"></script>

    <!-- Fonts -->
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css" rel="stylesheet" type="text/css"><!-- Avenir:L,N,B -->
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/icon_font/styles.css" rel="stylesheet" type="text/css"><!-- ICON FONT-->

    <!-- Styles -->
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/master.less" type="text/css" rel="stylesheet/less">
    <!--<link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/transition.css" type="text/css" rel="stylesheet">-->
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/leftbar.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/header.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/day.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/week.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/month.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/semester.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/dialog.less" type="text/css" rel="stylesheet/less">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/jq-datepicker.css" type="text/css" rel="stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/eventCreation.css" type = "text/css" rel = "stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/new_cal_styles.css" type = "text/css" rel = "stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/time_selector/time_selector.css" type = "text/css" rel = "stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/invite_people/invite_people.css" type = "text/css" rel = "stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/feed/feed.css" rel="stylesheet" type="text/css"><!-- Avenir:L,N,B -->
    <!--<link href="/css/calendar/bootstrap.css" rel="stylesheet" type="text/css"><!-- Avenir:L,N,B -->

    <!--<link href="/css/calendar/bootstrap-theme.css" rel="stylesheet" type="text/css"><!-- Avenir:L,N,B -->



    <!-- Libraries -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/lib/jq.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/lib/jq-datepicker.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/lib/ng.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/lib/ng-route.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/lib/ng-animate.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/lib/less.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.slimscroll.js"></script>

    <!-- Classes -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/event-target.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/key-control.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/event-div.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/date-provider.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/left-panel.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/ad-grid.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/month-grid.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/mini-month-grid.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/week-grid.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/day-grid.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/classes/cal-event.js"></script>

    <!-- Application -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/ulCalendar.js"></script>

    <!-- Controllers -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/controllers/calendar.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/controllers/day.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/controllers/week.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/controllers/month.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/controllers/minimonth.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/controllers/semester.js"></script>

    <!-- Helpers -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/time_selector/time_selector.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/extensions/date.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/extensions/range.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/extensions/directives.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/extensions/printer.js"></script>

    <!-- Main Events -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/events.js"></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/left_panel/left_panel.js"></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/day/day.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/month/month.js"></script>


<!--    <script src="../../../../../alpha/urlinqyii/js/calendar/week/week.js"></script>   -->

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/week/week.js"></script>


    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/inspect_event/inspect_event.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/bootstrap.js"></script>

</head>

<body id = "body_calendar">
    <?php echo Yii::app()->runController('partial/topbar'); ?>

    <script id="provider_template" type="text/x-handlebars-template">
        <div class="provider" data-origin_type='{{type}}' data-origin_id='{{id}}' title = "{{name}}">
            <div ng-uc-check="" style='background-color: {{color.hex}}' class="check ng-scope checked {{color_class}}" checked="">
                <i class="checkmark"></i>
            </div>
            <div class="title" style = "border:1px solid transparent;">{{name}}</div>
        </div>
    </script>


    <div class="ul-calendar" ng-app="ulCalendar" ng-controller="CalController">
        <div class="toolbar">
            <div class="wrap">
                <div class="column left"></div>
                <div class="column right">
<!--                    <button class="print" ng-click="printGrid()">&nbsp;</button>-->
                    <form class="search" id="form_calendar_search">
                        <input type="submit" value="">
                        <input type="text" id="txt_initial_search" data-placement="bottom" data-toggle="popover" placeholder="Search your events...">
                    </form>
                </div>
                <div class="column center">
                    <ul>
                        <li ng-repeat="item in menu.items">
                            <a ng-href="#/{{item}}/{{getLink($index)}}" ng-class="{active: menu.active == $index}">{{item}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="leftbar">
           
            <!-- ng-click="openNewEvent()" for create button -->
            <?php include "googlecalendar.php"; ?>
            <div class="create">
                <div class="button left_panel_create_button">
                    <div id='create_new_event_button' class="full" ng-click="openNewEvent()"><i></i> Create</div>
                    <div class="quick">
                        <i></i>
                        <div class="quick-dialog">
                            <div class="wedge"></div>
                            <form>
                                <div>Quick Add Event</div>
                                <input type="submit" value="Add">
                                <input type="text" placeholder="Example: Homework due Tuesday 11pm">
                            </form>
                        </div>
                    </div>
                    <div class="sep"></div>
                </div>
            </div>
            <div class = "providers_scrollable">

                <div class="providers personal">
                    <div class="provider" data-origin_type='user' data-origin_id='<?php echo $user->user_id;?>' title = "<?php echo $user->full_name();?>">
                        <div ng-uc-check="" style='background-color: #27e53f' class="check ng-scope checked" checked="">
                            <i class="checkmark"></i>
                        </div>
                        <div class="title" style = "border:1px solid transparent;"><?php echo $user->full_name();?></div>
                    </div>
                </div>
                <div class="providers class"></div>
                <div class="providers clubs"></div>
                <div class="providers depts"></div>
            </div>
            <div class="mini-calendar" ng-controller="MiniMonthController">
                <div class = "mini_calendar_cover"></div>
                <div class="header row1">
                    <a ng-click="goPrevMonth()" class="arrow left" ng-uc-check></a>
                    <a ng-click="goNextMonth()" class="arrow right" ng-uc-check></a>
                    <div class="title">{{getMonthName(miniActiveMonth, false)}} {{miniActiveYear}}</div>
                </div>
                <div class="header row2">
                    <div class="grid-column" ng-repeat="i in [] | range:7">{{getDayName(i, true, 2)}}</div>
                </div>
                <div class="mini-cal-grid"></div>
            </div>
        </div>
        <div ng-view class="body {{class}}">

        </div>
        <div class="dialog" id="dialog" ng-uc-dialog>


        </div>
        <div class="dialog" style="display:none;" id="search_dialog">

            <div class="overlay">
                <div class="content">
                    <div class="wrapper">
                        <div id="top_buttons_holder" class="create_event_section" style="padding-left:40px;">
                            <div class="toolbar" style="border:none">
                            <div class="wrap">
                            
                                <div class="column left">
                                    <div id="search_back_button" class="grey_button"><span></span>Back</div>
                                </div>
                                <div class="column right">
                                   <form class="search ng-pristine ng-valid" id="form_calendar_search_continue">
                                        <input type="submit" value="">
                                        <input type="text" id="search_text" placeholder="Search">
                                    </form>
                                </div>
                              
                            </div>
                            </div>
                            
                        </div>
                        <br><br><br>
                        <div id="events_results_found"  class="create_event_section">

                        </div>
                    </div>
                </div>
            </div>
            

        </div>
    </div>


</body>



<script id="day_event_template" type="text/x-handlebars-template">
    <div class="day_event_holder event_holder" data-url="{{url}}" data-all_day="{{all_day}}" data-formatted_time = "{{formatted_start_time}}" data-origin_name="{{origin.name}}" data-hex={{color.hex}} data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
        <div class = "event_color_bar color_bar_day" style = "background-color:{{color.hex}}"></div>
        <div class = "white_bg_line_blocker"></div>
        <div class="event_start_time" style = "color:{{color.hex}};">{{formatted_start_time}}</div>
        <div class="event_name" style = "color:{{color.hex}}" >{{title}}</div><div class="event_description" style = "color:{{color.hex}}">{{description}}</div>
        <div class = "event_type" style = "border-color:{{color.hex}}; color:{{color.hex}}">{{event_type}}</div>
        
        {{#if location}}
        <div class="event_location" style = "color:{{color.hex}}"><span style = "color:{{color.hex}}" class = "icon icon-pin-map" ></span>{{location}}</div>
        {{/if}}

        {{#if origin.name}}
        <a class="event_origin_link" href="<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}"><span class = "origin_name_text">{{origin.name}}</span> <span class= "right_arrow_head_icon"></span></a>
        {{/if}}
    </div>
</script>

<script id="week_day_event_template" type="text/x-handlebars-template">
    <div class="grid-event week_event_holder event_holder" data-url="{{url}}" data-formatted_time = "{{formatted_start_time}}" data-origin_name="{{origin.name}}" data-hex= "{{color.hex}}" data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
        <div class = "event_color_bar color_bar_week" style = "background-color:{{color.hex}}"></div>
        <div class = "white_bg_line_blocker"></div>
        <div class="event_name">{{title}}</div>

        <div class="event_start_time">{{formatted_start_time}}</div>

    </div>
</script>


<script id="month_event_template" type="text/x-handlebars-template">
    <div class="month_day_event event_holder" data-url="{{url}}" data-hex={{color.hex}} data-formatted_time="{{formatted_start_time}}" data-origin_name="{{origin.name}}" data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
        <div class = "event_color_bar color_bar_month" style = "background-color:{{color.hex}}"></div>
        
        <div class="event_name month_event_name">{{title}}</div>

        <div class="event_start_time month_event_start_time">{{formatted_start_time}}</div>
    </div>
</script>

<script id="event_attendee_template" type="text/x-handlebars-template">
    <div class="attendee_holder profile_link" data-user_id="{{user_id}}">
        <div class="attendee_picture" style="background:url({{base_url}}{{pictureFile.file_url}}); background-size:cover;"></div>
        <div class="attendee_name">{{firstname}} {{lastname}}</div>
    </div>
</script>

<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/searchevents.js"></script>

<script>
    /*if(window.name){
        console.log(window.name);
       // var top = $('.event_holder[data-id=454]').position().top;
        $('.scroll_view').scrollTop( 400 );
    }*/
</script>

</html>