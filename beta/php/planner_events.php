<?php

include 'dbconnection.php';

session_start();

$user_id = 1;



if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];
}

if (isset($_POST['time'])) {

    $now_time = $_POST['time'];
}

if (isset($_POST['date'])) {

    $today_date = $_POST['date'];
}



$today_date_unix = strtotime($today_date);

$today_date = date("Y-m-d", strtotime($today_date));

$now_time = date("H:i:s", strtotime($now_time));

$range = date("Y-m-d", strtotime("+1 month", strtotime($today_date)));


$get_types = "SELECT * FROM event_types";
$get_types_result = mysqli_query($con, $get_types);


while ($row = mysqli_fetch_array($get_types_result)) {
    $event_name = $row['event_name'];
    switch ($event_name) {
        case 'to_do':
            $to_do_event = $row['type'];
            break;
        case 'personal':
            $personal_event = $row['type'];
            break;
        case 'personal_invited':
            $personal_invited_event = $row['type'];
            break;
        case 'group':
            $group_event = $row['type'];
            break;
        case 'group_personal':
            $group_event_personal = $row['type'];
            break;
        case 'course':
            $course_event = $row['type'];
            break;
        case 'course_personal':
            $course_event_personal = $row['type'];
    }
}

$result_array = array();





//Selecting events for the user without recurrence

$personal_event_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' AND 

    ((`start_date` = '$today_date' AND `end_time`>'$now_time') OR (`start_date` > '$today_date'))

    AND `recurrence`='none'

    ORDER BY start_date ASC, start_time ASC";



//echo "personal query: "  . $personal_event_query;



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
        'end_time' => $row['end_time'],
        'is_check' => $row['is_check'],
        'event_id' => $row['event_id'],
        'type' => $personal_event
    );

    $count++;
}

//
//
//Selecting events for the user with recurrence

$personal_events_recurrence_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' 

    AND `end_date` >= '$today_date' AND `recurrence`!='none' ";



//echo "personal recurring query: "  . $personal_events_recurrence_query;



$personal_events_recurrence_query_result = mysqli_query($con, $personal_events_recurrence_query);

//echo mysqli_num_rows($personal_events_recurrence_query_result);
//echo $personal_events_recurrence_query;



$count = 0;

while ($row = mysqli_fetch_array($personal_events_recurrence_query_result)) {

    if ($count == 5) {

        break;
    }

    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

//    echo print_r($recurrence_dates);

    foreach ($recurrence_dates as $dates) {

        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $dates,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $personal_event
        );
    }

    $count++;
}



//Selecting events user has been invited to without recurrence

$personal_invited_event_query = "SELECT * FROM personal_event WHERE `event_id` IN 

    (SELECT `event_id` FROM personal_event_invited WHERE `user_id` ='$user_id' AND (`choice`='0' OR `choice`='1'))

        AND `recurrence`='none' AND ((`start_date` = '$today_date' AND `end_time`>'$now_time') OR (`start_date` > '$today_date'))

        ORDER BY start_date ASC,start_time ASC";



//echo "personal invited query: "  . $personal_invited_event_query;



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
        'end_time' => $row['end_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $personal_invited_event
    );

    $count++;
}

//
//
//
//
//Selecting events user has been invited to with recurrence

$personal_invited_event_recurrence_query = "SELECT * FROM personal_event WHERE

        `event_id` IN (SELECT `event_id` FROM personal_event_invited WHERE `user_id`='$user_id' AND (`choice`='0' OR `choice`='1'))

        AND `recurrence`!='none' AND `end_date` >= '$today_date'";



$personal_invited_event_recurrence_query_result = mysqli_query($con, $personal_invited_event_recurrence_query);



//echo "personal invited recurrence query: "  . $personal_invited_event_recurrence_query;

$count = 0;

while ($row = mysqli_fetch_array($personal_invited_event_recurrence_query_result)) {

    if ($count == 5) {

        break;
    }

    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

    foreach ($recurrence_dates as $dates) {

        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $dates,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $personal_invited_event
        );
    }

    $count++;
}



//
//
//
//Selecting club events has is part of without recurrence

$group_event_query = "SELECT * FROM group_event WHERE `event_id` IN 

    (SELECT `event_id` FROM group_event_invited WHERE `user_id`='$user_id' AND (`added`='0' OR `added`='1'))

        AND `recurrence`='none' AND ((`start_date` = '$today_date' AND `end_time`>'$now_time') OR (`start_date` > '$today_date'))

        ORDER BY start_date ASC,start_time ASC";



//echo "group query: "  . $group_event_query;



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
        'end_time' => $row['end_time'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $group_event
    );

    $count++;
}

//
//Selecting club events invited to with recurrence

$group_event_recurrence_query = "SELECT * FROM group_event    

        WHERE `event_id` IN (SELECT `event_id` FROM group_event_invited WHERE `user_id`='$user_id' 

            AND (`added`='0' OR `added`='1')) AND `recurrence`!='none' AND `end_date` >= '$today_date'";



//echo "group recurrence query: "  . $group_event_recurrence_query;

$group_event_recurrence_query_result = mysqli_query($con, $group_event_recurrence_query);



$count = 0;

while ($row = mysqli_fetch_array($group_event_recurrence_query_result)) {

    if ($count == 5) {

        break;
    }

    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

    foreach ($recurrence_dates as $dates) {

        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $dates,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $group_event
        );
    }

    $count++;
}

//
//
//
//
//Selecting course events he is part of without recurrence

$course_event_query = "SELECT * FROM course_event WHERE `event_id` IN

    (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`choice`='0' OR `choice`='1'))

        AND `recurrence`='none' AND ((`start_date` = '$today_date' AND `end_time`>'$now_time') OR (`start_date` > '$today_date'))

        ORDER BY start_date ASC,start_time ASC";



//echo "course query: "  . $course_event_query;

$course_event_query_result = mysqli_query($con, $course_event_query);



$count = 0;

while ($row = mysqli_fetch_array($course_event_query_result)) {

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
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'is_check' => $ischeck,
        'event_id' => $row['event_id'],
        'type' => $course_event
    );

    $count++;
}

//
//
//
//Selecting course events user is part of with recurrence

$course_event_recurrence_query = "SELECT * FROM course_event WHERE

    `event_id` IN (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`choice`='0' OR `choice`='1'))

        AND `end_date` >= '$today_date' AND `recurrence`!='none' ";



//echo "course recurrence query: "  . $course_event_recurrence_query;



$course_event_recurrence_query_result = mysqli_query($con, $course_event_recurrence_query);



$count = 0;

while ($row = mysqli_fetch_array($course_event_recurrence_query_result)) {

    if ($count == 5) {

        break;
    }

    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range);

    foreach ($recurrence_dates as $dates) {

        $event_id = $row['event_id'];

        $check_ischeck_query = "SELECT is_check FROM course_event_invited WHERE `event_id`='$event_id' AND `user_id`='$user_id'";

        $check_ischeck_query_result = mysqli_query($con, $check_ischeck_query);

        $ischeck = mysqli_fetch_array($check_ischeck_query_result);

        $ischeck = $ischeck['ischeck'];

        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $today_date,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'is_check' => $ischeck,
            'event_id' => $row['event_id'],
            'type' => $course_event
        );
    }

    $count++;
}

$course_personal_query = "SELECT * FROM course_event WHERE `user_id` = $user_id AND `end_date` >= $today_date";
$course_personal_query_result = mysqli_query($con, $course_personal_query);

$count = 0;

while ($row = mysqli_fetch_array($course_personal_query_result)) {

    if ($count == 5) {

        break;
    }
    if ($row['recurrence'] != 'none') {
        $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

        foreach ($recurrence_dates as $dates) {
            $result_array[] = array(
                'title' => $row['title'],
                'start_date' => $dates,
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'is_check' => $row['recurrence'],
                'event_id' => $row['event_id'],
                'type' => $course_event_personal
            );
        }
    } else {
        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $row['start_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'is_check' => $row['recurrence'],
            'event_id' => $row['event_id'],
            'type' => $course_event_personal
        );
    }
}


$group_personal_query = "SELECT * FROM group_event WHERE `user_id` = $user_id AND `end_date` >= $today_date";
$group_personal_query_result = mysqli_query($con, $group_personal_query);

$count = 0;

while ($row = mysqli_fetch_array($group_personal_query_result)) {
    if ($count == 5) {

        break;
    }
    if ($row['recurrence'] != 'none') {
        $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

        foreach ($recurrence_dates as $dates) {
            $result_array[] = array(
                'title' => $row['title'],
                'start_date' => $dates,
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'is_check' => $row['recurrence'],
                'event_id' => $row['event_id'],
                'type' => $group_event_personal
            );
        }
    } else {
        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $row['start_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'is_check' => $row['recurrence'],
            'event_id' => $row['event_id'],
            'type' => $group_event_personal
        );
    }
}


$event_count_show = 0;

$prev_day = 0;

$echo_string = "";

$count_incomplete = 0;

//print_r($result_array);

if (count($result_array) == 0) {

    $echo_string = $echo_string . "

    <div class = 'pl_free_planner'>
        
        <div class = 'no_events_exp'>

            <div class = 'no_events_speech'>
                    <p>Your Planner Looks Free!</p>
            </div>

            <img class = 'no_events_face' src = 'img/no_events_face.png' alt = 'No Events Icon of a Smiley Face'>

        </div>

    </div>

    ";
} else {

    $sort = array();

    foreach ($result_array as $k => $v) {

        $sort['start_date'][$k] = $v['start_date'];

        $sort['start_time'][$k] = $v['start_time'];
    }



    array_multisort($sort['start_date'], SORT_ASC, $sort['start_time'], SORT_ASC, $result_array);



    foreach ($result_array as $event) {

        if ($event_count_show == 5) {

            break;
        }

        if ($event['start_date'] < $today_date) {
            continue;
        } else if ($event['start_date'] == $today_date) {
            if ($event['start_time'] < $now_time) {
                continue;
            }
        }

//        echo $event['type'];

        $event_count_show++;

        if ($prev_day !== $event['start_date']) {

            $prev_day = $event['start_date'];

            if (isToday1($event['start_date'], $today_date_unix)) {

                $day = date("M j", strtotime($event['start_date']));

                $echo_string = $echo_string . '<div class = "pl_day">

                         <div class = "fl_l"><span class = "pl_day_week">' . 'Today </span><span class = "pl_day_date">' . $day . '</span></div>

                      </div>';



                //Setting id for use when this event is deleted or checked

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                $endtime = date("g:i a", strtotime($event['end_time']));

                if (isNow1($event['start_time'], $now_time)) {

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "current time">' . 'NOW' . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                } else {

                    $time = date("g:i a", strtotime($event['start_time']));

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                }
            } else if (isTomorrow1($event['start_date'], $today_date_unix)) {

                $day = date("M j", strtotime($event['start_date']));

                $echo_string = $echo_string . '<div class = "pl_day">

                         <div class = "fl_l">

                            <span class = "pl_day_week">' . 'Tomorrow' . ' </span>

                            <span class = "pl_day_date">' . $day . '</span>

                         </div>

                      </div>';

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                //Setting id for use when this event is deleted or checked    

                $time = date("g:i a", strtotime($event['start_time']));

                $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                    </div>';
            } else {

                $day = date("M j", strtotime($event['start_date']));

                $date = date("l", strtotime($event['start_date']));

                $echo_string = $echo_string . '<div class = "pl_day">

                        <div class = "fl_l"><span class = "pl_day_week">' . $date . ' </span><span class = "pl_day_date">' . $day . '</span></div>

                      </div>';

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                //Setting id for use when this event is deleted or checked    

                $time = date("g:i a", strtotime($event['start_time']));

                $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                    </div>';
            }
        } else {

            if (isToday1($event['start_date'], $today_date_unix)) {

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                $endtime = date("g:i a", strtotime($event['end_time']));

                if (isNow1($event['start_time'], $now_time)) {

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "current time">' . 'NOW' . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                } else {

                    $time = date("g:i a", strtotime($event['start_time']));

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                }
            } else {

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                //Setting id for use when this event is deleted or checked    

                $time = date("g:i a", strtotime($event['start_time']));

                $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                    </div>';
            }
        }



        $echo_string = $echo_string . '<div class = "upc-eventL">

                        <div class = "evntName" ><a href="calendar_beta.php?id=' . $event['event_id'] . '&type=' . $event['type'] . '">' . $event['title'] . '</a></div>

                    </div>';



        if ($event['type'] == $personal_event or $event['type'] == $course_event_personal or $event['type'] == $course_event) {

            if ($event['is_check'] == 0) {

                $count_incomplete++;

                $echo_string = $echo_string . '<div class="toDowrapper" id="w-2-2' . $event['event_id'] . '_' . $event['type'] . '">

                        <div class="button-block">

                            <button type="button">

                                <i class="mark x"></i>

                                <i class="mark xx"></i>

                            </button>

                        </div>

                    </div>';
            } else {

                $echo_string = $echo_string . '<div class="toDowrapper checked" id="w-2-2' . $event['event_id'] . '_' . $event['type'] . '">

                        <div class="button-block canceled">

                            <button type="button">

                                <i class="mark x"></i>

                                <i class="mark xx"></i>

                            </button>

                        </div>

                    </div>';
            }
        }

        $echo_string = $echo_string . '</div>';
    }
}

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



    if ($today_date_unix == $start_date) {

        return True;
    } else {

        return False;
    }
}

function isTomorrow1($start_date, $today_date_unix) {

    $tomorrow_unix = strtotime("+1 day", $today_date_unix);

    $start_date = strtotime($start_date);

    if (($tomorrow_unix - $start_date) == 0) {

        return True;
    } else {

        return False;
    }
}

function getDatesOfRecurrence($start_date, $end_date, $recurrenceType, $range, $today_date) {

    $dates = array();

    switch ($recurrenceType) {

        //Daily event

        case 'daily':

            $new_date = $start_date;

            while (TRUE) {

                if ($new_date < $today_date) {

                    $new_date = date("Y-m-d", strtotime("+1 day", strtotime($new_date)));

                    continue;
                } else if ($new_date <= $end_date and $new_date <= $range) {

                    $dates[] = $new_date;
                } else {

                    break;
                }

                $new_date = date("Y-m-d", strtotime("+1 day", strtotime($new_date)));
            }

//            print_r($dates);

            return $dates;

        //Weekly event

        case 'weekly':

            $new_date = $start_date;

            while (TRUE) {

                if ($new_date < $today_date) {

                    $new_date = date("Y-m-d", strtotime("+1 week", strtotime($new_date)));

                    continue;
                } else if ($new_date <= $end_date and $new_date <= $range) {

                    $dates[] = $new_date;
                } else {

                    break;
                }

                $new_date = date("Y-m-d", strtotime("+1 week", strtotime($new_date)));
            }

            return $dates;

        //Monthly event

        case 'monthly':

            $new_date = $start_date;

            while (TRUE) {

                $present_month = date("n", strtotime($new_date));

                $present_date = date("j", strtotime($new_date));

                if ($new_date < $today_date) {

                    if ($present_month == 1 and (($present_date > 28 and $leap_year = 0) or ($present_date > 29 and $leap_year = 1))) {

                        $new_date = date("Y-m-d", strtotime("+2 month", strtotime($new_date)));
                    } else {

                        $new_date = date("Y-m-d", strtotime("+1 month", strtotime($new_date)));
                    }

                    continue;
                } else if ($new_date <= $end_date and $new_date <= $range) {

                    $dates[] = $new_date;
                } else {

                    break;
                }

                if ($present_month == 1 and (($present_date > 28 and $leap_year = 0) or ($present_date > 29 and $leap_year = 1))) {

                    $new_date = date("Y-m-d", strtotime("+2 month", strtotime($new_date)));
                } else {

                    $new_date = date("Y-m-d", strtotime("+1 month", strtotime($new_date)));
                }
            }

            return $dates;

        default:

            echo "Should never get here";
    }
}

mysqli_close($con);



$json = array(
    'echo_string' => $echo_string
);



$jsonstring = json_encode($json);

echo $jsonstring;
?>