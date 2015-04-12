<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/27/14
 * Time: 4:22 PM
 */

if (!function_exists('add_class_events')) {
    function add_class_events($con, $class_id, $enroll_user_id, $choice)
    {
        $get_professor_query = "SELECT CM.professor FROM courses_semester CM WHERE CM.class_id = '$class_id'";
        $get_professor_query_result = $con->query($get_professor_query);
        $professor_row = mysqli_fetch_array($get_professor_query_result);

        $prof_id = $professor_row['professor'];
        if ($choice == 'all') {
            $add_event_query = $con->prepare("INSERT IGNORE INTO course_event_invited (event_id, user_id) SELECT course_event.event_id, ? FROM
             course_event WHERE (course_event.user_id IN (SELECT user_id FROM courses_user WHERE class_id = ? AND is_admin = 1) OR course_event.user_id IN (?))");
            if (!$add_event_query) {
                echo "Error in preparing add event query: " . $con->error;
            }
            $add_event_query->bind_param("isi", $enroll_user_id, $class_id, $prof_id);
            if (!$add_event_query) {
                echo "Error in binding add event query: " . $con->error;
            }
            $add_event_query->execute();
            if (!$add_event_query) {
                echo "Error in executing add event query: " . $con->error;
            }
        } elseif ($choice == 'future') {
            $today_date = date("Y-m-d", strtotime("now"));
            $now_time = date("H:i:s", strtotime("now"));

            $add_event_query = $con->prepare("INSERT IGNORE INTO course_event_invited (event_id, user_id) SELECT course_event.event_id, ? FROM
             course_event WHERE (course_event.user_id IN (SELECT user_id FROM courses_user WHERE class_id = ? AND is_admin = 1) OR course_event.user_id IN (?)) AND ((course_event.start_date = '$today_date' AND course_event.start_time > '$now_time') OR
              (course_event.start_date > '$today_date'))");
            if (!$add_event_query) {
                echo "Error in preparing add event query: " . $con->error;
            }
            $add_event_query->bind_param("isi", $enroll_user_id, $class_id, $prof_id);
            if (!$add_event_query) {
                echo "Error in binding add event query: " . $con->error;
            }
            $add_event_query->execute();
            if (!$add_event_query) {
                echo "Error in executing add event query: " . $con->error;
            }
        } else {
            echo "Wrong choice";
        }
    }
}

if (!function_exists('remove_class_events')) {
    function remove_class_events($con, $class_id, $enroll_user_id, $choice)
    {
        if ($choice == 'all') {
            $remove_event_query = $con->prepare("DELETE FROM course_event_invited WHERE event_id IN (SELECT course_event.event_id FROM               course_event WHERE course_event.class_id = ? AND course_event_invited.user_id = ?");

            if (!$remove_event_query) {
                echo "Error in preparing add event query: " . $con->error;
            }
            $remove_event_query->bind_param("si", $class_id, $user_id);
            if (!$remove_event_query) {
                echo "Error in binding add event query: " . $con->error;
            }
            $remove_event_query->execute();
            if (!$remove_event_query) {
                echo "Error in executing add event query: " . $con->error;
            }

        } elseif ($choice == 'future') {
            $remove_event_query = $con->prepare("DELETE FROM course_event_invited WHERE event_id IN (SELECT course_event.event_id FROM               course_event WHERE course_event.class_id = ? AND ((course_event.start_date = '$today_date' AND course_event.start_time > '$now_time') OR
        (course_event.start_date > '$today_date'))) AND course_event_invited.user_id = ? AND course_event_invited.choice = 0");

            if (!$remove_event_query) {
                echo "Error in preparing add event query: " . $con->error;
            }
            $remove_event_query->bind_param("si", $class_id, $user_id);
            if (!$remove_event_query) {
                echo "Error in binding add event query: " . $con->error;
            }
            $remove_event_query->execute();
            if (!$remove_event_query) {
                echo "Error in executing add event query: " . $con->error;
            }
        } else {
            echo "Wrong choice";
        }
    }
}

?>