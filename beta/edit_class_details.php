<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/31/14
 * Time: 7:59 PM
 */

require_once 'php/dbconnection.php';
require_once 'includes/follow.php';
require_once 'php/time_change.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$user_type = 's';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_POST['get_schedule'])) {
    //schedule for this course
    $get_schedule_query = "SELECT S.* FROM schedule S, courses_semester_schedule CMS WHERE CMS.class_id = '$class_id' AND CMS.schedule_id = S.schedule_id";
    $get_schedule_query_result = mysqli_query($con, $get_schedule_query);

    //joining all the schedule days of course and making one string
    $schedule_string = "";
    while ($schedule_row = mysqli_fetch_array($get_schedule_query_result)) {
        $start_time = new DateTime($schedule_row['start_time']);
        $end_time = new DateTime($schedule_row['end_time']);
        switch ($schedule_row['day']) {
            case "M":
                $day = 'Mo';
                break;
            case "T":
                $day = 'Tu';
                break;
            case "W":
                $day = 'We';
                break;
            case "TH":
                $day = 'Th';
                break;
            case "F":
                $day = 'Fr';
                break;
            case "S":
                $day = 'Sa';
                break;
            default:
                echo "Never get here";
                break;
        }

        if ($start_time->format("a") == $end_time->format("a")) {
            $schedule_string = $schedule_string . $day . " " . $start_time->format("g:i") . "-" . $end_time->format("g:i a");
        } else {
            $schedule_string = $schedule_string . $day . " " . $start_time->format("g:i a") . "-" . $end_time->format("g:i a");
        }
    }
    echo $schedule_string;
}

if (isset($_POST['course_location'])) {
    $course_location = $_POST['course_location'];
    $update_course_location_query = $con->prepare("UPDATE courses_semester SET location = ? WHERE class_id = '$class_id'");
    if (!$update_course_location_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $update_course_location_query->bind_param("s", $course_location);
    if (!$update_course_location_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $update_course_location_query->execute();
    if (!$update_course_location_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $update_course_location_query->close();
    echo $course_location;
}

//$_POST['course_timings'] = "M (11:00 PM - 12:30 AM)";
$schedule_string = "";
if (isset($_POST['course_timings'])) {
    $course_timings = $_POST['course_timings'];
    $schedule_array = explode(",", $course_timings);
    foreach ($schedule_array as $day_string) {
        $day_string = explode("(", $day_string);
        $day = $day_string[0];
        $day = trim($day);

        $time_string = preg_split("/[),-]+/", $day_string[1]);
        $start_time = new DateTime(date("Y-m-d H:i:s", strtotime($time_string[0])));
        $start_time_formatted = $start_time->format("H:i:s");
        $end_time = new DateTime(date("Y-m-d H:i:s", strtotime($time_string[1])));
        $end_time_formatted = $end_time->format("H:i:s");

        $insert_schedule_query = $con->prepare("INSERT INTO schedule (day, start_time, end_time) VALUES (?,?,?)
        ON DUPLICATE KEY UPDATE schedule_id = LAST_INSERT_ID(schedule_id)");
        if (!$insert_schedule_query) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $insert_schedule_query->bind_param("sss", $day, $start_time_formatted, $end_time_formatted);
        if (!$insert_schedule_query) {
            echo "Error in binding add user query: " . $con->error;
        }
        $insert_schedule_query->execute();
        if (!$insert_schedule_query) {
            echo "Error in executing add user query: " . $con->error;
        }
        $insert_schedule_query->close();
        $last_inserted_id = $con->insert_id;

        $delete_course_schedule = $con->prepare("DELETE FROM courses_semester_schedule WHERE class_id = ?");
        if (!$delete_course_schedule) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $delete_course_schedule->bind_param("s", $class_id);
        if (!$delete_course_schedule) {
            echo "Error in binding add user query: " . $con->error;
        }
        $delete_course_schedule->execute();
        if (!$delete_course_schedule) {
            echo "Error in executing add user query: " . $con->error;
        }
        $delete_course_schedule->close();

        $insert_course_schedule = $con->prepare("INSERT IGNORE INTO courses_semester_schedule (class_id, schedule_id) VALUES (?,?)");
        if (!$insert_course_schedule) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $insert_course_schedule->bind_param("si", $class_id, $last_inserted_id);
        if (!$insert_course_schedule) {
            echo "Error in binding add user query: " . $con->error;
        }
        $insert_course_schedule->execute();
        if (!$insert_course_schedule) {
            echo "Error in executing add user query: " . $con->error;
        }
        $insert_course_schedule->close();

        if ($start_time->format("a") == $end_time->format("a")) {
            $schedule_string = $schedule_string . $day . " (" . $start_time->format("g:i a") . "-" . $end_time->format("g:i a") . ")";
        } else {
            $schedule_string = $schedule_string . $day . " (" . $start_time->format("g:i a") . "-" . $end_time->format("g:i a") . ")";
        }
        $schedule_string = $schedule_string . ",";
    }
    $schedule_string = trim($schedule_string, ",");
}

//upload a syllabus for this course
if (isset($_POST['upload_syllabus'])) {
    require_once 'php/file_ops.php';
    if ($up_id != NULL) {
        $delete_syllabus_query = $con->prepare("DELETE FROM file_upload WHERE file_id = (SELECT syllabus_id FROM courses_semester WHERE class_id = ? AND syllabus_id IS NOT NULL)");
        if (!$delete_syllabus_query) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $delete_syllabus_query->bind_param("s", $class_id);
        if (!$delete_syllabus_query) {
            echo "Error in binding add user query: " . $con->error;
        }
        $delete_syllabus_query->execute();
        if (!$delete_syllabus_query) {
            echo "Error in executing add user query: " . $con->error;
        }
        $delete_syllabus_query->close();

        $insert_syllabus_query = $con->prepare("UPDATE courses_semester SET syllabus_id = ? WHERE class_id = ?");
        if (!$insert_syllabus_query) {
            echo "Error in preparing add user query: " . $con->error;
        }
        $insert_syllabus_query->bind_param("is", $up_id, $class_id);
        if (!$insert_syllabus_query) {
            echo "Error in binding add user query: " . $con->error;
        }
        $insert_syllabus_query->execute();
        if (!$insert_syllabus_query) {
            echo "Error in executing add user query: " . $con->error;
        }
        $insert_syllabus_query->close();

        echo "
          <a class='download_syla_btn' href='php/download_file.php?file_id=" . $up_id . "'><div class='blue_btn'>Download Syllabus</div></a>
        ";
    }
}


//create event from the course page
if (isset($_POST['create_schedule'])) {
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    }
    if (isset($_POST['location'])) {
        $location = $_POST['location'];
    }
    if (isset($_POST['details'])) {
        $details = $_POST['details'];
    }
    if (isset($_POST['start_date'])) {
        $start_date = $_POST['start_date'];
    }
    if (isset($_POST['start_time'])) {
        $start_time = $_POST['start_time'];
    }
    if (isset($_POST['end_time'])) {
        $end_time = $_POST['end_time'];
        if ($end_time < $start_time) {
            $end_time = $start_time;
        }
    }
    if (isset($_POST['repeat'])) {
        $repeat = $_POST['repeat'];
    }
    if (isset($_POST['end_date'])) {
        $end_date = $_POST['end_date'];
        if ($end_date == '' OR $end_date < $start_date) {
            $end_date = $start_date;
        }
    } else {
        $end_date = $start_date;
    }
    if (isset($_POST['event_class'])) {
        $event_class = $_POST['event_class'];
    }

    $server_time_start = server_time($start_date . " " . $start_time);
    $server_time_end = server_time($end_date . " " . $end_time);

    $start_date = date("Y-m-d", strtotime($server_time_start));
    $end_date = date("Y-m-d", strtotime($server_time_end));
    $start_time = date("H:i:s", strtotime($server_time_start));
    $end_time = date("H:i:s", strtotime($server_time_end));

    $insert_event_query = $con->prepare("INSERT INTO course_event (class_id, title, description, start_time, user_id, recurrence, end_time, start_date, end_date, location, event_class) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    if (!$insert_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_event_query->bind_param("ssssissssss", $class_id, $title, $details, $start_time, $user_id, $repeat, $end_time, $start_date, $end_date, $location, $event_class);
    if (!$insert_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_event_query->execute();
    if (!$insert_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_event_query->close();
    $inserted_event_id = $con->insert_id;
    echo $inserted_event_id;

    $insert_course_user_event_query = $con->prepare("INSERT INTO course_event_invited (event_id, user_id) (SELECT $inserted_event_id, user_id FROM courses_user WHERE class_id = ?)");
    if (!$insert_course_user_event_query) {
        echo "Error in preparing add user query: " . $con->error;
    }
    $insert_course_user_event_query->bind_param("s", $class_id);
    if (!$insert_course_user_event_query) {
        echo "Error in binding add user query: " . $con->error;
    }
    $insert_course_user_event_query->execute();
    if (!$insert_course_user_event_query) {
        echo "Error in executing add user query: " . $con->error;
    }
    $insert_course_user_event_query->close();
}

mysqli_close($con);
?>