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

$get_disc_query = "SELECT D.*, U.`firstname`, U.`lastname`, U.`profile_picture`, U.`pic_location`
    FROM discussion_table D, user U WHERE `event_id` = $event_id AND `type` = $type AND D.`user_id` = U.`user_id`";
$get_disc_query_result = mysqli_query($con, $get_disc_query);

while ($row = mysqli_fetch_array($get_disc_query_result)) {
    $user_name = $row['firstname'] . " " . $row['lastname'];
    $disc_array[] = array(
        'disc_id' => $row['disc_id'],
        'event_id' => $event_id,
        'type' => $type,
        'comment' => $row['comment'],
        'user_id' => $row['user_id'],
        'user_name' => $user_name,
        'profile_picture' => $row['profile_picture'],
        'pic_location' => $row['pic_location'],
        'time_added' => $row['time_added']
    );
}

$json = array(
    'disc_array' => $disc_array
);
$jsonstring = json_encode($json);

echo $jsonstring;
?>