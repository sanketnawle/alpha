<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/29/14
 * Time: 11:46 PM
 */
$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$range = date("Y-m-d", strtotime("+1 year"));
$user_type = 's';
$choice = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}
if (isset($_POST['choice'])) {
    $choice = $_POST['choice'];
}

$update_event_query = "INSERT INTO course_event_invited (user_id, choice, event_id) VALUES ($user_id, 1, $event_id)
ON DUPLICATE KEY UPDATE choice = $choice";
$update_event_query_result = mysqli_query($con, $update_event_query);

if (!$update_event_query) {
    echo "Error updating your choice for the event. Please try again";
}
?>