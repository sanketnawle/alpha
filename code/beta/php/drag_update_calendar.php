<?php

include 'dbconnection.php';
session_start();
$user_id = 1;
$type = 1;
$changed_days = date("Y-m-d", strtotime("now"));


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}
if (isset($_POST['changed_days'])) {
    $changed_days = $_POST['changed_days'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}

switch ($type) {
    case 1:
    case 2:
        $get_personal_event = "SELECT * FROM personal_event WHERE `event_id`=$event_id";
        $get_personal_event_result = mysqli_query($con, $get_personal_event);
        $result_row = mysqli_fetch_array($get_personal_event_result);

        $start_date = $result_row['start_date'];
        $end_date = $result_row['end_date'];

        if (strpos($changed_days, '-') == false) {
            $changed_start_date = date("Y-m-d", strtotime("+" . $changed_days . " days", strtotime($start_date)));
            $changed_end_date = date("Y-m-d", strtotime("+" . $changed_days . " days", strtotime($end_date)));
        } else {
            $changed_start_date = date("Y-m-d", strtotime("-" . $changed_days . " days", strtotime($start_date)));
            $changed_end_date = date("Y-m-d", strtotime("-" . $changed_days . " days", strtotime($end_date)));
        }

        $update_query = "UPDATE personal_event SET `start_date`='$changed_start_date',`end_date`='$changed_end_date' WHERE `event_id`=$event_id";
        $update_query_result = mysqli_query($con, $update_query);

        if (mysqli_affected_rows($con) == 0) {
            echo "Failure";
        } else {
            echo "Success";
        }
        break;
    case 4:
        $get_group_event = "SELECT * FROM group_event WHERE `event_id`=$event_id";
        $get_group_event_result = mysqli_query($con, $get_group_event);
        $result_row = mysqli_fetch_array($get_group_event_result);

        $start_date = $result_row['start_date'];
        $end_date = $result_row['end_date'];

        if (strpos($changed_days, '-') == false) {
            $changed_start_date = date("Y-m-d", strtotime("+" . $changed_days . " days", strtotime($start_date)));
            $changed_end_date = date("Y-m-d", strtotime("+" . $changed_days . " days", strtotime($end_date)));
        } else {
            $changed_start_date = date("Y-m-d", strtotime("-" . $changed_days . " days", strtotime($start_date)));
            $changed_end_date = date("Y-m-d", strtotime("-" . $changed_days . " days", strtotime($end_date)));
        }

        $update_query = "UPDATE group_event SET `start_date`='$changed_start_date',`end_date`='$changed_end_date' WHERE `event_id`=$event_id";
        $update_query_result = mysqli_query($con, $update_query);

        if (mysqli_affected_rows($con) == 0) {
            echo "Failure";
        } else {
            echo "Success";
        }
        break;
        
    case 6:
        $get_course_event = "SELECT * FROM course_event WHERE `event_id`=$event_id";
        $get_course_event_result = mysqli_query($con, $get_course_event);
        $result_row = mysqli_fetch_array($get_course_event_result);

        $start_date = $result_row['start_date'];
        $end_date = $result_row['end_date'];

        if (strpos($changed_days, '-') == false) {
            $changed_start_date = date("Y-m-d", strtotime("+" . $changed_days . " days", strtotime($start_date)));
            $changed_end_date = date("Y-m-d", strtotime("+" . $changed_days . " days", strtotime($end_date)));
        } else {
            $changed_start_date = date("Y-m-d", strtotime("-" . $changed_days . " days", strtotime($start_date)));
            $changed_end_date = date("Y-m-d", strtotime("-" . $changed_days . " days", strtotime($end_date)));
        }

        $update_query = "UPDATE course_event SET `start_date`='$changed_start_date',`end_date`='$changed_end_date' WHERE `event_id`=$event_id";
        $update_query_result = mysqli_query($con, $update_query);

        if (mysqli_affected_rows($con) == 0) {
            echo "Failure";
        } else {
            echo "Success";
        }
        break;
}
?>