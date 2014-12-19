<?php
$sid = 0;
$today_time = strtotime("now");

if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}
if (isset($_GET['time'])) {
    $today_time = $_GET['time'];
}
include ("dbconnection.php");

$PERSONAL_EVENT = 1;
$CHECKED = 1;



$time_1Ahead = date("Y-m-d H:i:s", $today_time + (60*60));
$time_now = date("Y-m-d H:i:s", $today_time);

$spe = "SELECT * from personal_event WHERE `s_id`= $sid AND `start` BETWEEN '$time_now' AND '$time_1Ahead' AND `ischeck`='$CHECKED'";
$spe_result = mysqli_query($con, $spe);

while ($row = mysqli_fetch_array($spe_result)) {    
    $check_eventid = $row['eventid'];

    $query = "SELECT * FROM event_notifications WHERE `sid`='$sid' AND event_id='$check_eventid' 
        AND event_type='$PERSONAL_EVENT'";
    $query_result = mysqli_query($con, $query);
    if (!mysql_num_rows($query_result)) {
        $query = "INSERT INTO event_notifications (sid, event_id, event_type) 
            VALUES ('$check_sid', '$check_eventid', '$PERSONAL_EVENT')";
        $insert_result = mysql1_query($con, $query);             
    }
}
?>
