<?php

include 'dbconnection.php';
include 'time_change.php';
session_start();

$user_id = 1;
$month_date = date("Y-m-d", strtotime("now"));


$grey_code = 192;
$invited_red_code = 51;
$invited_green_code = 255;
$invited_blue_code = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['month_date'])) {
    $month_date = $_POST['month_date'];
}
//echo $month_date;
//Starting of the month
$month_start = date("Y-m-01", strtotime($month_date));
//-7 days from month start
$month_start = date("Y-m-d", strtotime("-7 days", strtotime($month_start)));
//Month end
$month_end = date("Y-m-t", strtotime($month_date));
//+7 days from month start
$month_end = date("Y-m-d", strtotime("+7 days", strtotime($month_end)));



$range = $month_end;

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

$result_array = array();

//Selecting events for the user without recurrence
$personal_event_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' 
    AND `start_date` BETWEEN '$month_start' AND '$month_end' AND `recurrence`='none'
    ORDER BY start_date ASC, start_time ASC";

$personal_event_query_result = mysqli_query($con, $personal_event_query);

while ($row = mysqli_fetch_array($personal_event_query_result)) {
    $user_time_start = new DateTime(user_time($row['start_date'] . " " . $row['start_time']));
    $user_time_end = new DateTime(user_time($row['end_date'] . " " . $row['end_time']));

    if ($row['invites'] == 0 AND ($row['location'] == NULL OR $row['location'] == 'NULL') AND $row['recurrence'] == 'none') {
        $type_event = $to_do_event;
    } else {
        $type_event = $personal_event;
    }

    $result_array[] = array(
        'title' => $row['title'],
        'location' => $row['location'],
        'start_date' => $user_time_start->format("Y-m-d"),
        'end_date' => $user_time_end->format("Y-m-d"),
        'end_time' => $user_time_end->format("H:i:s"),
        'start_time' => $user_time_start->format("H:i:s"),
        'group_id' => NULL,
        'group_name' => "",
        'red_color' => $grey_code,
        'green_color' => $grey_code,
        'blue_color' => $grey_code,
        'is_check' => $row['is_check'],
        'event_id' => $row['event_id'],
        'editable' => TRUE,
        'type' => $type_event
    );
}


//Selecting events for the user with recurrence
$personal_events_recurrence_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' 
    AND `end_date` >= '$month_start' AND `recurrence`!='none' ";

$personal_events_recurrence_query_result = mysqli_query($con, $personal_events_recurrence_query);


while ($row = mysqli_fetch_array($personal_events_recurrence_query_result)) {
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
//    echo print_r($recurrence_dates);
    foreach ($recurrence_dates as $dates) {
        $user_time_start = new DateTime(user_time($dates . " " . $row['start_time']));
        $user_time_end = new DateTime(user_time($dates . " " . $row['end_time']));

        $result_array[] = array(
            'title' => $row['title'],
            'location' => $row['location'],
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'group_id' => NULL,
            'group_name' => "",
            'red_color' => $grey_code,
            'green_color' => $grey_code,
            'blue_color' => $grey_code,
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'editable' => TRUE,
            'type' => $personal_event
        );
    }
}

//
//Selecting events user has been invited to without recurrence
$personal_invited_event_query = "SELECT * FROM personal_event WHERE `event_id` IN 
    (SELECT `event_id` FROM personal_event_invited WHERE `user_id` ='$user_id' AND (`choice`='2' OR `choice`='1'))
        AND `recurrence`='none' AND `start_date` BETWEEN '$month_start' AND '$month_end'
        ORDER BY start_date ASC,start_time ASC";

//echo "personal invited query: "  . $personal_invited_event_query;

$personal_invited_event_query_result = mysqli_query($con, $personal_invited_event_query);


while ($row = mysqli_fetch_array($personal_invited_event_query_result)) {
    $user_time_start = new DateTime(user_time($row['start_date'] . " " . $row['start_time']));
    $user_time_end = new DateTime(user_time($row['end_date'] . " " . $row['end_time']));

    $result_array[] = array(
        'title' => $row['title'],
        'location' => $row['location'],
        'start_date' => $user_time_start->format("Y-m-d"),
        'end_date' => $user_time_end->format("Y-m-d"),
        'end_time' => $user_time_end->format("H:i:s"),
        'start_time' => $user_time_start->format("H:i:s"),
        'group_id' => NULL,
        'group_name' => "",
        'red_color' => $invited_red_code,
        'green_color' => $invited_green_code,
        'blue_color' => $invited_blue_code,
        'is_check' => 0,
        'event_id' => $row['event_id'],
        'editable' => FALSE,
        'type' => $personal_invited_event
    );
}


//Selecting events user has been invited to with recurrence
$personal_invited_event_recurrence_query = "SELECT * FROM personal_event WHERE
        `event_id` IN (SELECT `event_id` FROM personal_event_invited WHERE `user_id`='$user_id' AND (`choice`='2' OR `choice`='1'))
        AND `recurrence`!='none' AND `end_date` >= '$month_start'";

$personal_invited_event_recurrence_query_result = mysqli_query($con, $personal_invited_event_recurrence_query);

//echo "personal invited recurrence query: "  . $personal_invited_event_recurrence_query;

while ($row = mysqli_fetch_array($personal_invited_event_recurrence_query_result)) {
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
    foreach ($recurrence_dates as $dates) {
        $user_time_start = new DateTime(user_time($dates . " " . $row['start_time']));
        $user_time_end = new DateTime(user_time($dates . " " . $row['end_time']));

        $result_array[] = array(
            'title' => $row['title'],
            'location' => $row['location'],
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'group_id' => NULL,
            'group_name' => "",
            'red_color' => $invited_red_code,
            'green_color' => $invited_green_code,
            'blue_color' => $invited_blue_code,
            'is_check' => 0,
            'event_id' => $row['event_id'],
            'editable' => FALSE,
            'type' => $personal_invited_event
        );
    }
}
//
//Selecting club events has is part of without recurrence
$group_event_query = "SELECT E.*, G.`group_name` FROM group_event E, groups G WHERE E.`event_id` IN 
    (SELECT `event_id` FROM group_event_invited WHERE `user_id`='$user_id' AND (`added`='2' OR `added`='1'))
        AND E.`recurrence`='none' AND E.`start_date` BETWEEN '$month_start' AND '$month_end' AND E.`group_id` = G.`group_id`
        ORDER BY start_date ASC,start_time ASC";

//echo "group query: "  . $group_event_query;

$group_event_query_result = mysqli_query($con, $group_event_query);


while ($row = mysqli_fetch_array($group_event_query_result)) {
    $group_id = $row['group_id'];
    $get_color_query = "SELECT `red_code` ,`green_code`, `blue_code` FROM event_color_table WHERE `color_id` = 
        (SELECT `color_id` FROM group_users WHERE `group_id`=$group_id AND `user_id` = $user_id )";
    $get_color_query_result = mysqli_query($con, $get_color_query);
    $fetch_color = mysqli_fetch_array($get_color_query_result);
    $red_code = $fetch_color['red_code'];
    $green_code = $fetch_color['green_code'];
    $blue_code = $fetch_color['blue_code'];

    $user_time_start = new DateTime(user_time($row['start_date'] . " " . $row['start_time']));
    $user_time_end = new DateTime(user_time($row['end_date'] . " " . $row['end_time']));

    $result_array[] = array(
        'title' => $row['title'],
        'location' => $row['location'],
        'start_date' => $user_time_start->format("Y-m-d"),
        'end_date' => $user_time_end->format("Y-m-d"),
        'end_time' => $user_time_end->format("H:i:s"),
        'start_time' => $user_time_start->format("H:i:s"),
        'group_id' => $row['group_id'],
        'group_name' => $row['group_name'],
        'red_color' => $red_code,
        'green_color' => $green_code,
        'blue_color' => $blue_code,
        'is_check' => NULL,
        'event_id' => $row['event_id'],
        'editable' => FALSE,
        'type' => $group_event
    );
}
////
//Selecting club events invited to with recurrence
$group_event_recurrence_query = "SELECT E.*, G.`group_name` FROM group_event E, groups G   
        WHERE E.`event_id` IN (SELECT `event_id` FROM group_event_invited WHERE `user_id`='$user_id' 
            AND (`added`='2' OR `added`='1')) AND E.`recurrence`!='none' AND E.`end_date` >= '$month_start' 
                AND E.`group_id` = G.`group_id`";

//echo "group recurrence query: "  . $group_event_recurrence_query;
$group_event_recurrence_query_result = mysqli_query($con, $group_event_recurrence_query);


while ($row = mysqli_fetch_array($group_event_recurrence_query_result)) {
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
    $group_id = $row['group_id'];
    $get_color_query = "SELECT `red_code` ,`green_code`, `blue_code` FROM event_color_table WHERE `color_id` = 
        (SELECT `color_id` FROM group_users WHERE `group_id`=$group_id AND `user_id` = $user_id )";
    $get_color_query_result = mysqli_query($con, $get_color_query);
    $fetch_color = mysqli_fetch_array($get_color_query_result);
    $red_code = $fetch_color['red_code'];
    $green_code = $fetch_color['green_code'];
    $blue_code = $fetch_color['blue_code'];

    foreach ($recurrence_dates as $dates) {
        $user_time_start = new DateTime(user_time($dates . " " . $row['start_time']));
        $user_time_end = new DateTime(user_time($dates . " " . $row['end_time']));

        $result_array[] = array(
            'title' => $row['title'],
            'location' => $row['location'],
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'group_id' => $row['group_id'],
            'group_name' => $row['group_name'],
            'red_color' => $red_code,
            'green_color' => $green_code,
            'blue_color' => $blue_code,
            'is_check' => NULL,
            'event_id' => $row['event_id'],
            'editable' => FALSE,
            'type' => $group_event
        );
    }
}


//Selecting course events he is part of without recurrence
$course_event_query = "SELECT * FROM course_event WHERE `event_id` IN
    (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`choice`='2' OR `choice`='1'))
        AND `recurrence`='none' AND `start_date` BETWEEN '$month_start' AND '$month_end'
        ORDER BY start_date ASC,start_time ASC";

//echo "course query: "  . $course_event_query;
$course_event_query_result = mysqli_query($con, $course_event_query);


while ($row = mysqli_fetch_array($course_event_query_result)) {
    $event_id = $row['event_id'];
    $check_ischeck_query = "SELECT is_check FROM course_event_invited WHERE `event_id`='$event_id' AND `user_id`='$user_id'";
    $check_ischeck_query_result = mysqli_query($con, $check_ischeck_query);
    $ischeck = mysqli_fetch_array($check_ischeck_query_result);
    $ischeck = $ischeck['is_check'];

    $class_id = $row['class_id'];
    $course_name_query = "SELECT `course_name` FROM courses WHERE `course_id` = 
        (SELECT `course_id` FROM courses_semester WHERE `class_id` = '$class_id')";
    $course_name_query_result = mysqli_query($con, $course_name_query);
    $course_name = mysqli_fetch_array($course_name_query_result);
    $course_name = $course_name['course_name'];

    $get_color_query = "SELECT `red_code` ,`green_code`, `blue_code` FROM event_color_table WHERE `color_id` = 
        (SELECT `color_id` FROM courses_user WHERE `class_id`='$class_id' AND `user_id` = $user_id )";
    $get_color_query_result = mysqli_query($con, $get_color_query);
    $fetch_color = mysqli_fetch_array($get_color_query_result);
    $red_code = $fetch_color['red_code'];
    $green_code = $fetch_color['green_code'];
    $blue_code = $fetch_color['blue_code'];

    $user_time_start = new DateTime(user_time($row['start_date'] . " " . $row['start_time']));
    $user_time_end = new DateTime(user_time($row['end_date'] . " " . $row['end_time']));

    $result_array[] = array(
        'title' => $row['title'],
        'location' => $row['location'],
        'start_date' => $user_time_start->format("Y-m-d"),
        'end_date' => $user_time_end->format("Y-m-d"),
        'end_time' => $user_time_end->format("H:i:s"),
        'start_time' => $user_time_start->format("H:i:s"),
        'red_color' => $red_code,
        'green_color' => $green_code,
        'blue_color' => $blue_code,
        'group_id' => $row['class_id'],
        'group_name' => $course_name,
        'is_check' => $ischeck,
        'event_id' => $row['event_id'],
        'editable' => FALSE,
        'type' => $course_event
    );
}


//Selecting course events user is part of with recurrence
$course_event_recurrence_query = "SELECT * FROM course_event WHERE
    `event_id` IN (SELECT `event_id` FROM course_event_invited WHERE `user_id`='$user_id' AND (`choice`='2' OR `choice`='1'))
        AND `end_date` >= '$month_start' AND `recurrence`!='none' ";

//echo "course recurrence query: "  . $course_event_recurrence_query;

$course_event_recurrence_query_result = mysqli_query($con, $course_event_recurrence_query);


while ($row = mysqli_fetch_array($course_event_recurrence_query_result)) {
    $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
    foreach ($recurrence_dates as $dates) {
        $event_id = $row['event_id'];
        $check_ischeck_query = "SELECT is_check FROM course_event_invited WHERE `event_id`='$event_id' AND `user_id`='$user_id'";
        $check_ischeck_query_result = mysqli_query($con, $check_ischeck_query);
        $ischeck = mysqli_fetch_array($check_ischeck_query_result);
        $ischeck = $ischeck['ischeck'];

        $class_id = $row['class_id'];
        $course_name_query = "SELECT `course_name` FROM courses WHERE `course_id` = 
        (SELECT `course_id` FROM courses_semester WHERE `class_id` = '$class_id')";
        $course_name_query_result = mysqli_query($con, $course_name_query);
        $course_name = mysqli_fetch_array($course_name_query_result);
        $course_name = $course_name['course_name'];

        $get_color_query = "SELECT `red_code` ,`green_code`, `blue_code` FROM event_color_table WHERE `color_id` = 
        (SELECT `color_id` FROM courses_user WHERE `class_id`='$class_id' AND `user_id` = $user_id )";
        $get_color_query_result = mysqli_query($con, $get_color_query);
        $fetch_color = mysqli_fetch_array($get_color_query_result);
        $red_code = $fetch_color['red_code'];
        $green_code = $fetch_color['green_code'];
        $blue_code = $fetch_color['blue_code'];

        $user_time_start = new DateTime(user_time($dates . " " . $row['start_time']));
        $user_time_end = new DateTime(user_time($dates . " " . $row['end_time']));

        $result_array[] = array(
            'title' => $row['title'],
            'location' => $row['location'],
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $red_code,
            'green_color' => $green_code,
            'blue_color' => $blue_code,
            'group_id' => $row['class_id'],
            'group_name' => $course_name,
            'is_check' => $ischeck,
            'event_id' => $row['event_id'],
            'editable' => FALSE,
            'type' => $course_event
        );
    }
}

$course_personal_event_query = "SELECT * FROM course_event WHERE `user_id` = $user_id 
    AND `start_date` BETWEEN '$month_start' AND '$month_end'
        ORDER BY start_date ASC,start_time ASC";

$course_personal_event_query_result = mysqli_query($con, $course_personal_event_query);

while ($row = mysqli_fetch_array($course_personal_event_query_result)) {
    $class_id = $row['class_id'];
    $course_name_query = "SELECT `course_name` FROM courses WHERE `course_id` = 
        (SELECT `course_id` FROM courses_semester WHERE `class_id` = '$class_id')";
    $course_name_query_result = mysqli_query($con, $course_name_query);
    $course_name = mysqli_fetch_array($course_name_query_result);
    $course_name = $course_name['course_name'];

    $get_color_query = "SELECT `red_code` ,`green_code`, `blue_code` FROM event_color_table WHERE `color_id` = 
        (SELECT `color_id` FROM courses_user WHERE `class_id`='$class_id' AND `user_id` = $user_id )";
    $get_color_query_result = mysqli_query($con, $get_color_query);
    $fetch_color = mysqli_fetch_array($get_color_query_result);
    $red_code = $fetch_color['red_code'];
    $green_code = $fetch_color['green_code'];
    $blue_code = $fetch_color['blue_code'];

    if ($row['recurrence'] != 'none') {
        $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
        foreach ($recurrence_dates as $dates) {
            $user_time_start = new DateTime(user_time($dates . " " . $row['start_time']));
            $user_time_end = new DateTime(user_time($dates . " " . $row['end_time']));
            $event_id = $row['event_id'];
            $result_array[] = array(
                'title' => $row['title'],
                'location' => $row['location'],
                'start_date' => $user_time_start->format("Y-m-d"),
                'end_date' => $user_time_end->format("Y-m-d"),
                'end_time' => $user_time_end->format("H:i:s"),
                'start_time' => $user_time_start->format("H:i:s"),
                'red_color' => $red_code,
                'green_color' => $green_code,
                'blue_color' => $blue_code,
                'group_id' => $row['class_id'],
                'group_name' => $course_name,
                'is_check' => $row['is_check'],
                'event_id' => $row['event_id'],
                'editable' => TRUE,
                'type' => $course_event_personal
            );
        }
    } else {
        $user_time_start = new DateTime(user_time($row['start_date'] . " " . $row['start_time']));
        $user_time_end = new DateTime(user_time($row['end_date'] . " " . $row['end_time']));

        $result_array[] = array(
            'title' => $row['title'],
            'location' => $row['location'],
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $red_code,
            'green_color' => $green_code,
            'blue_color' => $blue_code,
            'group_id' => $row['class_id'],
            'group_name' => $course_name,
            'is_check' => $row['is_check'],
            'event_id' => $row['event_id'],
            'editable' => TRUE,
            'type' => $course_event_personal
        );
    }
}

$group_personal_event_query = "SELECT E.*, G.`group_name` FROM group_event E, groups G WHERE E.`user_id` = $user_id 
    AND E.`start_date` BETWEEN '$month_start' AND '$month_end' AND E.`group_id` = G.`group_id`
        ORDER BY start_date ASC,start_time ASC";

$group_personal_event_query_result = mysqli_query($con, $group_personal_event_query);

while ($row = mysqli_fetch_array($group_personal_event_query_result)) {
    $group_id = $row['group_id'];
    $get_color_query = "SELECT `red_code` ,`green_code`, `blue_code` FROM event_color_table WHERE `color_id` = 
        (SELECT `color_id` FROM group_users WHERE `group_id`=$group_id AND `user_id` = $user_id )";
    $get_color_query_result = mysqli_query($con, $get_color_query);
    $fetch_color = mysqli_fetch_array($get_color_query_result);
    $red_code = $fetch_color['red_code'];
    $green_code = $fetch_color['green_code'];
    $blue_code = $fetch_color['blue_code'];
    if ($row['recurrence'] != 'none') {
        $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $month_start);
        foreach ($recurrence_dates as $dates) {
            $user_time_start = new DateTime(user_time($dates . " " . $row['start_time']));
            $user_time_end = new DateTime(user_time($dates . " " . $row['end_time']));
            $event_id = $row['event_id'];
            $result_array[] = array(
                'title' => $row['title'],
                'location' => $row['location'],
                'start_date' => $user_time_start->format("Y-m-d"),
                'end_date' => $user_time_end->format("Y-m-d"),
                'end_time' => $user_time_end->format("H:i:s"),
                'start_time' => $user_time_start->format("H:i:s"),
                'red_color' => $red_code,
                'green_color' => $green_code,
                'blue_color' => $blue_code,
                'group_id' => $row['group_id'],
                'group_name' => $row['group_name'],
                'is_check' => NULL,
                'event_id' => $row['event_id'],
                'editable' => TRUE,
                'type' => $group_event_personal
            );
        }
    } else {
        $user_time_start = new DateTime(user_time($row['start_date'] . " " . $row['start_time']));
        $user_time_end = new DateTime(user_time($row['end_date'] . " " . $row['end_time']));

        $result_array[] = array(
            'title' => $row['title'],
            'location' => $row['location'],
            'start_date' => $user_time_start->format("Y-m-d"),
            'end_date' => $user_time_end->format("Y-m-d"),
            'end_time' => $user_time_end->format("H:i:s"),
            'start_time' => $user_time_start->format("H:i:s"),
            'red_color' => $red_code,
            'green_color' => $green_code,
            'blue_color' => $blue_code,
            'group_id' => $row['group_id'],
            'group_name' => $row['group_name'],
            'is_check' => NULL,
            'event_id' => $row['event_id'],
            'editable' => TRUE,
            'type' => $group_event_personal
        );
    }
}




if (count($result_array) > 0) {
//    $sort = array();
//    foreach ($result_array as $k => $v) {
//        $sort['start_date'][$k] = $v['start_date'];
//        $sort['start_time'][$k] = $v['start_time'];
//    }
//    array_multisort($sort['start_date'], SORT_ASC, $sort['start_time'], SORT_ASC, $result_array);
    $json = array(
        'events_array' => $result_array
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    $json = array(
        'events_array' => array()
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

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