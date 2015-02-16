<?php

/**

 * Created by PhpStorm.

 * User: aditya841

 * Date: 7/18/14

 * Time: 11:02 AM

 */
/*how do you do this, this comment is fucking cool- kuan*/



if (session_status() == PHP_SESSION_NONE) {

    session_start();

}

//database connection file

include 'php/dbconnection.php';

require_once 'includes/common_functions.php';





if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

}

if (isset($_SESSION['user_type'])) {

    $user_type = $_SESSION['user_type'];

}

if (isset($_GET['course_id'])) {

    $course_id = $_GET['course_id'];

}

if (isset($_SESSION['univ_id'])) {

    $univ_id = $_SESSION['univ_id'];

}



$current_semester = get_current_semester($con, $univ_id);

$admin_flag = 0;

if ($user_type == 'p') {

    $check_admin_query = "SELECT COUNT(C.course_id) as admin_flag FROM courses C

    JOIN courses_semester CM ON CM.course_id = C.course_id AND CM.professor = $user_id

    WHERE C.course_id = '$course_id'";

    $check_admin_query_result = $con->query($check_admin_query);

    $admin_row = $check_admin_query_result->fetch_array();

    $admin_flag = $admin_row['admin_flag'];

} else {

    $admin_flag = 0;

}



//get course details for header

$course_details_query = "SELECT D.dept_id, D.dept_name, C.*, COUNT(CM.class_id) as class_count, COUNT(CF.user_id) as follow_flag FROM courses C

LEFT JOIN department D ON C.dept_id = D.dept_id

LEFT JOIN course_follow CF ON CF.course_id = C.course_id AND CF.user_id = $user_id

LEFT JOIN courses_semester CM ON CM.course_id = C.course_id AND CM.semester = '$current_semester'

WHERE C.course_id = '$course_id'";

$course_details_query_result = $con->query($course_details_query);



$course_row = $course_details_query_result->fetch_array();



if ($course_row['course_id'] == NULL or $course_row['course_id'] == 'NULL') {

    echo "course id does not exist. Please check again.";

    $con->close();

    exit;

}

echo "

    <div class = 'group-head-sec'>
                <div class= 'courseDepartment ghr-box ghr-3'>
                <a class = 'department-link' href='department.php?dept_id=" . $course_row['dept_id'] . "'>
                    <div class = 'ghr-box-head' >
                        <div class = 'ghr-icon-3 ghr-icon' style='background-image:url(" . get_dp($con, $course_row['dept_id'], 'dept') . ");background-size:cover;height:20px;width:20px;display: inline-block;border-radius:4px;' >
                        </div >
                        <span class = 'ghr-head-title dept_title_txt'>
        " . $course_row['dept_name'] . "
                        </span>
                    </div>
                </a>
                </div>

";



$get_classes_query = "SELECT U.lastname, U.user_id, CM.class_id, CM.section_id, CM.professor FROM courses_semester CM

 LEFT JOIN user U ON CM.professor = U.user_id

 WHERE CM.course_id = '$course_id' AND CM.semester = '$current_semester'

 ORDER BY lastname DESC

 LIMIT 0,2";

$get_classes_query_result = $con->query($get_classes_query);



echo "

        <div class = 'group-head-top-sec'>

            <div class = 'classesExpandUI'>

                <div class = 'uiHeader uiHeaderFx'>

                    " . $course_row['class_count'] . " Classes this Semester

                </div>

                <div class='uiListWrapper'>

                    <ul class = 'uiList classList'>

";

$count_shown_classes = 0;

while ($class_row = $get_classes_query_result->fetch_array()) {

    $count_shown_classes++;

    $this_class_id = $class_row['class_id'];

    if ($class_row['lastname'] == null or $class_row['lastname'] == 'NULL') {

        $professor_name = "TBA";

    } else {

        $length_section_id = strlen($class_row['section_id']);

        $length_lastname = strlen($class_row['lastname']);

        if ($length_section_id + $length_lastname + 5 > 15) {

            $professor_name = "Prof " . substr($class_row['lastname'], 0, $length_section_id + 8 - 15) . "...";

        } else {

            $professor_name = "Prof " . $class_row['lastname'];

        }

    }



    $get_enroll_query = "SELECT COUNT(*) as total FROM courses_user WHERE class_id = '$this_class_id' AND user_id = $user_id";

    $get_enroll_query_result = $con->query($get_enroll_query);

    $enroll_row = $get_enroll_query_result->fetch_array();



    $get_schedule_query = "SELECT S.* FROM schedule S, courses_semester_schedule CMS WHERE CMS.class_id = '$this_class_id' AND CMS.schedule_id = S.schedule_id ORDER BY day";

    $get_schedule_query_result = $con->query($get_schedule_query);



    //joining all the schedule days of class and making one string

    $schedule_string = "";

    while ($schedule_row = $get_schedule_query_result->fetch_array()) {

        if (strpos($schedule_row['day'], 'TBA') !== FALSE) {

            $schedule_string = "TBA";

            continue;

        }

        $start_time = new DateTime($schedule_row['start_time']);

        $end_time = new DateTime($schedule_row['end_time']);



        if ($start_time->format("a") == $end_time->format("a")) {

            $schedule_string = $schedule_string . $schedule_row['day'] . " " . $start_time->format("g:ia") . "-" . $end_time->format("g:i a") . "";

        } else {

            $schedule_string = $schedule_string . $schedule_row['day'] . " " . $start_time->format("g:ia") . "-" . $end_time->format("g:i a") . "";

        }

        $schedule_string = $schedule_string . ",";

    }

    $schedule_string = trim($schedule_string, ",");

    $schedule_string = substr($schedule_string, 0, 20);



    echo "

                        <li class = 'classLi' id='" . $this_class_id . "'>

                        <a href='class.php?class_id=" . $this_class_id . "'>

                            <div class = 'leftFloat classDetails'>

                                <img src = '" . get_dp($con, $class_row['user_id'], 'user') . "'>

                                <span class = 'classInfo'>" . $schedule_string . "</span>

                                <span class = 'midline-dot'>

                                    &#183;

                                </span>

                                 <span class = 'classInfo classCode'>" . $class_row['section_id'] . "</span>

                                 <span class = 'classInfo'>" . $professor_name . "</span>

                            </div>

                        </a>";

    if ($class_row['professor'] == $user_id) {

        //cant join course

    } elseif ($enroll_row['total'] > 0) {

        echo "



                            <div class ='rightFloat'>

                                <button class = 'joinBtn  joinedBtn'>Member</button>

                            <div>

                        </li>

    ";

    } else {

        echo "



                            <div class ='rightFloat'>

                                <button title = 'Join this section' class = 'joinBtn'>Join</button>

                            <div>

                        </li>

    ";

    }

}

//close list-wrapper

echo "

                    </ul>

";

$remaining_class_count = $course_row['class_count'] - $count_shown_classes;

if ($remaining_class_count == 0) {

    //no more classes

} else {

    echo "

                    <div class = 'uiBtm moreClasses'>

                        <span>" . $remaining_class_count . " More Classes</span><em class = 'moreClassesIcon'></em>

                    </div>

    ";

}



echo "

                </div>

            </div>

        </div>

";

/*

echo "

        <div class = 'group-head-top-sec'>

            <div class = 'classesExpandUI'>

                <div class = 'uiHeader uiHeaderFx'>

                    " . $course_row['class_count'] . " Classes this Semester

                </div>

                <div class='uiListWrapper'>

                    <ul class = 'uiList classList'>

                        <li class = 'classLi'>

                            <div class = 'leftFloat classDetails'>

                                <img src = 'src/memon.jpg'>

                                <span class = 'classInfo'>M 9:00am, Th 10:00am</span>



                                <span class = 'classInfo'>Prof Memon</span>

                                <span class = 'midline-dot'>

                                    &#183;

                                </span>

                                 <span class = 'classInfo classCode'>NSC201A</span>

                            </div>



                            <div class ='rightFloat'>

                                <button title = 'Join this section' class = 'joinBtn'>Join</button>

                            <div>

                        </li>

                        <li class = 'classLi'>

                            <div class = 'leftFloat classDetails'>

                                <img src = 'src/memon.jpg'>

                                <span class = 'classInfo'>MWF 10:00am-11:00am</span>



                                <span class = 'classInfo'>Prof Memon</span>

                            </div>

                            <div class = 'rightFloat'>

                                <button title = 'Join this section' class = 'joinBtn'>Join</button>

                            <div>

                        </li>

                    </ul>

                    <div class = 'uiBtm moreClasses'>

                        <span>3 More Classes</span><em class = 'moreClassesIcon'></em>

                    </div>

                </div>

            </div>

        </div>";*/



echo "

        <div class = 'group-pic-frame'>

            <div style='background:no-repeat url(" . get_dp($con, $course_id, 'course') . ");background-size:cover;' class = 'group-pic'>

            </div>

";

if ($admin_flag > 0) {

    echo "

            <form>

            <input type='file' name='img' class='courses_pic_input' style='display:none;'>

            </form>

";

}

echo "

        </div>

        <div class = 'group-header-left group-header-above'>





            <div class = 'group-title course-group-title'>

                <div class = 'group-name'>

                    " . $course_row['course_name'] . "

                </div>

                <span class = 'group-id'>

                    " . $course_row['course_id'] . "

                </span>

                <br>";

if ($course_row['follow_flag'] > 0) {

    echo "

                    <div class= 'btnWrap'>

                        <button class = 'followBtn unfollowBtn'>

                            <em></em>

                            Following this Course

                        </button>

                    </div>

    ";

} else {

    echo "

                    <div class= 'btnWrap'>

                        <button class = 'followBtn'>

                            <em></em>

                            Follow this Course

                        </button>

                    </div>

    ";

}

echo "


            </div>

        </div>

        <div class = 'group-head-footer'>

            <div class = 'group-header-tab'>

                <ul class = 'group-nav'>

                    <li class = 'group-tab'>

                        <a class = 'tabFeed tab-anchor group-tab-active'>

                            <div class = 'tab-title'>

                                COURSE FEED

                                <span class = 'tab-icon tab1-icon-active'></span>

                            </div>



                        </a>

                    </li>



                    <li class = 'group-tab'>

                        <a class = 'tabCourse tab-anchor tab-inactive'>

                            <div class = 'tab-title'>

                                OPEN CLASSES

                                <span class = 'tab-icon tabClasses-icon-inactive'></span>

                            </div>

                            <div class = 'status tab-number'>

                                <span class = 'badge'>

                                    " . $course_row['class_count'] . "

                                </span>

                            </div>

                        </a>

                    </li>

                    <!--<li class = 'group-tab'>

                        <a class = 'tabAbout tab-anchor-last tab-anchor tab-inactive'>

                            <div class = 'tab-title'>

                                ABOUT

                                <span class = 'tab-icon tabAbout-icon-inactive'></span>

                            </div>

                            <div class = 'status tab-number'>

                                <span class = 'badge'>

                                    5

                                </span>

                            </div>

                        </a>

                    </li>-->



                </ul>

            </div>



        </div>

        <div class = 'tab-wedge-down'></div>

    </div>

";

?>