<?php

include 'dbconnection.php';
session_start();

$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$set_personal_event_seen_query = "UPDATE personal_event_invited SET `show_notification` = 3 WHERE `user_id` = $user_id
        AND `show_notification` != 0";
$set_personal_event_seen_query_result = mysqli_query($con, $set_personal_event_seen_query);

if ($set_personal_event_seen_query_result) {
    //success
} else {
    echo "Error in updating";
}

$set_course_event_seen_query = "UPDATE course_event_invited SET `show_notification` = 3 WHERE `user_id` = $user_id
        AND `show_notification` != 0";
$set_course_event_seen_query_result = mysqli_query($con, $set_course_event_seen_query);

if ($set_course_event_seen_query_result) {
    //success
} else {
    echo "Error in updating";
}

$set_group_event_seen_query = "UPDATE group_event_invited SET `show_notification` = 3 WHERE `user_id` = $user_id
        AND `show_notification` != 0";
$set_group_event_seen_query_result = mysqli_query($con, $set_group_event_seen_query);

if ($set_group_event_seen_query_result) {
    //success
} else {
    echo "Error in updating";
}
mysqli_close($con);
?>