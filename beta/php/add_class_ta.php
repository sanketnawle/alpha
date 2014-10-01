<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/1/14
 * Time: 1:53 PM
 */

require_once 'dbconnection.php';
require_once '../includes/follow.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$ta_user_id = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
}
if (isset($_POST['ta_user_id'])) {
    $ta_user_id = $_POST['ta_user_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}

$admin_flag = 0;

if ($user_type == 'p') {
    $get_prof_query = "SELECT COUNT(class_id) as admin_flag FROM courses_semester WHERE class_id = '$class_id' AND professor = $user_id UNION ALL (SELECT COUNT(class_id) as admin_flag FROM courses_user WHERE  class_id = '$class_id' AND user_id = $user_id AND is_admin = 1)";
    $get_prof_query_result = $con->query($get_prof_query);
    while ($prof_row = $get_prof_query_result->fetch_array()) {
        $admin_flag = $prof_row['admin_flag'] + $admin_flag;
    }
} else {
    $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM courses_user WHERE class_id ='$class_id' AND user_id = $user_id AND is_admin = 1";
    $get_admin_flag_query_result = $con->query($get_admin_flag_query);
    $admin_row = $get_admin_flag_query_result->fetch_array();
    $admin_flag = $admin_row['admin_flag'];
}

if ($admin_flag > 0) {
    $update_course_ta_query = "UPDATE courses_user CU SET is_admin = (NOT CU.is_admin) WHERE CU.class_id = ? AND CU.user_id = ?";
    $update_course_ta_query = $con->prepare($update_course_ta_query);
    if (!$update_course_ta_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $update_course_ta_query->bind_param("si", $class_id, $ta_user_id);
    if (!$update_course_ta_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $update_course_ta_query->execute();
    if (!$update_course_ta_query) {
        echo "Error in executing add user query: " . $con->error;
    } else {
        echo "changed ta";
    }
} else {
    echo "not an admin";
}

mysqli_close($con);

?>