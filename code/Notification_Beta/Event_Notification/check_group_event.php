<?php

$sid = 0;
if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}

include ("dbconnection.php");

$time_1Ahead = date("Y-m-d H:i:s", strtotime("+1 hour"));

$sql = "SELECT `groupid` from groups_student_1 WHERE `s_id`= $sid";

$event = mysqli_query($con, $sql);

$group_event = array();

while ($row = mysqli_fetch_array($event)) {
    $groupid = $row['groupid'];
    $sql1 = "SELECT * from groups_event WHERE `g_id`=$groupid";
    $event1 = mysqli_query($con, $sql1);
    while($row1 = mysqli_fetch_array($event1)){
        $group_event[] = $row;
    }
}

$json = array(
    'event_array' => $result
);

$json_string = json_encode($json);
echo $json_string;


?>
