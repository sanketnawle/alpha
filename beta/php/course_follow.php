<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/7/14
 * Time: 6:25 PM
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'dbconnection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['course'])) {
    $table_name = 'course_follow';
}
if (isset($_POST['dept'])) {
    $table_name = 'department_follow';
}

switch ($table_name) {
    case 'course_follow':
        $check_follow_query = "SELECT COUNT(*) as total FROM $table_name WHERE course_id = '$id' AND user_id = $user_id";
        break;
    case 'department_follow':
        $check_follow_query = "SELECT COUNT(*) as total FROM $table_name WHERE dept_id = $id AND user_id = $user_id";
        break;
    default:
        echo "Never get here set table";
}

$check_follow_query_result = $con->query($check_follow_query);
$follow_row = $check_follow_query_result->fetch_array();

if ($follow_row['total'] > 0) {
    switch ($table_name) {
        case 'course_follow':
            $remove_user_follow_query = $con->prepare("DELETE FROM course_follow WHERE course_id = ? AND user_id = ?");
            if (!$remove_user_follow_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $remove_user_follow_query->bind_param("si", $id, $user_id);
            if (!$remove_user_follow_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $remove_user_follow_query->execute();
            if (!$remove_user_follow_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $remove_user_follow_query->close();
            break;
        case 'department_follow':
            $remove_user_follow_query = $con->prepare("DELETE FROM department_follow WHERE dept_id = ? AND user_id = ?");
            if (!$remove_user_follow_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $remove_user_follow_query->bind_param("ii", $id, $user_id);
            if (!$remove_user_follow_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $remove_user_follow_query->execute();
            if (!$remove_user_follow_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $remove_user_follow_query->close();
            break;
        default:
            echo "Never get here delete";
    }
} else {
    switch ($table_name) {
        case 'course_follow':
            $add_user_follow_query = $con->prepare("INSERT INTO course_follow (course_id, user_id) VALUES (?,?)");
            if (!$add_user_follow_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $add_user_follow_query->bind_param("si", $id, $user_id);
            if (!$add_user_follow_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $add_user_follow_query->execute();
            if (!$add_user_follow_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $add_user_follow_query->close();
            break;
        case 'department_follow':
            $add_user_follow_query = $con->prepare("INSERT INTO department_follow (dept_id, user_id) VALUES (?,?)");
            if (!$add_user_follow_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $add_user_follow_query->bind_param("ii", $id, $user_id);
            if (!$add_user_follow_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $add_user_follow_query->execute();
            if (!$add_user_follow_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $add_user_follow_query->close();
            break;
        default:
            echo "Never get here add";
    }
}

$con->close();

?>