<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/4/14
 * Time: 10:45 AM
 */

require_once 'dbconnection.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$user_type = 's';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_POST['editing'])) {
    $editing_choice = $_POST['editing'];
}
if (isset($_POST['course'])) {
    $table_name = 'courses';
}
if (isset($_POST['class'])) {
    $table_name = 'courses_semester';
}
if (isset($_POST['group'])) {
    $table_name = 'groups';
}
if (isset($_POST['school'])) {
    $table_name = 'university';
}
if (isset($_POST['department'])) {
    $table_name = 'department';
}


if ($table_name == 'courses_semester' or $table_name == 'courses') {
    if ($editing_choice == 'display') {
        include_once 'img_upload.php';
        if ($up_id == NULL) {
            echo "Error flag true";
        } else {
            switch ($table_name) {
                case 'courses_semester':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT dp_blob_id FROM $table_name WHERE class_id = ?)");
                    break;
                case 'courses':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT dp_blob_id FROM $table_name WHERE course_id = ?)");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$delete_old_file_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $delete_old_file_query->bind_param("s", $id);
            if (!$delete_old_file_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $delete_old_file_query->execute();
            if (!$delete_old_file_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $delete_old_file_query->close();

            switch ($table_name) {
                case 'courses_semester':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET dp_blob_id = ? WHERE class_id = ? ");
                    break;
                case 'courses':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET dp_blob_id = ? WHERE course_id = ? ");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$update_display_picture_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $update_display_picture_query->bind_param("is", $up_id, $id);
            if (!$update_display_picture_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $update_display_picture_query->execute();
            if (!$update_display_picture_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $update_display_picture_query->close();
        }
    } elseif ($editing_choice == 'cover') {
        include_once 'img_upload.php';
        if ($up_id == NULL) {
            echo "Error";
        } else {
            switch ($table_name) {
                case 'courses_semester':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT cover_blob_id FROM $table_name WHERE class_id = ?)");
                    break;
                case 'courses':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT cover_blob_id FROM $table_name WHERE course_id = ?)");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$delete_old_file_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $delete_old_file_query->bind_param("s", $id);
            if (!$delete_old_file_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $delete_old_file_query->execute();
            if (!$delete_old_file_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $delete_old_file_query->close();

            switch ($table_name) {
                case 'courses_semester':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET cover_blob_id = ? WHERE class_id = ? ");
                    break;
                case 'courses':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET cover_blob_id = ? WHERE course_id = ? ");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$update_display_picture_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $update_display_picture_query->bind_param("is", $up_id, $id);
            if (!$update_display_picture_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $update_display_picture_query->execute();
            if (!$update_display_picture_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $update_display_picture_query->close();
        }
    } elseif ($editing_choice == 'show') {
        if (!isset($_FILES['img'])) {
            echo "No files";
            exit;
        }
        if ($_FILES['img']['error'] == "UPLOAD_ERR_OK" && is_uploaded_file($_FILES['img']['tmp_name'])) {

            $blockedExts = array(
                # HTML may contain cookie-stealing JavaScript and web bugs
                'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
                # PHP scripts may execute arbitrary code on the server
                'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
                # Other types that may be interpreted by some servers
                'shtml', 'jhtml', 'pl', 'py', 'cgi',
                # May contain harmful executables for Windows victims
                'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl'
            );
            $extension = $_FILES['img']['type'];
            if ((($_FILES['img']['type'] == "image/gif")
                    || ($_FILES['img']['type'] == "image/jpeg")
                    || ($_FILES['img']['type'] == "image/jpg")
                    || ($_FILES['img']['type'] == "image/pjpeg")
                    || ($_FILES['img']['type'] == "image/x-png")
                    || ($_FILES['img']['type'] == "image/png"))
                // && ($_FILES['img']['size'] < 20000)
                && (!in_array($extension, $blockedExts))
            ) {
                $info = pathinfo($_FILES['img']['tmp_name']);
                $ext = $info['extension']; // get the extension of the file
                $new_name = "class" . strtotime("now") . $ext;

                $send_target = 'temporary_uploads/' . $new_name;
                $target = '../temporary_uploads/' . $new_name;
                move_uploaded_file($_FILES['img']['tmp_name'], $target);
                // Output the image
                $im = new Imagick($target);
                $size = $im->getsize();
                $im->setImageCompressionQuality(40);
                $im->resizeimage($size['width'], 196, imagick::FILTER_LANCZOS, 1);
                $im->writeImage($target);
                echo $send_target;
            } else {
                echo $error = "Mazaak: Sorry, we only support these image formats for now (jpeg, gif, pjpeg, x-png, png)";
            }

        }
    } else {
        echo "Undefined choice";
    }
} else {
    if ($editing_choice == 'display') {
        include_once 'img_upload.php';
        if ($up_id == NULL) {
            echo "Error flag true";
        } else {
            switch ($table_name) {
                case 'groups':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT dp_blob_id FROM $table_name WHERE group_id = ?)");
                    break;
                case 'department':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT dp_blob_id FROM $table_name WHERE dept_id = ?)");
                    break;
                case 'university':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT dp_blob_id FROM $table_name WHERE univ_id = ?)");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$delete_old_file_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $delete_old_file_query->bind_param("i", $id);
            if (!$delete_old_file_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $delete_old_file_query->execute();
            if (!$delete_old_file_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $delete_old_file_query->close();

            switch ($table_name) {
                case 'groups':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET dp_blob_id = ? WHERE group_id = ? ");
                    break;
                case 'department':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET dp_blob_id = ? WHERE dept_id = ? ");
                    break;
                case 'university':
                    $update_display_picture_query = $con->prepare("UPDATE `$table_name` SET dp_blob_id = ? WHERE univ_id = ? ");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$update_display_picture_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $update_display_picture_query->bind_param("ii", $up_id, $id);
            if (!$update_display_picture_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $update_display_picture_query->execute();
            if (!$update_display_picture_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $update_display_picture_query->close();
        }
    } elseif ($editing_choice == 'cover') {
        include_once 'img_upload.php';
        if ($up_id == NULL) {
            echo "Error";
        } else {

            switch ($table_name) {
                case 'groups':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT cover_blob_id FROM $table_name WHERE group_id = ?)");
                    break;
                case 'department':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT cover_blob_id FROM $table_name WHERE dept_id = ?)");
                    break;
                case 'university':
                    $delete_old_file_query = $con->prepare("DELETE FROM display_picture WHERE img_id = (SELECT cover_blob_id FROM $table_name WHERE univ_id = ?)");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$delete_old_file_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $delete_old_file_query->bind_param("i", $id);
            if (!$delete_old_file_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $delete_old_file_query->execute();
            if (!$delete_old_file_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $delete_old_file_query->close();

            switch ($table_name) {
                case 'groups':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET cover_blob_id = ? WHERE group_id = ? ");
                    break;
                case 'department':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET cover_blob_id = ? WHERE dept_id = ? ");
                    break;
                case 'university':
                    $update_display_picture_query = $con->prepare("UPDATE $table_name SET cover_blob_id = ? WHERE univ_id = ? ");
                    break;
                default:
                    echo "Never come home";
            }
            if (!$update_display_picture_query) {
                echo "Error in preparing add user query: " . $con->error;
            }
            $update_display_picture_query->bind_param("ii", $up_id, $id);
            if (!$update_display_picture_query) {
                echo "Error in binding add user query: " . $con->error;
            }
            $update_display_picture_query->execute();
            if (!$update_display_picture_query) {
                echo "Error in executing add user query: " . $con->error;
            }
            $update_display_picture_query->close();
        }
    } elseif ($editing_choice == 'show') {
        if (!isset($_FILES['img'])) {
            echo "No files";
            exit;
        }
        if ($_FILES['img']['error'] == "UPLOAD_ERR_OK" && is_uploaded_file($_FILES['img']['tmp_name'])) {

            $blockedExts = array(
                # HTML may contain cookie-stealing JavaScript and web bugs
                'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
                # PHP scripts may execute arbitrary code on the server
                'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
                # Other types that may be interpreted by some servers
                'shtml', 'jhtml', 'pl', 'py', 'cgi',
                # May contain harmful executables for Windows victims
                'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl'
            );
            $extension = $_FILES['img']['type'];
            if ((($_FILES['img']['type'] == "image/gif")
                    || ($_FILES['img']['type'] == "image/jpeg")
                    || ($_FILES['img']['type'] == "image/jpg")
                    || ($_FILES['img']['type'] == "image/pjpeg")
                    || ($_FILES['img']['type'] == "image/x-png")
                    || ($_FILES['img']['type'] == "image/png"))
                // && ($_FILES['img']['size'] < 20000)
                && (!in_array($extension, $blockedExts))
            ) {
                $info = pathinfo($_FILES['img']['tmp_name']);
                $ext = $info['extension']; // get the extension of the file
                $new_name = "class" . strtotime("now") . $ext;

                $send_target = 'temporary_uploads/' . $new_name;
                $target = '../temporary_uploads/' . $new_name;
                move_uploaded_file($_FILES['img']['tmp_name'], $target);
                // Output the image
                $im = new Imagick($target);
                $size = $im->getsize();
                $im->setImageCompressionQuality(40);
                $im->resizeimage($size['width'], 196, imagick::FILTER_LANCZOS, 1);
                $im->writeImage($target);
                echo $send_target;
            } else {
                echo $error = "Mazaak: Sorry, we only support these image formats for now (jpeg, gif, pjpeg, x-png, png)";
            }

        }
    } else {
        echo "Undefined choice";
    }
}

mysqli_close($con);

?>