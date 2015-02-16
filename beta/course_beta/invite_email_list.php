<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/23/14
 * Time: 4:59 PM
 */
//
include '../php/dbconnection.php';
include '../php/file_ops.php';
include '../includes/common_functions.php';
// Execute the python script with the JSON data

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$choice = "Undefined";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}
if (isset($_FILES['excel_list'])) {
    $file = $_FILES['excel_list'];
}
if (isset($_POST['email_list'])) {
    $email_list = $_POST['email_list'];
}
if (isset($_POST['email_body'])) {
    $email_body = $_POST['email_body'];
}
if (isset($_POST['choice'])) {
    $choice = $_POST['choice'];
}

if ($choice == 'invite') {
    $email_list = explode(";", $email_list);
    $inserted_user_id = array();
    foreach ($email_list as $email) {
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
        $insert_id = $insert_user_query->insert_id;
    }
    $insert_user_query->close();

    $get_enroll_status = "SELECT COUNT(*) as total FROM courses_user WHERE user_id = $insert_id AND class_id = $class_id";
    $get_enroll_status_result = mysqli_query($con, $get_enroll_status);
    $enroll_row = mysqli_fetch_array($get_enroll_status_result);

    if ($enroll_row['total'] == 0) {
        mailto($email, "Invitation to Join Urlinq", $email_body . "You have been invited to join the course GUIDED STUDIES IN BIOMED ENGG", "urlinq@urlinq.com");
    }

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
} elseif ($choice == 'upload') {
    //check for errors
    if ($file['error'] == "UPLOAD_ERR_OK" && is_uploaded_file($file['tmp_name'])) {
        $file_type = $file['type'];
        if (get_file_type($file_type) == 'xls') {
            $file_name = $file["name"] . strtotime("now");
            $file_content = file_get_contents($file['tmp_name']);
            file_put_contents($file_name, $file_content);

            $result = shell_exec('../../../../python272/bin/python email_invite.py ' . $file_name . '');

            $resultData = json_decode($result, TRUE);
            $email_string = "";
            foreach ($resultData as $email) {
                $email_string = $email_string . $email . ";";
            }
            echo $email_string;
        } else {
            echo "Wrong format of file";
        }
    }

}
//
//function show($con, $file)
//{
//}
//
//
//function invite($con, $resultData)
//{

//}

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