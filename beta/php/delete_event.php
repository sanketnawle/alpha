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

$delete_event_query = "DELETE from $table_name WHERE `event_id` = $event_id";
$delete_event_query_result = mysqli_query($con, $delete_event_query);



if($delete_event_query_result){
    echo "Delete Success";
}else{
    echo "Failure to delete";
}
?>