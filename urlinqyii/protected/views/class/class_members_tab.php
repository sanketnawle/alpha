<script>
    $(document).ready(function () {
        $.urlParam = function (sParam) {

            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }

        }
        var class_id = $.urlParam('class_id');


        $(document).delegate(".searchMembers", "keyup", function (e) {

            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".member").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    /*control the text prompt of the div*/
                    $(".members-list-wrap").each(function (index) {
                        var l = $(this).find(".member").not('.hidden_result').length;
                        if (l == 0) {
                            $(this).prev(".blockwrapper").addClass("hidden_result");
                        } else {
                            $(this).prev(".blockwrapper").removeClass("hidden_result");
                        }
                    });
                    /*control the text prompt of the div end*/

                });

            } else {
                $(".hidden_result").removeClass("hidden_result");
            }

        });


        $(document).delegate(".upgrade-student", "click", function () {

            var ta_user_id = $(this).closest(".member").attr("id");

            $.ajax({
                type: "POST",
                url: "php/add_class_ta.php",
                data: {ta_user_id: ta_user_id, class_id: class_id},
                success: function (html) {
                    alert(html);
                    alert(class_id);
                },
                error: function (html) {
                    alert(html);
                }
            });

            if ($(this).hasClass("ta_already")) {
                $(this).removeClass("ta_already");
                var clone = $(this).closest(".member").clone();
                $(this).closest(".member").remove();
                $(".student-member-list").append(clone);

                //$(".members-admin").find("span").text();
            } else {
                $(this).addClass("ta_already");
                var clone = $(this).closest(".member").clone();
                $(this).closest(".member").remove();
                $(".prof-member-list").append(clone);
            }


        });


    });
</script>


<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/21/14
 * Time: 5:26 PM
 */
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
             . (1+count($class->admins)) .
            '</span>)
          </div>

          <div class="members-header-line">

          </div>
     </div>
';
echo '
         <div class="members-list-wrap prof-member-list">';
//}


//THIS IS FOR TAs and the Professor
    foreach ($class->admins as $admin) {
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
                            echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                $admin->pictureFile->file_url.')"></div>';
                        }else{
                            echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                '/assets/default/user.png)"></div>';
                        }
      echo               ' <div class="member-bio">
                        <span>' . $admin->user_bio . '</span> <a href="profile.php?user_id=' . $admin->user_id . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($admin->user_type == 's') {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $admin->user_id . '"><strong class="search_unit">' . $admin->firstname . ' ' . $admin->lastname . ' </strong></a>
                    <span><a class="search_unit">' . $admin->school->school_name . '</a></span>
                </h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $admin->user_id . ' "><strong class="search_unit">Professor ' . $admin->lastname . '</strong></a>
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

        if (in_array($admin->user_id,$following)) {
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

            if ($is_admin && $admin->user_type == 's') {
                echo '
                    <div class="upgrade-student">TA</div>
                ';
            }
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
if(count($class->students)  == 0){
    echo"
        <h2 id='noMembers'> Members </h2>
         <div class='noInfoBox' id='noInfoMemberBox'>
         <!-- <img src='DefaultImages/user.png' style='width:20px; height:auto;position:relative;top:3px;right:5px'></img> -->
          Be the first to join </div>
    ";
}

if (count($class->students)  > 0) {
echo "
    <div class='blockwrapper'>
        <div class = 'members-header members-students'>
            Enrolled Members (<span>" . count($class->students)  . "</span>)
        </div>
        <div style = 'width: 853px'class = 'members-header-line'></div>
    </div>
";

echo "
         <div class = 'members-list-wrap student-member-list'>";
}



if (count($class->students)  > 0) {
    foreach ($class->students as $student) {
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
                        <span>' . $student->user_bio . '</span> <a href="profile.php?user_id=' . $student->user_id . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($student->user_type == 's') {
            echo '
        <h3 class="person-title">
                <a href="profile.php?user_id=' . $student->user_id . ' "><strong class="search_unit">' . $student->firstname . ' ' . $student->lastname . ' </strong></a>
                <span><a class="search_unit">' . $student->school->school_name . '</a></span></h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $student->user_id . ' "><strong class="search_unit">Professor ' . $student->lastname . '</strong></a>
                <span><a class="search_unit">' . $student->school->school_name . '</a></span></h3>';
    }
    if ($student->user_id == $user->user_id) {
        if ($is_admin) {
            echo '
                        <div class="upgrade-student">TA</div>
        ';
        }
        echo '
                    </div>
                </div>
          </div>';
        continue;
    }
//        echo $user_id;
//        echo $row['user_id'];
        /*if (isFollowing($user_id, $row['user_id'])) {
            echo '
                    <div class="follow-btn">
                      <a class="follow tab_followed ready_to_unfollow">Following</a>
                    </div>';
            if ($admin_flag > 0) {
                echo '
                        <div class="upgrade-student">TA</div>
                ';
            }
            echo '      </div>
                </div>
          </div>';
        } else { */
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>';
            if ($is_admin) {
                echo '
                        <div class="upgrade-student">TA</div>
                ';
            }
            echo '    </div>
            </div>
        </div>';
        }
   // }
}

if (count($class->students) > 0) {
//closing member list w
echo '</div>';
}


//echo '</div>';

?>