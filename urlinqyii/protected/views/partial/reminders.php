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
                    <li class="tdo">
                        <div class = "reminder_hide">
                        <em></em>
                        </div>
                        <div class = "help-div help-div-reminder">
                            <div class = "wedge"></div>
                            <div class = "box">Hide this reminder</div>
                        </div>
                        <div class="content">


                            <div class="time">
                                <div class="stamp">in 3 days,</div>
                            </div>


                            <div class="message"><span class = "event_highlight">Exam</span> in <span>Math</span>.</div>

                            <span class = "reminders_cal_link">
                                <div class = "blue_file_icon small_icon_map"></div>
                                <div class = "blue_question_icon small_icon_map"></div>
                            </span>

                            
                        </div>
                    </li>




                </ul>
            </div>
        </div>

        <script id="reminder_template" type="text/x-handlebars-template">

            <li class="tdo">
                <div class = "reminder_hide">
                <em></em>
                </div>
                <div class = "help-div help-div-reminder">
                    <div class = "wedge"></div>
                    <div class = "box">Hide this reminder</div>
                </div>


                <div class="content">


                    <div class="time">
                        <div class="stamp">{{formatted_end_time}},</div>
                    </div>

                    {{#ifCond origin_type '==' 'class'}}
                        {{#ifCond event_type '==' 'exam'}}
                            <div class="message"><span class = "event_highlight">{{event_type}}</span> in <span>{{origin.name}}</span>.</div>
                        {{/ifCond}}
                    {{/ifCond}}

                    <span class = "reminders_cal_link">
                        <div class = "blue_file_icon small_icon_map"></div>
                        <div class = "blue_question_icon small_icon_map"></div>
                    </span>
            
                </div>
            </li>

        </script>
    </body>
</html>