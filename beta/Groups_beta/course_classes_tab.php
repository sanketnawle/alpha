<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/6/14
 * Time: 3:44 PM
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//database connection file
require_once '../php/dbconnection.php';
require_once '../includes/common_functions.php';
require_once '../includes/follow.php';

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
if (isset($_SESSION['univ_id'])) {
    $univ_id = $_SESSION['univ_id'];
}
if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
}
//$current_semester = get_current_semester($con, $univ_id);

$get_classes_query = "SELECT CM.*, U.firstname, U.lastname, C.course_desc, C.course_name FROM courses_semester CM
LEFT JOIN user U ON U.user_id = CM.professor
LEFT JOIN courses C ON C.course_id = CM.course_id
WHERE CM.course_id = '$course_id' AND CM.semester = '$current_semester'";

$get_classes_query_result = mysqli_query($con, $get_classes_query);

//starting of course tab content and card wrapper
echo "
    <div class = 'courses-tab-content'>
        <div class = 'coursesCards card-wrapper'>
";

while ($row = mysqli_fetch_array($get_classes_query_result)) {
    if ($row['class_id'] == '') {
        break;
    }
    $this_class_id = $row['class_id'];

    if ($row['dp_blob_id'] == NULL or $row['dp_blob_id'] == '') {
        $row['dp_blob_id'] = 1;
    }
    if ($row['lastname'] == '') {
        $row['lastname'] = $row['professor'];
    }

    //check whether the user is enrolled in this course
    $get_enroll_query = "SELECT COUNT(*) as total FROM courses_user WHERE class_id = '$this_class_id' AND user_id = $user_id";
    $get_enroll_query_result = $con->query($get_enroll_query);
    $enroll_row = mysqli_fetch_array($get_enroll_query_result);

    echo "
            <div class = 'item courses-selector'>
                <div class = 'courses ajax'>
                    <div class = 'course-top course-row'>
                        <div class = 'leftFloat'>
                            <div class = 'frame'>
                                <img width = '44px' height = '44px' src = '../includes/get_blob.php?img_id=" . $row['dp_blob_id'] . "' class = 'coursePicture'>
                            </div>
                            <a class = 'classlink' href='../class.php?class_id=" . $this_class_id . "'>
                                <h3 class = 'course-name'>" . $row['section_id'] . "</h3>
                            </a>
                            <div class = 'course-professor'>
                                 <span>Taught by</span>
                                <img  width = '21px' height = '21px' src = '../" . get_user_dp($con, $row['professor']) . "' class = 'professorPicture'>
                                <a class = 'courseCardLink'>Professor " . $row['lastname'] . "</a>
                            </div>
                        </div>";
    if ($user_type == 'p') {
        if ($user_id == $row['professor']) {
            //professor viewing his class
        } else {
            //if already joined class
            if ($enroll_row['total'] > 0) {
                echo "
                        <div class = 'classUIBtn'>
                            <!-- change 'Class' to 'Course' and button to follow, for courses in the button below'-->
                            <button class = 'joinBtn JoinBtnLong joinedBtn'>
                                Member
                            </button>
                        </div>
                ";
            } else {
                //not joined class
                echo "
                        <div class = 'classUIBtn'>
                            <!-- change 'Class' to 'Course' and button to follow, for courses in the button below'-->
                            <button class = 'joinBtn JoinBtnLong'>
                                Join
                            </button>
                        </div>
                ";

            }
        }
    } elseif ($user_type == 's') {
        //if already joined class
        if ($enroll_row['total'] > 0) {
            echo "
                        <div class = 'classUIBtn'>
                            <!-- change 'Class' to 'Course' and button to follow, for courses in the button below'-->
                            <button class = 'joinBtn JoinBtnLong joinedBtn'>
                                Member
                            </button>
                        </div>
                ";
        } else {
            //not joined class
            echo "
                        <div class = 'classUIBtn'>
                            <!-- change 'Class' to 'Course' and button to follow, for courses in the button below'-->
                            <button class = 'joinBtn JoinBtnLong'>
                                Join
                            </button>
                        </div>
                ";

        }
    }
    //schedule for this class
    $get_schedule_query = "SELECT S.* FROM schedule S, courses_semester_schedule CMS WHERE CMS.class_id = '$this_class_id' AND CMS.schedule_id = S.schedule_id";
    $get_schedule_query_result = mysqli_query($con, $get_schedule_query);

    //joining all the schedule days of class and making one string
    $schedule_string = "";
    $class_schedule = array();
    $conflict_status = FALSE;
    while ($schedule_row = mysqli_fetch_array($get_schedule_query_result)) {
        if (strpos($schedule_row['day'], 'TBA') !== FALSE) {
            $schedule_string = "TBA";
            continue;
        }
        $class_schedule[] = array(
            'schedule' => $schedule_row['schedule_id'],
            'course' => $row['section_id'],
            'class_id' => $row['class_id'],
            'day' => $schedule_row['day'],
            'start' => $schedule_row['start_time'],
            'end' => $schedule_row['end_time'],
            'conflict' => 'FALSE'
        );
        $start_time = new DateTime($schedule_row['start_time']);
        $end_time = new DateTime($schedule_row['end_time']);

        if ($start_time->format("a") == $end_time->format("a")) {
            $schedule_string = $schedule_string . $schedule_row['day'] . " " . $start_time->format("g:i a") . "-" . $end_time->format("g:i a") . "";
        } else {
            $schedule_string = $schedule_string . $schedule_row['day'] . " " . $start_time->format("g:i a") . "-" . $end_time->format("g:i a") . "";
        }
        $schedule_string = $schedule_string . ",";
    }
    $schedule_string = trim($schedule_string, ",");

    if (count($class_schedule) > 0) {
        require_once '../php/check_class_conflict.php';
        $conflict_status = checkConflict($user_id, $class_schedule);
        echo $conflict_status . " conflict status ";
    }
    if ($conflict_status == 'FALSE') {
        $conflict_string = "You have no other classes at this time.";
    } else {
        $conflict_string = "You have a conflict with " . $conflict_status;
    }
    echo "
                    </div>
                    <div class = 'course-row course-middle-top'>
                        <!--Hide Professor and time for and reviews for courses -->

                        <div class = 'leftFloat course-column time-column'>
                            <em class = 'schedule-free'>
                            </em>
                            <p class = 'course-info'>
                                " . $schedule_string . "
                            </p>
                            <div class = 'help-div-left' id = 'help-classTime'>
                                <div class = 'help-wedge'>
                                </div>
                                <div class = 'help-box'>
                                    " . $conflict_string . "
                                </div>
                            </div>
                        </div>


                        <!--For courses show the following HTML = the different class sections for this course
                        <div class = 'leftFloat course-column reviews-column'>
                            <a class = 'courseCardLink'>
                                Read Reviews (20)
                            </a>
                            <em class = 'right-arrow right-arrow-blue'></em>
                        </div>-->
                    </div>
                    <div class = 'course-row course-middle-bottom'>
                        <div class = 'courseDescription'>
                            " . $row['course_desc'] . "

                        </div>

                    </div>";
    $connected_users = get_connected_users($user_id);
    if (count($connected_users) > 0 AND is_array($connected_users)) {
        $connected_users = join(', ', $connected_users);
        $get_course_connection_query = "SELECT U.user_id, U.firstname, U.lastname, SA.student_type FROM courses_user CU
JOIN user U on CU.user_id = U.user_id AND U.user_type = 's'
JOIN student_attribs SA on U.user_id = SA.user_id
WHERE CU.user_id IN ($connected_users) AND CU.class_id = '$this_class_id' LIMIT 0,8";
        $get_course_connection_query_result = $con->query($get_course_connection_query);

        $user_count = mysqli_num_rows($get_course_connection_query_result);
        if ($user_count > 1) {
            $user_row = mysqli_fetch_array($get_course_connection_query_result);
            echo "
                <div class = 'course-row course-bottom'>
                    <div class = 'courseMember friendMember'>

                        <img class = 'courseMemberPic MemberPicBig' src = '../" . get_user_dp($con, $user_row['user_id']) . "'>
                        <div class = 'courseMembersWrapper'>
                            <a href='../profile.php?user_id=" . $user_row['user_id'] . "'>" . $user_row['firstname'] . " " . $user_row['lastname'] . "</a>
                            <span>and <b>" . $user_count . "</b> others you know have taken this class</span>
                        </div>
                    </div>
                </div>
            ";
        } elseif ($user_count > 0) {
            $user_row = mysqli_fetch_array($get_course_connection_query_result);
            echo "
                <div class = 'course-row course-bottom'>
                    <div class = 'courseMember friendMember'>
                        <img class = 'courseMemberPic MemberPicBig' src = 'src/myPic.png'>
                        <div class = 'courseMembersWrapper'>
                            <a href='../profile.php?user_id=" . $user_row['user_id'] . "'>" . $user_row['firstname'] . " " . $user_row['lastname'] . "</a>
                        </div>
                    </div>
                </div>
            ";

        } else {

        }
    }
    echo "
                </div>
            </div>
    ";

}

/*
echo "
                            <div class = 'courses-tab-content'>

                            <div class = 'coursesCards card-wrapper'>


                                <div class = 'item courses-selector'>
                                    <div class = 'courses ajax'>
                                        <div class = 'course-top course-row'>
                                            <div class = 'leftFloat'>
                                                <div class = 'frame'>
                                                    <img width = '44px' height = '44px' src = 'src/neuroscience.jpg' class = 'coursePicture'>
                                                </div>
                                                <a class = 'classLink'>
                                                    <h3 class = 'course-name'>Neuroscience and Advertising</h3>
                                                </a>
                                                <!-- For Courses, hide the ID here and instead show the various class ID's in the next row -->
                                                <h4 class = 'section-id'>
                                                    NSC203A
                                                </h4>
                                                <div class = 'course-professor'>
                                                     <span>Taught by</span>
                                                    <img  width = '21px' height = '21px' src = 'src/memon.jpg' class = 'professorPicture'>
                                                    <a class = 'courseCardLink'>Professor Herbert</a>
                                                </div>
                                            </div>
                                            <div class = 'classUIBtn'>
                                                <!-- change 'Class' to 'Course' and button to follow, for courses in the button below'-->
                                                <button class = 'joinBtn JoinBtnLong'>
                                                    Join this Class
                                                </button>
                                            </div>

                                        </div>
                                        <div class = 'course-row course-middle-top'>
                                            <!--Hide Professor and time for and reviews for courses -->

                                            <div class = 'leftFloat course-column time-column'>
                                                <em class = 'schedule-free'>
                                                </em>
                                                <p class = 'course-info'>
                                                    M 10:00am-11:00am W 1:30pm-4:00pm
                                                </p>
                                                <div class = 'help-div-left' id = 'help-classTime'>
                                                    <div class = 'help-wedge'>
                                                    </div>
                                                    <div class = 'help-box'>
                                                        You have no other classes at this time.
                                                    </div>
                                                </div>
                                            </div>


                                            <!--For courses show the following HTML = the different class sections for this course  -->
                                            <div class = 'leftFloat course-column reviews-column'>
                                                <a class = 'courseCardLink'>
                                                    Read Reviews (20)
                                                </a>
                                                <em class = 'right-arrow right-arrow-blue'></em>
                                            </div>
                                        </div>
                                        <div class = 'course-row course-middle-bottom'>
                                            <div class = 'courseDescription'>
                                                Calculating the actual coordinates of your box and doing the bounds checks will be tough, and will rely on mouse events anyways to get the mouse's current coordinates. Tracking mouseover/mouseouts has the issues you mentioned.

                                            </div>

                                        </div>

                                        <!-- This bottom row displays other students who are either members of this class or following this course show 8-->

                                        <div class = 'course-row course-bottom'>
                                            <div class = 'courseMember friendMember'>

                                                <img class = 'courseMemberPic MemberPicBig' src = 'src/myPic.png'>
                                                <div class = 'courseMembersWrapper'>
                                                    <a>Jacob Lazarus</a>
                                                    <span>and <b>4</b> others you know have taken this class</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class = 'item courses-selector'>
                                    <div class = 'courses ajax'>
                                        <div class = 'course-top course-row'>
                                            <div class = 'leftFloat'>
                                                <div class = 'frame'>
                                                    <img width = '44px' height = '44px' src = 'src/neuroscience.jpg' class = 'coursePicture'>
                                                </div>
                                                <a class = 'classLink'>
                                                    <h3 class = 'course-name'>Neuroscience and Advertising</h3>
                                                </a>
                                                <!-- For Courses, hide the ID here and instead show the various class ID's in the next row -->
                                                <h4 class = 'section-id'>
                                                    NSC203A
                                                </h4>
                                                <div class = 'course-professor'>
                                                     <span>Taught by</span>
                                                    <img  width = '21px' height = '21px' src = 'src/memon.jpg' class = 'professorPicture'>
                                                    <a class = 'courseCardLink'>Professor Herbert</a>
                                                </div>
                                            </div>
                                            <div class = 'classUIBtn'>
                                                <!-- change 'Class' to 'Course' and button to follow, for courses in the button below'-->
                                                <button class = 'joinBtn JoinBtnLong'>
                                                    Join this Class
                                                </button>
                                            </div>

                                        </div>
                                        <div class = 'course-row course-middle-top'>
                                            <!--Hide Professor and time for and reviews for courses -->

                                            <div class = 'leftFloat course-column time-column'>
                                                <em class = 'schedule-free'>
                                                </em>
                                                <p class = 'course-info'>
                                                    M 10:00am-11:00am W 1:30pm-4:00pm
                                                </p>
                                                <div class = 'help-div-left' id = 'help-classTime'>
                                                    <div class = 'help-wedge'>
                                                    </div>
                                                    <div class = 'help-box'>
                                                        You have no other classes at this time.
                                                    </div>
                                                </div>
                                            </div>


                                            <!--For courses show the following HTML = the different class sections for this course  -->
                                            <div class = 'leftFloat course-column reviews-column'>
                                                <a class = 'courseCardLink'>
                                                    Read Reviews (20)
                                                </a>
                                                <em class = 'right-arrow right-arrow-blue'></em>
                                            </div>
                                        </div>
                                        <div class = 'course-row course-middle-bottom'>
                                            <div class = 'courseDescription'>
                                                Calculating the actual coordinates of your box and doing the bounds checks will be tough, and will rely on mouse events anyways to get the mouse's current coordinates. Tracking mouseover/mouseouts has the issues you mentioned.

                                            </div>

                                        </div>

                                        <!-- This bottom row displays other students who are either members of this class or following this course show 8-->

                                        <div class = 'course-row course-bottom'>
                                            <div class = 'courseMember friendMember'>

                                                <img class = 'courseMemberPic MemberPicBig' src = 'src/myPic.png'>
                                                <div class = 'courseMembersWrapper'>
                                                    <a>Jacob Lazarus</a>
                                                    <span>and <b>4</b> others have taken this class</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
";*/
?>