<html>
	<head>


        <script>
            origin = '<?php echo $origin_type; ?>';
            origin_id = '<?php echo $origin_id; ?>';


        </script>

		<title>Home Planner</title>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/planner/planner.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/planner/datepicker.css"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"> </script>
<!--		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<!--		<script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>-->

<!--        <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<!---->
<!--        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->

<!--        <script src="--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/js/jquery.min.js" type="text/javascript"></script>-->

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar_selector.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.timeAutocomplete.min.js"></script>




        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/planner/planner.js"> </script>
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
                                echo '';
                            }else{
                                echo ucfirst($origin_type);
                            }
                         ?> Planner
                        <img id="dropdown_arrow" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/partial/planner/dropdown_arrow.png"/>
                    </div>
                </div>

            </div>

            <div class="create_event_body">
                <div class="entry_field" id="todo_wrap">
                    <div class="entry_field_placeholder" id="add_todo">
                        + Create To-do
                        <i class="help_icon"></i>
                    </div>
                    <div class="planner_creation_form">
                        <textarea class="event_name" id="event_name" name="event_name" placeholder="Title (e.g. Physics HW)" maxlength="100"></textarea>
                        <div class="event_time_wrap">
                            Due:
                            <input class="event_date" id="event_date" name="event_date" value="none" readonly></input>
                            <div class = "calLayer">
                                <section id = "mounth" class="mounth">
                                    <header class="minical-header">
                                        <h1 class="minical-h1"></h1>

                                        <nav role="padigation">
                                            <span class="m-prev"></span>
                                            <span class="m-next"></span>
                                        </nav>
                                    </header>

                                    <article>
                                        <div class="days">
                                            <b>SU</b>
                                            <b>MO</b>
                                            <b>TU</b>
                                            <b>WE</b>
                                            <b>TH</b>
                                            <b>FR</b>
                                            <b>SA</b>
                                        </div>
                                        <div class="dates">
                                            <span id="calcell_su_0" class="calcell disable cl_0"></span>
                                            <span id="calcell_mo_1" class="calcell disable cl_1"></span>
                                            <span id="calcell_tu_2" class="calcell disable cl_2"></span>
                                            <span id="calcell_we_3" class="calcell disable cl_3"></span>
                                            <span id="calcell_th_4" class="calcell disable cl_4"></span>
                                            <span id="calcell_fr_5" class="calcell disable cl_5"></span>
                                            <span id="calcell_sa_6" class="calcell disable cl_6"></span>
                                            <span id="calcell_su_7" class="calcell disable cl_7"></span>
                                            <span id="calcell_mo_8" class="calcell disable cl_8"></span>
                                            <span id="calcell_tu_9" class="calcell disable cl_9"></span>
                                            <span id="calcell_we_10" class="calcell disable cl_10"></span>
                                            <span id="calcell_th_11" class="calcell disable cl_11"></span>
                                            <span id="calcell_fr_12" class="calcell disable cl_12"></span>
                                            <span id="calcell_sa_13" class="calcell disable cl_13"></span>
                                            <span id="calcell_su_14" class="calcell disable cl_14"></span>
                                            <span id="calcell_mo_15" class="calcell disable cl_15"></span>
                                            <span id="calcell_tu_16" class="calcell disable cl_16"></span>
                                            <span id="calcell_we_17" class="calcell disable cl_17"></span>
                                            <span id="calcell_th_18" class="calcell disable cl_18"></span>
                                            <span id="calcell_fr_19" class="calcell disable cl_19"></span>
                                            <span id="calcell_sa_20" class="calcell disable cl_20"></span>
                                            <span id="calcell_su_21" class="calcell disable cl_21"></span>
                                            <span id="calcell_mo_22" class="calcell disable cl_22"></span>
                                            <span id="calcell_tu_23" class="calcell disable cl_23"></span>
                                            <span id="calcell_we_24" class="calcell disable cl_24"></span>
                                            <span id="calcell_th_25" class="calcell disable cl_25"></span>
                                            <span id="calcell_fr_26" class="calcell disable cl_26"></span>
                                            <span id="calcell_sa_27" class="calcell disable cl_27"></span>
                                            <span id="calcell_su_28" class="calcell disable cl_28"></span>
                                            <span id="calcell_mo_29" class="calcell disable cl_29"></span>
                                            <span id="calcell_tu_30" class="calcell disable cl_30"></span>
                                            <span id="calcell_we_31" class="calcell disable cl_31"></span>
                                            <span id="calcell_th_32" class="calcell disable cl_32"></span>
                                            <span id="calcell_fr_33" class="disable calcell cl_33"></span>
                                            <span id="calcell_sa_34" class="disable calcell cl_34"></span>
                                            <span id="calcell_su_35" class="disable calcell cl_35"></span>
                                            <span id="calcell_mo_36" class="disable calcell cl_36"></span>
                                            <span id="calcell_tu_37" class="disable calcell cl_37"></span>
                                            <span id="calcell_we_38" class="disable calcell cl_38"></span>
                                            <span id="calcell_th_39" class="disable calcell cl_39"></span>
                                            <span id="calcell_fr_40" class="disable calcell cl_40"></span>
                                            <span id="calcell_sa_41" class="disable calcell cl_41"></span>
                                        </div>
                                    </article>
                                </section>
                            </div>
                            <span class="event_time" data-time="00:00:00">Add time</span>
                            <input class="tp1" id="tp1" value="none">
                            <div class="timepicker">
                                <div class="timeslot1"></div>
                                <div class="timeslot2"></div>
                                <div class="timeslot3"></div>
                                <div class="timeslot4"></div>
                                <div class="timeslot5"></div>
                            </div>
                        </div>
                        <div class="event_action">
                            <span class="cancel_form">Cancel</span>

                            <form id='create_todo_form' method="post" action="<?php echo Yii::app()->getBaseUrl(true); ?>/event/createTodo">
                                <input type="submit" class="create_form" id="create_todo_button" name="create_form" value="Add this To-Do">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="planner_body_holder">
                <div id="free_planner_wrap" style="display: none;">
                    <img id="eventImg" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/partial/planner/eventImg.png" />
                    <span class="free_planner_message">Schedule clear</span>
                    <span class="create_planner_message">Add a todo</span>
                </div>


                <div id="event_list">


                    <!--    Add btn to delete event from planner                -->
                    <script id="event_template" type="text/x-handlebars-template">

                        <div class='event {{complete}}' data-event_id='{{event_id}}'>
                            <div class='event_data_holder'>
                                <div class='event_name'>{{title}}</div>
                                <div class='event_date_time'>{{end_date}}</div>
                            </div>
                            <div class='event_checkbox_holder'>


                                {{#ifCond complete '==' 'complete'}}
                                    <input type="checkbox" class='event_checkbox_input' name="event0" id="e0" value="#event_data0" checked="checked">
                                {{else}}
                                    <input type="checkbox" class='event_checkbox_input' name="event0" id="e0" value="#event_data0">
                                {{/ifCond}}
                            </div>
                        </div>


                    </script>




                    <div class='planner_event_header' id='past_due_events_header' style="display: none;">
                        <div class="planner_event_header_label">Past Due</div>
                    </div>



                    <div id='past_events'>

                    </div>



                    <div class='planner_event_header' id='todays_events_header' style="display: none;">
                        <div class="planner_event_header_label">Today</div>
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
                </div>

                <div id="planner_bottom_holder">
                    <div id="planner_bottom_bar_line"></div>

                    <div id="planner_bottom_see_all_button">
                        <div id="planner_bottom_text">View monthly calendar</div>
                    </div>
                </div>

            </div>


		</div>
		<script>
		</script>
	</body>
</html>