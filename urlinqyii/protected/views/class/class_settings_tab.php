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
    <div class = 'class-tab-content settings-content'>
";

//About this Class header
echo '
    <div class = "about-header">
        <div class="about-info-img"></div>
        <div class="about-info-txt">Class Settings</div>
        <div id="about-back"><div class="about-back">Back</div><div class="about-back-img"></div></div>
    </div>
    <hr>
';

//about left section starts
echo "
        <div class = 'about-tab-leftsec'>
";


echo "
            <div class = 'about-tab-about about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        Administrative Settings
                    </div>
                </div>
                <div class = 'tab-block-content'>
                    Is this class open to the public...
                </div>
            </div>

           <div class = 'about-tab-members about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        Class TAs and Admins
                    </div>
                </div>
                <div class = 'tab-block-content'>
                    Professor Barrack Obama
                </div>
            </div>
        </div>
";

//opening about-tab-rightsec and group-about
echo "
        <div class = 'about-tab-rightsec prof-rightsec'>
            <div class = 'about-tab-block group-about group-about-2'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>Personal Notification Settings</div>
                </div>
                <div class = 'tab-block-content'>
                    Notifications are ON For this Class
                </div>
            </div>
        </div>
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

    echo "
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
*/

/*    $file_row = $get_course_files_query_result->fetch_array();
    $time_string = new DateTime(user_time($file_row['created_timestamp']));
    $time_string = $time_string->format("F j");

    //closing group-about
    echo "
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
*/

//closing about-content
echo "
    </div>
";
?>