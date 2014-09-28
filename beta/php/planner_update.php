<?php

include 'dbconnection.php';
require_once '../includes/common_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$event_id = input_sanitize($_POST['event_id'], $con);
$event_type = input_sanitize($_POST['event_type'], $con);
$value = input_sanitize($_POST['value'], $con);


$get_types = "SELECT * FROM event_types";
$get_types_result = $con->query($get_types);


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
        $sql = "UPDATE personal_event SET is_check=$value WHERE event_id = $event_id and user_id= $user_id";
        echo $sql;
        if (!$con->query($sql)) {
            echo "Error in executing query";
        }
        break;

    //One of these queries will be successful depending on admin/non-admin
    case 6:
        $sql = "UPDATE course_event SET is_check=$value WHERE event_id = $event_id and user_id= $user_id";
        if (!$con->query($sql)) {
            echo "Error in executing query";
        }
    case 7:
        $sql = "UPDATE course_event_invited SET is_check=$value WHERE event_id = $event_id and user_id= $user_id";
        if (!$con->query($sql)) {
            echo "Error in executing query";
        }
        break;
}

$con->close();
?>