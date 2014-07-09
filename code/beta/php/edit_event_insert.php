<?php

include 'dbconnection.php';
include 'time_change.php';
session_start();


$user_id = 1;
$event_id = 1;
$up_id = NULL;
$location = NULL;
$details = NULL;
$repeat = 'none';
$file_flag = FALSE;
$connections = array();
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

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['title'])) {
    $title = $_POST['title'];
}
if (isset($_POST['location'])) {
    $location = $_POST['location'];
    if ($location == '') {
        $location = NULL;
    }
}
if (isset($_POST['details'])) {
    $details = $_POST['details'];
    if ($details == '') {
        $details = NULL;
    }
}
if (isset($_POST['start_date'])) {
    $start_date = $_POST['start_date'];
}
if (isset($_POST['start_time'])) {
    $start_time = $_POST['start_time'];
}
if (isset($_POST['end_time'])) {
    $end_time = $_POST['end_time'];
}
if (isset($_POST['repeat'])) {
    $repeat = $_POST['repeat'];
}
if (isset($_POST['end_date'])) {
    $end_date = $_POST['end_date'];
    if ($end_date == '') {
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
if (isset($_POST['theme_id'])) {
    $theme_id = $_POST['theme_id'];
    if ($theme_id == "") {
        $theme_id = 1;
    }
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}
if (isset($_POST['file_flag'])) {
    $file_flag = $_POST['file_flag'];
}

switch ($type) {
    case 1:
    case 2:
        $table_name = "personal_event";
        $red_code = $grey_color;
        $green_code = $grey_color;
        $blue_code = $grey_color;
        break;
    case 4:
        $table_name = "group_event";
        $get_color_query = "SELECT * FROM event_color_table WHERE `color_id` = 
            (SELECT `color_id` FROM group_users WHERE `group_id` = 
            (SELECT `group_id` FROM group_event WHERE `event_id` = $event_id))";
        $get_color_query_result = mysqli_query($con, $get_color_query);
        $result_row = mysqli_fetch_array($get_color_query_result);
        $red_code = $result_row['red_code'];
        $green_code = $result_row['green_code'];
        $blue_code = $result_row['blue_code'];

        break;
    case 6:
        $table_name = "course_event";
        $get_color_query = "SELECT * FROM event_color_table WHERE `color_id` = 
            (SELECT `color_id` FROM courses_user WHERE `class_id` = 
            (SELECT `class_id` FROM course_event WHERE `event_id` = $event_id))";
        $get_color_query_result = mysqli_query($con, $get_color_query);
        $result_row = mysqli_fetch_array($get_color_query_result);
        $red_code = $result_row['red_code'];
        $green_code = $result_row['green_code'];
        $blue_code = $result_row['blue_code'];
        break;
}
if ($file_flag == TRUE) {

    $delete_file_query = "DELETE FROM file_upload WHERE `file_id` = 
        (SELECT `file_id` FROM $table_name WHERE `event_id` = $event_id)";
    $delete_file_query_result = mysqli_query($con, $delete_file_query);
    include 'fileupload.php';
}

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
    if ($type == 1 or $type == 2) {
        $event_insert_query = "UPDATE $table_name SET `title`= '$title', `description`= '$details', `start_time`= '$start_time', 
        `end_time` = '$end_time', `invites` = $invites, `recurrence` = '$repeat', `start_date` = '$start_date', 
            `end_date` = '$end_date', `file_id` = $up_id, `location` = '$location', `theme_id` = $theme_id 
                WHERE `event_id` = $event_id";
    } else {
        $event_insert_query = "UPDATE $table_name SET `title`= '$title', `description`= '$details', `start_time`= '$start_time', 
        `end_time` = '$end_time', `recurrence` = '$repeat', `start_date` = '$start_date', 
            `end_date` = '$end_date', `file_id` = $up_id, `location` = '$location', `theme_id` = $theme_id 
                WHERE `event_id` = $event_id";
    }

    $event_insert_query_result = mysqli_query($con, $event_insert_query);

    $table_name_invited = $table_name . "_invited";

    foreach ($connections as $user) {
        $insert_for_user_query = "INSERT IGNORE INTO $table_name_invited (`user_id`, `event_id`) VALUES ($user, $event_id)";
        $insert_for_user_query_result = mysqli_query($con, $insert_for_user_query);
    }

    if ($repeat != 'none') {
        $recurrence_dates = getDatesOfRecurrence($start_date, $end_date, $repeat, $range, $month_start);
        foreach ($recurrence_dates as $dates) {
            $user_time_start = new DateTime(user_time($dates . " " . $start_time));
            $user_time_end = new DateTime(user_time($dates . " " . $end_time));
            $result_array[] = array(
                'title' => $title,
                'location' => $location,
                'start_date' => $user_time_start->format("Y-m-d"),
                'end_date' => $user_time_end->format("Y-m-d"),
                'end_time' => $user_time_end->format("H:i:s"),
                'start_time' => $user_time_start->format("H:i:s"),
                'red_color' => $red_code,
                'green_color' => $green_code,
                'blue_color' => $blue_code,
                'is_check' => 0,
                'event_id' => $event_id,
                'editable' => TRUE,
                'type' => $type
            );
        }
    } else {
        $user_time_start = new DateTime(user_time($start_date . " " . $start_time));
        $user_time_end = new DateTime(user_time($end_date . " " . $end_time));

        $result_array[] = array(
            'title' => $title,
            'location' => $location,
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $red_code,
            'green_color' => $green_code,
            'blue_color' => $blue_code,
            'is_check' => 0,
            'event_id' => $event_id,
            'editable' => TRUE,
            'type' => $type
        );
    }
} else if ($up_id == NULL) {
    if ($type == 1 or $type == 2) {
        $event_insert_query = "UPDATE $table_name SET `title`= '$title', `description`= '$details', `start_time`= '$start_time', 
        `end_time` = '$end_time', `invites` = $invites, `recurrence` = '$repeat', `start_date` = '$start_date', 
            `end_date` = '$end_date', `location` = '$location', `theme_id` = $theme_id 
                WHERE `event_id` = $event_id";
    } else {
        $event_insert_query = "UPDATE $table_name SET `title`= '$title', `description`= '$details', `start_time`= '$start_time', 
        `end_time` = '$end_time', `recurrence` = '$repeat', `start_date` = '$start_date', 
            `end_date` = '$end_date', `location` = '$location', `theme_id` = $theme_id 
                WHERE `event_id` = $event_id";
    }

    $event_insert_query_result = mysqli_query($con, $event_insert_query);

    $table_name_invited = $table_name . "_invited";

    foreach ($connections as $user) {
        $insert_for_user_query = "INSERT IGNORE INTO $table_name_invited (`user_id`, `event_id`) VALUES ($user, $event_id)";
        $insert_for_user_query_result = mysqli_query($con, $insert_for_user_query);
    }
    if ($repeat != 'none') {
        $recurrence_dates = getDatesOfRecurrence($start_date, $end_date, $repeat, $range, $month_start);
        foreach ($recurrence_dates as $dates) {
            $user_time_start = new DateTime(user_time($dates . " " . $start_time));
            $user_time_end = new DateTime(user_time($dates . " " . $end_time));
            $result_array[] = array(
                'title' => $title,
                'location' => $location,
                'start_date' => $user_time_start->format("Y-m-d"),
                'end_date' => $user_time_end->format("Y-m-d"),
                'end_time' => $user_time_end->format("H:i:s"),
                'start_time' => $user_time_start->format("H:i:s"),
                'red_color' => $red_code,
                'green_color' => $green_code,
                'blue_color' => $blue_code,
                'is_check' => 0,
                'event_id' => $event_id,
                'editable' => TRUE,
                'type' => $type
            );
        }
    } else {
        $user_time_start = new DateTime(user_time($start_date . " " . $start_time));
        $user_time_end = new DateTime(user_time($end_date . " " . $end_time));

        $result_array[] = array(
            'title' => $title,
            'location' => $location,
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $red_code,
            'green_color' => $green_code,
            'blue_color' => $blue_code,
            'is_check' => 0,
            'event_id' => $event_id,
            'editable' => TRUE,
            'type' => $type
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