<?php

include 'dbconnection.php';
session_start();
$user_id = 1;
$event_id = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['query'])) {
    $search_string = $_POST['query'];

    $search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
    $search_string = mysqli_real_escape_string($con, $search_string);

// Check Length More Than One Character
    if (strlen($search_string) >= 1 && $search_string !== '') {
// Build Query
        $people_array = array();
        $get_connection_query = "SELECT u.`user_id`, u.`firstname`, u.`lastname`, u.`profile_picture`, u.`pic_location`
    FROM user u WHERE u.`user_id` IN (SELECT `from_user_id` from connect WHERE `to_user_id` = $user_id)
        AND (u.`firstname` LIKE '%" . $search_string . "%' OR lastname LIKE '%" . $search_string . "%' )";

//echo $get_connection_query;
        $get_connection_query_result = mysqli_query($con, $get_connection_query);

        while ($row = mysqli_fetch_array($get_connection_query_result)) {
            if ($row['pic_location'] == NULL OR $row['pic_location'] == '') {
                $picture_link = $row['profile_picture'];
            } else {
                $picture_link = "../DEMO/" . $row['pic_location'] . "/" . $row['profile_picture'];
            }
            if ($event_id == 0) {
                $conn_user_id = $row['user_id'];
                $people_array[] = array(
                    'user_id' => $conn_user_id,
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'profile_picture' => $picture_link,
                    'invited' => 0
                );
            } else {
                $conn_user_id = $row['user_id'];

                $invited_query = "SELECT COUNT(*) as total from personal_event_invited WHERE `user_id` = $conn_user_id and `event_id` = $event_id";
                $invited_query_result = mysqli_query($con, $invited_query);
                $count_row = mysqli_fetch_array($invited_query_result);
                if ($count_row['total'] != 0) {
                    continue;
                } else {
                    $people_array[] = array(
                        'user_id' => $conn_user_id,
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'profile_picture' => $picture_link,
                        'invited' => 0
                    );
                }
            }
        }

        $json = array(
            'people_array' => $people_array
        );

        $jsonstring = json_encode($json);
        echo $jsonstring;
        mysqli_close($con);
    }
}
?>