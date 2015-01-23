<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/25/14
 * Time: 10:56 AM
 */

//database connection file
include 'dbconnection.php';
require_once '../includes/common_functions.php';
require_once '../includes/event_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
     WHERE CU.class_id = '$class_id' AND CU.user_id = $user_id";
    $get_enroll_query_result = $con->query($get_enroll_query);
    $enroll_row = mysqli_fetch_array($get_enroll_query_result);

    if ($enroll_row['total'] == 0) {
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
            add_class_events($con, $class_id, $user_id, 'future');
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
        remove_class_events($con, $class_id, $user_id, 'future');
    }
}

?>