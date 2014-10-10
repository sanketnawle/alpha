<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/25/14
 * Time: 4:18 PM
 */


include 'dbconnection.php';
include 'time_change.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$month_start_timestamp = new DateTime(server_time(date("Y-m-01 00:00:00", strtotime("now"))));
$month_start_date = $month_start_timestamp->format("Y-m-d");
$month_start_time = $month_start_timestamp->format("H:i:s");
$month_end_timestamp = new DateTime(server_time(date("Y-m-t 23:59:59", strtotime("now"))));
$month_end_date = $month_end_timestamp->format("Y-m-d");
$month_end_time = $month_end_timestamp->format("H:i:s");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['club_id'])) {
    $group_id = $_POST['club_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
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

$events_array = array();
$admin_flag = 0;

$get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM group_users WHERE group_id = $group_id AND user_id = $user_id AND is_admin = 1";
$get_admin_flag_query_result = mysqli_query($con, $get_admin_flag_query);
$admin_row = mysqli_fetch_array($get_admin_flag_query_result);
$admin_flag = $admin_row['admin_flag'];

// add date filter to show the evnts from current month to future 15 events
$get_admin_event_query = "SELECT GE.* FROM group_event GE WHERE GE.made_by_admin = 1 AND (((start_date = '$month_start_date' AND start_time >= '$month_start_time') OR (start_date > '$month_start_date')) AND ((end_date = '$month_end_date' AND end_time < '$month_end_time') OR (end_date < '$month_end_date')))";
$get_admin_event_query_result = mysqli_query($con, $get_admin_event_query);

while ($row = mysqli_fetch_array($get_admin_event_query_result)) {
    $this_event_id = $row['event_id'];
    if ($admin_flag > 0) {
        $event_type = $group_event_personal;
        $choice = -2;
    } else {
        $event_type = $group_event;
        $get_user_choice_query = "SELECT added FROM group_event_invited WHERE user_id = $user_id AND event_id = $this_event_id";
        $get_user_choice_query_result = mysqli_query($con, $get_user_choice_query);
        if (mysqli_num_rows($get_user_choice_query_result) > 0) {
            $choice_row = mysqli_fetch_array($get_user_choice_query_result);
            $choice = $choice_row['added'];
            if ($choice >= 0) {
                $event_class = 'Added';
            } else {
                $event_class = 'Add to cal';
            }
        } else {
            $choice = -1;
            $event_class = 'Add to cal';
        }
    }

    if ($row['recurrence'] != 'none') {
        $recurrence_dates = getDatesOfRecurrence($row['start_date'], $row['end_date'], $row['recurrence'], $range, $row['start_date']);
        foreach ($recurrence_dates as $dates) {
            $events_array[] = array(
                'event_id' => $row['event_id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'start_date' => $dates,
                'start_time' => $row['start_time'],
                'end_date' => $dates,
                'choice' => $choice,
                'end_time' => $row['end_time'],
                'event_class' => $event_class,
                'type' => $event_type
            );
        }
    } else {
        $events_array[] = array(
            'event_id' => $row['event_id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'start_date' => $row['start_date'],
            'start_time' => $row['start_time'],
            'end_date' => $row['end_date'],
            'choice' => $choice,
            'end_time' => $row['end_time'],
            'event_class' => $event_class,
            'type' => $event_type
        );
    }
}


echo "
    
        <div class='syla-evt_ctr'>";
if ($admin_flag > 0) {
    echo "<div class='blue_btn create-schedule'>Create Event</div>";
}
echo "
        </div>
        <div class='syllabus-canvas'>
";

if (count($events_array) > 0) {
    $sort = array();
    foreach ($events_array as $k => $v) {
        $sort['start_date'][$k] = $v['start_date'];
        $sort['start_time'][$k] = $v['start_time'];
    }

    array_multisort($sort['start_date'], SORT_ASC, $sort['start_time'], SORT_ASC, $events_array);


    $prev_week_start_date = "2014-01-01";
    $prev_week_end_date = "2014-01-07";
    $prev_day = "00-00-00";
    $show_count = 0;

    foreach ($events_array as $event) {
        $user_start_timestamp = new DateTime(user_time($event['start_date'] . "" . $event['start_time']));
        $user_end_timestamp = new DateTime(user_time($event['end_date'] . "" . $event['end_time']));
        if ($user_start_timestamp->format("w") == 0) {
            $week_start_timestamp = clone $user_start_timestamp;
            $week_start_timestamp = $week_start_timestamp->modify("previous week monday");
            $week_end_timestamp = clone $user_start_timestamp;
        } else {
            $week_start_timestamp = clone $user_start_timestamp;
            $week_start_timestamp->modify("this week monday");
            $week_end_timestamp = clone $user_start_timestamp;
            $week_end_timestamp->modify("this week sunday");
        }

        if ($prev_week_start_date == $week_start_timestamp->format("Y-m-d")) {
            $show_count++;
            echo "
                    <div class='weekview_content' id='" . $event['event_id'] . "'>
                        <div class='a_weekview'>";

            if ($prev_day == $user_start_timestamp->format("Y-m-d")) {
                echo "
                            <div class='a_weekview_left'></div>
                ";
            } else {
                $prev_day = $user_start_timestamp->format("Y-m-d");
                echo "
                            <div class='a_weekview_left'>" . $user_start_timestamp->format("D, M j") . "</div>
                ";
            }
            echo "
                            <div class='a_weekview_mid'>
                                <div class='a_weekview_mid_head'>
                                    <span class='a_weekview_mid_head_topic'>" . $event['title'] . "</span>
                                    <span class='a_weekview_mid_head_time'>" . $user_start_timestamp->format("g:i a") . "-"
                . $user_end_timestamp->format("g:i a") . "</span>
                                </div>
                                <div class='a_weekview_mid_content'>
                                    " . $event['description'] . "
                                </div>

                            </div>";
            if ($admin_flag > 0) {
//                echo "
//                            <div class='a_weekview_right'>
//                                <div class='syla_tag syla_tag_lec'>" . $event['event_class'] . " <span class='check_syla'></div>
//                            </div>
//                            <div class = 'help-div-black help-div' id ='help-2'>
//                                <div class ='help-wedge-black help-wedge2'></div>
//                                <div class = 'help-box-black help-box2'>
//                                    Click to add this event
//                                </div>
//                            </div>";
            } else {
                if ($event['choice'] == 1 or $event['choice'] == 0 or $event['choice'] == 2 or $event['choice'] == 3) {
                    echo "
                            <div class='a_weekview_right'>
                                <div class='syla_tag syla_tag_lec syla_checked'>" . $event['event_class'] . " <span style='background-image: url(" . 'src/checked-syla.png' . ");' class='check_syla'></span></div>
                            </div>
                            <div class = 'help-div-black help-div' id ='help-2'>
                                <div class ='help-wedge-black help-wedge2'></div>
                                <div class = 'help-box-black help-box2'>
                                    Click to remove this event
                                </div>
                            </div>";

                    //do not echo right side add button
                } elseif ($event['choice'] == -1) {
                    echo "
                            <div class='a_weekview_right'>
                                <div class='syla_tag syla_tag_lec'>" . $event['event_class'] . " <span class='check_syla'></div>
                            </div>
                            <div class = 'help-div-black help-div' id ='help-2'>
                                <div class ='help-wedge-black help-wedge2'></div>
                                <div class = 'help-box-black help-box2'>
                                    Click to add this event
                                </div>
                            </div>";
                }
            }

            echo "
                            </div>
                        </div>
            ";
        } else {
            $prev_week_start_date = $week_start_timestamp->format("Y-m-d");
            if ($show_count != 0) {
                echo "
                    </div>
                ";
            }
            $show_count++;
            //closing previous syla_weekview and starting new
            echo "
                <div class='syla_weekview'>
                    <div class='weekview_head'>
                        Week of " . $week_start_timestamp->format("M d, Y") . "
                    </div>
            ";

            echo "
                    <div class='weekview_content' id='" . $event['event_id'] . "'>
                        <div class='a_weekview'>";

            if ($prev_day == $user_start_timestamp->format("Y-m-d")) {
                //same date so skip printing date
                echo "
                            <div class='a_weekview_left'></div>
                ";
            } else {
                $prev_day = $user_start_timestamp->format("Y-m-d");
                echo "
                            <div class='a_weekview_left'>" . $user_start_timestamp->format("D, M j") . "</div>
                ";
            }
            echo "
                            <div class='a_weekview_mid'>
                                <div class='a_weekview_mid_head'>
                                    <span class='a_weekview_mid_head_topic'>" . $event['title'] . "</span>
                                    <span class='a_weekview_mid_head_time'>" . $user_start_timestamp->format("g:i a") . "-"
                . $user_end_timestamp->format("g:i a") . "</span>
                                </div>
                                <div class='a_weekview_mid_content'>
                                    " . $event['description'] . "
                                </div>

                            </div>";
            if ($admin_flag > 0) {
//                echo "
//                            <div class='a_weekview_right'>
//                                <div class='syla_tag syla_tag_lec'>" . $event['event_class'] . " <span class='check_syla'></div>
//                            </div>
//                            <div class = 'help-div-black help-div' id ='help-2'>
//                                <div class ='help-wedge-black help-wedge2'></div>
//                                <div class = 'help-box-black help-box2'>
//                                    Click to add this event
//                                </div>
//                            </div>";
            } else {
                if ($event['choice'] == 1 or $event['choice'] == 0 or $event['choice'] == 2 or $event['choice'] == 3) {
                    echo "
                            <div class='a_weekview_right'>
                                <div class='syla_tag syla_tag_lec syla_checked'>" . $event['event_class'] . " <span style='background-image: url(" . 'src/checked-syla.png' . ");' class='check_syla'></span></div>
                            </div>
                            <div class = 'help-div-black help-div' id ='help-2'>
                                <div class ='help-wedge-black help-wedge2'></div>
                                <div class = 'help-box-black help-box2'>
                                    Click to remove this event
                                </div>
                            </div>";

                    //do not echo right side add button
                } elseif ($event['choice'] == -1) {
                    echo "
                            <div class='a_weekview_right'>
                                <div class='syla_tag syla_tag_lec'>" . $event['event_class'] . " <span class='check_syla'></div>
                            </div>
                            <div class = 'help-div-black help-div' id ='help-2'>
                                <div class ='help-wedge-black help-wedge2'></div>
                                <div class = 'help-box-black help-box2'>
                                    Click to add this event
                                </div>
                            </div>";
                }
            }

            echo "
                            </div>
                        </div>
            ";
        }
    }

    //closing the last syla_weekview
    // echo "
    //         </div>
    // ";
}

//closing syllabus-tab-content and syllabus canvas
echo "
        </div>
    </div>
";

function getDatesOfRecurrence($start_date, $end_date, $recurrenceType, $range, $month_start)
{
    $dates = array();
    switch ($recurrenceType) {
        //Daily event
        case 'daily':
            $new_date = $start_date;
            while (TRUE) {
                if ($new_date < $month_start) {
                    $new_date = date("Y-m-d", strtotime("+1 day", strtotime($new_date)));
                    continue;
                } else if ($new_date <= $end_date and $new_date <= $range) {
                    $dates[] = $new_date;
                } else {
                    break;
                }
                $new_date = date("Y-m-d", strtotime("+1 day", strtotime($new_date)));
            }
//            print_r($dates);
            return $dates;
        //Weekly event
        case 'weekly':
            $new_date = $start_date;
            while (TRUE) {
                if ($new_date < $month_start) {
                    $new_date = date("Y-m-d", strtotime("+1 week", strtotime($new_date)));
                    continue;
                } else if ($new_date <= $end_date and $new_date <= $range) {
                    $dates[] = $new_date;
                } else {
                    break;
                }
                $new_date = date("Y-m-d", strtotime("+1 week", strtotime($new_date)));
            }
            return $dates;
        //Monthly event
        case 'monthly':
            $new_date = $start_date;
            while (TRUE) {
                $present_month = date("n", strtotime($new_date));
                $present_date = date("j", strtotime($new_date));
                if ($new_date < $month_start) {
                    if ($present_month == 1 and (($present_date > 28 and $leap_year = 0) or ($present_date > 29 and $leap_year = 1))) {
                        $new_date = date("Y-m-d", strtotime("+2 month", strtotime($new_date)));
                    } else {
                        $new_date = date("Y-m-d", strtotime("+1 month", strtotime($new_date)));
                    }
                    continue;
                } else if ($new_date <= $end_date and $new_date <= $range) {
                    $dates[] = $new_date;
                } else {
                    break;
                }
                if ($present_month == 1 and (($present_date > 28 and $leap_year = 0) or ($present_date > 29 and $leap_year = 1))) {
                    $new_date = date("Y-m-d", strtotime("+2 month", strtotime($new_date)));
                } else {
                    $new_date = date("Y-m-d", strtotime("+1 month", strtotime($new_date)));
                }
            }
            return $dates;
        default:
            echo "Should never get here";
    }
    return NUll;
}


?>