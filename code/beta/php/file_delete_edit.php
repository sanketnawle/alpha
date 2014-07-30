<?php

include 'dbconnection.php';
session_start();


$user_id = 1;
$event_id = 1;
$type = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['file_id'])) {
    $file_id = $_POST['file_id'];
}

$delete_file_query = "DELETE FROM file_upload WHERE `file_id` = $file_id";
$delete_file_query_result = mysqli_query($con, $delete_file_query);

if ($delete_file_query_result) {
    echo "Successfull delete";
} else {
    echo "Not deleted";
}
?>