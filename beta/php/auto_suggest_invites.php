<?php

include 'dbconnection.php';
require_once '../includes/common_functions.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    if ($event_id == "") {
        $event_id = 0;
    }
}
if (isset($_POST['query'])) {
    $search_string = $_POST['query'];

    $search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
    $search_string = mysqli_real_escape_string($con, $search_string);

// Check Length More Than One Character
    if (strlen($search_string) >= 1 && $search_string !== '') {
// Build Query
        $people_array = array();
        $get_connection_query = "(SELECT
   U.user_id,
   U.firstname,
   U.lastname
 FROM user U
 WHERE U.user_id != $user_id AND (U.firstname LIKE '%" . $search_string . "%' OR U.lastname LIKE '%" . $search_string . "%') AND U.user_id IN (SELECT
                                                                               user_id
                                                                             FROM courses_user CU
                                                                             WHERE CU.class_id IN (SELECT
                                                                                                     CUU.class_id
                                                                                                   FROM courses_user CUU
                                                                                                   WHERE
                                                                                                     CUU.user_id = $user_id)))
UNION (SELECT
         U.user_id,
         U.firstname,
         U.lastname
       FROM user U
       WHERE U.user_id != $user_id AND (U.firstname LIKE '%" . $search_string . "%' OR U.lastname LIKE '%" . $search_string . "%') AND U.user_id IN (SELECT
                                                                                     user_id
                                                                                   FROM group_users GU
                                                                                   WHERE GU.group_id IN (SELECT
                                                                                                           GUU.group_id
                                                                                                         FROM
                                                                                                           group_users GUU
                                                                                                         WHERE
                                                                                                           GUU.user_id =
                                                                                                           $user_id)))
UNION (SELECT
         U.user_id,
         U.firstname,
         U.lastname
       FROM user U
       WHERE U.user_id != $user_id AND (U.firstname LIKE '%" . $search_string . "%' OR U.lastname LIKE '%" . $search_string . "%') AND U.user_id IN (SELECT
                                                                                     C.from_user_id
                                                                                   FROM connect C
                                                                                   WHERE C.to_user_id = $user_id))";

//echo $get_connection_query;
        $get_connection_query_result = mysqli_query($con, $get_connection_query);

        while ($row = mysqli_fetch_array($get_connection_query_result)) {
            $conn_user_id = $row['user_id'];
            $picture_link = get_user_dp($con, $conn_user_id);
            if ($event_id == 0) {
                $people_array[] = array(
                    'user_id' => $conn_user_id,
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'profile_picture' => $picture_link,
                    'invited' => 0
                );
            } else {
                $invited_query = "SELECT COUNT(*) as total from personal_event_invited WHERE user_id = $conn_user_id and event_id = $event_id";
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