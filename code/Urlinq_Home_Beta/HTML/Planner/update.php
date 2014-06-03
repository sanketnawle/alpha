<?php

$host = "localhost";
$user = "campusla_UrlinqU";
$password = "PASSurlinq@word9";
$database = "campusla_urlinq_demo";

$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
    echo "Failed to connect";
}

$event_id = mysqli_escape_string($con, $_POST['event_id']);
$value = mysqli_escape_string($con, $_POST['value']);

$sql = "UPDATE personal_event SET ischeck='$value' WHERE `eventid` = '$event_id'";

if (!mysqli_query($con, $sql)) {
    echo "Error in executing query";
}
?>