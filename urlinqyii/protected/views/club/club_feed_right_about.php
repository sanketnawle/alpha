<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/8/14
 * Time: 11:50 AM
 */

/*if (isset($_GET['class_id']) AND !isset($class_id)) {
    $class_id = $_GET['class_id'];
}

include 'php/dbconnection.php';
require_once 'php/time_change.php';

$get_course_files_query = "SELECT FU.*, U.user_id, U.firstname, U.lastname FROM course_files CF
LEFT JOIN file_upload FU on FU.file_id = CF.file_id
LEFT JOIN user U on U.user_id = CF.user_id
WHERE CF.class_id = '$class_id'
UNION
(SELECT FU.*, U.user_id, U.firstname, U.lastname FROM posts P
LEFT JOIN file_upload FU on FU.file_id = P.file_id
LEFT JOIN user U on U.user_id = P.user_id
WHERE P.target_id = '$class_id' AND P.target_type = 'courses_semester' AND P.file_id IS NOT NULL)
ORDER BY created_timestamp DESC
LIMIT 0,1";
$get_course_files_query_result = $con->query($get_course_files_query);
*/
echo "
        <div class='group-about'>
";
/*
if ($get_course_files_query_result->num_rows > 0) {
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
    $file_row = $get_course_files_query_result->fetch_array();
    $time_string = new DateTime(user_time($file_row['created_timestamp']));
    $time_string = $time_string->format("F j");


    if (strlen($file_row['file_name']) > 33) {
        $file_row['file_name'] = substr($file_row['file_name'], 0, 30) . "...";
    }
    //closing group-about
    echo "
                <div class = 'box-content content-file'>
                    <a class = 'file-download' href='php/download_file.php?file_id=" . $file_row['file_id'] . "'>
                    <div class = 'file-icon'>
                    </div>
                    <div class= 'file-name'>
                        " . $file_row['file_name'] . "
                    </div>
                    </a>
                    <div class ='file-created'>
                        <a class = 'file-creator'  href='profile.php?user_id=" . $file_row['user_id'] . "'>" . $file_row['firstname'] . " " . $file_row['lastname'] . "</a> <span> uploaded " . $time_string . "</span>
                    </div>
                </div>
    ";


}

$get_course_about_query = "SELECT C.course_desc, U.firstname, U.lastname, U.user_id FROM courses C
JOIN courses_semester CM on CM.course_id = C.course_id AND CM.class_id = '$class_id'
JOIN user U on CM.professor = U.user_id";
$get_course_about_query_result = $con->query($get_course_about_query);

$course_about_row = $get_course_about_query_result->fetch_array();
*/
echo "
            <div class='box-header'>
                <span class='bh-t1'>
                    ABOUT
                </span>

            </div>
            <div class='box-content content-about'>aaaaaaaaaaa aaaaaaaaa aaaaaaaa aaaaaaaaa aaaaaaaa aaaaaaaaaa aa aaaaa aaa
            </div>
            <div class='box-header'>
                <a class='bh-t2 small_invite_email'>
                    Invite email list
                </a>
            </div>
            <div class='box-content content-invite'>
                <form rel='' method='post'>
                    <input type='hidden' autocomplete='off'>
                    <i class='plusIcon'></i>

                    <div class='invite-input-wrap'>
                        <div class='innerWrap'>
                            <input type='text' class='inputText inviteInput' name='Invite form'
                                   placeholder='Invite people to join this class'>

                            <div class='search-icon' title='Search people'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>";
//  </div>
//";

//$con->close();
?>