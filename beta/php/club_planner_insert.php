<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 9/10/14
 * Time: 10:54 AM
 */

include 'dbconnection.php';
require_once 'time_change.php';
require_once '../includes/common_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//$class_flag = false;
//$group_flag = false;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_POST['club_id'])) {
    $group_id = input_sanitize($_POST['club_id'], $con);
    $group_flag = true;
}
$title = input_sanitize($_POST['event_name'], $con);
$start_date = input_sanitize($_POST['event_date'], $con);
$start_time = input_sanitize($_POST['event_time'], $con);

$server_time_start = server_time($start_date . " " . $start_time);

$start_date = date("Y-m-d", strtotime($server_time_start));
$start_time = date("H:i:s", strtotime($server_time_start));

$check_admin_query = "SELECT COUNT(*) as total FROM group_users WHERE group_id = $group_id AND is_admin = 1 AND user_id = $user_id";
$check_admin_query_result = $con->query($check_admin_query);
$admin_row = $check_admin_query_result->fetch_array();
$admin_flag = $admin_row['total'];

if ($admin_flag > 0) {
    $made_by_admin = 1;

    $insert_event_query = $con->prepare("INSERT INTO group_event (group_id, title, start_time, user_id, end_time, start_date, end_date, made_by_admin ) VALUES (?,?,?,?,?,?,?,?)");
    if (!$insert_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_event_query->bind_param("ississsi", $group_id, $title, $start_time, $user_id, $start_time, $start_date, $start_date, $made_by_admin);
    if (!$insert_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_event_query->execute();
    if (!$insert_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_event_query->close();
    $inserted_event_id = $con->insert_id;

    $insert_course_user_event_query = $con->prepare("INSERT INTO group_event_invited (event_id, user_id, added) (SELECT $inserted_event_id, user_id, 1 FROM group_users WHERE group_id = ? AND user_id != ?)");
    if (!$insert_course_user_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_course_user_event_query->bind_param("ii", $group_id, $user_id);
    if (!$insert_course_user_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_course_user_event_query->execute();
    if (!$insert_course_user_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_course_user_event_query->close();
} else {
    $made_by_admin = 0;

    $insert_event_query = $con->prepare("INSERT INTO group_event (group_id, title, start_time, user_id, end_time, start_date, end_date, made_by_admin ) VALUES (?,?,?,?,?,?,?,?)");
    if (!$insert_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_event_query->bind_param("ississsi", $group_id, $title, $start_time, $user_id, $start_time, $start_date, $start_date, $made_by_admin);
    if (!$insert_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_event_query->execute();
    if (!$insert_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_event_query->close();
    $inserted_event_id = $con->insert_id;
}

include_once('club_planner_events.php');
?>