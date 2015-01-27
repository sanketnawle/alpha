<html>
	<head>


        <script>
            origin = '<?php echo $origin_type; ?>';
            origin_id = '<?php echo $origin_id; ?>';

        </script>




		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/planner/planner.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/planner/datepicker.css"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"></script>
<!--		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<!--		<script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>-->

<!--        <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<!---->
<!--        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->

<!--        <script src="--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/js/jquery.min.js" type="text/javascript"></script>-->

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar_selector.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.timeAutocomplete.min.js"></script>

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>




        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/planner/planner.js"> </script>


        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/time_selector/time_selector.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/time_selector/time_selector.css" type = "text/css" rel = "stylesheet">


        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/date_selector/date_selector.js" type="text/javascript"></script>

        <!--old planner.js file, I leave it here for your reference-->
        <!--<script src="js/planner.js" type="text/javascript"></script>-->
	</head>
	<body>
		<div class="planner_container">


            <div id="planner_header_holder">
                <div class="planner_header_panel">
                    <div class="planner_header">
                        <?php
                            if($origin_type == 'home'){
                                echo 'WEEK';
                            }else{
                                echo ucfirst($origin_type);
                            }
                         ?> Planner
                         <div class="entry_field_placeholder" id="add_todo">
                            <span id = "add_todo_text">Add Todo</span>
                            <div class="nav-icon">
                              <div class="nav-icon-plus"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="create_event_body">
                <div class="entry_field" id="todo_wrap">

                    <div class="planner_creation_form">
                        <input class="event_title" id="event_name" name="event_name" placeholder="Title (e.g. Physics HW)" maxlength="100"></input>
                        <div class="event_time_wrap">
                            Due:
                            <input class="event_date date_input" id="event_date" name="event_date" value="none" readonly>




                            <input placeholder = "Start time" id="tp1" class = "fbar_date_time fbar_time_input time_input" type = "text" name = "event_start_time">


<!--                            <input class="tp1" id="tp1" value="none">-->
<!--                            <div class="timepicker">-->
<!--                                <div class="timeslot1"></div>-->
<!--                                <div class="timeslot2"></div>-->
<!--                                <div class="timeslot3"></div>-->
<!--                                <div class="timeslot4"></div>-->
<!--                                <div class="timeslot5"></div>-->
<!--                            </div>-->
                        </div>
                        <div class="event_action">

                            <form id='create_todo_form' method="post" action="<?php echo Yii::app()->getBaseUrl(true); ?>/event/createTodo">
                                <input type="submit" class="create_form" id="create_todo_button" name="create_form" value="Create Todo">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="planner_body_holder">
                <div id="free_planner_wrap" style="display: none;">
                    <img id="eventImg" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/partial/planner/eventImg.png" />
                    <span class="create_planner_message" style = "opacity:1">   Fill out your planner</span>
                    <span class="point point1" style = "opacity:1"> <em></em> classwork reminders</span>
                    <span class="point point2" style = "opacity:1"> <em></em> syncs with cal</span>
                </div>

                <div id="event_list">


                    <!--    Add btn to delete event from planner                -->
                    <script id="event_template" type="text/x-handlebars-template">

                        <div class='event {{complete}}' data-event_id='{{event_id}}'>
                            <div class='event_data_holder'>
                                <div class='event_name'>{{title}}</div>
                                <div class='event_date_time'>{{start_time}}</div>
                            </div>
                            <div class='event_checkbox_holder'>


                                {{#ifCond complete '==' 'complete'}}
                                    <input type="checkbox" class='event_checkbox_input' name="event_{{event_id}}_input" id="event_{{event_id}}_input" value="#event_data0" checked="checked">
                                    <label class = "planner_checkbox_label" for = "event_{{event_id}}_input"></label>
                                    <div class="checkbox_hint complete_hint">
                                        <div class="hint_box">
                                            Mark as Complete
                                        </div>
                                        <div class="hint_wedge">
                                        </div>
                                    </div>
                                    <div class="checkbox_hint incomplete_hint">
                                        <div class="hint_box">
                                            Mark as Incomplete
                                        </div>
                                        <div class="hint_wedge">
                                        </div>
                                    </div>
                                {{else}}
                                    <input type="checkbox" class='event_checkbox_input' name="event_{{event_id}}_input" id="event_{{event_id}}_input" value="#event_data0">
                                    <label class = "planner_checkbox_label" for = "event_{{event_id}}_input"></label>
                                    <div class="checkbox_hint complete_hint">
                                        
                                        <div class="hint_box">
                                            Mark as Complete
                                        </div>
                                        <div class="hint_wedge">
                                        </div>
                                    </div>
                                    <div class="checkbox_hint incomplete_hint">
                                        <div class="hint_box">
                                            Mark as Incomplete
                                        </div>
                                        <div class="hint_wedge">
                                        </div>
                                    </div>
                                {{/ifCond}}
                            </div>
                        </div>


                    </script>




                    <div class='planner_event_header' id='past_due_events_header' style="display: none;">
                        <div class="planner_event_header_label"><em class = "pl_red_circle small_icon_map"></em> Past Due</div>

                    </div>



                    <div id='past_events'>

                    </div>



                    <div class='planner_event_header' id='todays_events_header' style="display: none;">
                        <div class="planner_event_header_label"><em class = "pl_blue_circle"></em> Today</div>
                        <div class="planner_event_header_date" id="todays_date"></div>
                    </div>

                    <div id='todays_events'>

                    </div>


                    <div class='planner_event_header' id='tomorrows_events_header' style="display: none;">
                        <div class="planner_event_header_label">Tomorrow</div>
                        <div class="planner_event_header_date" id="tomorrows_date"></div>
                    </div>

                    <div id='tomorrows_events'>

                    </div>



                    <div class='planner_event_header' id='future_events_header' style="display: none;">
                        <div class="planner_event_header_label">Future</div>
                        <div class="planner_event_header_date" id="future_date"></div>
                    </div>

                    <div id='future_events'>

                    </div>
                </div>

                <!--
                <div id="planner_bottom_holder">
                    <div id="planner_bottom_bar_line"></div>

                    <div id="planner_bottom_see_all_button">
                        <div id="planner_bottom_text"><a href="<?php echo Yii::app()->getBaseUrl(true); ?>/calendar">View monthly calendar</a></div>
                    </div>
                </div>
                -->

            </div>


		</div>
		<script>
		</script>




	</body>










</html>


