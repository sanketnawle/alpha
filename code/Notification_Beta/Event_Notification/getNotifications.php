<?php

$sid = 0;
if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}

include ("dbconnection.php");

$PERSONAL_EVENT = 1;
$GROUP_EVENT = 2;
$UNSEEN = 1;

$query_nots = "SELECT * FROM event_notifications WHERE `sid`='$sid' AND `status`='$UNSEEN'";
$query_result = mysqli_query($con, $query_nots);
$result = array();

while($row = mysqli_fetch_array($query_result)){
    $result[] = getNotificationMessage($row['event_type'], $row['event_id'], $result);    
}

$json = array(
    'event_array' => $result
);

$json_string = json_encode($json);
echo $json_string;

function getNotificationMessage($event_type, $event_id, $event){
    switch($event_type){
        case 1:
            $query_personal = "SELECT title, start FROM personal_event WHERE 'event_id' = $event_id";
            $query_result = mysqli_fetch_array($query_personal);
            if(mysqli_num_rows($query_result)){
                $result = mysqli_fetch_array($query_result);
                return array($result['title'], $result['start']);
            }  
            break;
        case 2:
            $query_personal = "SELECT title, start FROM group_event WHERE 'event_id' = $event_id";
            $query_result = mysqli_fetch_array($query_personal);
            if(mysqli_num_rows($query_result)){
                $result = mysqli_fetch_array($query_result);
                return array($result['title'], $result['start']);
            }   
            break;
    }
}

?>
