<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/class/class_members_tab.js'></script>


<?php

/*
require_once 'php/dbconnection.php';
require_once 'includes/follow.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
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
*/

echo
   // <div class="members-tab-content">
    ' <div class="members-search-top">
          <div class="searchmemberwrapper">
            <input type="text" class="inputText searchMembers" name="Search Users"
            placeholder="Search the members of this class..." />
          </div>

          <div class="invite-users email_invite">
            Invite email list
          </div>
        </div>';
/*

//get professor query
$get_professor_query = "SELECT U.*, UN.univ_name FROM user U, university UN WHERE U.user_id IN
(SELECT professor from courses_semester WHERE class_id = '$class_id') AND U.univ_id = UN.univ_id";
$get_professor_query_result = $con->query($get_professor_query);

//fetching admin members of the course
$get_admin_members_query = "SELECT U.*, UN.univ_name FROM user U, university UN WHERE U.status = 'active' AND U.user_id IN
(SELECT user_id from courses_user WHERE class_id = '$class_id' AND is_admin = 1) AND U.univ_id = UN.univ_id AND U.user_id != (SELECT CS.professor FROM courses_semester CS WHERE CS.class_id = '$class_id')";
$get_admin_members_query_result = $con->query($get_admin_members_query);

if (!$get_admin_members_query_result) {
    $admin_member_count = 0;
} else {
    $admin_member_count = $get_admin_members_query_result->num_rows;
}
if (!$get_professor_query_result) {
    $prof_count = 0;
} else {
    $prof_count = $get_professor_query_result->num_rows;
}

$count_prof = $admin_member_count + $prof_count;
*/
//if ($count_prof > 0) {
echo '
    <div class="blockwrapper">
          <div class="members-header members-admin">
            Professors and TAs (<span>'
             . (count($admins)) .
            '</span>)
          </div>

          <div class="members-header-line">

          </div>
     </div>
';
echo '
         <div class="members-list-wrap prof-member-list">';
//}
$base_url = Yii::app()->getBaseUrl(true);

//THIS IS FOR TAs and the Professor
    foreach ($admins as $admin) {
        echo '
            <div class="member" id="' . $admin->user_id . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">';
           //           <div class="picwrap" style="background-image:url(' .
           // get_dp($con, $row['user_id'], "user")
              //  'DefaultImages/user.png'
               //         . ')"></div>
                        if($admin->picture_file_id){
                            echo '<div class="picwrap" style="background-image:url('. $base_url. $admin->pictureFile->file_url.')"></div>';
                        }else{
                            echo '<div class="picwrap" style="background-image:url(' . $base_url . '/assets/default/user.png)"></div>';
                        }
      echo               ' <div class="member-bio">
                        <span>' . $admin->user_bio . '</span> <a href="' . $base_url . '/profile/'. $admin->user_id . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($admin->user_type == 's') {
            echo '
                <h3 class="person-title">
                <a href="'. Yii::app()->getBaseUrl(true).'/profile/'.$admin->user_id . '"><strong class="search_unit">' . $admin->firstname . ' ' . $admin->lastname . ' </strong></a>
                    <span><a class="search_unit">' . $admin->school->school_name . '</a></span>
                </h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="'. Yii::app()->getBaseUrl(true).'/profile/'.$admin->user_id . ' "><strong class="search_unit">Professor ' . $admin->lastname . '</strong></a>
                <span><a class="search_unit">' . $admin->school->school_name . '</a></span></h3>';
        }
        // if you ARE the TA or if the TA is not active
        if ($user->user_id == $admin->user_id or $admin->status != 'active') {
            echo '
                    </div>
                </div>
          </div>';
            continue;
        }

        if ($user->isFollowing($admin)) {
            echo '
                    <div class="follow-btn">
                      <a class="follow tab_followed ready_to_unfollow">Following</a>
                    </div>
                  </div>
                </div>
          </div>';
        } else {
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>';

           /* if ($is_admin && $admin->user_type == 's') {
                echo '
                    <div class="upgrade-student">TA</div>
                ';
            }*/
          echo '      </div>
            </div>
        </div>';
        }
    }
//}

//if ($count_prof > 0) {
echo '
        </div>
';
//}
/*
//fetching students for the class
$get_student_query = "SELECT U.*, UN.univ_name FROM university UN, user U WHERE U.status = 'active' AND U.user_id IN(SELECT user_id from courses_user WHERE class_id = '$class_id' AND is_admin = 0) AND U.univ_id = UN.univ_id";
$get_student_query_result = $con->query($get_student_query);

$count_student = mysqli_num_rows($get_student_query_result);*/
if(count($students)  == 0){
    echo"
        <h2 id='noMembers'> Members </h2>
         <div class='noInfoBox' id='noInfoMemberBox'>
         <!-- <img src='DefaultImages/user.png' style='width:20px; height:auto;position:relative;top:3px;right:5px'></img> -->
          Be the first to join </div>
    ";
}

if (count($students)  > 0) {
    echo "
        <div class='blockwrapper'>
            <div class = 'members-header members-students'>
                Enrolled Members (<span>" . count($students)  . "</span>)
            </div>
            <div style = 'width: 853px'class = 'members-header-line'></div>
        </div>
    ";

    echo "
             <div class = 'members-list-wrap student-member-list'>";

    foreach ($students as $student) {
        echo '
            <div class="member" id="' . $student->user_id . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">';

                        if($student->picture_file_id){
                            echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                $student->pictureFile->file_url.')"></div>';
                        }else{
                            echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                '/assets/default/user.png)"></div>';
                        }

       echo             '  <div class="member-bio">
                        <span>' . $student->user_bio . '</span> <a href="'. Yii::app()->getBaseUrl(true).'/profile/'.$student->user_id . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($student->user_type == 's') {
            echo '
        <h3 class="person-title">
                <a href="'. Yii::app()->getBaseUrl(true).'/profile/'.$student->user_id . ' "><strong class="search_unit">' . $student->firstname . ' ' . $student->lastname . ' </strong></a>
                <span><a class="search_unit">' . $student->school->school_name . '</a></span></h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="'. Yii::app()->getBaseUrl(true).'/profile/'.$student->user_id . ' "><strong class="search_unit">Professor ' . $student->lastname . '</strong></a>
                <span><a class="search_unit">' . $student->school->school_name . '</a></span></h3>';
    }
    if ($student->user_id == $user->user_id) {
        /*if ($is_admin) {
            echo '
                        <div class="upgrade-student">TA</div>
        ';
        }*/
        echo '
                    </div>
                </div>
          </div>';
        continue;
    }
        if ($user->isFollowing($student)) {
            echo '
                    <div class="follow-btn">
                      <a class="follow tab_followed ready_to_unfollow">Following</a>
                    </div>
                  </div>
                </div>
          </div>';
        } else {
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>';
       /*     if ($is_admin) {
                echo '
                        <div class="upgrade-student">TA</div>
                ';
            }*/
            echo '    </div>
            </div>
        </div>';
        }
    }

    echo '</div>';
}


//echo '</div>';

?>