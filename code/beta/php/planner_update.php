<?php

include 'dbconnection.php';
include "redirect.php";

$user_id = 1;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$event_id = mysqli_escape_string($con, $_POST['event_id']);
$event_id = (int) $event_id;
$event_type = mysqli_escape_string($con, $_POST['event_type']);
$event_type = (int) $event_type;
$value = mysqli_escape_string($con, $_POST['value']);


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


switch ($event_type) {
    case 1:
    case 2:
        $sql = "UPDATE personal_event SET is_check=$value WHERE `event_id` = $event_id and `user_id`= $user_id";
        echo $sql;
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        }
        break;
    case 6:
        $sql = "UPDATE course_event SET is_check=$value WHERE `event_id` = $event_id and `user_id`= $user_id";
        echo $sql;
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        }
        break;
    case 7:
        $sql = "UPDATE course_event_invited SET is_check=$value WHERE `event_id` = $event_id and `user_id`= $user_id";
        echo $sql;
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        }
        break;
}

mysqli_close($con);
?>