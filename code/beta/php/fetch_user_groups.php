<?php

include 'dbconnection.php';
session_start();

$user_id = 1;
$course_array = array();
$group_array = array();
$current_semester = 'fall';
$month_date = date("Y-m-d", strtotime("now"));

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_SESSION['current_semester'])) {
    $current_semester = $_SESSION['current_semester'];
}
if (isset($_POST['month_date'])) {
    $month_date = $_POST['month_date'];
}
//echo $month_date;
//Starting of the month
$month_start = date("Y-m-01", strtotime($month_date));
//-7 days from month start
$month_start = date("Y-m-d", strtotime("-7 days", strtotime($month_start)));
//Month end
$month_end = date("Y-m-t", strtotime($month_date));
//+7 days from month start
$month_end = date("Y-m-d", strtotime("+7 days", strtotime($month_end)));



$range = $month_end;

$current_year = date("Y", strtotime("now"));

$get_group_query = "SELECT G.`group_name`, CO.`red_code` ,CO.`green_code`, CO.`blue_code`, G.`group_id`
    FROM groups G, group_users U, event_color_table CO
    WHERE G.`group_id`= U.`group_id` AND U.`user_id` = $user_id AND U.`color_id` = CO.`color_id` 
        AND G.`group_id` IN (SELECT `group_id` FROM group_event WHERE `user_id` = $user_id 
            AND `start_date` >= '$month_start' AND `end_date` <= '$month_end')";
$get_group_query_result = mysqli_query($con, $get_group_query);

while ($row = mysqli_fetch_array($get_group_query_result)) {
    $group_array[] = array(
        'group_name' => $row['group_name'],
        'group_id' => $row['group_id'],
        'red_color' => $row['red_code'],
        'green_color' => $row['green_code'],
        'blue_color' => $row['blue_code']
    );
}

$get_course_query = "SELECT C.`course_name`, CO.`red_code` ,CO.`green_code`, CO.`blue_code`, CM.`class_id`
    FROM courses C, courses_semester CM, courses_user U, event_color_table CO WHERE U.`user_id` = $user_id 
        AND U.`class_id` = CM.`class_id` AND CM.`course_id` = C.`course_id` AND U.`color_id` = CO.`color_id`
        AND CM.`semester` = '$current_semester' AND CM.`year` = $current_year 
        AND CM.`class_id` IN (SELECT `class_id` FROM course_event WHERE `user_id` = $user_id 
        AND `start_date` >= '$month_start' AND `end_date` <= '$month_end')";
$get_course_query_result = mysqli_query($con, $get_course_query);

while ($row = mysqli_fetch_array($get_course_query_result)) {
    $course_array[] = array(
        'course_name' => $row['course_name'],
        'class_id' => $row['class_id'],
        'red_color' => $row['red_code'],
        'green_color' => $row['green_code'],
        'blue_color' => $row['blue_code']
    );
}

$json = array(
    'course_array' => $course_array,
    'group_array' => $group_array
);

$jsonstring = json_encode($json);
echo $jsonstring;
?>