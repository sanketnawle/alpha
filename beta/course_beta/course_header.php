<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/18/14
 * Time: 11:02 AM
 */

//database connection file
include '../php/dbconnection.php';
session_start();

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;
$user_type = 's';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}

$admin_flag = 1;

if ($user_type == 'p') {
    $get_prof_query = "SELECT COUNT(*) as admin_flag FROM courses_semester WHERE class_id = '$class_id' AND professor = $user_id";
    $get_prof_query_result = mysqli_query($con, $get_prof_query);
    $prof_row = mysqli_fetch_array($get_prof_query_result);
    $admin_flag = $prof_row['admin_flag'];
} else {
    $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM courses_user WHERE user_id = $user_id AND is_admin = 1";
    $get_admin_flag_query_result = mysqli_query($con, $get_admin_flag_query);
    $admin_row = mysqli_fetch_array($get_admin_flag_query_result);
    $admin_flag = $admin_row['admin_flag'];
}

//count for members in class, professor name, course name, department name and id, course_location and status of the professor in Urlinq
$get_course_details_query = "SELECT C.*, D.dept_name, D.dept_id, U.firstname, U.lastname, U.user_id, U.status, CM.location, COUNT(CU.user_id) as total  FROM courses_semester CM
JOIN courses C ON C.course_id = CM.course_id
JOIN user U ON U.user_id = CM.professor
JOIN department D ON D.dept_id = CM.dept_id
LEFT JOIN courses_user CU ON CU.class_id = CM.class_id
WHERE CM.class_id = '$class_id'";
$get_course_details_query_result = mysqli_query($con, $get_course_details_query);

while ($row = mysqli_fetch_array($get_course_details_query_result)) {
    $course_name = $row['course_name'];
    $course_desc = $row['course_desc'];
    $professor = "Professor " . $row['lastname'];
    $course_pic = $row['course_pic'];
    $course_location = $row['location'];
    $dept_id = $row['dept_id'];
    $dept_name = $row['dept_name'];
    $course_id = $row['course_id'];
    $status = $row['status'];
    $member_count = $row['total'] + 1; //members + professor

    //check whether the user is enrolled in this course
    $get_enroll_query = "SELECT COUNT(*) as total FROM courses_user WHERE class_id = '$class_id' AND user_id = $user_id";
    $get_enroll_query_result = mysqli_query($con, $get_enroll_query);
    $enroll_row = mysqli_fetch_array($get_enroll_query_result);

    $file_count = 0;
    //number of files uploaded for this course
    $get_file_count_query = "SELECT COUNT(file_id) as file_count FROM course_files CF WHERE CF.class_id = '$class_id' UNION ALL (SELECT COUNT(file_id) from posts P WHERE P.target_id = '$class_id' AND P.target_type = 'courses_semester' AND P.file_id IS NOT NULL)";
    $get_file_count_query_result = mysqli_query($con, $get_file_count_query);
    while ($file_count_row = mysqli_fetch_array($get_file_count_query_result)) {
        $file_count = $file_count_row['file_count'] + $file_count;
    }

    //schedule for this course
    $get_schedule_query = "SELECT S.* FROM schedule S, courses_semester_schedule CMS WHERE CMS.class_id = '$class_id' AND CMS.schedule_id = S.schedule_id";
    $get_schedule_query_result = mysqli_query($con, $get_schedule_query);

    //joining all the schedule days of course and making one string
    $schedule_string = "";
    while ($schedule_row = mysqli_fetch_array($get_schedule_query_result)) {
        $start_time = new DateTime($schedule_row['start_time']);
        $end_time = new DateTime($schedule_row['end_time']);

        if ($start_time->format("a") == $end_time->format("a")) {
            $schedule_string = $schedule_string . $schedule_row['day'] . " " . $start_time->format("g:i") . "-" . $end_time->format("g:i a");
        } else {
            $schedule_string = $schedule_string . $schedule_row['day'] . " " . $start_time->format("g:i a") . "-" . $end_time->format("g:i a");
        }
    }
    echo '<div class = "group-head-sec">
        <div class = "group-pic-frame">
            <div class = "group-pic">
            </div>
        </div>
        <div class = "group-header-left">


            <div class = "group-title">
                <div class = "group-name">
                    ' . $course_name . '
                </div>
                <a class = "group-id">
                    ' . $course_id . '
                </a>
            </div>
            <div class = "group-leader">
                <a href=" ../profile.php?user_id =' . $row["user_id"] . '">
                    <span class = "imp-icon leader-icon" >
                    </span >
                    <span class = "group-info-title" >
    ' . $professor . '
                    </span >
                </a > ';
    //status inactive means professor has not joined Urlinq and invite him
    if ($status == "inactive") {
        echo '<div class = "invite-btn" >
                    <span class = "mail-icon" >
                    </span >
    Invite to Urlinq
    </div > ';
    }
    echo '
            </div >
        </div >

        <div class="group_info_head_sec" >
            <div class = "gih" >


            </div >
        </div >
        <div class = "group-header-right" >
            <div class="ch_edit_time_wrap" >';
    if ($admin_flag > 0) {
        echo '<div class="ch_edit_time" >Edit</div >';
    }
    echo '<div class = "ghr-1 ghr-box" style = "left:0px" >
                <div class = "ghr-box-head" >
                    <span class = "ghr-icon-1 ghr-icon" >
                    </span >
                    <span class = "ghr-head-time ghr-head-title" >
    ' . $schedule_string . '
                    </span >

                </div >
            </div >
            </div >

            <div class="ch_edit_location_wrap" >
            ';
    if ($admin_flag > 0) {
        echo '<div class="ch_edit_loc" >Edit</div >';
    }
    echo '<div class = "ghr-2 ghr-box" style = "left:0px" >
                <div class = "ghr-box-head" >
                    <span class = "ghr-icon-2 ghr-icon" >
                    </span >
                    <span class = "ghr-head-title-place ghr-head-title" >
    ' . $course_location . '
                    </span >
                    <input type = "text" class="edit_header ed_loc" >
                </div >
            </div >
            </div >

            <div class = "ghr-3 ghr-box" >
                <a class = "department-link" >
                    <div class = "ghr-box-head" >
                        <span class = "ghr-icon-3 ghr-icon" >
                        </span >
                        <span class = "ghr-head-title" id = "' . $dept_id . '" >
        ' . $dept_name . '
                        </span >
                    </div >
                </a >
            </div >
        </div >
        <div class = "group-head-footer" >
            <div class = "group-header-tab" >
                <ul class = "group-nav" >
                    <li class = "group-tab" >
                        <a class = "tab1 tab-anchor group-tab-active" >
                            <div class = "tab-title" >
                                CLASS FEED
                                <span class = "tab-icon tab1-icon-active" ></span >
                            </div >
                        </a >
                    </li >
                    <li class = "group-tab" >
                        <a class = "tab2 tab-anchor tab-inactive" >
                            <div class = "tab-title" >
    MEMBERS
                                <span class = "tab-icon tab2-icon-inactive" ></span >
                            </div >
                            <div class = "status tab-number" >
                                <span class = "badge" >
    ' . $member_count . '
                                </span >
                            </div >
                        </a >
                    </li >
                    <li class = "group-tab" >
                        <a class = "tab3 tab-anchor tab-inactive" >
                            <div class = "tab-title" >
    FILES
                                <span class = "tab-icon tab3-icon-inactive" ></span >
                            </div >
                            <div class = "status tab-number" >
                                <span class = "badge" >
    ' . $file_count . '
                                </span >
                            </div >
                        </a >
                    </li >
                    <li class = "tab-no-badge group-tab" >
                        <a class = "tabc tab-anchor tab-inactive" >
                            <div class = "tab-title" >
    SYLLABUS
                                <span class = "tab-icon tabc-icon-inactive" ></span >
                            </div >
                        </a >
                    </li >
                </ul >
            </div >
            <div class = "group-footer-functions" > ';

    if ($admin_flag > 0) {
        echo '
                <div class = "join-button" >
                    <a class = "join" >
                        Edit
                    </a >
                </div >
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
    </div > ';
    } else {
        //checking enrollment and echoing button accordingly
        if ($enroll_row["total"] == 0) {
            echo '
                <div class = "join-button" >
                    <a class = "join" >
    Enroll
                    </a >
                </div >
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
    </div > ';
        } else {
            echo '
                <div class = "join-button" >
                    <a class = "join joined" >
    Enrolled
                    </a >
                </div >
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
    </div > ';
        }
    }
}
?>