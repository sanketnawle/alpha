<script>

</script>

<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/13/14
 * Time: 5:53 PM
 */


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'php/dbconnection.php';
require_once 'includes/follow.php';


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['dept_id'])) {
    $dept_id = $_POST['dept_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_SESSION['univ_id'])) {
    $univ_id = $_SESSION['univ_id'];
}

$current_semester = get_current_semester($con, $univ_id);

if ($user_type == 'p') {
    $admin_check_query = "SELECT COUNT(*) as admin_flag FROM user WHERE user_id = $user_id AND dept_id = $dept_id";
    $admin_check_query_result = $con->query($admin_check_query);
    $admin_row = $admin_check_query_result->fetch_array();
    $admin_flag = $admin_row['admin_flag'];
} else {
    $admin_flag = 0;
}

$get_courses_query = "SELECT C.*, (SELECT COUNT(*) FROM course_follow CF WHERE C.course_id = CF.course_id AND CF.user_id = $user_id) as follow_flag, (SELECT COUNT(CM.class_id) FROM courses_semester CM WHERE CM.course_id = C.course_id AND CM.semester = '$current_semester') as class_count FROM courses C WHERE C.dept_id = $dept_id ORDER BY class_count DESC";
$get_courses_query_result = $con->query($get_courses_query);

echo "
    <div class = 'courses-tab-content'>
        <div class = 'coursesCards card-wrapper'>
";

$connected_users = get_connected_users($user_id);

while ($course_row = $get_courses_query_result->fetch_array()) {
    $this_course_id = $course_row['course_id'];
    $get_class_query = "SELECT CM.section_id, CM.class_id FROM courses_semester CM WHERE CM.course_id = '$this_course_id' AND CM.semester = '$current_semester'";
    $get_class_query_result = $con->query($get_class_query);

    echo "
                                <div class = 'item courses-selector' id='$this_course_id'>
                                    <div class = 'courses ajax'>
                                        <div class = 'course-top course-row'>
                                            <div class = 'leftFloat'>
                                                <div class = 'frame'>
                                                    <img width = '44px' height = '44px' src = '" . get_dp($con, $this_course_id, 'course') . "' class = 'coursePicture'>
                                                </div>
                                                <a class = 'classLink' href='courses.php?course_id=" . $this_course_id . "'>
                                                    <h3 class = 'course-name'>" . $course_row['course_name'] . "</h3>
                                                </a>

                                            </div>";
    if ($course_row['follow_flag'] > 0) {
        echo "
                                            <div class = 'classUIBtn'>
                                                <button class='joinBtn JoinBtnLong joinedBtn'>
                                                    Joined
                                                </button>
                                            </div>
    ";
    } else {
        echo "
                                            <div class = 'classUIBtn'>
                                                <button class = 'joinBtn JoinBtnLong'>
                                                    Join
                                                </button>
                                            </div>
    ";
    }
    echo "
                                        </div>
                                        <div class = 'course-row course-middle-top'>
                                            <div class = 'leftFloat course-column time-column'>                                                ";
    if ($get_class_query_result->num_rows == 0) {
        echo "
                                                <p class = 'course-info'>
                                                    No classes this semester
                                                </p>
        ";
    } else {
        while ($class_row = $get_class_query_result->fetch_array()) {
            echo "
                                            <a href='class.php?class_id=" . $class_row['class_id'] . "'>
                                                <p class = 'course-info'>
                                                    " . $class_row['section_id'] . "
                                                </p>
                                            </a>
        ";
        }
    }
    if (strlen($course_row['course_desc']) > 250) {
        $course_row['course_desc'] = substr($course_row['course_desc'], 0, 245) . "...";
    }

    echo "
                                            </div>
                                        </div>
                                        <div class = 'course-row course-middle-bottom'>
                                            <div class = 'courseDescription'>
                                            " . $course_row['course_desc'] . "
                                            </div>

                                        </div>
    ";
    if (count($connected_users) > 0 AND is_array($connected_users)) {
        $connected_users = join(', ', $connected_users);
        $get_course_connection_query = "SELECT U.user_id, U.firstname, U.lastname FROM course_follow CF
JOIN user U on CF.user_id = U.user_id AND U.user_type = 's'
WHERE CF.user_id IN ($connected_users) AND CF.course_id = '$this_course_id'";
        $get_course_connection_query_result = $con->query($get_course_connection_query);

        $user_count = $get_course_connection_query_result->num_rows;
        if ($user_count > 1) {
            $user_count = $user_count - 1; //decrease count by one since one user is shown
            $user_row = $get_course_connection_query_result->fetch_array();
            echo "
                <div class = 'course-row course-bottom'>
                    <div class = 'courseMember friendMember'>

                        <img class = 'courseMemberPic MemberPicBig' src = '" . get_dp($con, $user_row['user_id'], 'user') . "'>
                        <div class = 'courseMembersWrapper'>
                            <a href='profile.php?user_id=" . $user_row['user_id'] . "'>" . $user_row['firstname'] . " " . $user_row['lastname'] . "</a>
                            <span>and <b>" . $user_count . "</b> others you know have followed this course</span>
                        </div>
                    </div>
                </div>
            ";
        } elseif ($user_count > 0) {
            $user_row = $get_course_connection_query_result->fetch_array();
            echo "
                <div class = 'course-row course-bottom'>
                    <div class = 'courseMember friendMember'>
                        <img class = 'courseMemberPic MemberPicBig' src = '" . get_dp($con, $user_row['user_id'], 'user') . "'>
                        <div class = 'courseMembersWrapper'>
                            <a href='profile.php?user_id=" . $user_row['user_id'] . "'>" . $user_row['firstname'] . " " . $user_row['lastname'] . "</a>
                            <span> has followed this course</span>
                        </div>
                    </div>
                </div>
            ";

        } else {
            //no users you know in this class
        }
    }

    echo "
                                    </div>
                            </div>
    ";
}

echo "
        </div>
    </div>
";

$con->close();

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
                            </div>
                        </div>
";*/

?>