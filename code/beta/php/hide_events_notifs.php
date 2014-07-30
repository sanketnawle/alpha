<?php

include 'dbconnection.php';
session_start();

$user_id = 1;
$event_id = 0;
$type = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}

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

switch ($type) {
    case $to_do_event:
    case $personal_event:
        $set_personal_event_seen_query = "UPDATE personal_event SET `hide_notification` = 1 WHERE `user_id` = $user_id
            AND `event_id` = $event_id";
        $set_personal_event_seen_query_result = mysqli_query($con, $set_personal_event_seen_query);

        if ($set_personal_event_seen_query_result) {
            //success
        } else {
            echo "Error in updating";
        }
        break;
    case $course_event:
        $set_course_event_seen_query = "UPDATE course_event_invited SET `hide_notification` = 1 WHERE `user_id` = $user_id
            AND `event_id` = $event_id";
        $set_course_event_seen_query_result = mysqli_query($con, $set_course_event_seen_query);

        if ($set_course_event_seen_query_result) {
            //success
        } else {
            echo "Error in updating";
        }
        break;
    case $course_event_personal:
        $set_group_event_seen_query = "UPDATE course_event SET `hide_notification` = 1 WHERE `user_id` = $user_id
            AND `event_id` = $event_id";
        $set_group_event_seen_query_result = mysqli_query($con, $set_group_event_seen_query);

        if ($set_group_event_seen_query_result) {
            //success
        } else {
            echo "Error in updating";
        }
        break;
    default:
        echo "Never come here";
}

mysqli_close($con);
?>