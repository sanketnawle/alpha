<?php

include 'dbconnection.php';
require_once 'time_change.php';
require_once '../includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$event_id = 1;
$type = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = input_sanitize($_POST['event_id'], $con);
}
if (isset($_POST['type'])) {
    $type = input_sanitize($_POST['type'], $con);
}

switch ($type) {
    case 1:
    case 2:
        $table_name = "personal_event";
        break;
    case 4:
        $table_name = "group_event";
        break;
    case 6:
        $table_name = "course_event";
        break;
}

$fetch_event_query = "SELECT * FROM $table_name WHERE event_id = $event_id";
$fetch_event_query_result = $con->query($fetch_event_query);

$result_row = mysqli_fetch_array($fetch_event_query_result);
if ($type == 1 or $type == 2) {
    $invites = $result_row['invites'];
} else {
    $invites = NULL;
}

$table_name_invited = $table_name . "_invited";
$get_invited_query = "SELECT COUNT(*) AS total FROM $table_name_invited WHERE event_id=$event_id";
$get_invited_query_result = $con->query($get_invited_query);
$invited_result_row = mysqli_fetch_array($get_invited_query_result);
$count = $invited_result_row['total'];

if ($result_row['file_id'] != NULL) {
    $file_id = $result_row['file_id'];
    $fetch_file_query = "SELECT file_name from file_upload WHERE file_id= $file_id";
    $fetch_file_query_result = $con->query($fetch_file_query);
    if ($fetch_file_query_result > 0) {
        $file_result_row = mysqli_fetch_array($fetch_file_query_result);
        $file_name = $file_result_row['file_name'];
    }
} else {
    $file_id = NULL;
    $file_name = NULL;
}
if ($result_row['description'] == NULL or $result_row['description'] == 'NULL') {
    $description = "";
} else {
    $description = $result_row['description'];
}
if ($result_row['location'] == NULL or $result_row['location'] == 'NULL') {
    $location = "";
} else {
    $location = $result_row['location'];
}

$user_time_start = new DateTime(user_time($result_row['start_date'] . " " . $result_row['start_time']));
$user_time_end = new DateTime(user_time($result_row['end_date'] . " " . $result_row['end_time']));

$result_array = array(
    'title' => $result_row['title'],
    'description' => $description,
    'location' => $location,
    'start_date' => $user_time_start->format("Y-m-d"),
    'end_date' => $user_time_end->format("Y-m-d"),
    'end_time' => $user_time_end->format("H:i:s"),
    'start_time' => $user_time_start->format("H:i:s"),
    'is_check' => $result_row['is_check'],
    'recurrence' => $result_row['recurrence'],
    'invites' => $invites,
    'invite_count' => $count,
    'file_name' => $file_name,
    'file_id' => $file_id,
    'theme_id' => $result_row['theme_id'],
    'type' => $type
);

$json = array(
    'event_array' => $result_array
);

$jsonstring = json_encode($json);
echo $jsonstring;
?>