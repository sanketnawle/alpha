<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/31/14
 * Time: 11:32 PM
 */

require_once 'dbconnection.php';
require_once 'file_ops.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
}


$uploaded_file_id = $up_id;

$insert_course_file_query = "INSERT INTO course_files (file_id, user_id, class_id) VALUES ($uploaded_file_id, $user_id, '$class_id')";
$insert_course_file_query_result = mysqli_query($con, $insert_course_file_query);

if ($insert_course_file_query_result) {
    echo "Successful upload";
} else {
    echo "Error in uploading. Please try again";
}

?>