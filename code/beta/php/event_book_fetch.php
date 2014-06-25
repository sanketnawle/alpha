<?php

include 'dbconnection.php';
session_start();
$user_id = 1;
$event_id = 0;
$now_time = "00:00:00";
$today_date = date("Y-m-d", strtotime("now"));

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['time'])) {
    $now_time = $_POST['time'];
}
if (isset($_POST['date'])) {
    $today_date = $_POST['date'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}

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


$result_array = array();



if ($type == 1 AND $event_id != 0) {
//Selecting events for the user without recurrence
    $personal_event_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' AND `event_id`!='$event_id' 
        AND ((`start_date` = '$today_date' AND `end_time`>'$now_time') OR (`start_date` > '$today_date'))
    ORDER BY start_date ASC, start_time ASC LIMIT 15";

    $personal_event_query_result = mysqli_query($con, $personal_event_query);
} else {
    //Selecting events for the user without recurrence
    $personal_event_query = "SELECT * FROM personal_event WHERE `user_id`= '$user_id' 
        AND ((`start_date` = '$today_date' AND `end_time`>'$now_time') OR (`start_date` > '$today_date'))    
    ORDER BY start_date ASC, start_time ASC LIMIT 15";

    $personal_event_query_result = mysqli_query($con, $personal_event_query);
}


while ($row = mysqli_fetch_array($personal_event_query_result)) {
    $event_id = $row['event_id'];
    if ($row['invites'] == 1) {
        $get_invited_query = "SELECT COUNT(*) AS total FROM personal_event_invited WHERE `event_id`=$event_id";
        $get_invited_query_result = mysqli_query($con, $get_invited_query);
        $result_row = mysqli_fetch_array($get_invited_query_result);
        $count = $result_row['total'];

        $get_user_query = "SELECT `pic_location`, `profile_picture`, `firstname`, `lastname`, `user_id` FROM user 
            WHERE `user_id` = (SELECT `user_id` from personal_event WHERE `event_id`=$event_id)";
        $get_user_query_result = mysqli_query($con, $get_user_query);
        $result_row = mysqli_fetch_array($get_user_query_result);

        $name = $result_row['firstname'] . " " . $result_row['lastname'];
        $pic_location = $result_row['pic_location'];
        $pic_name = $result_row['profile_picture'];
        if ($result_row['user_id'] == $user_id) {
            $created_by = 1;
            $name = "Created by you";
        } else {
            $created_by = 0;
        }
    } else {
        $count = 0;
        $name = NULL;
        $pic_location = NULL;
        $pic_name = NULL;
        $created_by = NUll;
    }
    if ($row['description'] != NULL or $row['location'] != NULL or $row['file_location'] != NULL) {
        $type_event = $personal_event;
    } else {
        $type_event = $to_do_event;
    }
    $result_array[] = array(
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'location' => $row['location'],
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'is_check' => $row['is_check'],
        'recurrence' => $row['recurrence'],
        'invites' => $row['invites'],
        'count' => $count,
        'choice' => 0,
        'name' => $name,
        'pic_location' => $pic_location,
        'pic_name' => $pic_name,
        'created_by' => $created_by,
        'type' => $type_event
    );
}

//Selecting events user has been invited to without recurrence
if ($type == 2 AND $event_id != 0) {
    $personal_invited_event_query = "SELECT P.*, PI.`choice` FROM personal_event P, personal_event_invited PI 
    WHERE P.`event_id` = PI.`event_id` AND PI.`user_id` = '$user_id'    
        AND ((P.`start_date` = '$today_date' AND P.`end_time`>'$now_time') OR (P.`start_date` > '$today_date')) 
            AND P.`event_id`!='$event_id'
        ORDER BY start_date ASC,start_time ASC LIMIT 15";

    $personal_invited_event_query_result = mysqli_query($con, $personal_invited_event_query);
} else {
    $personal_invited_event_query = "SELECT P.*, PI.`choice` FROM personal_event P, personal_event_invited PI 
    WHERE P.`event_id` = PI.`event_id` AND PI.`user_id` = '$user_id'    
        AND ((P.`start_date` = '$today_date' AND P.`end_time`>'$now_time') OR (P.`start_date` > '$today_date'))
        ORDER BY start_date ASC,start_time ASC LIMIT 15";

    $personal_invited_event_query_result = mysqli_query($con, $personal_invited_event_query);
}

while ($row = mysqli_fetch_array($personal_invited_event_query_result)) {
    $event_id = $row['event_id'];

    $get_invited_query = "SELECT COUNT(*) AS total FROM personal_event_invited WHERE `event_id`=$event_id";
    $get_invited_query_result = mysqli_query($con, $get_invited_query);
    $result_row = mysqli_fetch_array($get_invited_query_result);
    $count = $result_row['total'];

    $get_user_query = "SELECT `pic_location`, `profile_picture`, `firstname`, `lastname`, `user_id` FROM user 
            WHERE `user_id` = (SELECT `user_id` from personal_event WHERE `event_id`=$event_id)";
    $get_user_query_result = mysqli_query($con, $get_user_query);
    $result_row = mysqli_fetch_array($get_user_query_result);

    $name = $result_row['firstname'] . " " . $result_row['lastname'];
    $pic_location = $result_row['pic_location'];
    $pic_name = $result_row['profile_picture'];
    if ($result_row['user_id'] == $user_id) {
        $created_by = 1;
        $name = "Created by you";
    } else {
        $created_by = 0;
    }

    $result_array[] = array(
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'location' => $row['location'],
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'is_check' => $row['is_check'],
        'recurrence' => $row['recurrence'],
        'invites' => $row['invites'],
        'count' => $count,
        'choice' => 0,
        'name' => $name,
        'pic_location' => $pic_location,
        'pic_name' => $pic_name,
        'created_by' => $created_by,
        'type' => $type_event
    );
}


if ($type == 3 AND $event_id != 0) {
//Selecting club events has is part of without recurrence
    $group_event_query = "SELECT G.*, GI.`added` FROM group_event G, group_event_invited GI WHERE G.`event_id`=GI.`event_id` 
AND G.`event_id`!='$event_id' AND GI.`added`= '1' AND GI.`user_id` = '$user_id'
AND ((G.`start_date` = '$today_date' AND G.`end_time`>'$now_time') OR (G.`start_date` > '$today_date'))
ORDER BY start_date ASC,start_time ASC LIMIT 15";

    $group_event_query_result = mysqli_query($con, $group_event_query);
} else {
//Selecting club events has is part of without recurrence
    $group_event_query = "SELECT * FROM group_event G, group_event_invited GI WHERE G.`event_id`=GI.`event_id` 
AND GI.`added`= '1' AND GI.`user_id` = '$user_id'
AND ((G.`start_date` = '$today_date' AND G.`end_time`>'$now_time') OR (G.`start_date` > '$today_date'))
ORDER BY start_date ASC,start_time ASC LIMIT 15";

    $group_event_query_result = mysqli_query($con, $group_event_query);
}



while ($row = mysqli_fetch_array($group_event_query_result)) {
    $event_id = $row['event_id'];
    $get_invited_query = "SELECT COUNT(*) AS total FROM group_event_invited WHERE `event_id`=$event_id";
    $get_invited_query_result = mysqli_query($con, $get_invited_query);
    $result_row = mysqli_fetch_array($get_invited_query_result);
    $count = $result_row['total'];

    $result_array[] = array(
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'location' => $row['location'],
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'is_check' => $row['is_check'],
        'recurrence' => $row['recurrence'],
        'invites' => $row['invites'],
        'count' => $count,
        'choice' => $row['added'],
        'type' => $group_event
    );
}

if ($type == 4 and $event_id != 0) {
//Selecting course events he is part of without recurrence
    $course_event_query = "SELECT C.*, CI.`choice` FROM course_event C, course_event_invited CI WHERE C.`event_id`=CI.`event_id`
CI.`user_id` = $user_id AND C.`event_id` != $event_id
AND ((C.`start_date` = '$today_date' AND C.`end_time`>'$now_time') OR (C.`start_date` > '$today_date'))
ORDER BY start_date ASC,start_time ASC LIMIT 15";

//echo "course query: "  . $course_event_query;
    $course_event_query_result = mysqli_query($con, $course_event_query);
} else {
//Selecting course events he is part of without recurrence
    $course_event_query = "SELECT C.*, CI.`choice` FROM course_event C, course_event_invited CI WHERE C.`event_id`=CI.`event_id`
AND CI.`user_id` = $user_id 
AND ((C.`start_date` = '$today_date' AND C.`end_time`>'$now_time') OR (C.`start_date` > '$today_date'))
ORDER BY start_date ASC,start_time ASC LIMIT 15";

//echo "course query: "  . $course_event_query;
    $course_event_query_result = mysqli_query($con, $course_event_query);
}



while ($row = mysqli_fetch_array($course_event_query_result)) {
    $event_id = $row['event_id'];
    $get_invited_query = "SELECT COUNT(*) AS total FROM course_event_invited WHERE `event_id`=$event_id";
    $get_invited_query_result = mysqli_query($con, $get_invited_query);
    $result_row = mysqli_fetch_array($get_invited_query_result);
    $count = $result_row['total'];

    $result_array[] = array(
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'location' => $row['location'],
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'is_check' => $row['is_check'],
        'recurrence' => $row['recurrence'],
        'invites' => $row['invites'],
        'count' => $count,
        'choice' => $row['choice'],
        'type' => $course_event
    );
}

if (count($result_array) > 0) {
    $sort = array();
    foreach ($result_array as $k => $v) {
        $sort['start_date'][$k] = $v['start_date'];
        $sort['start_time'][$k] = $v['start_time'];
    }
    array_multisort($sort['start_date'], SORT_ASC, $sort['start_time'], SORT_ASC, $result_array);
    $json = array(
        'events_array' => $result_array
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    $json = array(
        'events_array' => array()
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
}
?>