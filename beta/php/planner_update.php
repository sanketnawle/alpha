<?php

include 'dbconnection.php';


$user_id = 0;
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
}

$event_id = mysqli_escape_string($con, $_POST['event_id']);
$event_type = mysqli_escape_string($con, $_POST['event_type']);
$value = mysqli_escape_string($con, $_POST['value']);



switch ($event_type) {
    case 1:
        $sql = "UPDATE personal_event SET is_check='$value' WHERE `event_id` = $event_id and `user_id`= $user_id";
        if (!mysqli_query($con, $sql)) {

            echo "Error in executing query";
        }
        break;
    case 5:
        $sql = "UPDATE group_event_invited SET is_check='$value' WHERE `event_id` = $event_id and `user_id`= $user_id";
        if (!mysqli_query($con, $sql)) {
            echo "Error in executing query";
        }
}

mysqli_close($con);
?>