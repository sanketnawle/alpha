<?php

include 'dbconnection.php';
require_once 'time_change.php';
require_once '../includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$up_id = NULL;
$location = NULL;
$details = NULL;
$repeat = 'none';
$connections = array();
$event_type = 2;
$theme_id = 1;
$grey_color = 192;


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (isset($_POST['month_date'])) {
    $month_date = $_POST['month_date'];
}
//Starting of the month
$month_start = date("Y-m-01", strtotime($month_date));
//-7 days from month start
$month_start = date("Y-m-d", strtotime("-7 days", strtotime($month_start)));
//Month end
$month_end = date("Y-m-t", strtotime($month_date));
//+7 days from month start
$month_end = date("Y-m-d", strtotime("+7 days", strtotime($month_end)));

$range = $month_end;

if (isset($_POST['title'])) {
    $title_original = $_POST['title'];
    $title = input_sanitize($_POST['title'], $con);
}
if (isset($_POST['location'])) {
    $location_original = $_POST['location'];
    $location = input_sanitize($_POST['location'], $con);
    if ($location == '') {
        $location = NULL;
        $location_original = NULL;
    }
}
if (isset($_POST['details'])) {
    $details_original = $_POST['details'];
    $details = input_sanitize($_POST['details'], $con);
    if ($details == '') {
        $details = NULL;
        $details_original = NULL;
    }
}
if (isset($_POST['theme_id'])) {
    $theme_id = input_sanitize($_POST['theme_id'], $con);
    if ($theme_id == "") {
        $theme_id = 1;
    }
}
if (isset($_POST['start_date'])) {
    $start_date = input_sanitize($_POST['start_date'], $con);
}
if (isset($_POST['start_time'])) {
    $start_time = input_sanitize($_POST['start_time'], $con);
}
if (isset($_POST['end_time'])) {
    $end_time = input_sanitize($_POST['end_time'], $con);
    if ($end_time < $start_time) {
        $end_time = $start_time;
    }
}
if (isset($_POST['repeat'])) {
    $repeat = input_sanitize($_POST['repeat'], $con);
}
if (isset($_POST['end_date'])) {
    $end_date = $_POST['end_date'];
    if ($end_date == '' OR $end_date < $start_date) {
        $end_date = $start_date;
    }
} else {
    $end_date = $start_date;
}
if (isset($_POST['connections'])) {
    $connections = $_POST['connections'];
    if ($connections == '') {
        $connections = array();
    }
}

include 'file_ops.php';
if (count($connections) > 0) {
    $invites = 1;
} else {
    $invites = 0;
}
$server_time_start = server_time($start_date . " " . $start_time);
$server_time_end = server_time($end_date . " " . $end_time);

$start_date = date("Y-m-d", strtotime($server_time_start));
$end_date = date("Y-m-d", strtotime($server_time_end));
$start_time = date("H:i:s", strtotime($server_time_start));
$end_time = date("H:i:s", strtotime($server_time_end));

if ($up_id != NULL) {

    $event_insert_query = "INSERT INTO personal_event (`user_id`, `title`, `description`, `start_time`, `end_time`, `invites`, 
    `recurrence`, `start_date`, `end_date`, `file_id`, `location`, `theme_id`)
    VALUES ($user_id, '$title', '$details', '$start_time', '$end_time', $invites, '$repeat', '$start_date', '$end_date',
       $up_id, '$location', $theme_id)";

    $event_insert_query_result = mysqli_query($con, $event_insert_query);
    $inserted_event_id = mysqli_insert_id($con);

    foreach ($connections as $user) {
        $insert_for_user_query = "INSERT INTO personal_event_invited (`user_id`, `event_id`) VALUES ($user, $inserted_event_id)";
        $insert_for_user_query_result = mysqli_query($con, $insert_for_user_query);
    }
    if ($repeat != 'none') {
        $recurrence_dates = getDatesOfRecurrence($start_date, $end_date, $repeat, $range, $month_start);
        foreach ($recurrence_dates as $dates) {
            $user_time_start = new DateTime(user_time($dates . " " . $start_time));
            $user_time_end = new DateTime(user_time($dates . " " . $end_time));
            $result_array[] = array(
                'title' => $title_original,
                'location' => $location_original,
                'start_date' => $user_time_start->format("Y-m-d"),
                'end_date' => $user_time_end->format("Y-m-d"),
                'end_time' => $user_time_end->format("H:i:s"),
                'start_time' => $user_time_start->format("H:i:s"),
                'red_color' => $grey_color,
                'green_color' => $grey_color,
                'blue_color' => $grey_color,
                'is_check' => 0,
                'event_id' => $inserted_event_id,
                'editable' => TRUE,
                'type' => $event_type
            );
        }
    } else {
        $user_time_start = new DateTime(user_time($start_date . " " . $start_time));
        $user_time_end = new DateTime(user_time($end_date . " " . $end_time));

        $result_array[] = array(
            'title' => $title_original,
            'location' => $location_original,
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $grey_color,
            'green_color' => $grey_color,
            'blue_color' => $grey_color,
            'is_check' => 0,
            'event_id' => $inserted_event_id,
            'editable' => TRUE,
            'type' => $event_type
        );
    }
} else if ($up_id == NULL) {

    $event_insert_query = "INSERT INTO personal_event (`user_id`, `title`, `description`, `start_time`, `end_time`, `invites`, 
    `recurrence`, `start_date`, `end_date`,`location`, `theme_id`) VALUES ($user_id, '$title', '$details', 
        '$start_time', '$end_time', $invites, '$repeat', '$start_date','$end_date','$location', $theme_id)";

    $event_insert_query_result = mysqli_query($con, $event_insert_query);
    $inserted_event_id = mysqli_insert_id($con);

    foreach ($connections as $user) {
        $insert_for_user_query = "INSERT INTO personal_event_invited (`user_id`, `event_id`) VALUES ($user, $inserted_event_id)";
        $insert_for_user_query_result = mysqli_query($con, $insert_for_user_query);
    }
    if ($repeat != 'none') {
        $recurrence_dates = getDatesOfRecurrence($start_date, $end_date, $repeat, $range, $month_start);
        foreach ($recurrence_dates as $dates) {
            $user_time_start = new DateTime(user_time($dates . " " . $start_time));
            $user_time_end = new DateTime(user_time($dates . " " . $end_time));
            $result_array[] = array(
                'title' => $title_original,
                'location' => $location_original,
                'start_date' => $user_time_start->format("Y-m-d"),
                'end_date' => $user_time_end->format("Y-m-d"),
                'end_time' => $user_time_end->format("H:i:s"),
                'start_time' => $user_time_start->format("H:i:s"),
                'red_color' => $grey_color,
                'green_color' => $grey_color,
                'blue_color' => $grey_color,
                'is_check' => 0,
                'event_id' => $inserted_event_id,
                'editable' => TRUE,
                'type' => $event_type
            );
        }
    } else {
        $user_time_start = new DateTime(user_time($start_date . " " . $start_time));
        $user_time_end = new DateTime(user_time($end_date . " " . $end_time));

        $result_array[] = array(
            'title' => $title_original,
            'location' => $location_original,
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $grey_color,
            'green_color' => $grey_color,
            'blue_color' => $grey_color,
            'is_check' => 0,
            'event_id' => $inserted_event_id,
            'editable' => TRUE,
            'type' => $event_type
        );
    }
} else {
    if ($up_id == -1) {
        echo "Maximum size exceeded.";
    }
}

$json = array(
    'events_array' => $result_array
);

$jsonstring = json_encode($json);
echo $jsonstring;

function getDatesOfRecurrence($start_date, $end_date, $recurrenceType, $range, $month_start)
{
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
                if ($new_date < $month_start) {
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
                if ($new_date < $month_start) {
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