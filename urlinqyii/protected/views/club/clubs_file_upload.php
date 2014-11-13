<?php


require_once 'php/dbconnection.php';
require_once 'php/file_ops.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['club_id'])) {
    $club_id = $_GET['club_id'];
}


$uploaded_file_id = upload($con);
// echo $uploaded_file_id;

$insert_course_file_query = "INSERT INTO groups_files (file_id, user_id, group_id) VALUES (?,?, ?)";
$insert_course_file_stmt = $con->prepare($insert_course_file_query);$insert_course_file_stmt->bind_param("iii", $uploaded_file_id, $user_id, $club_id);$insert_course_file_stmt->execute();

if ($insert_course_file_stmt->affected_rows == 1) {
    echo "Successful upload";
} else {
    echo "Error in uploading. Please try again";
}

?>