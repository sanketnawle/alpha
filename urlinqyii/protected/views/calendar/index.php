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
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/eventCreation.css" type="text/css" rel="stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/calendar/eventCreation.css" type = "text/css" rel = "stylesheet">

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


</head>
<body>
    <?php echo Yii::app()->runController('partial/topbar'); ?>

    <script id="provider_template" type="text/x-handlebars-template">
        <div class="provider" data-origin_type='{{type}}' data-origin_id='{{id}}'>
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
                    <div id='create_new_event_button' class="full" ng-click="openNewEvent()">Create Event</div>
                    <div class="quick">
                        <i>&nbsp;</i>
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
</html>