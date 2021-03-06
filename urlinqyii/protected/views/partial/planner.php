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


        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/calendar_selector.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.timeAutocomplete.min.js"></script>

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>




        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>


	</head>
	<body>
		<div class="planner_container">


            <div id="planner_header_holder">
                <div class="planner_header_panel">
                    <div class="planner_header">
                        <?php
                            if($origin_type === 'club'){
                                echo 'Planner';
                            }
                            elseif($origin_type === 'class'){
                                echo 'Planner';
                            }
                            elseif($origin_type === 'department'){
                                echo 'Planner';
                            }
                            else{
                                echo 'Planner';
                            }
                         ?>
                         <div class="entry_field_placeholder" id="add_todo">
                            <span id = "add_todo_text">
                            <?php
                            if($origin_type === 'class'){
                                echo 'Add class task';
                            }
                            elseif($origin_type === 'club'){
                                echo 'Add club event';
                            } 
                            elseif($origin_type === 'department'){
                                echo 'Add event';
                            }  
                            else{
                                echo 'Add Todo';
                            }
                            ?>
                            </span>
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
                            <input class="event_date date_input planner" id="event_date" name="event_date" value="none" readonly>




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
                <div id="free_planner_wrap" class = "create_planner_message" style="display: none;">
                    <img id="eventImg" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/partial/planner/eventImg.png" />
                    <span class="create_planner_message_pre" style = "opacity:1">   Plan your Week</span>
                    <span class="point point1" style = "opacity:1"> <em></em> Invite your friends to join in</span>
                    <span class="point point2" style = "opacity:1"> <em></em> Receive classwork reminders</span>
                    <span class="point point3" style = "opacity:1"> <em></em> Syncs with your calendar</span>
                </div>

                <div id="event_list">


                    <!--    Add btn to delete event from planner                -->
                    <script id="event_template" type="text/x-handlebars-template">
                        
                        <div class='event {{complete}} event_origin_event_tab_link' data-event_id='{{event_id}}' data-event_start_date="{{start_date}}" data-start_date="{{start_date}}" data-start_time="{{start_time}}" data-end_date="{{end_date}}" data-end_time="{{end_time}}" data-color_hex="{{color.hex}}">
                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}">
                            <div class='event_data_holder {{checkable}}'>
                                
                                {{#ifCond origin_type '!=' 'user'}}
                                     <?php if($origin_type==="home"){?>
                                    <div class = "event_origin"><span class = "origin_vert_line" style = "color:{{color.hex}}">&#x7c; </span><a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a></div>
                                    <?php }?>

                                {{/ifCond}}
                                <span class='event_name' data-event_id="{{event_id}}" data-event_start_date="{{start_date}}">{{title}}</span>
                                <div class = "planner_event_date">
                                {{#if future}}
                                    <div class="event_date_time date">{{formatted_date_time}}</div>
                                {{/if}}
                                {{#if start_time}}
                                    <div class='event_date_time'>at {{formatted_start_time}}</div>
                                {{/if}}
                                {{#ifCond user_id '==' <?php echo $user->user_id;?>}}
                                   <span class = "planner_edit_wrapper"><span class = "edit_middot">·</span> <span class="edit_button" style="display: none;">edit</span></span>
                                {{/ifCond}}                                
                                {{#ifCond event_type '==' 'NYU Event'}}
                                    <div class='event_date_time'>· <a target="_blank" href='{{url}}'>NYU Event</a></div>
                                {{/ifCond}}
                            </div>
                            {{#if checkable}}
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
                            {{/if}}
                            </a>
                        </div>
                        


                    </script>

                    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/planner/planner.js"> </script>


                    <div class='planner_event_header' id='past_due_events_header' style="display: none;">
                        <div class="planner_event_header_label"><em class = "pl_red_circle small_icon_map"></em> 
                            <?php
                                if($origin_type === 'class'){
                                    echo 'Past Due';
                                }
                                else{
                                    echo 'Past';
                                }
                             ?>                            
                        </div>

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

        <div class = "edit_event_box" style="display: none">
            <input type="text" id="edit_event_title" placeholder="title" >
            <input type="text" id="edit_event_date" placeholder="date due" class="planner_edit date_input">
            <input type="text" id="edit_event_time" placeholder="time due" class="planner_edit time_input">
            <div class = "popout_sep">
                <input type="button" id="submit_edit_event" value="Save">
                <input type="button" id="cancel_edit_event" value="Cancel">
            </div>
        </div>




        <!--<!-- INCLUDE THIS AND date_selector.js and add class name date_input to your date input fields to use this -->

     <!--   <div id = "calLayer"  class = "planner" style="display: none;">
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
        </div> -->
    </body>










</html>


