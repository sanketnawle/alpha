<?php

include 'dbconnection.php';
session_start();

$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['time'])) {
    $time = $_POST['time'];
}
if (isset($_POST['date'])) {
    $date = $_POST['date'];
}

$unseen_count = 0;
$events_array = array();

$get_types = "SELECT * FROM event_types";
$get_types_result = mysqli_query($con, $get_types);

while ($row = mysqli_fetch_array($get_types_result)) {
    $event_name = $row['event_name'];
    switch ($event_name) {
        case 'to_do':
            $to_do_event = $row['type'];
            break;
        case 'personal':
            $personal_event = $row['type'];
            break;
        case 'personal_invited':
            $personal_invited_event = $row['type'];
            break;
        case 'group':
            $group_event = $row['type'];
            break;
        case 'group_personal':
            $group_event_personal = $row['type'];
            break;
        case 'course':
            $course_event = $row['type'];
            break;
        case 'course_personal':
            $course_event_personal = $row['type'];
            break;
    }
}

$personal_invited_events_notification_query = "SELECT * FROM personal_event_invited WHERE `user_id` = $user_id
        `show_notification` != 0 AND `choice`=0";
$personal_invited_events_notification_query_result = mysqli_query($con, $personal_invited_events_notification_query);

while ($row = mysqli_fetch_array($personal_invited_events_notification_query_result)) {
    if ($row['show_notification'] == 1) {
        $unseen_count++;
    }

    $event_id = $row['event_id'];
    $get_creator_query = "SELECT E.`title`, E.`time_added`, U.`firstname`,U.`lastname`, U.`profile_picture`, U.`pic_location` 
        FROM `personal_event` E, `user` U WHERE E.`user_id` = U.`user_id` AND E.`event_id` = $event_id";
    $get_creator_query_result = mysqli_query($con, $get_creator_query);

    $creator_row = mysqli_fetch_array($get_creator_query_result);
    $creator_name = $creator_row['firstname'] . " " . $creator_row['lastname'];
    $events_array[] = array(
        'creator_name' => $creator_name,
        'creator_picture' => $creator_row['profile_picture'],
        'creator_pic_loc' => $creator_row['pic_location'],
        'created_time' => $creator_row['time_added'],
        'title' => $creator_row['title'],
        'group_name' => "",
        'is_admin' => TRUE,
        'choice' => $row['choice'],
        'event_id' => $row['event_id'],
        'type' => $personal_invited_event
    );
}


$group_event_invited_query = "SELECT * FROM group_event_invited WHERE `user_id`=$user_id AND `show_notification`!=0 AND `added`=0";
$group_event_invited_query_result = mysqli_query($con, $group_event_invited_query);


while ($row = mysqli_fetch_array($group_event_invited_query_result)) {
    if ($row['show_notification'] == 1) {
        $unseen_count++;
    }

    $event_id = $row['event_id'];
    $get_creator_query = "SELECT E.`user_id`, E.`title`, E.`time_added`, U.`firstname`, U.`lastname`, U.`profile_picture`, 
        U.`pic_location` , G.`group_name`, G.`group_id` FROM `group_event` E, `user` U, groups G WHERE E.`user_id` = U.`user_id` 
        AND E.`event_id` = $event_id AND G.`group_id`=E.`group_id`";
    $get_creator_query_result = mysqli_query($con, $get_creator_query);

    $creator_row = mysqli_fetch_array($get_creator_query_result);
    $creator_name = $creator_row['firstname'] . " " . $creator_row['lastname'];
    $group_name = $creator_row['group_name'];
    $creator_id = $creator_row['user_id'];
    $group_id = $creator_row['group_id'];

    $check_admin_query = "SELECT COUNT(*) AS total FROM group_users WHERE `user_id`=$creator_id AND `group_id`=$group_id 
        AND is_admin = 1";
    $check_admin_query_result = mysqli_query($con, $check_admin_query);
    $admin_row = mysqli_fetch_array($check_admin_query_result);
    $is_admin = $admin_row['total'];


    $events_array[] = array(
        'creator_name' => $creator_name,
        'creator_picture' => $creator_row['profile_picture'],
        'creator_pic_loc' => $creator_row['pic_location'],
        'created_time' => $creator_row['time_added'],
        'title' => $creator_row['title'],
        'group_name' => $group_name,
        'is_admin' => $is_admin,
        'choice' => NULL,
        'event_id' => $row['event_id'],
        'type' => $group_event
    );
}

$course_event_invited_query = "SELECT * FROM course_event_invited WHERE `user_id`=$user_id AND `show_notification`!=0 
    AND `choice` = 0";
$course_event_invited_query_result = mysqli_query($con, $course_event_invited_query);


while ($row = mysqli_fetch_array($course_event_invited_query_result)) {
    if ($row['show_notification'] == 1) {
        $unseen_count++;
    }

    $event_id = $row['event_id'];
    $get_creator_query = "SELECT E.`user_id`, E.`title`, E.`time_added`, U.`firstname`, U.`lastname`, U.`profile_picture`, 
        U.`pic_location`, C.`course_name`, E.`class_id` FROM `course_event` E, `user` U, courses C, courses_semester CM WHERE E.`user_id` = U.`user_id` 
        AND E.`event_id` = $event_id AND E.`class_id` = CM.`class_id` AND CM.`course_id` = C.`course_id`";
    $get_creator_query_result = mysqli_query($con, $get_creator_query);

    $creator_row = mysqli_fetch_array($get_creator_query_result);
    $creator_name = $creator_row['firstname'] . " " . $creator_row['lastname'];
    $group_name = $creator_row['course_name'];
    $creator_id = $creator_row['user_id'];
    $class_id = $creator_row['class_id'];

    $check_admin_query = "SELECT COUNT(*) AS total FROM courses_user WHERE `user_id`=$creator_id AND `class_id`='$class_id' 
        AND is_admin = 1";
//    echo $check_admin_query;
    $check_admin_query_result = mysqli_query($con, $check_admin_query);
    $admin_row = mysqli_fetch_array($check_admin_query_result);
    $is_admin = $admin_row['total'];


    $events_array[] = array(
        'creator_name' => $creator_name,
        'creator_picture' => $creator_row['profile_picture'],
        'creator_pic_loc' => $creator_row['pic_location'],
        'created_time' => $creator_row['time_added'],
        'title' => $creator_row['title'],
        'group_name' => $group_name,
        'is_admin' => $is_admin,
        'choice' => $row['choice'],
        'event_id' => $row['event_id'],
        'type' => $course_event
    );
}

$sort = array();

foreach ($events_array as $k => $v) {

    $sort['created_time'][$k] = $v['created_time'];    
}



array_multisort($sort['created_time'], SORT_DESC, $events_array);

print_r($events_array);
?>