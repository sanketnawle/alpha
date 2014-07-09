<?php

include 'dbconnection.php';
session_start();

$user_id = 1;
$disc_id = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['disc_id'])) {
    $disc_id = $_POST['disc_id'];
}

$delete_comment_query = "DELETE FROM discussion_table WHERE `disc_id` = $disc_id";
$delete_comment_query_result = mysqli_query($con, $delete_comment_query);

if ($delete_comment_query_result == TRUE) {
    echo "DELETED";
} else {
    echo "ERROR!";
}
?>