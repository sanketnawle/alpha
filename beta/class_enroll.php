<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/25/14
 * Time: 10:56 AM
 */

//database connection file
require_once 'php/dbconnection.php';
session_start();

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$today_date = date("Y-m-d", strtotime("now"));
$now_time = date("H:i:s", strtotime("now"));

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
}
enrollWithdraw($class_id, $user_id, $con, $today_date, $now_time);

function enrollWithdraw($class_id, $user_id, $con, $today_date, $now_time)
{
    $get_enroll_query = "SELECT COUNT(CU.user_id) as total FROM courses_user CU
     WHERE CU.class_id = '$class_id' AND CU.user_id = $user_id
     UNION (SELECT CM.professor FROM courses_semester CM WHERE CM.class_id = '$class_id')";
    $get_enroll_query_result = mysqli_query($con, $get_enroll_query);
    $enroll_row = mysqli_fetch_array($get_enroll_query_result);

    if ($enroll_row['total'] == 0) {
        $professor_row = mysqli_fetch_array($get_enroll_query_result);
        $prof_id = $professor_row['total'];
        $color_id = rand(3, 12);
        $add_user_query = $con->prepare("INSERT INTO courses_user (user_id, class_id, color_id) VALUES (?,?,?)");
        if (!$add_user_query) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $add_user_query->bind_param("isi", $user_id, $class_id, $color_id);
        if (!$add_user_query) {
            echo "Error in binding add user query: " . $con->error;
        }
        $add_user_query->execute();
        if (!$add_user_query) {
            echo "Error in executing add user query: " . $con->error;
        } else {
            $add_user_query->close();
            $add_event_query = $con->prepare("INSERT IGNORE INTO course_event_invited (event_id, user_id) SELECT event_id, ? FROM
             course_event WHERE (course_event.user_id IN (SELECT user_id FROM courses_user WHERE class_id = ? AND is_admin = 1) OR course_event.user_id IN (?)) AND ((course_event.start_date = '$today_date' AND course_event.start_time > '$now_time') OR
              (course_event.start_date > '$today_date'))");
            if (!$add_event_query) {
                echo "Error in preparing add event query: " . $con->error;
            }
            $add_event_query->bind_param("isi", $user_id, $class_id, $prof_id);
            if (!$add_event_query) {
                echo "Error in binding add event query: " . $con->error;
            }
            $add_event_query->execute();
            if (!$add_event_query) {
                echo "Error in executing add event query: " . $con->error;
            }
        }
    } else {
        $remove_user_query = $con->prepare("DELETE FROM courses_user WHERE class_id = ? AND user_id = ?");
        if (!$remove_user_query) {
            echo "Error in preparing add event query: " . $con->error;
        }
        $remove_user_query->bind_param("si", $class_id, $user_id);
        if (!$remove_user_query) {
            echo "Error in binding add event query: " . $con->error;
        }
        $remove_user_query->execute();
        if (!$remove_user_query) {
            echo "Error in executing add event query: " . $con->error;
        }

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
    }
}

?>