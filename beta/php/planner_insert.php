<?php

include 'dbconnection.php';
require_once 'time_change.php';
require_once '../includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$title = input_sanitize($_POST['event_name'], $con);
$start_date = input_sanitize($_POST['event_date'], $con);
$start_time = input_sanitize($_POST['event_time'], $con);

$server_timestamp = new DateTime(server_time($start_date . " " . $start_time));
$start_date = $server_timestamp->format("Y-m-d");
$start_time = $server_timestamp->format("H:i:s");

$insert_event_query = "INSERT INTO personal_event 
    (user_id, title, start_date, end_date, start_time, end_time, recurrence, invites)
    VALUES ($user_id, '$title', '$start_date' , '$start_date', '$start_time', '$start_time', 'none', 0)";
//echo $insert_event_query;
$insert_event_query_result = mysqli_query($con, $insert_event_query);

if ($insert_event_query_result) {
    //success
} else {
    echo mysqli_errno($con);
}

$now_time = date("H:i:s", strtotime("now"));
$today_date = date("Y-m-d", strtotime("now"));

$user_today_timestamp = new DateTime(user_time($today_date . "" . $now_time));
$today_date_user = $user_today_timestamp->format("Y-m-d");
$now_time_user = $user_today_timestamp->format("H:i:s");
$user_today_timestamp_copy = clone $user_today_timestamp;
$user_today_timestamp_copy->add(new DateInterval("P1D"));
$tommorow_date = $user_today_timestamp_copy->format("Y-m-d");
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
            break;
        case 'office timing':
            $office_timing = $row['type'];
            break;
    }
}

//Selecting events for the user without recurrence

$personal_event_query = "SELECT * FROM personal_event WHERE user_id= $user_id AND

    ((start_date = '$today_date' AND end_time>'$now_time') OR (start_date > '$today_date'))

    AND recurrence='none' ORDER BY start_date ASC, start_time ASC";


//echo "personal query: "  . $personal_event_query;


$personal_event_query_result = $con->query($personal_event_query);


$count = 0;

while ($row = $personal_event_query_result->fetch_array()) {

    if ($count == 5) {

        break;
    }
    if ($row['invites'] == 0 AND ($row['location'] == NULL OR $row['location'] == 'NULL') AND $row['recurrence'] == 'none') {
        $type_event = $to_do_event;
    } else {
        $type_event = $personal_event;
    }

    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'end_date' => $row['end_date'],
        'recurrence' => $row['recurrence'],
        'is_check' => $row['is_check'],
        'event_id' => $row['event_id'],
        'type' => $type_event
    );

    $count++;
}

//Selecting events for the user with recurrence

$personal_events_recurrence_query = "SELECT * FROM personal_event WHERE user_id= $user_id
    AND end_date >= '$today_date' AND recurrence!='none'";


//echo "personal recurring query: "  . $personal_events_recurrence_query;


$personal_events_recurrence_query_result = $con->query($personal_events_recurrence_query);

//echo $personal_events_recurrence_query;


$count = 0;

while ($row = $personal_events_recurrence_query_result->fetch_array()) {

    if ($count == 5) {

        break;
    }

    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

//    echo print_r($recurrence_dates);
    if ($row['invites'] == 0 AND ($row['location'] == NULL OR $row['location'] == 'NULL') AND $row['recurrence'] == 'none') {
        $type_event = $to_do_event;
    } else {
        $type_event = $personal_event;
    }

    foreach ($recurrence_dates as $dates) {

        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $dates,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'end_date' => $row['end_date'],
            'recurrence' => $row['recurrence'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $type_event
        );
    }

    $count++;
}


//Selecting events user has been invited to without recurrence

$personal_invited_event_query = "SELECT * FROM personal_event WHERE event_id IN

    (SELECT event_id FROM personal_event_invited WHERE user_id =$user_id AND choice='1')

        AND recurrence='none' AND ((start_date = '$today_date' AND end_time>'$now_time') OR (start_date > '$today_date'))

        ORDER BY start_date ASC,start_time ASC";


//echo "personal invited query: "  . $personal_invited_event_query;


$personal_invited_event_query_result = $con->query($personal_invited_event_query);


$count = 0;

while ($row = $personal_invited_event_query_result->fetch_array()) {

    if ($count == 5) {

        break;
    }

    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'end_date' => $row['end_date'],
        'recurrence' => $row['recurrence'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $personal_invited_event
    );

    $count++;
}

//Selecting events user has been invited to with recurrence

$personal_invited_event_recurrence_query = "SELECT * FROM personal_event WHERE

        event_id IN (SELECT event_id FROM personal_event_invited WHERE user_id=$user_id AND choice='1')

        AND recurrence!='none' AND end_date >= '$today_date'";


$personal_invited_event_recurrence_query_result = $con->query($personal_invited_event_recurrence_query);


//echo "personal invited recurrence query: "  . $personal_invited_event_recurrence_query;

$count = 0;

while ($row = $personal_invited_event_recurrence_query_result->fetch_array()) {

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
            'end_date' => $row['end_date'],
            'recurrence' => $row['recurrence'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $personal_invited_event
        );
    }

    $count++;
}


//Selecting club events has is part of without recurrence

$group_event_query = "SELECT
  G.*
FROM group_event G
WHERE G.event_id IN
      (SELECT
         GI.event_id
       FROM group_event_invited GI
       WHERE GI.user_id = $user_id AND GI.added = 1)
      AND (G.group_id NOT IN (SELECT
                                GU.group_id
                              FROM group_users GU
                              WHERE GU.user_id = $user_id AND GU.is_admin = 1)) AND G.recurrence = 'none' AND
      ((G.start_date = '$today_date' AND G.end_time > '$now_time') OR (G.start_date > '$today_date'))
ORDER BY start_date ASC, start_time ASC";


//echo "group query: "  . $group_event_query;


$group_event_query_result = $con->query($group_event_query);


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
        'end_date' => $row['end_date'],
        'recurrence' => $row['recurrence'],
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'type' => $group_event
    );

    $count++;
}

//
//Selecting club events invited to with recurrence

$group_event_recurrence_query = "SELECT
  G.*
FROM group_event G

WHERE G.event_id IN (SELECT
                       GI.event_id
                     FROM group_event_invited GI
                     WHERE GI.user_id = $user_id AND GI.added = '1') AND G.recurrence != 'none' AND
      G.end_date >= '$today_date' AND
      (G.group_id NOT IN (SELECT
                            GU.group_id
                          FROM group_users GU
                          WHERE GU.user_id = $user_id AND GU.is_admin = 1))";


//echo "group recurrence query: "  . $group_event_recurrence_query;

$group_event_recurrence_query_result = $con->query($group_event_recurrence_query);


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
            'end_date' => $row['end_date'],
            'recurrence' => $row['recurrence'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $group_event
        );
    }

    $count++;
}

//Selecting course events he is part of without recurrence

$course_event_query = "SELECT
  C.*
FROM course_event C
WHERE C.event_id IN
      (SELECT
         CI.event_id
       FROM course_event_invited CI
       WHERE CI.user_id = $user_id AND CI.choice = 1)
      AND (C.class_id NOT IN (SELECT
                                CU.class_id
                              FROM courses_user CU
                              WHERE CU.user_id = $user_id AND CU.is_admin = 1))
      AND C.recurrence = 'none' AND
      ((C.start_date = '$today_date' AND C.end_time > '$now_time') OR (C.start_date > '$today_date'))
ORDER BY start_date ASC, start_time ASC";


//echo "course query: "  . $course_event_query;

$course_event_query_result = $con->query($course_event_query);


$count = 0;

while ($row = mysqli_fetch_array($course_event_query_result)) {

    if ($count == 5) {

        break;
    }

    $event_id = $row['event_id'];

    $check_ischeck_query = "SELECT is_check FROM course_event_invited WHERE event_id='$event_id' AND user_id='$user_id'";

    $check_ischeck_query_result = $con->query($check_ischeck_query);

    $ischeck = mysqli_fetch_array($check_ischeck_query_result);

    $ischeck = $ischeck['is_check'];

    $result_array[] = array(
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'end_date' => $row['end_date'],
        'recurrence' => $row['recurrence'],
        'is_check' => $ischeck,
        'event_id' => $row['event_id'],
        'type' => $course_event
    );

    $count++;
}

//Selecting course events user is part of with recurrence

$course_event_recurrence_query = "SELECT
  C.*
FROM course_event C
WHERE
  C.event_id IN (SELECT
                   CI.event_id
                 FROM course_event_invited CI
                 WHERE CI.user_id = '$user_id' AND CI.choice = 1)
  AND (C.class_id NOT IN (SELECT
                            CU.class_id
                          FROM courses_user CU
                          WHERE CU.user_id = $user_id AND CU.is_admin = 1))
  AND C.end_date >= '$today_date' AND C.recurrence != 'none'";


//echo "course recurrence query: "  . $course_event_recurrence_query;


$course_event_recurrence_query_result = $con->query($course_event_recurrence_query);


$count = 0;

while ($row = mysqli_fetch_array($course_event_recurrence_query_result)) {

    if ($count == 5) {

        break;
    }

    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $today_date);

    foreach ($recurrence_dates as $dates) {

        $event_id = $row['event_id'];

        $check_ischeck_query = "SELECT is_check FROM course_event_invited WHERE event_id='$event_id' AND user_id='$user_id'";

        $check_ischeck_query_result = $con->query($check_ischeck_query);

        $ischeck = mysqli_fetch_array($check_ischeck_query_result);

        $ischeck = $ischeck['ischeck'];

        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $today_date,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'end_date' => $row['end_date'],
            'recurrence' => $row['recurrence'],
            'is_check' => $ischeck,
            'event_id' => $row['event_id'],
            'type' => $course_event
        );
    }

    $count++;
}

$course_personal_query = "SELECT
  C.*
FROM course_event C
WHERE ((C.user_id = $user_id) OR
       ((C.class_id IN (SELECT
                          CU.class_id
                        FROM courses_user CU
                        WHERE CU.user_id = $user_id AND CU.is_admin = 1)) AND
        C.made_by_admin = 1)) AND
      ((C.start_date = '$today_date' AND C.end_time > '$now_time') OR (C.start_date > '$today_date'))";
$course_personal_query_result = $con->query($course_personal_query);

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
                'end_date' => $row['end_date'],
                'recurrence' => $row['recurrence'],
                'is_check' => $row['is_check'],
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
            'end_date' => $row['end_date'],
            'recurrence' => $row['recurrence'],
            'is_check' => $row['is_check'],
            'event_id' => $row['event_id'],
            'type' => $course_event_personal
        );
    }
}


$group_personal_query = "SELECT
  G.*
FROM group_event G
WHERE ((G.user_id = $user_id) OR
       (G.group_id IN (SELECT
                         GU.group_id
                       FROM group_users GU
                       WHERE GU.user_id = $user_id AND GU.is_admin = 1) AND
        G.made_by_admin = 1)) AND
      ((G.start_date = '$today_date' AND G.start_time >= '$now_time') OR (G.start_date > '$today_date'))";
$group_personal_query_result = $con->query($group_personal_query);

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
                'end_date' => $row['end_date'],
                'recurrence' => $row['recurrence'],
                'is_check' => NULL,
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
            'end_date' => $row['end_date'],
            'recurrence' => $row['recurrence'],
            'is_check' => NULL,
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
//    print_r($result_array);


    foreach ($result_array as $event) {

        if ($event_count_show == 5) {
            break;
        }

        $user_start_timestamp = new DateTime(user_time($event['start_date'] . " " . $event['start_time']));
        $user_end_timestamp = new DateTime(user_time($event['end_date'] . " " . $event['end_time']));
        $start_date = $user_start_timestamp->format("Y-m-d");
        $end_date = $user_end_timestamp->format("Y-m-d");
        $start_time = $user_start_timestamp->format("H:i:s");
        $end_time = $user_end_timestamp->format("H:i:s");

        if ($start_date < $today_date_user) {
            continue;
        } else if ($start_date == $today_date_user) {
            if ($start_time < $now_time_user) {
                continue;
            }
        }

//        echo $event['type'];

        $event_count_show++;

        if ($prev_day !== $start_date) {

            $prev_day = $start_date;

            if (isToday1($start_date, $today_date_user)) {


                $day = $user_start_timestamp->format("M j");

                $echo_string = $echo_string . '<div class = "pl_day">

                         <div class = "fl_l"><span class = "pl_day_week">' . 'Today </span><span class = "pl_day_date">' . $day . '</span></div>

                      </div>';


                //Setting id for use when this event is deleted or checked

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                $endtime = $user_end_timestamp->format("g:i a");

                if (isNow1($start_time, $now_time_user)) {

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "current time">' . 'NOW' . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                } else {

                    $time = $user_start_timestamp->format("g:i a");

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                }
            } else if (isTomorrow1($start_date, $tommorow_date)) {

                $day = $user_start_timestamp->format("M j");

                $echo_string = $echo_string . '<div class = "pl_day">

                         <div class = "fl_l">

                            <span class = "pl_day_week">' . 'Tomorrow' . ' </span>

                            <span class = "pl_day_date">' . $day . '</span>

                         </div>

                      </div>';

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                //Setting id for use when this event is deleted or checked    

                $time = $user_start_timestamp->format("g:i a");

                $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                    </div>';
            } else {

                $day = $user_start_timestamp->format("M j");

                $date = $user_start_timestamp->format("l");

                $echo_string = $echo_string . '<div class = "pl_day">

                        <div class = "fl_l"><span class = "pl_day_week">' . $date . ' </span><span class = "pl_day_date">' . $day . '</span></div>

                      </div>';

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                //Setting id for use when this event is deleted or checked    

                $time = $user_start_timestamp->format("g:i a");

                $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                    </div>';
            }
        } else {

            if (isToday1($start_date, $today_date_user)) {

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                $endtime = $user_end_timestamp->format("g:i a");

                if (isNow1($start_time, $now_time_user)) {

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "current time">' . 'NOW' . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                } else {

                    $time = $user_start_timestamp->format("g:i a");

                    $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                        <div style="display:none;">' . $endtime . '</div>

                    </div>';
                }
            } else {

                $echo_string = $echo_string . '<div class = "upcoming upc-1" id="event' . $event['event_id'] . '">';

                //Setting id for use when this event is deleted or checked    

                $time = $user_start_timestamp->format("g:i a");

                $echo_string = $echo_string . '

                    <div class = "upc-floatL">

                        <div class = "time">' . $time . '</div>

                    </div>';
            }
        }


        $echo_string = $echo_string . '<div class = "upc-eventL">

                        <div class = "evntName" ><a href="calendar_beta.php?plnr=0&id=' . $event['event_id'] . '&type=' . $event['type'] . '">' . $event['title'] . '</a></div>

                    </div>';


        if (($event['type'] == $personal_event or $event['type'] == $course_event_personal or
                $event['type'] == $course_event or $event['type'] == $to_do_event) AND $event['recurrence'] == 'none'
        ) {

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

function isNow1($start_time, $now_time)
{
    $start_time = new DateTime($start_time);
    $now_time = new DateTime($now_time);
    $diff = $now_time->diff($start_time);
    $minutes = $diff->format('%i');
    $hours = $diff->format('%h');

    if ($minutes < 30 and $hours == 0) {

        return True;
    } else {

        return False;
    }
}

function isToday1($start_date, $today_date)
{
    if ($today_date === $start_date) {
        return True;
    } else {
        return False;
    }
}

function isTomorrow1($start_date, $tomorrow_date)
{
    if ($tomorrow_date === $start_date) {
        return True;
    } else {
        return False;
    }
}

function getDatesOfRecurrence($start_date, $end_date, $recurrenceType, $range, $today_date)
{

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
