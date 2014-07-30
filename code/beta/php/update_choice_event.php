<?php

include 'dbconnection.php';
session_start();

$user_id = 1;
$event_id = 0;
$type = 0;
$value = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}
if (isset($_POST['value'])) {
    $value = $_POST['value'];
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
    }
}

switch ($type) {
    case $personal_invited_event:
        $sql = "UPDATE personal_event_invited SET choice=$value, show_notification=0 WHERE `event_id` = $event_id and `user_id`= $user_id";
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        } else {
            echo "Success";
        }
        break;
    case $course_event:
        $sql = "UPDATE course_event_invited SET choice=$value, show_notification=0 WHERE `event_id` = $event_id and `user_id`= $user_id";
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        } else {
            echo "Success";
        }
        break;
    case $group_event:
        $sql = "UPDATE group_event_invited SET added=$value, show_notification=0 WHERE `event_id` = $event_id and `user_id`= $user_id";
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        } else {
            echo "Success";
        }
        break;
}

mysqli_close($con);
?>