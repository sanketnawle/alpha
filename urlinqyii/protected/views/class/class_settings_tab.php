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
            <div class = 'about-tab-about about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        Administrative Settings
                    </div>
                </div>
                <div class = 'tab-block-content'>
                    <div class='settings-line'>
                        <div class='settings-line-left'><p>Is this class open to the public, or is it invite-only?</p></div>
                        <div class='settings-line-middle'>
                            <p class='settings-open-current' id='class-open-privacy'>Public</p>
                            <div class='class-settings-expand' id='settings-open-expand'>
                                <form id='settings-open-form'>
                                    <input type='radio' name='open-option' value='Public' id='Public'>Public<br>
                                    <input type='radio' name='open-option' value='Invite-only' id='Invite-only'>Invite-only<br>
                                    <button class='settings-edit-button settings-edit-submit' id='settings-open-submit' type='submit'>Submit</button>
                                    <button class='settings-edit-button settings-edit-cancel' id='settings-open-cancel' type='cancel'>Cancel</button>
                                </form>
                            </div>
                        </div>
                        <div class='settings-line-right' id='settings-edit-open'><div class='settings-edit-icon'></div><p>Edit</p></div>
                    </div>
                    <hr>
                    <div class='settings-line'>
                        <div class='settings-line-left'><p>Can anyone see the members of this class, or just people who are enrolled?</p></div>
                        <div class='settings-line-middle'>
                            <p class='settings-member-current' id='class-member-privacy'>Anyone</p>
                            <div class='class-settings-expand' id='settings-member-expand'>
                                <form id='settings-member-form'>
                                    <input type='radio' name='open-member' value='Anyone'id='Anyone'>Anyone<br>
                                    <input type='radio' name='open-member' value='Enrolled'id='Enrolled'>Enrolled<br>
                                    <button class='settings-edit-button settings-edit-submit' id='settings-member-submit' type='submit'>Submit</button>
                                    <button class='settings-edit-button settings-edit-cancel' id='settings-member-cancel' type='cancel'>Cancel</button>
                                </form>
                            </div>
                        </div>
                        <div class='settings-line-right' id='settings-edit-members'><div class='settings-edit-icon'></div><p>Edit</p></div>
                    </div>
                </div>
            </div>

           <div class = 'settings-tab-officers about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        Class TAs and Admins
                    </div>
                </div>
                <div class = 'tab-block-content'>
                    <div class='settings-officers-line'>
                        <div class='officer-pic' id='prof'></div>
                        <div class='officer-name'><p>Professor Barrack Obama</p><p id='officer-you'>(YOU)</p></div>
                    </div>
                    <hr>
                    <div class='settings-officers-line'>
                        <div class='officer-pic' id='prof'></div>
                        <div class='officer-name'><p>Barrack Obama</p></div>
                        <div class='officer-delete-icon'></div>
                    </div>
                    <hr>
                    <div class='officers-input'>
                        <div class='officers-input-icon'></div>
                        <input class='officer-input-text' type='text' placeholder='Add a new TA or admin to this class'>
                    </div>
                </div>
            </div>
        </div>

        <div class = 'about-tab-rightsec notifications-rightsec'>
            <div class = 'about-tab-block group-about group-about-3'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>Personal Notification Settings</div>
                </div>
                <div class = 'tab-block-content'>
                    <div class='notifications-text'><p>Notifications are <b>ON</b> For this Class</p></div>
                    <div class='class-notifications-check'>
                        <input type='checkbox' id='class-notifications' class='flat7c'>
                            <label for='flat7' class='flat7b_fbar flat_checked' style='border: 1px solid rgb(0, 160, 118); background-color: rgb(2, 226, 167);'>
                                <span class='move' style='margin-left: 1px;'></span>
                            </label>
                    </div>
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