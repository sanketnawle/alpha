<?php

include 'dbconnection.php';
require_once '../includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$people_array = array();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = input_sanitize($_POST['event_id'], $con);
    $get_connection_query = "SELECT u.user_id, u.firstname, u.lastname
    FROM user u WHERE u.user_id IN (SELECT user_id from personal_event_invited PI WHERE PI.event_id = $event_id)";

//echo $get_connection_query;
    $get_connection_query_result = mysqli_query($con, $get_connection_query);

    while ($row = mysqli_fetch_array($get_connection_query_result)) {
        $conn_user_id = $row['user_id'];
        $picture_link = get_dp($con, $conn_user_id, 'user');

        $people_array[] = array(
            'user_id' => $conn_user_id,
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'profile_picture' => $picture_link,
            'invited' => 1
        );
    }

    $json = array(
        'people_array' => $people_array
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
} else {
    //no event id passes
    $json = array(
        'people_array' => $people_array
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
}
?>