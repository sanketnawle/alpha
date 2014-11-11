<script src='<?php echo Yii::app()->getBaseUrl(true);?>/js/class/class_about_tab.js'></script>

<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/30/14
 * Time: 12:39 PM
 */

/*include 'php/dbconnection.php';
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
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}

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


$get_course_about_query = "SELECT C.course_desc, U.firstname, U.lastname, U.user_id FROM courses C
JOIN courses_semester CM on CM.course_id = C.course_id AND CM.class_id = '$class_id'
JOIN user U on CM.professor = U.user_id";
$get_course_about_query_result = $con->query($get_course_about_query);
*/
//about content starts here
echo "
    <div class = 'about-content'>
";

//about left section starts
echo "
        <div class = 'about-tab-leftsec'>
";



echo "
            <div class = 'about-tab-about about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        About
                    </div>
                </div>
                <div class = 'tab-block-content'>";
                    echo '<p>Schedule: <br>';
                    foreach($schedules as $schedule){
                        echo $schedule.'<br>';
                    }
                    echo '</p>';
                    echo '<p>Course Name: <a href="'.Yii::app()->getBaseUrl(true).'/course/'.$course->course_id.'">'.$course->course_name.'</a></p>';
                    echo '<p>Course Description: '.$course->course_desc.'</p>';
                    echo '<p>Users you follow who have taken this course:<br>';
                    foreach($all_following as $user_followed){
                        if($user_followed->user_type == 's'){
                            echo '    <a href="'.Yii::app()->getBaseUrl(true).'/course/'.$user_followed['user_id'].'">'.$user_followed['firstname'].' '.$user_followed['lastname'].'</a><br>';

                        }else{
                            echo '    <a href="'.Yii::app()->getBaseUrl(true).'/course/'.$user_followed['user_id'].'">Professor '.$user_followed['lastname'].'</a><br>';
                        }
                    }
                    echo '<p>Department Name: <a href="'.Yii::app()->getBaseUrl(true).'/user/'.$department->department_id.'">'.$department->department_name.'</a></p>';
                    echo '<p>Department description: '.$department->department_description.'</p>';
                    echo '<p>Professor Name: <a href="'.Yii::app()->getBaseUrl(true).'/user/'.$professor->user_id.'"> Professor '.$professor->firstname.' '.$professor->lastname.'</a></p>';
                    echo '<p>Professor Bio: '.$professor->user_bio.'</p>';
                    echo '<p>Other courses taught by this professor:<br>';
                    foreach($other_courses as $other_course){
                        echo '    <a href="'.Yii::app()->getBaseUrl(true).'/course/'.$other_course['course_id'].'">'.$other_course['course_name'].'</a><br>';
                    }
                    echo '</p>';

echo "
                </div>
                    <div class = 'about_edit'>
                            <textarea class = 'about_edit_area'></textarea>
                            <div class = 'about_edit_toolbar'>
                                <button class = 'about_edit_done'>Done</button>
                                <button class = 'about_edit_cancel'>Cancel</button>
                            </div>
                    </div>
            </div>
";
/*
$connected_users = get_connected_users($user_id);
if (count($connected_users) > 0) {
    $connected_users = join(', ', $connected_users);
    $get_course_connection_query = "SELECT U.user_id, U.firstname, U.lastname, SA.student_type FROM courses_user CU
JOIN user U on CU.user_id = U.user_id AND U.user_type = 's'
JOIN student_attribs SA on U.user_id = SA.user_id
WHERE CU.user_id IN ($connected_users) AND CU.class_id = '$class_id' LIMIT 0,8";
    $get_course_connection_query_result = $con->query($get_course_connection_query);
*/

    if (count($all_following) > 0) {
        echo "
           <div class = 'about-tab-members about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        STUDENTS YOU KNOW WHO TOOK THIS COURSE <span>(" . count($all_following). ")</span>
                    </div>

                </div>
                <div class = 'tab-block-content tab-block-content-scroll'>
                    <div class = 'members-scrollwrap'>
                        <ul class = 'people-you-know'>
    ";
        foreach ($all_following as $user_followed) {
            echo "
                            <li class = 'people-box'>
                                <div class = 'person-pic-wrap' style='background-image:url(";
            if($user_followed->picture_file_id) {
                echo Yii::app()->getBaseUrl(true) . $user_followed->pictureFile->file_url;
            }else{
                echo Yii::app()->getBaseUrl(true).'/assets/default/user.png';
            }
           echo                     ")'>
                                </div>"
                              //  <span class = 'grade'>  </span>
                               . " <div class = 'person-title-wrap'>
                                    <a href='" .Yii::app()->getBaseUrl(true)."/profile/" . $user_followed->user_id . "'><p>" . $user_followed->firstname . " " . $user_followed->lastname . "</p></a>
                                </div>
                                <div class = 'after-click-effect'></div>
                            </li>
        ";
        }

        echo "
                        </ul>
                    </div>
                    <a class = 'ddbox-hor-scroller hor-scroller-left'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-left'>
                        </i>
                    </a>
                    <a class = 'ddbox-hor-scroller hor-scroller-right'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-right'>
                        </i>
                    </a>
                </div>
            </div>
    ";

    }   /* else {
        $get_course_student_query = "SELECT U.* FROM user U WHERE U.user_id IN(SELECT user_id from courses_user
WHERE class_id = '$class_id' AND is_admin = 0 LIMIT 0,8)";
        $get_course_student_query_result = $con->query($get_course_student_query);
        $user_count = 0;
        if ($get_course_student_query_result) {
            $user_count = $get_course_student_query_result->num_rows;
        }
        if ($user_count > 0) {
            echo "
           <div class = 'about-tab-members about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        STUDENTS IN THIS COURSE <span>(" . $user_count . ")</span>
                    </div>

                </div>
                <div class = 'tab-block-content tab-block-content-scroll'>

                    <div class = 'members-scrollwrap'>
                        <ul class = 'people-you-know'>
    ";
            while ($row = $get_course_student_query_result->fetch_array()) {
                echo "
                            <li class = 'people-box'>
                                <div class = 'person-pic-wrap' style='background-image:url(" . get_user_dp($con, $row['user_id']) . ")'>
                                </div>
                                <span class = 'grade'>Grad</span>
                                <div class = 'person-title-wrap'>
                                    <a href='profile.php?user_id=" . $row['user_id'] . "'><p></a>" . $row['firstname'] . " " . $row['lastname'] . "</p>
                                </div>
                                <div class = 'after-click-effect'></div>
                            </li>
        ";
            }
            echo "
                        </ul>
                    </div>
                    <a class = 'ddbox-hor-scroller hor-scroller-left'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-left'>
                        </i>
                    </a>
                    <a class = 'ddbox-hor-scroller hor-scroller-right'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-right'>
                        </i>
                    </a>
                </div>
            </div>
    ";
        }

    }
} else {
    $get_course_student_query = "SELECT U.* FROM user U WHERE U.user_id IN(SELECT user_id from courses_user
WHERE class_id = '$class_id' AND is_admin = 0 LIMIT 0,8)";
    $get_course_student_query_result = $con->query($get_course_student_query);

    $user_count = mysqli_num_rows($get_course_student_query_result);
    if ($user_count > 0) {
        echo "
           <div class = 'about-tab-members about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        STUDENTS IN THIS COURSE <span>(" . $user_count . ")</span>
                    </div>

                </div>
                <div class = 'tab-block-content tab-block-content-scroll'>

                    <div class = 'members-scrollwrap'>
                        <ul class = 'people-you-know'>
    ";
        while ($row = $get_course_student_query_result->fetch_array()) {
            echo "
                            <li class = 'people-box'>
                                <div class = 'person-pic-wrap' style='background-image:url(" . get_user_dp($con, $row['user_id']) . ")'>
                                </div>
                                <span class = 'grade'>Grad</span>
                                <div class = 'person-title-wrap'>
                                    <a href='profile.php?user_id=" . $row['user_id'] . "'><p></a>" . $row['firstname'] . " " . $row['lastname'] . "</p>
                                </div>
                                <div class = 'after-click-effect'></div>
                            </li>
        ";
        }
        echo "
                        </ul>
                    </div>
                    <a class = 'ddbox-hor-scroller hor-scroller-left'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-left'>
                        </i>
                    </a>
                    <a class = 'ddbox-hor-scroller hor-scroller-right'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-right'>
                        </i>
                    </a>
                </div>
            </div>
    ";
    }

}
*/
echo "
    <div class = 'about-tab-prof about-tab-block'>
        <a class = 'prof-header'><div class = 'tab-block-header'>
            <div class = 'block-head-left'>
                <a href='profile.php?user_id=" . $professor->user_id . "'>Profesor " . $professor->lastname . "</a>
            </div>

        </div></a>
    </div>
";

//closing about-tab-leftsec
echo "
        </div>
";

//opening about-tab-rightsec and group-about
echo "
        <div class = 'about-tab-rightsec'>
            <div class = 'group-about group-about-2'>
";
/*
$get_course_files_query = "SELECT FU.*, U.user_id, U.firstname, U.lastname FROM course_files CF
LEFT JOIN file_upload FU on FU.file_id = CF.file_id
LEFT JOIN user U on CF.user_id = CF.user_id
WHERE CF.class_id = '$class_id'
UNION
(SELECT FU.*, U.user_id, U.firstname, U.lastname FROM posts P
LEFT JOIN file_upload FU on FU.file_id = P.file_id
LEFT JOIN user U on U.user_id = P.user_id
WHERE P.target_id = '$class_id' AND P.target_type = 'courses_semester' AND P.file_id IS NOT NULL)
ORDER BY created_timestamp
LIMIT 0,1";
$get_course_files_query_result = $con->query($get_course_files_query);

if (mysqli_num_rows($get_course_files_query_result) > 0) {
   */ echo "
                 <div class = 'box-header'>
                    <span class = 'bh-t1'>
                        RECENT UPLOAD
                    </span>
                    <span class = 'midline-dot'>
                        &#183;
                    </span>
                    <a style = 'font-weight:600;' class = 'bh-t2 small_upload'>
                        Upload a file
                    </a>
                    <form>
                    <input class='file_small_upload_input' type='file' name='file'>
                    </form>
                </div>
    ";
/*    $file_row = $get_course_files_query_result->fetch_array();
    $time_string = new DateTime(user_time($file_row['created_timestamp']));
    $time_string = $time_string->format("F j");

    //closing group-about
  */  echo "
                <div class = 'box-content content-file'>
                    <a class = 'file-download' href='php/download_file.php?file_id="
                            //. $file_row['file_id'] .
                        ."derp".
                        "'>
                    <div class = 'file-icon'>
                    </div>
                    <div class= 'file-name'>".
                       // " . $file_row['file_name'] . "
                        " derp"
                   . "</div>
                    </a>".
                 //   <div class ='file-created'>
                 //       <a class = 'file-creator'  href='profile.php?user_id=" . $file_row['user_id'] . "'>" . $file_row['firstname'] . " " . $file_row['lastname'] . "</a> <span> uploaded " . $time_string . "</span>
                 //   </div>
            "    </div>
    ";


//}

echo "
                <div class = 'box-header'>
                    <a class = 'bh-t2 small_invite_email'>
                        Invite email list
                    </a>
                </div>
                <div class = 'box-content content-invite'>
                    <form rel = '' method = 'post'>
                        <input type = 'hidden' autocomplete = 'off'>
                        <i class = 'plusIcon'></i>
                        <div class = 'invite-input-wrap'>
                            <div class = 'innerWrap'>
                                <input type = 'text' class = 'inputText inviteInput' name = 'Invite form' placeholder = 'Invite people to join this course'>
                                <div class = 'search-icon' title = 'Search people'>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
";

//closing about-content
echo "
    </div>
";
?>