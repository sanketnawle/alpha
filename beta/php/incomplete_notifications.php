<?php

include 'dbconnection.php';
include 'time_change.php';
session_start();

$user_id = 1;
$event_id = 0;
$type = 0;
$timestamp = date("Y-m-d H:i:s", strtotime("now"));

$user_timestamp = new DateTime(user_time(date("Y-m-d H:i:s", strtotime("now"))));
$today_date_user = $user_timestamp->format("Y-m-d");

$server_timestamp = new DateTime(server_time($today_date_user . " 00:00:00"));
$today_date = $server_timestamp->format("Y-m-d");
$now_time = $server_timestamp->format("H:i:s");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['timestamp'])) {
    $timestamp = $_POST['timestamp'];
    $timestamp = str_replace("&", " ", $timestamp);
    $today_timestamp = new DateTime($timestamp);
    $today_date = $today_timestamp->format("Y-m-d");
    $now_time = $today_timestamp->format("H:i:s");
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
        case 'office timing':
            $office_timing = $row['type'];
            break;
    }
}

$event_array = array();
if (($type == $personal_event or $type == $to_do_event) and $event_id != 0) {
    $get_complete_personal_event_query = "SELECT * FROM personal_event WHERE `user_id` = $user_id AND `is_check` = 0
            AND `hide_notification` != 1
        AND ((`start_date` = '$today_date' AND `start_time` = '$now_time' AND `event_id` > $event_id) OR 
        (`start_date` = '$today_date' AND `start_time` < '$now_time') OR (`start_date` < '$today_date'))";
    $get_complete_personal_event_query_result = mysqli_query($con, $get_complete_personal_event_query);
} else if (($type == $course_event or $type == $course_event_personal) and $event_id != 0) {
    $get_complete_personal_event_query = "SELECT * FROM personal_event WHERE `user_id` = $user_id AND `is_check` = 0
        AND `hide_notification` != 1
    AND ((`start_date` = '$today_date' AND `start_time` < '$now_time') OR (`start_date` < '$today_date'))";
    $get_complete_personal_event_query_result = mysqli_query($con, $get_complete_personal_event_query);
} else {
    $get_complete_personal_event_query = "SELECT * FROM personal_event WHERE `user_id` = $user_id AND `is_check` = 0
        AND `hide_notification` != 1
    AND ((`start_date` = '$today_date' AND `start_time` <= '$now_time') OR (`start_date` < '$today_date'))";
    $get_complete_personal_event_query_result = mysqli_query($con, $get_complete_personal_event_query);
}
//echo $get_complete_personal_event_query;

while ($row = mysqli_fetch_array($get_complete_personal_event_query_result)) {
    if ($row['invites'] == 0 AND ($row['location'] == NULL OR $row['location'] == 'NULL') AND $row['recurrence'] == 'none') {
        $type_event = $to_do_event;
    } else {
        $type_event = $personal_event;
    }
    $event_array[] = array(
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'type' => $type_event
    );
}

if (($type == $course_event or $type == $course_event_personal) and $event_id != 0) {
    $get_complete_course_event_query = "SELECT C.* FROM course_event C WHERE 
    ((C.`start_date` = '$today_date' AND C.`start_time` = '$now_time' AND C.`event_id` > $event_id) OR 
        (C.`start_date` = '$today_date' AND C.`start_time` < '$now_time') OR (C.`start_date` < '$today_date')) AND
    ((C.`user_id` = $user_id AND C.`is_check` = 0 AND C.`hide_notification` != 1) OR 
        (C.`event_id` IN (SELECT `event_id` FROM course_event_invited CI 
        WHERE CI.`user_id` = $user_id AND CI.`is_check` = 0 AND CI.`hide_notification` != 1)))";
    $get_complete_course_event_query_result = mysqli_query($con, $get_complete_course_event_query);
} else {
    $get_complete_course_event_query = "SELECT C.* FROM course_event C WHERE 
    ((C.`start_date` = '$today_date' AND C.`start_time` <= '$now_time') OR (C.`start_date` < '$today_date')) AND
    ((C.`user_id` = $user_id AND C.`is_check`=0 AND `hide_notification` != 1) OR (C.`event_id` IN (SELECT `event_id` FROM course_event_invited CI 
    WHERE CI.`user_id` = $user_id AND CI.`is_check` = 0)))";
    $get_complete_course_event_query_result = mysqli_query($con, $get_complete_course_event_query);
}
//echo $get_complete_course_event_query;


while ($row = mysqli_fetch_array($get_complete_course_event_query_result)) {
    if ($row['user_id'] == $user_id) {
        $type_event = $course_event_personal;
    } else {
        $type_event = $course_event;
    }
    $event_array[] = array(
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'start_date' => $row['start_date'],
        'start_time' => $row['start_time'],
        'type' => $type_event
    );
}

if (count($event_array) > 0) {
    $sort = array();

    foreach ($event_array as $k => $v) {
        $sort['start_time'][$k] = $v['start_time'];
        $sort['start_date'][$k] = $v['start_date'];
        $sort['type'][$k] = $v['type'];
        $sort['event_id'][$k] = $v['event_id'];
    }

    array_multisort($sort['start_date'], SORT_DESC, $sort['start_time'], SORT_DESC, $sort['type'], SORT_ASC, $sort['event_id'], SORT_ASC, $event_array);
    if (count($event_array) > 6) {
        $event_array = array_slice($event_array, 0, 6);
    }

    foreach ($event_array as $event) {
        $user_start_timestamp = new DateTime(user_time($event['start_date'] . "" . $event['start_time']));
        $day = $user_start_timestamp->format("l");
        $date = $user_start_timestamp->format("d");
        $month = $user_start_timestamp->format("M");

        echo "
        <a href='calendar_beta.php?plnr=0&id=" . $event['event_id'] . "&type=" . $event['type'] . "'>
            <div class='c_noti_gen c_noti_complete'>
		        <div class = 'calnoti_left'>
			        <div class = 'calnoti_daybox'>
				        <div class = 'daybox_month'>" . $month . "
				        </div>
				        <div class = 'daybox_day'>" . $date . "
				        </div>
			        </div>
		        </div>

		        <div class='c_gen_right'>
			        <div class='c_notievent_des'
                        id='" . $event['event_id'] . "_" . $event['type'] . "_" . $event['start_date'] . "&" . $event['start_time'] . "'>
				        <div class='c_noti_fol'>
				            <span class='c_span1 h_span1'>" . $event['title'] . "</span>
                            <span class='c_span2 h_span2'></span>
				        </div>
			        </div>
		        </div>
                <div class='cnoti_xcontainer'>
                    <div class='c_noti_remove'>
                        <div class='c_remove_icon'></div>
                        <div class = 'c_card-tag'>
                            <div class = 'c_tag-wedge'></div>
                            <div class = 'c_tag-box'>
                                    <span>Hide</span>
                            </div>
                        </div>
                    </div>
                </div>
	        </div>
        </a>";
    }
}

mysqli_close($con);
?>