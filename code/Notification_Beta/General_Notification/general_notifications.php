<?php
$sid = 0;
if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}

include ("dbconnection.php");

$UNSEEN = 1;
$POST_LIKE = 1;
$POST_REPLY = 2;
$REPLY_LIKE = 3;
$REPLY_LIKE_POST = 4;

$query_nots = "SELECT * FROM general_notifications WHERE `sid`='$sid' AND `status`='$UNSEEN'";
$query_result = mysqli_query($con, $query_nots);
$result = array();

while($row = mysqli_fetch_array($query_result)){
    $result[] = getNotificationMessage($row['post_type'], $row['post_id'], $result);    
}


function getNotificationMessage($post_type, $post_id, $event){
    switch($event_type){
        case 1:
            $query_personal = "SELECT * FROM post WHERE 'post_id' = $post_id";
            $query_result = mysqli_fetch_array($query_personal);
            if(mysqli_num_rows($query_result)){
                $result = mysqli_fetch_array($query_result);
                return array($result['text_msg'], $result['sub_text']);
            }  
            break;
        case 2:
            $query_personal = "SELECT * FROM post WHERE 'post_id' = $post_id";
            $query_result = mysqli_fetch_array($query_personal);
            if(mysqli_num_rows($query_result)){
                $result = mysqli_fetch_array($query_result);
                return array($result['text_msg'], $result['sub_text']);
            }   
            break;
    }
}

?>
