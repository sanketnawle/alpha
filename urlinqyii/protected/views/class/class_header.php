<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/18/14
 * Time: 11:02 AM
 */

//database connection file
/*include 'php/dbconnection.php';
require_once 'includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
} else {
    echo "Class id is not provided. Please check the URL";
    $con->close();
    exit;
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_SESSION['univ_id'])) {
    $univ_id = $_SESSION['univ_id'];
}

$current_semester = get_current_semester($con, $univ_id);
$admin_flag = 0;

if ($user_type == 'p') {
    $get_prof_query = "SELECT COUNT(class_id) as admin_flag FROM courses_semester WHERE class_id = '$class_id' AND professor = $user_id UNION ALL (SELECT COUNT(class_id) as admin_flag FROM courses_user WHERE  class_id = '$class_id' AND user_id = $user_id AND is_admin = 1)";
    $get_prof_query_result = $con->query($get_prof_query);
    while ($prof_row = $get_prof_query_result->fetch_array()) {
        $admin_flag = $prof_row['admin_flag'] + $admin_flag;
    }
} else {
    $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM courses_user WHERE class_id ='$class_id' AND user_id = $user_id AND is_admin = 1";
    $get_admin_flag_query_result = $con->query($get_admin_flag_query);
    $admin_row = $get_admin_flag_query_result->fetch_array();
    $admin_flag = $admin_row['admin_flag'];
}

//count for members in class, professor name, course name, department name and id, course_location and status of the professor in Urlinq
$get_course_details_query = "SELECT C.*, D.dept_name, D.dept_id, U.firstname, U.lastname, U.user_id, U.status, CM.location, CM.section_id  FROM courses_semester CM
JOIN courses C ON C.course_id = CM.course_id
LEFT JOIN user U ON U.user_id = CM.professor
JOIN department D ON D.dept_id = CM.dept_id
WHERE CM.class_id = '$class_id'";
$get_course_details_query_result = $con->query($get_course_details_query);

//if the query return no class
if (!$get_course_details_query_result or $get_course_details_query_result->num_rows == 0) {
    echo "This class does not exist. Please check the class id";
    $con->close();
    exit;
}

while ($row = $get_course_details_query_result->fetch_array()) {
    $course_name = $row['course_name'];
    $course_desc = $row['course_desc'];
    $prof_id = $row['user_id'];
    if ($row['lastname'] == NULL or $row['lastname'] == 'NULL') {
        $prof_id = 0;
        $member_count = 0;
        $professor = "TBA";
    } else {
        $member_count = 1;
        $professor = "Professor " . $row['lastname'];
    }
    $course_location = $row['location'];
    $dept_id = $row['dept_id'];
    $dept_name = $row['dept_name'];
    $course_id = $row['course_id'];
    $status = $row['status'];
    //$member_count = $row['total'];
    $section_id = $row['section_id'];

    //get count of class members
    $get_member_count_query = "SELECT COUNT(U.user_id) as total FROM courses_user CU
    JOIN user U ON CU.user_id = U.user_id AND U.status = 'active' AND U.user_id != $prof_id
    WHERE CU.class_id = '$class_id'";
    $get_member_count_query_result = $con->query($get_member_count_query);
    $member_count_row = $get_member_count_query_result->fetch_array();
    $member_count = $member_count_row['total'] + $member_count;

    //check whether the user is enrolled in this course
    $get_enroll_query = "SELECT COUNT(*) as total FROM courses_user WHERE class_id = '$class_id' AND user_id = $user_id";
    $get_enroll_query_result = $con->query($get_enroll_query);
    $enroll_row = $get_enroll_query_result->fetch_array();

    $file_count = 0;
    //number of files uploaded for this course
    $get_file_count_query = "SELECT COUNT(file_id) as file_count FROM course_files CF WHERE CF.class_id = '$class_id' UNION ALL (SELECT COUNT(file_id) from posts P WHERE P.target_id = '$class_id' AND P.target_type = 'courses_semester' AND P.file_id IS NOT NULL)";
    $get_file_count_query_result = $con->query($get_file_count_query);
    while ($file_count_row = $get_file_count_query_result->fetch_array()) {
        $file_count = $file_count_row['file_count'] + $file_count;
    }

    //schedule for this class
    $get_schedule_query = "SELECT S.* FROM schedule S, courses_semester_schedule CMS WHERE CMS.class_id = '$class_id' AND CMS.schedule_id = S.schedule_id ORDER BY day";
    $get_schedule_query_result = $con->query($get_schedule_query);

    //joining all the schedule days of class and making one string
    $schedule_string = "";
    while ($schedule_row = $get_schedule_query_result->fetch_array()) {
        if (strpos($schedule_row['day'], 'TBA') !== false) {
            $schedule_string = "TBA";
            continue;
        }
        $start_time = new DateTime($schedule_row['start_time']);
        $end_time = new DateTime($schedule_row['end_time']);

        if ($start_time->format("a") == $end_time->format("a")) {
            $schedule_string = $schedule_string . $schedule_row['day'] . " (" . $start_time->format("g:i a") . "-" . $end_time->format("g:i a") . ")";
        } else {
            $schedule_string = $schedule_string . $schedule_row['day'] . " (" . $start_time->format("g:i a") . "-" . $end_time->format("g:i a") . ")";
        }
        $schedule_string = $schedule_string . ",";
    }
    $schedule_string = trim($schedule_string, ",");*/


    echo '
    <div class = "group-head-sec">
      <div class="group-head-content">
        <div class = "group-pic-frame">
             <div class = "group-pic" style="background-image:url(';
                if($class->picture_file_id){
                    echo Yii::app()->getBaseUrl(true).$class->pictureFile->file_url;
                }else{
                    echo Yii::app()->getBaseUrl(true). '/assets/default/class.png';
                }

    echo            ' ); background-size:cover;">
            </div>';
    if ($is_admin) {
        echo '
            <form>
            <input type="file" name="img" class="header_small_img_input">
            </form>
        ';
    } /*else {
        //no option to upload picture
    }*/
    echo '
        </div>
        <div class = "group-header-left">
            <div class = "group-title">
                <div class = "group-name">
                    ' . $course->course_name . '
                </div>
                <a class = "group-id">
                    ' . $class->section_id . '
                </a>
            </div>
            <div class = "group-leader">
    ';
 /*   if ($course->professor == NULL) {
        echo '
                    <span class = "imp-icon leader-icon" style="background-image:url(' . get_dp($con, $row['user_id'], "user") . ')" >
                    </span >
                    <span class = "group-info-title" >
    ' . $professor . '
                    </span >
    ';
    } else { */
        echo '
                <a href=" profile.php?user_id=' . $professor->user_id . '">
                    <span class = "imp-icon leader-icon" style="background-image:url(';
                                if($professor->picture_file_id){
                                    echo Yii::app()->getBaseUrl(true).$professor->pictureFile->file_url;
                                }else{
                                    echo Yii::app()->getBaseUrl(true). '/assets/default/user.png';
                                }
        echo                    ')" >
                   </span >
                    <span class = "group-info-title" >
            Professor ' . $professor->lastname . '
                    </span >
                </a >
    ';
 //   }

    //status inactive means professor has not joined Urlinq and invite him
    if ( /*$status != "active"*/
    FALSE
    ) {
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
    if ($is_admin) {
        echo '<div class="ch_edit_time" >Edit</div >';
    }
    echo '<div class = "ghr-1 ghr-box" style = "left:0px" >
                <div class = "ghr-box-head" >
                    <span class = "ghr-icon-1 ghr-icon" >
                    </span >
                    <span class = "ghr-head-time ghr-head-title" >';

                        foreach($schedules as $i=>$schedule){
                            echo $schedule;
                            if($i < count($schedules)-1){
                                echo '<br>';
                            }
                        }
    echo             ' </span >

                </div >
            </div >
            </div >';

    echo '  <div class="ch_edit_location_wrap" >';
    if ($is_admin) {
        echo '<div class="ch_edit_loc" >Edit</div >';
    }
    echo '      <div class = "ghr-2 ghr-box" style = "left:0px" >
                    <div class = "ghr-box-head" >
                        <span class = "ghr-icon-2 ghr-icon" >
                        </span >
                        <span class = "ghr-head-title-place ghr-head-title" >
        ' . $class->location . '
                        </span >
                        <input type = "text" class="edit_header ed_loc" >
                    </div >
                </div >
            </div >

            <div class = "ghr-3 ghr-box" >
                <a class = "department-link" href="department.php?dept_id=' . $department->department_id . '">
                    <div class = "ghr-box-head" >
                        <div class = "ghr-icon-3 ghr-icon" style="background-image:url(';
                            if($department->picture_file_id){
                                echo Yii::app()->getBaseUrl(true).$department->pictureFile->file_url;
                            }else{
                                echo Yii::app()->getBaseUrl(true). '/assets/default/dept_dp.png';
                            }
echo                   ');background-size:cover;height:20px;width:20px;display: inline-block;border-radius:4px;" >
                        </div >
                        <span class = "ghr-head-title dept_title_txt">
        ' . $department->department_name . '
                        </span>
                    </div>
                </a>
            </div>
        </div> <!--end group header right -->
        <div class = "group-head-footer" >
            <div class = "group-header-tab" >
                <ul class = "group-nav" >';
                /* for non-member view there is a class */
				if ($is_member) {
					echo '<li class = "group-tab" >
			                <a class = "tab1 tab-anchor group-tab-active" >
			                    <div class = "tab-title" >
			                        CLASS FEED
			                        <span class = "tab-icon tab1-icon-active" ></span >
			                    </div >
			                </a >
			            </li >';
				}
				// new tab for non-member view as suggested by Kuan
				else {

					echo '<li class = "group-tab" >
                            <a class = "tab1 tab-anchor group-tab-active about-tab" >
                                <div class = "tab-title" style="padding-left:25px;" >
                                    ABOUT
                                </div >
                            </a >
                            <button id="group-about-link" style="display:none;"></button>
                        </li >';
				}
                echo '
                    <li class = "group-tab" >
                        <a class = "tab2 tab-anchor tab-inactive" >
                            <div class = "tab-title" >
                                MEMBERS
                                <span class = "tab-icon tab2-icon-inactive" ></span >
                            </div >
                            <div class = "status tab-number" >
                                <span class = "badge" >
                                    ' . count($class->users) . '
                                </span >
                            </div >
                        </a >
                    </li >';
	if ($is_member) {

		echo '<li class = "group-tab" >
                        <a class = "tab3 tab-anchor tab-inactive" >
                            <div class = "tab-title" >
                                FILES
                                <span class = "tab-icon tab3-icon-inactive" ></span >
                            </div >
                            <div class = "status tab-number" >
                                <span class = "badge" >'
     . count($class->files).
                               ' </span >
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
                </ul >';
	}
     echo '</div >
           <div class = "group-footer-functions" >';
    if ($is_admin) {
        echo '
            </div >
        </div >
        <div class = "tab-wedge-down">
        </div >
        </div>
    </div > ';
    } else {

        //checking enrollment and echoing button accordingly
        if ($is_member) {
            echo '
                <div class = "join-button" >
                    <a class = "join" >
    Enroll
                    </a >
                </div >
                <div class="settings-button">
                    <a class="class-settings"><div class="settings-bg"></div></a>
                </div>
                <div class="settings-hover">
                    <div class="settings-hover-tip"></div>
                    <div class="settings-hover-body">Adjust settings and invite people</div>
                </div>
                <div class="settings-menu">
                    <div class="settings-drop">
                        <div class ="settings-item" id="show-class-settings"><div class="class-menu-icon" id="class-settings"></div>Class settings</div>
                        <hr class = "hr">
                        <div class ="settings-item" id="show-class-invite"><div class="class-menu-icon" id="class-invite"></div>Invite people</div>
                    </div>
                </div>
            </div >
        </div >
        <div class = "tab-wedge-down" style="left:303px">
        </div >
        </div>
    </div > ';
        } else {
            echo '
                <div class = "join-button" >
                    <a class = "join joined" >
    Enrolled
                    </a >
                </div >
                <div class="settings-button">
                    <a class="class-settings"><div class="settings-bg"></div></a>
                </div>
                <div class="settings-hover">
                    <div class="settings-hover-tip"></div>
                    <div class="settings-hover-body">Adjust settings and invite people</div>
                </div>
                <div class="settings-menu">
                    <div class="settings-drop">
                        <div class ="settings-item" id="show-class-settings"><div class="class-menu-icon" id="class-settings"></div>Class settings</div>
                        <hr class = "hr">
                        <div class ="settings-item" id="show-class-invite"><div class="class-menu-icon" id="class-invite"></div>Invite people</div>
                    </div>
                </div>
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
        </div>
    </div > ';
        }
    }


?>