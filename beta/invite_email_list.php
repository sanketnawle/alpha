<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/23/14
 * Time: 4:59 PM
 */

include 'php/dbconnection.php';
require_once 'php/file_ops.php';
require_once 'includes/common_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_info = get_user_info($con, $user_id);
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
} else if (isset($_POST['group_id'])) {
    $group_id = $_POST['group_id'];
}
if (isset($_FILES['excel_list'])) {
    $file = $_FILES['excel_list'];
}
if (isset($_POST['email_list'])) {
    $email_list = $_POST['email_list'];
}
if (isset($_POST['email_body'])) {
    $email_message = $_POST['email_body'];
    if (trim($email_message) != '') {
        $email_message = "Personal Message: " . $email_message;
    } else {
        $email_message = "";
    }
}
if (isset($_POST['choice'])) {
    $choice = $_POST['choice'];
}

if ($choice == 'invite') {
    $email_list = explode(";", $email_list);
    $inserted_user_id = array();
    foreach ($email_list as $email) {
        $email_body = "";
        $insert_user_query = $con->prepare("INSERT INTO user SET firstname = 'default_firstname', user_email = ?, user_type = 's', status = 'invited', univ_id = 1, dept_id = 1 ON DUPLICATE KEY UPDATE user_id = LAST_INSERT_ID(user_id)");
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

        $insert_user_query->close();

        if (isset($_POST['class_id'])) {
            $get_enroll_status = "SELECT COUNT(CU.class_id) as total, (SELECT C.course_name FROM courses C WHERE C.course_id = (SELECT CM.course_id FROM courses_semester CM WHERE CM.class_id = '$class_id'))course_name FROM courses_user CU
             WHERE CU.user_id = $insert_id AND CU.class_id = '$class_id'";
            $get_enroll_status_result = $con->query($get_enroll_status);
            $enroll_row = $get_enroll_status_result->fetch_array();
            if ($enroll_row['total'] <= 0) {
                $email_body = "<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'><head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name='viewport' content='width=320; initial-scale=.55; user-scalable=no;'>
        <title>Invitation to join a class on Urlinq</title>
        <style type='text/css'>
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;padding-left: 10px;padding-right: 10px;}

        .header{
            padding:0 20px 20px 0;
        }
        </style>
    </head>
    <body bgcolor='#f2f2f2'>
        <table width='100%' bgcolor='#f2f2f2' border='0' cellpadding='0' cellspacing='0' style='padding:30px;'>
            <tbody style='border:1px solid #d7d7d7;
            max-width: 650px; /* padding-left: 10px; */ /* padding-right: 10px; */
            display: block;
            background: #fff;
            position: relative; margin:0 auto; border-radius: 6px 6px 4.5px 4.5px;'>
                <tr style='width: 650px;'>
                    <td style='margin: 0 auto; width: 650px; position: relative;'>
                    <table style='width: 100%;padding-left: 14px;padding-right: 15px;background-image: -moz-linear-gradient(top,#00d9a0,#00c792);background-image: -webkit-linear-gradient(top,#00d9a0,#00c792);border-radius: 5px 0px 0px 0px;border-bottom: 1px solid rgb(25, 151, 111);' align='left' cellpadding='0' cellspacing='0' border='0'>
                        <tbody>
                            <tr>
                                <td width='600' height='70' style=' height: 45px;'>
                                    <a href='https://urlinq.com' style='-moz-box-shadow: -1px 0px 0px rgba(126, 248, 200, 0.79) inset;-webkit-box-shadow: -1px 0px 0px rgba(126, 248, 200, 0.79) inset;box-shadow: -1px 0px 0px rgba(126, 248, 200, 0.79) inset;border-right: 1.5px solid rgb(25, 151, 111);text-decoration:none; padding: 14px 0px 8px;padding-right: 18px;display: block;width: 75px;height: 100%;' target='_blank'>
                                        <img class='emailLogo' src='http://urlinq.com/beta/emailImg/whiteLogo.png' height='23.5' style='margin-left:5px;' border='0' alt=''>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class='content' align='center' cellspacing='0' cellpadding='0' style='border-spacing:0;vertical-align:top;text-align:inherit;margin: 0;max-width: 100%!important;padding: 14px;'>
                        <tbody>
                            <tr>
                                <td valign='top' style='font-size:14px;font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;width:100%;text-align:left'>
                                    <table cellspacing='0' cellpadding='0' style='border-collapse:collapse;width:100%;'>
                                        <tbody>
                                            <tr>You have been invited by <a href='https://urlinq.com/beta/profile.php?user_id=" . $user_id . "'>" . $user_info['firstname'] . " " . $user_info['lastname'] . "</a> to join <a href='https://urlinq.com/beta/class.php?class_id=" . $class_id . "'>" . $enroll_row['course_name'] . "</tr></a>
                                            <tr></tr>
                                            <tr>" . $email_message . "</tr>
                                            <tr></tr>
                                            <tr></tr>
                                        </tbody>

                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr width='650'>
                <td valign='top'>
                    <img src='http://urlinq.com/beta/emailImg/bottomShadow.png' height='7' style='display:block;margin:0;display:block;top:auto;width: 100%;position:absolute;margin-top: 0px;position:relative;top:4px;' border='0' alt=''>
                </td>
            </tr>
        </tbody>
        <tbody style='
    margin-top: 20px;
    display: block;
'>
            <tr style='margin:0;padding:0;display: block;width: 84px;margin: 0 auto;padding-top: 12px;'>
                <td style='max-width: 30px; margin:0;padding:5px;white-space: nowrap;'>
                    <a title='Facebook' href='https://facebook.com/joinurlinq' style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                        <img alt='Facebook' height='18' width='18' style='' 'margin:0;padding:0;border:0;'='' src='http://urlinq.com/beta/emailImg/fb_email_icon.png'>
                    </a>
                </td>
                <td style='width:30px; margin:0;padding:5px;'>
                    <a title='Google Plus' href='https://plus.google.com/+urlinq' style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                        <img alt='Google Plus' height='17' width='17' style='' 'margin:0;padding:0;border:0;'='' src='http://urlinq.com/beta/emailImg/plus_email_icon.png'>
                    </a>
                </td>
                <td style='width:30px; margin:0;padding:5px;'>
                    <a title='Twitter' href='https://twitter.com/urlinq' style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                        <img alt='Twitter' height='17' width='17' style='' 'margin:0;padding:0;border:0;position:relative;top:5px;'='' src='http://urlinq.com/beta/emailImg/twitter_email_icon.png'>
                    </a>
                </td>
            </tr>
            <tr style='vertical-align:top;text-align:left;padding:0;display: block;margin: 0 auto;width: 600px;'>
                <td align='center' height='70' style='border-collapse: collapse!important; vertical-align:top; text-align: center; height: auto; padding: 0px; padding-top: 0px;width: 350px;display: block;margin: 0 auto;position: absolute;left: 50%;margin-left: -175px;'>
                    <p style='color:#999999;font-size:9px;width:340px;text-align:center;font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;line-height:1.714em;margin:0 auto;padding:12px 0 10px;' align='center'>
                        This email was sent to <span style='text-decoration:none; color:#999999;'>$email</span>.

                        <br>
                        <br>
                        TM and copyright © 2014 Urlinq LLC. New York City.

                    </p>
                </td>
            </tr>
        </tbody>
    </table>




</body></html>";
                mailto($email, "Invitation to Join class on Urlinq", $email_body, "campus@urlinq.com");
            }
        } elseif (isset($_POST['group_id'])) {
            $get_enroll_status = "SELECT g.* , count( gu.user_id ) as total	FROM group_users gu	RIGHT JOIN groups g	ON ( gu.group_id = g.group_id			AND gu.user_id = $insert_id)	WHERE g.group_id =$group_id";
            $get_enroll_status_result = $con->query($get_enroll_status);
            $enroll_row = $get_enroll_status_result->fetch_array();
            if ($enroll_row['total'] <= 0) {
                $email_body = "<!DOCTYPE html>
        <html xmlns='http://www.w3.org/1999/xhtml'><head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name='viewport' content='width=320; initial-scale=.55; user-scalable=no;'>
        <title>Invitation to join a class on Urlinq</title>
        <style type='text/css'>
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;padding-left: 10px;padding-right: 10px;}

        .header{
            padding:0 20px 20px 0;
        }
        </style>
    </head>
    <body bgcolor='#f2f2f2'>
        <table width='100%' bgcolor='#f2f2f2' border='0' cellpadding='0' cellspacing='0' style='padding:30px;'>
            <tbody style='border:1px solid #d7d7d7;
            max-width: 650px; /* padding-left: 10px; */ /* padding-right: 10px; */
            display: block;
            background: #fff;
            position: relative; margin:0 auto; border-radius: 6px 6px 4.5px 4.5px;'>
                <tr style='width: 650px;'>
                    <td style='margin: 0 auto; width: 650px; position: relative;'>
                    <table style='width: 100%;padding-left: 14px;padding-right: 15px;background-image: -moz-linear-gradient(top,#00d9a0,#00c792);background-image: -webkit-linear-gradient(top,#00d9a0,#00c792);border-radius: 5px 0px 0px 0px;border-bottom: 1px solid rgb(25, 151, 111);' align='left' cellpadding='0' cellspacing='0' border='0'>
                        <tbody>
                            <tr>
                                <td width='600' height='70' style=' height: 45px;'>
                                    <a href='https://urlinq.com' style='-moz-box-shadow: -1px 0px 0px rgba(126, 248, 200, 0.79) inset;-webkit-box-shadow: -1px 0px 0px rgba(126, 248, 200, 0.79) inset;box-shadow: -1px 0px 0px rgba(126, 248, 200, 0.79) inset;border-right: 1.5px solid rgb(25, 151, 111);text-decoration:none; padding: 14px 0px 8px;padding-right: 18px;display: block;width: 75px;height: 100%;' target='_blank'>
                                        <img class='emailLogo' src='http://urlinq.com/beta/emailImg/whiteLogo.png' height='23.5' style='margin-left:5px;' border='0' alt=''>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class='content' align='center' cellspacing='0' cellpadding='0' style='border-spacing:0;vertical-align:top;text-align:inherit;margin: 0;max-width: 100%!important;padding: 14px;'>
                        <tbody>
                            <tr>
                                <td valign='top' style='font-size:14px;font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;width:100%;text-align:left'>
                                    <table cellspacing='0' cellpadding='0' style='border-collapse:collapse;width:100%;'>
                                        <tbody>
                                            <tr>You have been invited by <a href='https://urlinq.com/beta/profile.php?user_id=" . $user_id . "'>" . $user_info['firstname'] . " " . $user_info['lastname'] . "</a> to join <a href='https://urlinq.com/beta/club.php?group_id=" . $enroll_row['group_id'] . "'>" . $enroll_row['group_name'] . "</tr></a>
                                            <tr></tr>
                                            <tr>" . $email_message . "</tr>
                                            <tr></tr>
                                            <tr></tr>
                                        </tbody>

                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr width='650'>
                <td valign='top'>
                    <img src='http://urlinq.com/beta/emailImg/bottomShadow.png' height='7' style='display:block;margin:0;display:block;top:auto;width: 100%;position:absolute;margin-top: 0px;position:relative;top:4px;' border='0' alt=''>
                </td>
            </tr>
        </tbody>
        <tbody style='
    margin-top: 20px;
    display: block;
'>
            <tr style='margin:0;padding:0;display: block;width: 84px;margin: 0 auto;padding-top: 12px;'>
                <td style='max-width: 30px; margin:0;padding:5px;white-space: nowrap;'>
                    <a title='Facebook' href='https://facebook.com/joinurlinq' style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                        <img alt='Facebook' height='18' width='18' style='' 'margin:0;padding:0;border:0;'='' src='http://urlinq.com/beta/emailImg/fb_email_icon.png'>
                    </a>
                </td>
                <td style='width:30px; margin:0;padding:5px;'>
                    <a title='Google Plus' href='https://plus.google.com/+urlinq' style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                        <img alt='Google Plus' height='17' width='17' style='' 'margin:0;padding:0;border:0;'='' src='http://urlinq.com/beta/emailImg/plus_email_icon.png'>
                    </a>
                </td>
                <td style='width:30px; margin:0;padding:5px;'>
                    <a title='Twitter' href='https://twitter.com/urlinq' style='margin:0;text-decoration:none;color:#999999;padding:0;'>
                        <img alt='Twitter' height='17' width='17' style='' 'margin:0;padding:0;border:0;position:relative;top:5px;'='' src='http://urlinq.com/beta/emailImg/twitter_email_icon.png'>
                    </a>
                </td>
            </tr>
            <tr style='vertical-align:top;text-align:left;padding:0;display: block;margin: 0 auto;width: 600px;'>
                <td align='center' height='70' style='border-collapse: collapse!important; vertical-align:top; text-align: center; height: auto; padding: 0px; padding-top: 0px;width: 350px;display: block;margin: 0 auto;position: absolute;left: 50%;margin-left: -175px;'>
                    <p style='color:#999999;font-size:9px;width:340px;text-align:center;font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-weight:normal;line-height:1.714em;margin:0 auto;padding:12px 0 10px;' align='center'>
                        This email was sent to <span style='text-decoration:none; color:#999999;'>$email</span>.

                        <br>
                        <br>
                        TM and copyright © 2014 Urlinq LLC. New York City.

                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>";
                mailto($email, "Invitation to Join club on Urlinq", $email_body, "campus@urlinq.com");
            }
        }
    }
    $ch = isset($_POST['class_id']) ? 1 : 2;
    switch ($ch) {
        case 1:
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
            break;
        case 2:
            foreach ($inserted_user_id as $user_id_insert) {
                $insert_notification_query = $con->prepare("INSERT INTO general_notifications (owner_id, actor_id, notification_type, id)			SELECT ?, ?, 'gr_invite', ? FROM dual WHERE NOT EXISTS (SELECT id FROM general_notifications WHERE owner_id = ? AND notification_type = 'gr_invite' AND id = ?)");
                if (!$insert_notification_query) {
                    echo "Error in preparing notif query: " . $con->error;
                }
                $insert_notification_query->bind_param("iiiis", $inserted_user_id, $user_id, $group_id, $inserted_user_id, $group_id);
                if (!$insert_notification_query) {
                    echo "Error in binding notif query: " . $con->error;
                }
                $insert_notification_query->execute();
                if (!$insert_notification_query) {
                    echo "Error in executing notif query: " . $con->error;
                }
            }
            break;
    }
} elseif ($choice == 'upload') {
    //check for errors
    if ($file['error'] == "UPLOAD_ERR_OK" && is_uploaded_file($file['tmp_name'])) {
        $file_type = $file['type'];
        if (get_file_type($file_type) == 'xls') {
            $file_name = $file["name"] . strtotime("now");
            $file_content = file_get_contents($file['tmp_name']);
            file_put_contents($file_name, $file_content);

            $result = shell_exec('../../../python272/bin/python email_invite.py ' . $file_name . '');

            $resultData = json_decode($result, TRUE);
            $email_string = "";
            foreach ($resultData as $email) {
                $filter_email = filter_var($email, FILTER_VALIDATE_EMAIL);
                if ($filter_email == FALSE) {
                    continue;
                } else {
                    $email_string = $email_string . $email . ";";
                }
            }
            echo $email_string;
        } else {
            echo "Wrong format of file";
        }
    }

}

$con->close();

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