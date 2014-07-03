<?php

include 'dbconnection.php';
session_start();


$user_id = 1;
$event_id = 1;
$type = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
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

$delete_file_query = "DELETE FROM file_upload WHERE `file_id` = 
        (SELECT `file_id` FROM $table_name WHERE `event_id` = $event_id)";
$delete_file_query_result = mysqli_query($con, $delete_file_query);

if ($delete_file_query_result) {
    echo "Successfull delete";
} else {
    echo "Not deleted";
}
?>