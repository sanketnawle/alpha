<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 9/10/14
 * Time: 10:33 AM
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
if (isset($_POST['class_id'])) {
    $class_id = input_sanitize($_POST['class_id'], $con);
    $class_flag = true;
}
$title = input_sanitize($_POST['event_name'], $con);
$start_date = input_sanitize($_POST['event_date'], $con);
$start_time = input_sanitize($_POST['event_time'], $con);
if (isset($_POST['event_class'])) {
    $event_class = input_sanitize($_POST['event_class'], $con);
} else {
    $event_class = 'Lecture';
}

$server_time_start = server_time($start_date . " " . $start_time);

$start_date = date("Y-m-d", strtotime($server_time_start));
$start_time = date("H:i:s", strtotime($server_time_start));

if ($user_type == 'p') {
    $get_prof_query = "SELECT COUNT(class_id) as admin_flag FROM courses_semester WHERE class_id = '$class_id' AND professor = $user_id UNION ALL (SELECT COUNT(class_id) as admin_flag FROM courses_user WHERE  class_id = '$class_id' AND user_id = $user_id AND is_admin = 1)";
    $get_prof_query_result = $con->query($get_prof_query);
    while ($prof_row = $get_prof_query_result->fetch_array()) {
        $admin_flag = $prof_row['admin_flag'] + $admin_flag;
    }
} else {
    $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM courses_user WHERE class_id ='$class_id' AND user_id = $user_id AND is_admin = 1";
    $get_admin_flag_query_result = $con->query($get_admin_flag_query);
    $admin_row = $get_admin_flag_query_result->fetch_array();
    $admin_flag = $admin_row['admin_flag'];
}

if ($admin_flag > 0) {
    $made_by_admin = 1;

    $insert_event_query = $con->prepare("INSERT INTO course_event (class_id, title, start_time, user_id, end_time, start_date, end_date, event_class,made_by_admin ) VALUES (?,?,?,?,?,?,?,?,?)");
    if (!$insert_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_event_query->bind_param("sssissssi", $class_id, $title, $start_time, $user_id, $start_time, $start_date, $start_date, $event_class, $made_by_admin);
    if (!$insert_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_event_query->execute();
    if (!$insert_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_event_query->close();
    $inserted_event_id = $con->insert_id;

    $insert_course_user_event_query = $con->prepare("INSERT INTO course_event_invited (event_id, user_id, choice) (SELECT $inserted_event_id, user_id, 1 FROM courses_user WHERE class_id = ? AND user_id != $user_id)");
    if (!$insert_course_user_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_course_user_event_query->bind_param("s", $class_id);
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

    $insert_event_query = $con->prepare("INSERT INTO course_event (class_id, title, start_time, user_id, end_time, start_date, end_date, event_class,made_by_admin ) VALUES (?,?,?,?,?,?,?,?,?)");
    if (!$insert_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_event_query->bind_param("sssissssi", $class_id, $title, $start_time, $user_id, $start_time, $start_date, $start_date, $event_class, $made_by_admin);
    if (!$insert_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_event_query->execute();
    if (!$insert_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_event_query->close();
}

include_once('class_planner_events.php');

?>