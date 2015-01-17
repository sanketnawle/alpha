<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>
    <script>
        window.base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";
        window.views_url = base_url + "/assets/calendar/views";
        window.css_url = base_url + "/css/calendar";
    </script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>


    <!-- global show event functions -->
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar/global/show_events.js"></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/invite_people/invite_people.js"></script>

    <!-- Fonts -->
    <link href="http://goo.gl/CHQFJX" rel="stylesheet" type="text/css"><!-- Open Sans:3->8-5 -->
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css" rel="stylesheet" type="text/css"><!-- Avenir:L,N,B -->
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
<body>
    <?php echo Yii::app()->runController('partial/topbar'); ?>

    <script id="provider_template" type="text/x-handlebars-template">
        <div class="provider" data-origin_type='{{type}}' data-origin_id='{{id}}' style='background-color: {{color.hex}}'>
            <img width="25" height="25" src="http://lorempixel.com/60/60" class="icon">
            <div ng-uc-check="" class="check ng-scope checked {{color_class}}" checked="">
                <i class="x"></i><i class="xx"></i>
            </div>
            <div class="title" style="box-shadow: rgb(170, 170, 170) 3px 0px 8px -3px;">{{name}}</div>
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
                <div class="button">
                    <div id='create_new_event_button' class="full" ng-click="openNewEvent()"><i></i> Create Event</div>
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
            <div class="providers class"></div>
            <div class="providers clubs"></div>
            <div class="providers depts"></div>
            <div class="mini-calendar" ng-controller="MiniMonthController">
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


<!--Include this and js/time_selector/time_selector.js to use this.
Set the class name on your input to 'time_input' -->
<div id="time_selector">
    <div class='time_selector_div' data-time='00:00:00' value="00:00:00">12:00am</div>
    <div class='time_selector_div' data-time='00:30:00' value="00:30:00">12:30am</div>

    <div class='time_selector_div' data-time='01:00:00' value="01:00:00">1:00am</div>
    <div class='time_selector_div' data-time='01:30:00' value="01:30:00">1:30am</div>

    <div class='time_selector_div' data-time='02:00:00' value="02:00:00">2:00am</div>
    <div class='time_selector_div' data-time='02:30:00' value="02:30:00">2:30am</div>

    <div class='time_selector_div' data-time='03:00:00' value="03:00:00">3:00am</div>
    <div class='time_selector_div' data-time='03:30:00' value="03:30:00">3:30am</div>

    <div class='time_selector_div' data-time='04:00:00' value="04:00:00">4:00am</div>
    <div class='time_selector_div' data-time='04:30:00' value="04:30:00">4:30am</div>

    <div class='time_selector_div' data-time='05:00:00' value="05:00:00">5:00am</div>
    <div class='time_selector_div' data-time='05:30:00' value="05:30:00">5:30am</div>

    <div class='time_selector_div' data-time='06:00:00' value="06:00:00">6:00am</div>
    <div class='time_selector_div' data-time='06:30:00' value="06:30:00">6:30am</div>

    <div class='time_selector_div' data-time='07:00:00' value="06:00:00">7:00am</div>
    <div class='time_selector_div' data-time='07:30:00' value="06:30:00">7:30am</div>


    <div class='time_selector_div' data-time='08:00:00' value="08:00:00">8:00am</div>
    <div class='time_selector_div' data-time='08:30:00' value="08:30:00">8:30am</div>

    <div class='time_selector_div' data-time='09:00:00' value="09:00:00">9:00am</div>
    <div class='time_selector_div' data-time='09:30:00' value="09:30:00">9:30am</div>

    <div class='time_selector_div' data-time='10:00:00' value="10:00:00">10:00am</div>
    <div class='time_selector_div' data-time='10:30:00' value="10:30:00">10:30am</div>

    <div class='time_selector_div' data-time='11:00:00' value="11:00:00">11:00am</div>
    <div class='time_selector_div' data-time='11:30:00' value="11:30:00">11:30am</div>


    <!-- NOON -->
    <div class='time_selector_div' data-time='12:00:00' value="12:00:00">12:00pm</div>
    <div class='time_selector_div' data-time='12:30:00' value="12:30:00">12:30pm</div>



    <div class='time_selector_div' data-time='13:00:00' value="13:00:00">1:00pm</div>
    <div class='time_selector_div' data-time='13:30:00' value="13:30:00">1:30pm</div>

    <div class='time_selector_div' data-time='14:00:00' value="14:00:00">2:00pm</div>
    <div class='time_selector_div' data-time='14:30:00' value="14:30:00">2:30pm</div>

    <div class='time_selector_div' data-time='15:00:00' value="15:00:00">3:00pm</div>
    <div class='time_selector_div' data-time='15:30:00' value="15:30:00">3:30pm</div>

    <div class='time_selector_div' data-time='16:00:00' value="16:00:00">4:00pm</div>
    <div class='time_selector_div' data-time='16:30:00' value="16:30:00">4:30pm</div>

    <div class='time_selector_div' data-time='17:00:00' value="17:00:00">5:00pm</div>
    <div class='time_selector_div' data-time='17:30:00' value="17:30:00">5:30pm</div>

    <div class='time_selector_div' data-time='18:00:00' value="18:00:00">6:00pm</div>
    <div class='time_selector_div' data-time='18:30:00' value="18:30:00">6:30pm</div>

    <div class='time_selector_div' data-time='19:00:00' value="19:00:00">7:00pm</div>
    <div class='time_selector_div' data-time='19:30:00' value="19:30:00">7:30pm</div>


    <div class='time_selector_div' data-time='20:00:00' value="20:00:00">8:00pm</div>
    <div class='time_selector_div' data-time='20:30:00' value="20:30:00">8:30pm</div>

    <div class='time_selector_div' data-time='21:00:00' value="21:00:00">9:00pm</div>
    <div class='time_selector_div' data-time='21:30:00' value="21:30:00">9:30pm</div>

    <div class='time_selector_div' data-time='22:00:00' value="22:00:00">20:00pm</div>
    <div class='time_selector_div' data-time='22:30:00' value="22:30:00">20:30pm</div>

    <div class='time_selector_div' data-time='23:00:00' value="23:00:00">11:00pm</div>
    <div class='time_selector_div' data-time='23:30:00' value="23:30:00">11:30pm</div>


</div>


<script id="day_event_template" type="text/x-handlebars-template">
    <div class="day_event_holder event_holder" data-rgb = {{color.rgb}} data-hex={{color.hex}} data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}" style = "border-left:2.5px solid {{color.hex}};">
        <div class="event_start_time" style = "color:#FFF;" >{{formatted_start_time}}</div>
        <div class="event_name" style = "color:{{color.hex}}" >{{title}}</div>
        <div class = "event_type">{{event_type}}</span>
        <div class="event_location" style = "color:{{color.hex}}"><span></span>{{location}}</div>
        <div class="event_description">{{description}}</div>
    </div>
</script>

<script id="week_day_event_template" type="text/x-handlebars-template">
    <div class="grid-event week_event_holder event_holder" data-hex={{color.hex}} data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}" style = "border-left:2.5px solid {{color.hex}};">
        
        <div class="event_name">{{title}}</div>

        <div class="event_start_time">{{formatted_start_time}}</div>

        <div class="event_location"><span></span>{{location}}</div>
    </div>
</script>


<script id="month_event_template" type="text/x-handlebars-template">
    <div class="month_day_event event_holder" data-hex={{color.hex}} data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}">
        <div class = "event_color_bar color_bar_month" style = "background-color:{{color.hex}}"></div>
        
        <div class="event_name month_event_name">{{title}}</div>

        <div class="event_start_time month_event_start_time">{{formatted_start_time}}</div>
    </div>
</script>





</html>