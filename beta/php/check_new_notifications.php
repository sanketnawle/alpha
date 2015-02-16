<?php

include 'dbconnection.php';
session_start();

$user_id = 285;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$get_count_notifs_query = "SELECT COUNT(*) as count FROM personal_event_invited WHERE `show_notification` = 1 AND `user_id` = $user_id";
$get_count_notifs_query_result = mysqli_query($con, $get_count_notifs_query);

$count_row = mysqli_fetch_array($get_count_notifs_query_result);
$count = $count_row['count'];

$get_count_notifs_query = "SELECT COUNT(*) as count FROM course_event_invited WHERE `show_notification` = 1 AND `user_id` = $user_id";
$get_count_notifs_query_result = mysqli_query($con, $get_count_notifs_query);

$count_row = mysqli_fetch_array($get_count_notifs_query_result);
$count1 = $count_row['count'];

$get_count_notifs_query = "SELECT COUNT(*) as count FROM group_event_invited WHERE `show_notification` = 1 AND `user_id` = $user_id";
$get_count_notifs_query_result = mysqli_query($con, $get_count_notifs_query);

$count_row = mysqli_fetch_array($get_count_notifs_query_result);
$count2 = $count_row['count'];

mysqli_close($con);
echo $count + $count1 + $count2;


?>