<?php

include 'dbconnection.php';

$user_id = 0;
$end_date = 'NULL';
$file_name = 'NULL';
$file_location = 'NULL';
$location = 'NULL';
$details = 'NULL';
$repeat = 'none';

if (isset($_POST['title'])) {
    $title = $_POST['title'];
}
if (isset($_POST['location'])) {
    $location = $_POST['location'];
}
if (isset($_POST['details'])) {
    $details = $_POST['details'];
}
if (isset($_POST['start_date'])) {
    $start_date = $_POST['start_date'];
}
if (isset($_POST['start_time'])) {
    $start_time = $_POST['start_time'];
}
if (isset($_POST['end_time'])) {
    $end_time = $_POST['end_time'];
}
if (isset($_POST['repeat'])) {
    $repeat = $_POST['repeat'];
}
if (isset($_POST['end_date'])) {
    $end_date = $_POST['end_date'];
}
if (isset($_POST['connections'])) {
    $connections = $_POST['connections'];
}
if (isset($_POST['file_location'])) {
    $file_location = $_POST['file_location'];
}
if (isset($_POST['file_name'])) {
    $file_name = $_POST['file_name'];
}

if (count($connections) > 0) {
    $invites = 1;
} else {
    $invites = 0;
}
$file_name = 'NULL';
$file_location = 'NULL';

$start_date = date("Y-m-d", strtotime($start_date));
$end_date = date("Y-m-d", strtotime($end_date));
$start_time = date("H:i:s", strtotime($start_time));
$end_time = date("H:i:s", strtotime($end_time));

$event_insert_query = "INSERT INTO personal_event (`user_id`, `title`, `description`, `start_time`, `end_time`, `invites`, 
    `recurrence`, `start_date`, `end_date`, `file_name`, `file_location`, `location`)
    VALUES ($user_id, '$title', '$details', '$start_time', '$end_time', $invites, '$repeat', '$start_date', '$end_date',
        '$file_name', '$file_location', '$location')";

//echo $event_insert_query;

$event_insert_query_result = mysqli_query($con, $event_insert_query);
//
$inserted_event_id = mysqli_insert_id($con);

foreach ($connections as $user) {
    $insert_for_user_query = "INSERT INTO personal_event_invited (`user_id`, `event_id`) VALUES ($user, $inserted_event_id)";
    $insert_for_user_query_result = mysqli_query($con, $insert_for_user_query);
}
?>