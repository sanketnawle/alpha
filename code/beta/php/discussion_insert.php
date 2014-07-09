<?php

include 'dbconnection.php';
session_start();

$user_id = 1;
$event_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
}

$insert_disc_query = "INSERT INTO discussion_table (`user_id`, `event_id`, `type`, `comment`)
    VALUES ($user_id, $event_id, $type, '$comment')";
$insert_disc_query_result = mysqli_query($con, $insert_disc_query);

if ($insert_disc_query_result == TRUE) {
    echo "Succesful Insert";
} else {
    echo "Error!";
}
?>