<?php

include 'php/dbconnection.php';
include 'php/time_change.php';
session_start();

$user_id = 1;
$event_id = 0;
$type = 0;
$timestamp = date("Y-m-d H:i:s", strtotime("now"));
$notifs = 0;

$user_timestamp = new DateTime(user_time(date("Y-m-d H:i:s", strtotime("now"))));
$today_date_user = $user_timestamp->format("Y-m-d");
$server_timestamp = new DateTime(server_time($today_date_user . " 00:00:00"));
$today_date = $server_timestamp->format("Y-m-d");
$now_time = $server_timestamp->format("H:i:s");
$server_timestamp_copy = clone $server_timestamp;
$server_timestamp_copy->add(new DateInterval("P7D"));
$week_date = $server_timestamp_copy->format("Y-m-d");
$week_time = $server_timestamp_copy->format("H:i:s");
$today_date_server = date("Y-m-d", strtotime("now"));
$now_time_server = date("H:i:s", strtotime("now"));

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['timestamp'])) {
    $timestamp = $_POST['timestamp'];
    $timestamp = str_replace("&", " ", $timestamp);
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}

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

if ($type == $personal_invited_event and $event_id != 0) {
    $personal_invited_events_notification_query = "SELECT P.*, PI.`show_notification` FROM personal_event_invited PI, 
        personal_event P WHERE PI.`user_id` = $user_id AND PI.`show_notification` != 0 AND P.`event_id` = PI.`event_id`
            AND ((P.`time_added` = '$timestamp' AND PI.`event_id` > $event_id) OR (P.`time_added` < '$timestamp'))";
    $personal_invited_events_notification_query_result = mysqli_query($con, $personal_invited_events_notification_query);
} else if (($type == $group_event or $type == $course_event) and $event_id != 0) {
    $personal_invited_events_notification_query = "SELECT P.*, PI.`show_notification` FROM personal_event_invited PI, 
        personal_event P WHERE PI.`user_id` = $user_id AND PI.`show_notification` != 0 AND P.`event_id` = PI.`event_id`
            AND P.`time_added` < '$timestamp'";
    $personal_invited_events_notification_query_result = mysqli_query($con, $personal_invited_events_notification_query);
} else {
    $personal_invited_events_notification_query = "SELECT P.*, PI.`show_notification` FROM personal_event_invited PI, 
        personal_event P WHERE PI.`user_id` = $user_id AND PI.`show_notification` != 0 AND P.`event_id` = PI.`event_id`
            AND P.`time_added` <= '$timestamp'";
    $personal_invited_events_notification_query_result = mysqli_query($con, $personal_invited_events_notification_query);
}
//echo $personal_invited_events_notification_query;
while ($row = mysqli_fetch_array($personal_invited_events_notification_query_result)) {
    $this_event_id = $row['event_id'];
    $get_creator_query = "SELECT E.`title`, E.`time_added`, U.`firstname`,U.`lastname`, U.`profile_picture`, U.`pic_location`         FROM `personal_event` E, `user` U WHERE E.`user_id` = U.`user_id` AND E.`event_id` = $this_event_id";
    $get_creator_query_result = mysqli_query($con, $get_creator_query);
    $creator_row = mysqli_fetch_array($get_creator_query_result);
    $creator_name = $creator_row['firstname'] . " " . $creator_row['lastname'];
    if ($creator_row['pic_location'] == NULL OR $creator_row['pic_location'] == '') {
        $picture_link = $creator_row['profile_picture'];
    } else {
        $picture_link = "../DEMO/" . $creator_row['pic_location'] . "/" . $creator_row['profile_picture'];
    }
    if ($row['show_notification'] == 1 or $row['show_notification'] == 2) {
        $class = "unseen_notifications";
    } else {
        $class = "seen_notifications";
    }
    $events_array[] = array(
        'creator_name' => $creator_name,
        'creator_picture' => $picture_link,
        'created_time' => $creator_row['time_added'],
        'title' => $creator_row['title'],
        'group_name' => "",
        'is_admin' => TRUE,
        'event_id' => $row['event_id'],
        'status_class' => $class,
        'type' => $personal_invited_event
    );
}

if ($type == $group_event and $event_id != 0) {
    $group_event_invited_query = "SELECT G.*, GI.`show_notification` FROM group_event_invited GI, group_event G 
        WHERE GI.`user_id`=$user_id         
            AND GI.`show_notification`!=0 AND GI.`added`=0 AND G.`event_id` = GI.`event_id` AND             
            ((G.`time_added` = '$timestamp' AND G.`event_id` > $event_id) OR (G.`time_added` < '$timestamp'))";
    $group_event_invited_query_result = mysqli_query($con, $group_event_invited_query);
} else if ($type == $course_event and $event_id != 0) {
    $group_event_invited_query = "SELECT G.*, GI.`show_notification` FROM group_event_invited GI, group_event G 
        WHERE GI.`user_id`=$user_id         
            AND GI.`show_notification`!=0 AND GI.`added`=0 AND G.`event_id` = GI.`event_id` AND G.`time_added` < '$timestamp'";
    $group_event_invited_query_result = mysqli_query($con, $group_event_invited_query);
} else {
    $group_event_invited_query = "SELECT G.*, GI.`show_notification` FROM group_event_invited GI, group_event G 
        WHERE GI.`user_id`=$user_id         
            AND GI.`show_notification`!=0 AND GI.`added`=0 AND G.`event_id` = GI.`event_id` AND G.`time_added` <= '$timestamp'";
    $group_event_invited_query_result = mysqli_query($con, $group_event_invited_query);
}
while ($row = mysqli_fetch_array($group_event_invited_query_result)) {
    $this_event_id = $row['event_id'];
    $get_creator_query = "SELECT E.`user_id`, E.`title`, E.`time_added`, U.`firstname`, U.`lastname`, U.`profile_picture`,         U.`pic_location` , G.`group_name`, G.`group_id` FROM `group_event` E, `user` U, groups G WHERE E.`user_id` = U.`user_id`         AND E.`event_id` = $this_event_id AND G.`group_id`=E.`group_id`";
    $get_creator_query_result = mysqli_query($con, $get_creator_query);
    $creator_row = mysqli_fetch_array($get_creator_query_result);
    $creator_name = $creator_row['firstname'] . " " . $creator_row['lastname'];
    $group_name = $creator_row['group_name'];
    $creator_id = $creator_row['user_id'];
    $group_id = $creator_row['group_id'];
    if ($creator_row['pic_location'] == NULL OR $creator_row['pic_location'] == '') {
        $picture_link = $creator_row['profile_picture'];
    } else {
        $picture_link = "../DEMO/" . $creator_row['pic_location'] . "/" . $creator_row['profile_picture'];
    }
    $check_admin_query = "SELECT COUNT(*) AS total FROM group_users WHERE `user_id`=$creator_id AND `group_id`=$group_id
        AND is_admin = 1";
    $check_admin_query_result = mysqli_query($con, $check_admin_query);
    $admin_row = mysqli_fetch_array($check_admin_query_result);
    if ($admin_row['total'] == 0) {
        $is_admin = FALSE;
    } else {
        $is_admin = TRUE;
    }
    if ($row['show_notification'] == 1 or $row['show_notification'] == 2) {
        $class = "unseen_notifications";
    } else {
        $class = "seen_notifications";
    }
    $events_array[] = array(
        'creator_name' => $creator_name,
        'creator_picture' => $picture_link,
        'created_time' => $creator_row['time_added'],
        'title' => $creator_row['title'],
        'group_name' => $group_name,
        'is_admin' => $is_admin,
        'event_id' => $row['event_id'],
        'status_class' => $class,
        'type' => $group_event
    );
}

if ($type == $course_event and $event_id != 0) {
    $course_event_invited_query = "SELECT C.*, CI.`show_notification` FROM course_event_invited CI, course_event C 
        WHERE CI.`user_id`=$user_id AND CI.`show_notification`!=0 AND CI.`event_id`=C.`event_id` AND             
            ((C.`time_added` = '$timestamp' AND CI.`event_id` > $event_id) OR (C.`time_added` < '$timestamp'))";
    $course_event_invited_query_result = mysqli_query($con, $course_event_invited_query);
} else {
    $course_event_invited_query = "SELECT C.*, CI.`show_notification` FROM course_event_invited CI, course_event C 
        WHERE CI.`user_id`=$user_id         
            AND CI.`show_notification`!=0 AND CI.`event_id`=C.`event_id` AND C.`time_added` <= '$timestamp'";
    $course_event_invited_query_result = mysqli_query($con, $course_event_invited_query);
}
//echo $course_event_invited_query;
while ($row = mysqli_fetch_array($course_event_invited_query_result)) {
    $this_event_id = $row['event_id'];
    $get_creator_query = "SELECT E.`user_id`, E.`title`, E.`time_added`, U.`firstname`, U.`lastname`, U.`profile_picture`, 
        U.`pic_location`, C.`course_name`, E.`class_id` FROM `course_event` E, `user` U, courses C, courses_semester CM 
        WHERE E.`user_id` = U.`user_id` AND E.`event_id` = $this_event_id AND E.`class_id` = CM.`class_id` 
            AND CM.`course_id` = C.`course_id`";
    $get_creator_query_result = mysqli_query($con, $get_creator_query);
    $creator_row = mysqli_fetch_array($get_creator_query_result);
    $creator_name = $creator_row['firstname'] . " " . $creator_row['lastname'];
    $group_name = $creator_row['course_name'];
    $creator_id = $creator_row['user_id'];
    $class_id = $creator_row['class_id'];
    if ($creator_row['pic_location'] == NULL OR $creator_row['pic_location'] == '') {
        $picture_link = $creator_row['profile_picture'];
    } else {
        $picture_link = "../DEMO/" . $creator_row['pic_location'] . "/" . $creator_row['profile_picture'];
    }

    $check_admin_query = "SELECT COUNT(*) AS total FROM courses_user WHERE `user_id`=$creator_id AND `class_id`='$class_id'
        AND is_admin = 1";
//    echo $check_admin_query;
    $check_admin_query_result = mysqli_query($con, $check_admin_query);
    $admin_row = mysqli_fetch_array($check_admin_query_result);
    $is_admin = $admin_row['total'];
    if ($row['show_notification'] == 1 or $row['show_notification'] == 2) {
        $class = "unseen_notifications";
    } else {
        $class = "seen_notifications";
    }
    $events_array[] = array(
        'creator_name' => $creator_name,
        'creator_picture' => $picture_link,
        'created_time' => $creator_row['time_added'],
        'title' => $creator_row['title'],
        'group_name' => $group_name,
        'is_admin' => $is_admin,
        'event_id' => $row['event_id'],
        'status_class' => $class,
        'type' => $course_event
    );
}

if ($event_id == 0) {
    $notifs++;
    $get_today_event_count_query = "(SELECT COUNT(`event_id`) as total FROM personal_event WHERE `user_id` = $user_id
        AND ((`start_date` = '$today_date' AND `start_time`>='$now_time') OR
            (`start_date` = '$today_date_user' AND `start_time` <= '$now_time')))
        UNION all (SELECT COUNT(`event_id`) FROM course_event WHERE `user_id` = $user_id AND
        ((`start_date` = '$today_date' AND `start_time`>='$now_time') OR 
            (`start_date` = '$today_date_user' AND `start_time` <= '$now_time')))
        UNION all (SELECT COUNT(`event_id`) FROM group_event WHERE `user_id` = $user_id
            AND ((`start_date` = '$today_date' AND `start_time`>='$now_time') OR     
            (`start_date` = '$today_date_user' AND `start_time` <= '$now_time')))
        UNION all (SELECT COUNT(GI.`event_id`) FROM group_event_invited GI, group_event G 
            WHERE GI.`user_id` = $user_id AND ((`start_date` = '$today_date' AND `start_time`>='$now_time') OR
            (`start_date` = '$today_date_user' AND `start_time` <= '$now_time'))        
            AND G.`event_id` = GI.`event_id` AND (GI.`added`=1 OR GI.`added`=2) )
        UNION all (SELECT COUNT(GI.`event_id`) FROM course_event_invited GI, course_event G WHERE GI.`user_id` = $user_id
            AND ((`start_date` = '$today_date' AND `start_time`>='$now_time') OR         
            (`start_date` = '$today_date_user' AND `start_time` <= '$now_time'))        
                AND G.`event_id` = GI.`event_id` AND (GI.`choice`=1 OR GI.`choice`=2))
        UNION all (SELECT COUNT(GI.`event_id`) FROM personal_event_invited GI, personal_event G WHERE GI.`user_id` = $user_id
            AND ((`start_date` = '$today_date' AND `start_time`>='$now_time') OR         
            (`start_date` = '$today_date_user' AND `start_time` <= '$now_time'))        
            AND G.`event_id` = GI.`event_id` AND (GI.`choice`=1 OR GI.`choice`=2))";
    $get_today_event_count_query_result = mysqli_query($con, $get_today_event_count_query);
    $count = 0;
    while ($row = mysqli_fetch_array($get_today_event_count_query_result)) {
        $count = $count + $row['total'];
    }

    $day = $user_timestamp->format("l");
    $date = $user_timestamp->format("d");
    $month = $user_timestamp->format("M");
    if ($count == 0) {
        $des_string = "Your day looks free";
    } else {
        $des_string = "You have " . $count . " events for today";
    }

    echo "<a href='calendar_beta.php?plnr=0'>
            <div class='c_noti_gen'>
                <div class='calnoti_left'>
                    <div class='calnoti_daybox'>
                        <div class='daybox_month'>" . $month . "</div>
                        <div class='daybox_day'>" . $date . "</div>
                    </div>
                </div>
                <div class='c_gen_right'>
                    <div class='c_notievent_des'>
                        <div class='c_noti_fol'>	
                        <span class='c_span1 h_span1'>" . $day . "</span>
                            <span class='c_span2 h_span2'>" . $des_string . "</span>	
                        </div>
                    </div>
                </div>
            </div>
        </a>";


    $get_exam_event_personal_query = "SELECT P.* FROM personal_event P WHERE     
        ((P.`user_id` = $user_id) OR (P.`event_id` IN (SELECT `event_id` FROM personal_event_invited PI WHERE       
            PI.`user_id` = $user_id AND PI.`event_id` = P.`event_id` AND PI.`choice` = 1)))    
                AND (((P.`start_date` = '$today_date_server' AND P.`start_time`>='$now_time_server') OR 
                    (P.`start_date` > '$today_date_server'))         
                        AND ((P.`start_date` = '$week_date' AND P.`start_time`<='$week_time') OR 
                            (P.`start_date` < '$week_date')))             
                                ORDER BY `start_date` LIMIT 0, 2";
    $get_exam_event_personal_query_result = mysqli_query($con, $get_exam_event_personal_query);
    while ($row = mysqli_fetch_array($get_exam_event_personal_query_result)) {
        if ($row['user_id'] == $user_id) {
            $type_event = $personal_event;
        } else {
            $type_event = $personal_invited_event;
        }

        $user_start_timestamp = new DateTime(user_time($row['start_date'] . "" . $row['start_time']));
        $diff = $user_timestamp->diff($user_start_timestamp);
        $days = $diff->format('%d');
        $hours = $diff->format('%h');
        $minutes = $diff->format('$i');
        if ($days != 0 and $days <= 7) {
            $day_string = $days . " days";
        } else if ($hours != 0) {
            $day_string = $hours . " hrs";
        } else if ($minutes != 0) {
            $day_string = $minutes . " mins";
        }

        $time_added = $row['time_added'];
        $row['time_added'] = str_replace(' ', '&', $time_added);
        if (strlen($row['title']) > 40) {
            $row['title'] = substr($row['title'], 0, 37) . "...";
        }
        if (wordsExist($row['title'], array('Assessment', 'Examination', 'Midterm', 'Quiz', 'Exam', 'test'))) {
            $notifs++;
            echo "<a href='calendar_beta.php?plnr=0&id=" . $row['event_id'] . "&type=" . $type_event . "'>
                    <div class='c_noti_gen'>
                        <div class='c_gen_left'>
                            <div class='calnoti_left'>
                                <div class='calnoti_exam'>
                                    <div class='calnoti_exam_text'>TEST</div>
                                </div>
                            </div>
                        </div>
                        <div class='c_gen_right'>
                            <div class='c_notievent_des' 
                            id='" . $row['event_id'] . "_" . $type_event . "_" . $row['time_added'] . "'>
                                You have " . $row['title'] . " in " . $day_string . "</div>
                        </div>
                    </div>
                </a>";
        } else if (wordsExist($row['description'], array('Assessment', 'Examination', 'Midterm', 'Quiz', 'Exam', 'test'))) {
            $notifs++;
            echo "<a href='calendar_beta.php?plnr=0&id=" . $row['event_id'] . "&type=" . $type_event . "'>
                    <div class='c_noti_gen'>
                        <div class='c_gen_left'>
                            <div class='calnoti_left'>
                                <div class='calnoti_exam'>
                                    <div class='calnoti_exam_text'>TEST</div>
                                </div>
                            </div>
                        </div>
                        <div class='c_gen_right'>
                            <div class='c_notievent_des' 
                            id='" . $row['event_id'] . "_" . $type_event . "_" . $row['time_added'] . "'>
                                You have " . $row['title'] . " in " . $day_string . "</div>
                        </div>
                    </div>
                </a>";
        }
    }

    $get_exam_event_course = "SELECT C.*, CO.`course_name` FROM course_event C, course_event_invited CI,     
        courses_semester CM, courses CO WHERE    
        ((C.`user_id` = $user_id) OR (CI.`user_id` = $user_id AND CI.`event_id` = C.`event_id` AND CI.`choice` = 1))        
            AND C.`class_id` = CM.`class_id` AND CM.`course_id` = CO.`course_id` AND        
            (((C.`start_date` = '$today_date_server' AND C.`start_time`>='$now_time_server') OR 
                (C.`start_date` > '$today_date_server'))         
                    AND ((C.`start_date` = '$week_date' AND C.`start_time`<='$week_time') OR (C.`start_date` < '$week_date')))
                        ORDER BY `start_date` LIMIT 0, 2";
    $get_exam_event_course_query_result = mysqli_query($con, $get_exam_event_course);
    while ($row = mysqli_fetch_array($get_exam_event_course_query_result)) {
        if ($row['user_id'] == $user_id) {
            $type_event = $course_event_personal;
        } else {
            $type_event = $course_event;
        }
        $user_start_timestamp = new DateTime(user_time($row['start_date'] . "" . $row['start_time']));
        $diff = $user_timestamp->diff($user_start_timestamp);
        $days = $diff->format('%d');
        $hours = $diff->format('%h');
        $minutes = $diff->format('$i');
        if ($days != 0 and $days <= 7) {
            $day_string = $days . " days";
        } else if ($hours != 0) {
            $day_string = $hours . " hrs";
        } else if ($minutes != 0) {
            $day_string = $minutes . " mins";
        }

        $time_added = $row['time_added'];
        $row['time_added'] = str_replace(' ', '&', $time_added);
        if (strlen($row['title']) > 20) {
            $row['title'] = substr($row['title'], 0, 17) . "...";
        }
        if (strlen($row['course_name']) > 20) {
            $row['course_name'] = substr($row['course_name'], 0, 17) . "...";
        }
        if (wordsExist($row['title'], array('Assessment', 'Examination', 'Midterm', 'Quiz', 'Exam', 'test'))) {
            $notifs++;
            echo "<a href='calendar_beta.php?plnr=0&id=" . $row['event_id'] . "&type=" . $type_event . "'>
                    <div class='c_noti_gen'>
                        <div class='c_gen_left'>
                            <div class='calnoti_left'>
                                <div class='calnoti_exam'>
                                    <div class='calnoti_exam_text'>TEST</div>
                                </div>
                            </div>
                        </div>
                        <div class='c_gen_right'>
                            <div class='c_notievent_des' 
                            id='" . $row['event_id'] . "_" . $type_event . "_" . $row['time_added'] . "'>
                                You have " . $row['title'] . " in " . $row['course_name'] . " " . $day_string . "</div>
                        </div>
                    </div>
                </a>";
        } else if (wordsExist($row['description'], array('Assessment', 'Examination', 'Midterm', 'Quiz', 'Exam', 'test'))) {
            $notifs++;
            echo "<a href='calendar_beta.php?plnr=0&id=" . $row['event_id'] . "&type=" . $type_event . "'>
                    <div class='c_noti_gen'>
                        <div class='c_gen_left'>
                            <div class='calnoti_left'>
                                <div class='calnoti_exam'>
                                    <div class='calnoti_exam_text'>TEST</div>
                                </div>
                            </div>
                        </div>
                        <div class='c_gen_right'>
                            <div class='c_notievent_des' 
                            id='" . $row['event_id'] . "_" . $type_event . "_" . $row['time_added'] . "'>
                                You have " . $row['title'] . " in " . $row['course_name'] . " " . $day_string . "</div>
                        </div>
                    </div>
                </a>";
        }
    }
}

function wordsExist(&$string, $words)
{
    foreach ($words as &$word) {
        if (stripos($string, $word) !== false) {
            return true;
        }
    }
    return false;
}

if (count($events_array) > 0) {
    $sort = array();
    foreach ($events_array as $k => $v) {
        $sort['created_time'][$k] = $v['created_time'];
        $sort['event_id'][$k] = $v['event_id'];
        $sort['type'][$k] = $v['type'];
    }
    array_multisort($sort['created_time'], SORT_DESC, $sort['type'], SORT_ASC, $sort['event_id'], SORT_ASC, $events_array);
    if (count($events_array) > (6 - $notifs)) {
        $events_array = array_slice($events_array, 0, 6 - $notifs);
    }
    foreach ($events_array as $event) {
        $time_added = $event['created_time'];
        $event['created_time'] = str_replace(' ', '&', $time_added);
        $this_event_id = $event['event_id'];
        switch ($event['type']) {
            case $personal_invited_event:
                $update_notif_status_query = "UPDATE personal_event_invited SET
                `show_notification` = 2 WHERE `user_id` = $user_id AND `event_id` = $this_event_id                  AND `show_notification` != 3";
                $update_notif_status_query_result = mysqli_query($con, $update_notif_status_query);
                if ($update_notif_status_query_result) {
                    //echo "success";
                } else {
                    echo "Error in updating";
                }
                $string_length = strlen($row['creator_name']);
                if (strlen($event['title']) > (29 - $string_length)) {
                    $event['title'] = substr($event['title'], 0, 22 - $string_length) . "...";
                }
                echo "
                <a href='calendar_beta.php?plnr=0&id=" . $event['event_id'] . "&type=" . $event['type'] . "'
                    class = '" . $event['status_class'] . "'>	
                        <div class='c_noti_gen'>		
                            <div class='c_gen_left'>			
                                <div class='calnoti_inviter' style='background:url(" . $event['creator_picture'] . ")'></div>
                            </div>
                            <div class='c_gen_right'>
                                <div class='c_notievent_des' 
                                    id='" . $event['event_id'] . "_" . $event['type'] . "_" . $event['created_time'] . "'>
                                        " . $event['creator_name'] . " has invited you to the event " . $event['title'] . "
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
                             <button class='c_follow_bt c_accpet_btn'>Accept</button>
                        </div>
                </a>";
                break;
            case $course_event:
                $update_notif_status_query = "UPDATE course_event_invited SET `show_notification` = 2 WHERE
                    `user_id` = $user_id AND `event_id` = $this_event_id AND `show_notification` != 3";
                $update_notif_status_query_result = mysqli_query($con, $update_notif_status_query);
                if ($update_notif_status_query_result) {
                    //echo "success";
                } else {
                    echo "Error in updating";
                }
                if ($event['is_admin'] > 0) {
                    if (strlen($event['title']) > 20) {
                        $event['title'] = substr($event['title'], 0, 17) . "...";
                    }
                    if (strlen($event['group_name']) > 20) {
                        $event['group_name'] = substr($event['group_name'], 0, 17) . "...";
                    }
                    $des_string = $event['title'] . " has been added to " . $event['group_name'] . " ";
                } else {
                    $string_length = $event['creator_name'];
                    if (strlen($event['title']) > (18 - $string_length)) {
                        $event['title'] = substr($event['title'], 0, 15 - $string_length) . "...";
                    }
                    if (strlen($event['group_name']) > (18 - $string_length)) {
                        $event['group_name'] = substr($event['group_name'], 0, 15 - $string_length) . "...";
                    }
                    $des_string = $event['creator_name'] . " has added " . $event['title'] . " to " . $event['group_name'] . "";
                }

                echo "<a href='calendar_beta.php?plnr=0&id=" . $event['event_id'] . "&type=" . $event['type'] . "' 
                    class='" . $event['status_class'] . "'>
                        <div class='c_noti_gen'>
                            <div class='calnoti_left'>
                                <div class='calnoti_group' style='background:url(" . $event['creator_picture'] . ")'></div>
                            </div>
                            <div class='c_gen_right'>
                                <div class='c_notievent_des' 
                                id='" . $event['event_id'] . "_" . $event['type'] . "_" . $event['created_time'] . "'>
                                    " . $des_string . "
                                </div>
                            </div>
                            <div class='cnoti_xcontainer'>
                                <div class='c_noti_remove'>
                                    <div class='c_remove_icon'></div>
                                    <div class='c_card-tag'>
                                        <div class='c_tag-wedge'></div>
                                        <div class='c_tag-box'>	<span>Hide</span>	
                                    </div>
                                </div>
                            </div>
                         </div>";
                if ($event['is_admin'] > 0) {
                    echo "<button class='c_follow_bt c_big_button'>Add to cal</button>                       
                        </div>                        
                        </a>";
                } else {
                    echo "</div>                        </a>";
                }
                break;
            case $group_event:
                $update_notif_status_query = "UPDATE group_event_invited SET `show_notification` = 2 WHERE
                `user_id` = $user_id AND `event_id` = $this_event_id AND `show_notification` != 3";
                $update_notif_status_query_result = mysqli_query($con, $update_notif_status_query);
                if ($update_notif_status_query_result) {
                    //echo "success";
                } else {
                    echo "Error in updating";
                }
                if ($event['is_admin'] > 0) {
                    if (strlen($event['title']) > 10) {
                        $event['title'] = substr($event['title'], 0, 7) . "...";
                    }
                    if (strlen($event['group_name']) > 10) {
                        $event['group_name'] = substr($event['group_name'], 0, 7) . "...";
                    }
                    $des_string = "You have been invited to " . $event['group_name'] . "'s event " . $event['title'] . "";
                } else {
                    $string_length = $event['creator_name'];
                    if (strlen($event['title']) > (10 - $string_length)) {
                        $event['title'] = substr($event['title'], 0, 7 - $string_length) . "...";
                    }
                    if (strlen($event['group_name']) > (10 - $string_length)) {
                        $event['group_name'] = substr($event['group_name'], 0, 7 - $string_length) . "...";
                    }
                    $des_string = "You have been invited by " . $event['creator_name'] . "to " . $event['group_name'] . "'s event " . $event['title'] . "";
                }
                echo "<a href='calendar_beta.php?plnr=0&id=" . $event['event_id'] . "&type=" . $event['type'] . "'
                    class='" . $event['status_class'] . "'>
                            <div class='c_noti_gen'>
                                <div class='calnoti_left'>
                                    <div class='calnoti_group' style='background:url(" . $event['creator_picture'] . ")'></div>
                                </div>
                                <div class='c_gen_right'>
                                    <div class='c_notievent_des' 
                                    id='" . $event['event_id'] . "_" . $event['type'] . "_" . $event['created_time'] . "'>
                                        " . $des_string . "</div>
                                </div>
                                <div class='cnoti_xcontainer'>
                                    <div class='c_noti_remove'>
                                        <div class='c_remove_icon'></div>
                                        <div class='c_card-tag'>
                                            <div class='c_tag-wedge'></div>
                                            <div class='c_tag-box'>	<span>Hide</span>	
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class='c_follow_bt c_accpet_btn'>Accept</button>
                            </div>
                        </a>";
                break;
            default:
                echo "Should never come here";
        }
    }
}
mysqli_close($con);
?>