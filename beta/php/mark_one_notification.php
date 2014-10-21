<?php

include 'dbconnection.php';
require_once '../includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$event_id = 0;
$type = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = input_sanitize($_POST['event_id'], $con);
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}

echo $type;

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
    case $personal_invited_event:
        $set_personal_event_seen_query = "UPDATE personal_event_invited SET show_notification = 3 WHERE user_id = $user_id AND
            event_id = $event_id";
        $set_personal_event_seen_query_result = mysqli_query($con, $set_personal_event_seen_query);

        if ($set_personal_event_seen_query_result) {
            //success
        } else {
            echo "Error in updating";
        }
        break;
    case $course_event_personal:
    case $course_event:
        $set_course_event_seen_query = "UPDATE course_event_invited SET show_notification = 3 WHERE user_id = $user_id AND
            event_id = $event_id";
        $set_course_event_seen_query_result = mysqli_query($con, $set_course_event_seen_query);

        if ($set_course_event_seen_query_result) {
            //success
        } else {
            echo "Error in updating";
        }
        break;
    case $group_event_personal:
    case $group_event:
        $set_group_event_seen_query = "UPDATE group_event_invited SET show_notification = 3 WHERE user_id = $user_id AND
            event_id = $event_id";
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