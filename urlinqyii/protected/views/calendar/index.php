﻿<!DOCTYPE html>
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

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>


    <!-- global show event functions -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/global/show_events.js"></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/invite_people/invite_people.js"></script>

    <!-- Fonts -->
    <link href="http://goo.gl/CHQFJX" rel="stylesheet" type="text/css"><!-- Open Sans:3->8-5 -->
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
                    <form class="search">
                        <input type="submit" value="">
                        <input type="text" placeholder="Search">
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
    </div>
</body>





<script id="day_event_template" type="text/x-handlebars-template">
    <div class="day_event_holder event_holder" data-rgb = {{color.rgb}} data-formatted_time = "{{formatted_start_time}}" data-origin_name="{{origin.name}}" data-hex={{color.hex}} data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
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
    <div class="grid-event week_event_holder event_holder" data-formatted_time = "{{formatted_start_time}}" data-origin_name="{{origin.name}}" data-hex= "{{color.hex}}" data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
        <div class = "event_color_bar color_bar_week" style = "background-color:{{color.hex}}"></div>
        <div class = "white_bg_line_blocker"></div>
        <div class="event_name">{{title}}</div>

        <div class="event_start_time">{{formatted_start_time}}</div>

    </div>
</script>


<script id="month_event_template" type="text/x-handlebars-template">
    <div class="month_day_event event_holder" data-hex={{color.hex}} data-formatted_time = "{{formatted_start_time}}" data-origin_name="{{origin.name}}" data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
        <div class = "event_color_bar color_bar_month" style = "background-color:{{color.hex}}"></div>
        
        <div class="event_name month_event_name">{{title}}</div>

        <div class="event_start_time month_event_start_time">{{formatted_start_time}}</div>
    </div>
</script>





</html>