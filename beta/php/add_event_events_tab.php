<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/11/14
 * Time: 1:58 PM
 */
include 'dbconnection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    if (isset($_POST['club'])) {
        $check_event_query = "SELECT COUNT(*) as total FROM group_event_invited WHERE event_id = $event_id AND user_id = $user_id";
        $check_event_query_result = $con->query($check_event_query);
        $event_row = $check_event_query_result->fetch_array();

        if ($event_row['total'] > 0) {
            $delete_event_query = $con->prepare("DELETE FROM group_event_invited WHERE event_id = ? AND user_id = ?");
            if (!$delete_event_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $delete_event_query->bind_param("ii", $event_id, $user_id);
            if (!$delete_event_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $delete_event_query->execute();
            if (!$delete_event_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $delete_event_query->close();
        } else {
            $add_event_group_query = $con->prepare("INSERT INTO group_event_invited (event_id, user_id, added, show_notification) VALUES (?,?,?,?)");
            if (!$add_event_group_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $added = 1;
            $show_notifications = 0;
            $add_event_group_query->bind_param("iiii", $event_id, $user_id, $added, $show_notifications);
            if (!$add_event_group_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $add_event_group_query->execute();
            if (!$add_event_group_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $add_event_group_query->close();
        }

    } elseif (isset($_POST['classes'])) {
        $check_event_query = "SELECT COUNT(*) as total FROM course_event_invited WHERE event_id = $event_id AND user_id = $user_id";
        $check_event_query_result = $con->query($check_event_query);
        $event_row = $check_event_query_result->fetch_array();

        if ($event_row['total'] > 0) {
            $delete_event_query = $con->prepare("DELETE FROM course_event_invited WHERE event_id = ? AND user_id = ?");
            if (!$delete_event_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $delete_event_query->bind_param("ii", $event_id, $user_id);
            if (!$delete_event_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $delete_event_query->execute();
            if (!$delete_event_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $delete_event_query->close();
        } else {
            $add_event_class_query = $con->prepare("INSERT INTO course_event_invited (event_id, user_id, choice, show_notification) VALUES (?,?,?,?)");
            if (!$add_event_class_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $choice = 1;
            $show_notifications = 0;
            $add_event_class_query->bind_param("iiii", $event_id, $user_id, $choice, $show_notifications);
            if (!$add_event_class_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $add_event_class_query->execute();
            if (!$add_event_class_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $add_event_class_query->close();
        }
    }
}



?>