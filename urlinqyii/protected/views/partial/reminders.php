<html>
    <head>


        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/reminders/reminders.css"/>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/reminders.js"></script>



    </head>
    <body>
        <div id="reminders_section">
            <div>
                <div class="reminders_header header">Reminders</div>
                <ul class="reminder_entries">





                </ul>
                <div class="footer reminders_footer">
                    <a class = "reminders_cal_link" href="<?php echo Yii::app()->getBaseUrl(true); ?>/calendar">
                        See full calendar
                        <div class = "blue_right_arrow small_icon_map"></div>
                    </a>
                </div>
            </div>
        </div>

        <script id="reminder_template" type="text/x-handlebars-template">

            <li class="tdo">
                <div class="icon date">
                    <div class = "mini_cal_top_border"></div>
                    <div class="month">{{month}}</div>
                    <div class="day">{{day}}</div>
                </div>
                <div class="content">


                    <div class="time">
                        <div class="stamp">{{formatted_end_time}}</div>
                    </div>

                    {{#ifCond origin_type '==' 'class'}}
                        {{#ifCond event_type '==' 'exam'}}
                            <div class="message"><span class = "event_highlight">{{event_type}}</span> in {{origin.name}}.</div>
                        {{/ifCond}}
                    {{/ifCond}}


                    
                </div>
            </li>

        </script>
    </body>
</html>