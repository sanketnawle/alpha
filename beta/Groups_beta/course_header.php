<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/18/14
 * Time: 11:02 AM
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//database connection file
require_once '../php/dbconnection.php';
require_once '../includes/common_functions.php';

$course_id = "BE 871X";
$user_id = 1;
$user_type = 's';
$univ_id = 1;
$current_semester = 'fall';

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

//$current_semester = get_current_semester($con, $univ_id);

//get course details for header
$course_details_query = "SELECT D.dept_id, D.dept_name, C.*, COUNT(CM.class_id) as class_count, COUNT(CF.user_id) as follow_count FROM courses C
LEFT JOIN department D ON C.dept_id = D.dept_id
LEFT JOIN course_follow CF ON CF.course_id = C.course_id AND CF.user_id = $user_id
LEFT JOIN courses_semester CM ON CM.course_id = C.course_id AND CM.semester = '$current_semester'
WHERE C.course_id = '$course_id'";
$course_details_query_result = mysqli_query($con, $course_details_query);

$course_row = mysqli_fetch_array($course_details_query_result);

echo "
    <div class = 'group-head-sec'>
        <div class = 'group-head-top-sec'>

            <!--<div class = 'classesExpandUI'>
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
            </div>-->


        </div>
        <div class = 'group-pic-frame'>
            <div style='background:no-repeat url(../includes/get_blob.php?img_id=" . $course_row['dp_blob_id'] . "background-size:cover;)' class = 'group-pic'>
            </div>
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
if ($course_row['follow_count'] > 0) {
    echo "
                    <div class= 'btnWrap'>
                        <button class = 'followBtn unfollowBtn'>
                            <em></em>
                            Unfollow this Course
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
                <div class= 'courseDepartment'>
                    <a><span>" . $course_row['dept_name'] . "</span></a>
                </div>
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