<?php

$sid = 0;
if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}

include ("dbconnection.php");

$time_1Ahead = date("Y-m-d H:i:s", strtotime("+1 hour"));
$time_now = date("Y-m-d H:i:s", strtotime("now"));

$sql = "SELECT * from event_notifications WHERE `sid`= $sid";
$event = mysqli_query($con, $sql);

$row = mysqli_fetch_array($event);
$last_updated = $row['check_personal_event'];
$last_updated_1ahead = date("Y-m-d H:i:s", strtotime($last_updated . "+1 hour"));

$sql1 = "SELECT * from personal_event WHERE `s_id`= $sid AND `start` BETWEEN '$time_now' AND '$time_1Ahead' AND `start` > '$last_updated_1ahead'";
$event1 = mysqli_query($con, $sql1);

$sql_update = "UPDATE event_notifications SET check_personal_event = '$time_now' WHERE `sid` = $sid";
mysqli_query($con, $sql_update);

$result = array();

while ($row = mysqli_fetch_array($event1)) {
    $result[] = $row;
    echo $row['title'];
}

$json = array(
    'event_array' => $result
);

$json_string = json_encode($json);
echo $json_string;
?>
