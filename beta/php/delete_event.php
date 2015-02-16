<?php

include 'dbconnection.php';
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
    case 5:
        $table_name = "group_event";
        break;
    case 6:
    case 7:
        $table_name = "course_event";
        break;
}

$delete_event_query = "DELETE from $table_name WHERE event_id = $event_id";
$delete_event_query_result = $con->query($delete_event_query);


if ($delete_event_query_result) {
    echo "Delete Success";
} else {
    echo "Failure to delete";
}
?>