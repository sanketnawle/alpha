<?php

include 'dbconnection.php';
include 'time_change.php';
session_start();

$user_id = 1;
$group_id = 1;
$event_id = 1;

//if (isset($_SESSION['user_id'])) {
//    $user_id = $_SESSION['user_id'];
//}
//if (isset($_GET['group_id'])) {
//    $group_id = $_GET['group_id'];
//}
//if (isset($_POST['title'])) {
//    $title = mysqli_escape_string($con, htmlspecialchars($_POST['title']));
//}
//if (isset($_POST['details'])) {
//    $details = mysqli_escape_string($con, htmlspecialchars($_POST['details']));
//    if ($details == '') {
//        $details = NULL;
//    }
//}
//if (isset($_POST['location'])) {
//    $location = mysqli_escape_string($con, htmlspecialchars($_POST['location']));
//    if ($location == '') {
//        $location = NULL;
//    }
//}
//if (isset($_POST['start_date'])) {
//    $start_date = $_POST['start_date'];
//}
//if (isset($_POST['start_time'])) {
//    $start_time = $_POST['start_time'];
//}
//if (isset($_POST['end_date'])) {
//    $end_date = $_POST['end_date'];
//    if ($end_date == '' OR $end_date < $start_date) {
//        $end_date = $start_date;
//    }
//} else {
//    $end_date = $start_date;
//}
//if (isset($_POST['end_time'])) {
//    $end_time = $_POST['end_time'];
//    if ($end_time < $start_time) {
//        $end_time = $start_time;
//    }
//}
//if (isset($_POST['repeat'])) {
//    $repeat = $_POST['repeat'];
//}
//if (isset($_POST['theme_id'])) {
//    $theme_id = $_POST['theme_id'];
//    if ($theme_id == "") {
//        $theme_id = 1;
//    }
//}
//include 'fileupload.php';

$check_group_admin_query = "SELECT COUNT(*) as total FROM group_users WHERE `user_id`=$user_id AND `is_admin`= 1 
    AND `group_id`=$group_id";
$check_group_admin_query_result = mysqli_query($con, $check_group_admin_query);
$result_row = mysqli_fetch_array($check_group_admin_query_result);

if ($result_row['total'] == 0) {
    $added = 0;
} else {
    $added = 1;
}
$show_notification = 1;

$insert_event_query = $con->prepare("INSERT INTO group_event_invited (`event_id`, `user_id`, `added`, `show_notification`)
    SELECT ?, `user_id`, ?, ? FROM group_users WHERE `group_id` = ? AND `user_id` != ?");
if (!$insert_event_query) {
    echo "Failed prepare: " . $con->error;
}
//$insert_event_query->bind_param("iiii", $event_id, $added, $show_notification, $group_id);
if (!$insert_event_query->bind_param("iiiii", $event_id, $added, $show_notification, $group_id, $user_id)) {
    echo "Failed binding: " . $con->error;
}
//$insert_event_query->execute();
if (!$insert_event_query->execute()) {
    echo "Failed binding: " . $con->error;
}
$insert_event_query->close();
?>