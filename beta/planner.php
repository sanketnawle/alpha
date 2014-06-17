<?php
include 'dbconnection.php';

$user_id = 0;
$now_time = strtotime(date("H:i:s", strtotime("now")));
$today_date = strtotime(date("Y-m-d", strtotime("now")));
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}
if (isset($_POST['time_now'])) {
    $now_time = $_POST['time_now'];
}
if (isset($_POST['date_now'])) {
    $today_date = $_POST['today_date'];
}
$today_date_unix = $today_date;
$today_date = date("Y-m-d", $today_date);
$now_time = date("H:i:s", $now_time);

$personal_event = 1;
$personal_event_recurring = 2;
$personal_invited_event = 3;
$group_event = 4;
$course_event = 5;
$result_array = array();

//Selecting events for the user without recurrence
$personal_event_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' AND `start_date` >='$today_date' 
    AND `recurrence`='0' AND `end_time` > '$now_time'
    ORDER BY start_date ASC, start_time ASC";
$personal_event_query_result = mysqli_query($con, $personal_event_query);

$count = 0;
while ($row = mysqli_fetch_array($personal_event_query_result)) {
    if ($count == 5) {
        break;
    }
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'is_check' => $row['is_check'],
        'event_id' => $row['event_id'],
        'type' => $personal_event
    );
    $count++;
}


//Selecting events for the user with recurrence
$personal_events_recurrence_query = "SELECT EV.*
FROM `personal_event` EV
JOIN `personal_event_meta` EM1 ON EM1.`event_id` = EV.`event_id`
JOIN `personal_event_meta` EM2 ON EM2.`meta_key` = 'repeat_interval' AND EM2.`event_id`=EV.`event_id`
WHERE EM1.meta_key = 'repeat_start' AND EV.`end_time`>'$now_time' AND EV.`user_id`='$user_id' AND (
        ( CASE ( '$today_date_unix' - EM1.`meta_value` )
            WHEN 0
              THEN 1
            ELSE (( '$today_date_unix' - EM1.`meta_value` ) / EM2.`meta_value`)
          END
        ) >= 1) 
        ORDER BY start_date ASC, start_time ASC";

$personal_events_recurrence_query_result = mysqli_query($con, $personal_events_recurrence_query);

$count = 0;
while ($row = mysqli_fetch_array($personal_events_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $today_date,
        'start_time' => $row['start_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $personal_event_recurring
    );
    $count++;
}

//Selecting events user has been invited to without recurrence
$personal_invited_event_query = "SELECT * FROM personal_event WHERE `event_id` IN 
    (SELECT `event_id` FROM personal_event_invited WHERE `user_id` ='$user_id' AND (`choice`='0' OR `choice`='1'))
        AND `recurrence`=0 AND `end_time`>'$now_time'
        ORDER BY start_date ASC,start_time ASC";
$personal_invited_event_query_result = mysqli_query($con, $personal_invited_event_query);


$count = 0;
while ($row = mysqli_fetch_array($personal_invited_event_query_result)) {
    if ($count == 5) {
        break;
    }
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $personal_invited_event
    );
    $count++;
}




//Selecting events user has been invited to with recurrence
$personal_invited_event_recurrence_query = "SELECT EV.* FROM personal_event EV WHERE 
    JOIN `personal_event_meta` EM1 ON EM1.`event_id` = EV.`event_id`
    JOIN `personal_event_meta` EM2 ON EM2.`meta_key` = 'repeat_interval' AND EM2.`event_id`=EV.`event_id`
    WHERE EM1.meta_key = 'repeat_start' AND EV.`end_time`>'$now_time' AND
        `event_id` IN (SELECT `event_id` FROM personal_event_invited WHERE `user_id`='$user_id' (`choice`='0' OR `choice`='1')) 
            AND (
        ( CASE ( '$today_date_unix' - EM1.`meta_value` )
            WHEN 0
              THEN 1
            ELSE (( '$today_date_unix' - EM1.`meta_value` ) / EM2.`meta_value`)
          END
        ) >= 1) 
        ORDER BY start_date ASC, start_time ASC";

$personal_invited_event_recurrence_query_result = mysqli_query($con, $personal_invited_event_recurrence_query);

$count = 0;
while ($row = mysqli_fetch_array($personal_invited_event_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $today_date,
        'start_time' => $row['start_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $personal_invited_event
    );
    $count++;
}



//Selecting club events has is part of without recurrence
$group_event_query = "SELECT * FROM group_event WHERE `event_id` IN 
    (SELECT `event_id` FROM group_event_invited WHERE `user_id`='$user_id' AND (`added`='0' OR `added`='1'))
        AND `recurrence`=0 `end_time`>'$now_time'
        ORDER BY start_date ASC,start_time ASC";
$group_event_query_result = mysqli_query($con, $group_event_query);

$count = 0;
while ($row = mysqli_fetch_array($group_event_query_result)) {
    if ($count == 5) {
        break;
    }
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $group_event
    );
    $count++;
}

//Selecting club events invited to with recurrence
$group_event_recurrence_query = "SELECT EV.* FROM group_event EV WHERE 
    JOIN `group_event_meta` EM1 ON EM1.`event_id` = EV.`event_id`
    JOIN `group_event_meta` EM2 ON EM2.`meta_key` = 'repeat_interval' AND EM2.`event_id`=EV.`event_id`
    WHERE EM1.meta_key = 'repeat_start' AND EV.`end_time`>'$now_time' AND
        `event_id` IN (SELECT `event_id` FROM group_event_invited WHERE `user_id`='$user_id' AND (`added`='0' OR `added`='1')) 
            AND (
        ( CASE ( '$today_date_unix' - EM1.`meta_value` )
            WHEN 0
              THEN 1
            ELSE (( '$today_date_unix' - EM1.`meta_value` ) / EM2.`meta_value`)
          END
        ) >= 1) 
        ORDER BY start_date ASC, start_time ASC";

$group_event_recurrence_query_result = mysqli_query($con, $group_event_recurrence_query);

$count = 0;
while ($row = mysqli_fetch_array($group_event_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $today_date,
        'start_time' => $row['start_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $group_event
    );
    $count++;
}




//Selecting course events he is part of without recurrence
$course_event_query = "SELECT * FROM course_event WHERE `event_id` IN
    (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`choice`='0' OR `choice`='1')) 
        ORDER BY start_date ASC,start_time ASC";
$course_event_query_result = mysqli_query($con, $course_event_query);

$count = 0;
while ($row = mysqli_fetch_array($course_event_query_result)) {
    if ($count == 5) {
        break;
    }
    $event_id = $row['event_id'];
    $check_ischeck_query = "SELECT is_check FROM group_event_invited WHERE `event_id`='$event_id' AND `user_id`='$user_id'";
    $check_ischeck_query_result = mysqli_query($con, $check_ischeck_query);
    $ischeck = mysqli_fetch_array($check_ischeck_query_result);
    $ischeck = $ischeck['ischeck'];
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'is_check' => $ischeck,
        'event_id' => $row['event_id'],
        'type' => $course_event
    );
    $count++;
}




//Selecting course events user is part of with recurrence
$course_event_recurrence_query = "SELECT EV.* FROM course_event EV WHERE 
    JOIN `course_event_meta` EM1 ON EM1.`event_id` = EV.`event_id`
    JOIN `course_event_meta` EM2 ON EM2.`meta_key` = 'repeat_interval' AND EM2.`event_id`=EV.`event_id`
    WHERE EM1.meta_key = 'repeat_start' AND EV.`end_time`>'$now_time' AND
        `event_id` IN (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`added`='0' OR `added`='1')) 
            AND (
        ( CASE ( '$today_date_unix' - EM1.`meta_value` )
            WHEN 0
              THEN 1
            ELSE (( '$today_date_unix' - EM1.`meta_value` ) / EM2.`meta_value`)
          END
        ) >= 1) 
        ORDER BY start_date ASC, start_time ASC";

$course_event_recurrence_query_result = mysqli_query($con, $course_event_recurrence_query);

$count = 0;
while ($row = mysqli_fetch_array($course_event_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $event_id = $row['event_id'];
    $check_ischeck_query = "SELECT is_check FROM course_event_invited WHERE `event_id`='$event_id' AND `user_id`='$user_id'";
    $check_ischeck_query_result = mysqli_query($con, $check_ischeck_query);
    $ischeck = mysqli_fetch_array($check_ischeck_query_result);
    $ischeck = $ischeck['ischeck'];
    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $today_date,
        'start_time' => $row['start_time'],
        'is_check' => $ischeck,
        'event_id' => $row['event_id'],
        'type' => $course_event
    );
    $count++;
}

$sort = array();
foreach ($result_array as $k => $v) {
    $sort['start_date'][$k] = $v['start_date'];
    $sort['start_time'][$k] = $v['start_time'];
}

array_multisort($sort['start_date'], SORT_ASC, $sort['start_time'], SORT_ASC, $result_array);

$event_count_show = 0;
$prev_day = 0;
$echo_string = "";
$count_incomplete = 0;
//print_r($result_array);
foreach ($result_array as $event) {
    if ($event_count_show == 5) {
        break;
    }
    if ($prev_day !== $event['start_date']) {
        $prev_day = $event['start_date'];
        if (isToday1($event['start_date'], $today_date_unix)) {
            $echo_string = $echo_string . '<div class = "pl_day">
                         <div class = "fl_l">' . 'Today' . '</div>
                      </div>';

            //Setting id for use when this event is deleted or checked
            $echo_string = $echo_string . '<div class = "upcoming upc-1 id="event' . $event['event_id'] . '_' . $event['event_type'] . '" ">';
            if (isNow1($event['start_time'], $now_time)) {
                $echo_string = $echo_string . '
                    <div class = "upc-floatL">
                        <div class = "current time">' . 'NOW' . '</div>
                    </div>';
            } else {
                $time = date("g:i a", strtotime($event['start_time']));
                $echo_string = $echo_string . '
                    <div class = "upc-floatL">
                        <div class = "time">' . $time . '</div>
                    </div>';
            }
        } else {
            $day = date("l M j", strtotime($event['start_date']));
            $echo_string = $echo_string . '<div class = "pl_day">
                        <div class = "fl_l">' . $day . '</div>
                      </div>';
            $echo_string = $echo_string . '<div class = "upcoming upc-1 id="event' . $event['event_id'] . '_' . $event['event_type'] . '" ">';
            //Setting id for use when this event is deleted or checked    
            $time = date("g:i a", strtotime($event['start_time']));
            $echo_string = $echo_string . '
                    <div class = "upc-floatL">
                        <div class = "time">' . $time . '</div>
                    </div>';
        }
    } else {
        //Setting id for use when this event is deleted or checked
        $echo_string = $echo_string . '<div class = "upcoming upc-1 id="event' . $event['event_id'] . '_' . $event['event_type'] . '" ">';
        if (isNow1($event['start_time'], $now_time)) {
            $echo_string = $echo_string . '
                    <div class = "upc-floatL">
                        <div class = "current time">' . 'NOW' . '</div>
                    </div>';
        } else {
            $time = date("g:i a", strtotime($event['start_time']));
            $echo_string = $echo_string . '
                    <div class = "upc-floatL">
                        <div class = "time">' . $time . '</div>
                    </div>';
        }
    }

    $echo_string = $echo_string . '<div class = "upc-eventL">
                        <div class = "evntName">' . $event['title'] . '</div>
                    </div>';

    if ($event['type'] == 1 or $event['type'] == 5) {
        if ($event['is_check'] == 0) {
            $count_incomplete++;
            $echo_string = $echo_string . '<div class="toDowrapper" id="w-2-2' . $event['event_id'] . '_' . $event['event_type'] . '">
                        <div class="button-block">
                            <button type="button">
                                <i class="mark x"></i>
                                <i class="mark xx"></i>
                            </button>
                        </div>
                    </div>
            </div>';
        } else {
            $echo_string = $echo_string . '<div class="toDowrapper checked" id="w-2-2' . $event['event_id'] . '_' . $event['event_type'] . '">
                        <div class="button-block canceled">
                            <button type="button">
                                <i class="mark x"></i>
                                <i class="mark xx"></i>
                            </button>
                        </div>
                    </div>
            </div>';
        }
    }
}

$echo_string = '                      </div>

                                            </div>
                                        </div>
                                        <div class = "add_upcoming">                                            
                                                <textarea placeholder = "+ Add new Event" class = "pl_add" name="event_name" id="event_name"></textarea>
                                                <div class = "pl_addevnt">
                                                    <div class = "evnt_inps">
                                                        When<input class = "set_date" name="event_date" id="event_date"/>

                                                        <input id="set_time_24hr"  class = "set_time" name="event_time"></input>
                                                        <div class = "calLayer">
                                                            <section id = "mounth" class="mounth">
                                                                <header class="minical-header">
                                                                    <h1 class="minical-h1">JANUARY 2013</h1>

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
                                                    </div>
                                                    <div class = "evnt_create">
                                                        <a class = "btn_canc">Cancel</a>
                                                        <button id="add_event" class = "btn_addvent" type = "submit">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="result" class = "upcomingEvnt-wrapper">' . $echo_string;

if ($count_incomplete == 0) {
    $echo_string = '<div id="event_count" class = "upcomingNmbr">' . 'All Complete' . '</div>' . $echo_string;
} else {
    $echo_string = '<div id="event_count" class = "upcomingNmbr">' . $count_incomplete . ' Incomplete</div>' . $echo_string;
}

$echo_string = '<div class = "rightsec">
                                <div class = "n_pf_5">
                                    <div class = "planner">
                                        <div class = "pl_head">
                                            <div class = "pl_head_wrap">
                                                <div class = "floatL">
                                                    <div class = "text1">MY PLANNER</div>
                                                    <i class="fa fa-caret-down"></i>
                                                    <div class = "pl_options">
                                                        <div class = "pl_option">View my full planner</div>
                                                        <div class = "pl_option">View my monthly calendar</div>
                                                        <div class = "pl_option">Hide all upcoming</div>
                                                    </div>
                                                </div>
                                                <div class = "floatR">' . $echo_string;
$echo_string = $echo_string . '</div>';

function isNow1($start_time, $now_time) {
    $system_time = strtotime($now_time);
    $start_time = strtotime($start_time);
    $diff = round(($start_time - $system_time) / 60, 2);
//                                            echo nl2br($diff . "\r\n");
    if ($diff < 30.00) {
        return True;
    } else {
        return False;
    }
}

function isToday1($start_date, $today_date_unix) {
//    echo "Start date" . $start_date . '*';
//    echo $today_date_unix;
    $start_date = strtotime($start_date);
    if (($today_date_unix - $start_date) == 0) {
        return True;
    } else {
        return False;
    }
}

echo $echo_string;
?>