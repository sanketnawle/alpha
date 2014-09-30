<?php

include 'dbconnection.php';
session_start();
$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if ($_POST['event_id'] != "") {
    $event_id = $_POST['event_id'];
} else {
    $event_id = NULL;
}

$people_array = array();
$get_connection_query = "SELECT u.`user_id`, u.`firstname`, u.`lastname`, u.`profile_picture`, u.`pic_location`, 
    s.`univ_name`, sa.`major` FROM user u, university s, student_attribs sa WHERE u.`univ_id` = s.`univ_id` 
    and sa.`user_id` = u.`user_id` and u.`user_id` IN (SELECT `from_user_id` from connect WHERE `to_user_id` = $user_id)";
//echo $get_connection_query;
$get_connection_query_result = mysqli_query($con, $get_connection_query);

while ($row = mysqli_fetch_array($get_connection_query_result)) {
    $conn_user_id = $row['user_id'];

    $invited_query = "SELECT `user_id` from personal_event_invited WHERE `user_id` = $conn_user_id and `event_id` = $event_id";
    $invited_query_result = mysqli_query($con, $invited_query);
    if (mysqli_num_rows($invited_query_result) > 0) {
        $people_array[] = array($conn_user_id, $row['firstname'], $row['lastname'], $row['profile_picture'],
            $row['pic_location'], $row['univ_name'], $row['major'], 1);
    } else {
        $people_array[] = array($conn_user_id, $row['firstname'], $row['lastname'], $row['profile_picture'],
            $row['pic_location'], $row['univ_name'], $row['major'], 0);
    }
}

$json = array(
    'people_array' => $people_array
);

$jsonstring = json_encode($json);
echo $jsonstring;
?>