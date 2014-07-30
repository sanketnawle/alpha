<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/23/14
 * Time: 4:59 PM
 */

include '../php/dbconnection.php';
// Execute the python script with the JSON data

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}

$result = shell_exec('../../../../python272/bin/python email_invite.py');

$resultData = json_decode($result, TRUE);
$inserted_user_id = array();
/*
foreach ($resultData as $email) {
    echo $email;
    echo "<br>";
    $insert_user_query = $con->prepare("INSERT INTO user SET firstname = 'default_firstname', user_email = ?, user_type = 's', status = 'invited', univ_id = 1, dept_id = 1
ON DUPLICATE KEY UPDATE user_id = LAST_INSERT_ID(user_id)");
    if (!$insert_user_query) {
        echo "Error in preparing user query: " . $con->error;
    }
    $insert_user_query->bind_param("s", $email);
    if (!$insert_user_query) {
        echo "Error in binding user query: " . $con->error;
    }
    $insert_user_query->execute();
    if (!$insert_user_query) {
        echo "Error in executing user query: " . $con->error;
    }
    $inserted_user_id[] = $insert_user_query->insert_id;
}
$insert_user_query->close();

foreach ($inserted_user_id as $user_id_insert) {
    $insert_notification_query = $con->prepare("INSERT INTO general_notifications (owner_id, actor_id, notification_type, id)
    SELECT ?, ?, 'cr_invite', ? FROM dual WHERE NOT EXISTS (SELECT id FROM general_notifications WHERE owner_id = ? AND notification_type = 'cr_invite' AND id = ?)");
    if (!$insert_notification_query) {
        echo "Error in preparing notif query: " . $con->error;
    }
    $insert_notification_query->bind_param("iisis", $inserted_user_id, $user_id, $class_id, $inserted_user_id, $class_id);
    if (!$insert_notification_query) {
        echo "Error in binding notif query: " . $con->error;
    }
    $insert_notification_query->execute();
    if (!$insert_notification_query) {
        echo "Error in executing notif query: " . $con->error;
    }
}
mysqli_close($con);
*/
?>