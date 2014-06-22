<?php

include 'php/dbconnection.php';

$user_id = 0;
$today_date = date("Y-m-d", strtotime("now"));

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}
if (isset($_POST['date'])) {
    $today_date = $_POST['date'];
}

$today_date_unix = strtotime($today_date);

//Starting of the month
$today_date = date("Y-m-d", strtotime($today_date));
$month_start = date("Y-m-01", strtotime($today_date));
$month_end = date("Y-m-t", strtotime($today_date));

$range = $month_end;

$personal_event = 1;
$personal_event_recurring = 2;
$personal_invited_event = 3;
$group_event = 4;
$course_event = 5;
$result_array = array();




//Selecting events for the user without recurrence
$personal_event_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' 
    AND `start_date` BETWEEN $month_start AND $month_end AND `recurrence`='none'
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
    AND `end_date` >= '$month_start' AND `recurrence`!='none' ";

//echo "personal recurring query: "  . $personal_events_recurrence_query;

$personal_events_recurrence_query_result = mysqli_query($con, $personal_events_recurrence_query);
//echo mysqli_num_rows($personal_events_recurrence_query_result);
//echo $personal_events_recurrence_query;

$count = 0;
while ($row = mysqli_fetch_array($personal_events_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $tange, $month_start);
//    echo print_r($recurrence_dates);
    foreach ($recurrence_dates as $dates) {
        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $dates,
            'start_time' => $row['start_time'],
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'type' => $personal_event_recurring
        );
    }
    $count++;
}

//Selecting events user has been invited to without recurrence
$personal_invited_event_query = "SELECT * FROM personal_event WHERE `event_id` IN 
    (SELECT `event_id` FROM personal_event_invited WHERE `user_id` ='$user_id' AND (`choice`='0' OR `choice`='1'))
        AND `recurrence`='none' AND `start_date` BETWEEN $month_start AND $month_end
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
        AND `recurrence`!='none' AND `end_date` >= '$month_start'";

$personal_invited_event_recurrence_query_result = mysqli_query($con, $personal_invited_event_recurrence_query);

//echo "personal invited recurrence query: "  . $personal_invited_event_recurrence_query;
$count = 0;
while ($row = mysqli_fetch_array($personal_invited_event_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
    foreach ($recurrence_dates as $dates) {
        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $dates,
            'start_time' => $row['start_time'],
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
        AND `recurrence`='none' AND `start_date` BETWEEN $month_start AND $month_end
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
            AND (`added`='0' OR `added`='1')) AND `recurrence`!='none' AND `end_date` >= '$month_start'";

//echo "group recurrence query: "  . $group_event_recurrence_query;
$group_event_recurrence_query_result = mysqli_query($con, $group_event_recurrence_query);

$count = 0;
while ($row = mysqli_fetch_array($group_event_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
    foreach ($recurrence_dates as $dates) {
        $result_array[] = array(
            'title' => $row['title'],
            'start_date' => $$dates,
            'start_time' => $row['start_time'],
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
        AND `recurrence`='none' AND `start_date` BETWEEN $month_start AND $month_end
        ORDER BY start_date ASC,start_time ASC";

//echo "course query: "  . $course_event_query;
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
//
//
//
//Selecting course events user is part of with recurrence
$course_event_recurrence_query = "SELECT * FROM course_event WHERE
    `event_id` IN (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`choice`='0' OR `choice`='1'))
        AND `end_date` >= '$month_start' AND `recurrence`!='none' ";

//echo "course recurrence query: "  . $course_event_recurrence_query;

$course_event_recurrence_query_result = mysqli_query($con, $course_event_recurrence_query);

$count = 0;
while ($row = mysqli_fetch_array($course_event_recurrence_query_result)) {
    if ($count == 5) {
        break;
    }
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
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
            'is_check' => $ischeck,
            'event_id' => $row['event_id'],
            'type' => $course_event
        );
    }
    $count++;
}


$sort = array();
foreach ($result_array as $k => $v) {
    $sort['start_date'][$k] = $v['start_date'];
    $sort['start_time'][$k] = $v['start_time'];
}

array_multisort($sort['start_date'], SORT_ASC, $sort['start_time'], SORT_ASC, $result_array);

function getDatesOfRecurrence($start_date, $end_date, $recurrenceType, $range, $month_start) {
    $dates = array();
    switch ($recurrenceType) {
        //Daily event
        case 'daily':
            $new_date = $start_date;
            while (TRUE) {
                if ($new_date < $month_start) {
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

?>