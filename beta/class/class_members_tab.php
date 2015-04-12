<script>
    $(document).ready(function () {
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

                });

            } else {
                $(".hidden_result").removeClass("hidden_result");
            }

        });


        $(document).delegate(".upgrade-student", "click", function () {

            var ta_user_id = $(this).closest(".member").attr("id");

            $.ajax({
                type: "POST",
                url: "add_course_ta.php",
                data: {ta_user_id: ta_user_id},
                success: function (html) {
                    alert(html);
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
echo $class_id;
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}

$admin_flag = 1;

if ($user_type == 'p') {
    $get_prof_query = "SELECT COUNT(*) as admin_flag FROM courses_semester WHERE class_id = '$class_id' AND professor = $user_id";
    $get_prof_query_result = mysqli_query($con, $get_prof_query);
    $prof_row = mysqli_fetch_array($get_prof_query_result);
    $admin_flag = $prof_row['admin_flag'];
} else {
    $get_admin_flag_query = "SELECT COUNT(*) as admin_flag FROM courses_user WHERE user_id = $user_id AND is_admin = 1";
    $get_admin_flag_query_result = mysqli_query($con, $get_admin_flag_query);
    $admin_row = mysqli_fetch_array($get_admin_flag_query_result);
    $admin_flag = $admin_row['admin_flag'];
}

echo '
    <div class="members-tab-content">
        <div class="members-search-top">
          <div class="searchmemberwrapper">
            <input type="text" class="inputText searchMembers" name="Search Users"
            placeholder="Search the members of this course..." />
          </div>

          <div class="invite-users email_invite">
            Invite email list
          </div>
        </div>';


//get professor query
$get_professor_query = "SELECT U.*, UN.univ_name FROM user U, university UN WHERE U.user_id IN
(SELECT professor from
    courses_semester
  WHERE class_id = '$class_id') AND U.univ_id = UN.univ_id";
$get_professor_query_result = mysqli_query($con, $get_professor_query);

//fetching admin members of the course
$get_admin_members_query = "SELECT U.*, UN.univ_name FROM user U, university UN WHERE U.user_id IN
(SELECT user_id from
    courses_user
  WHERE class_id = '$class_id' AND is_admin = 1) AND U.univ_id = UN.univ_id";
$get_admin_members_query_result = mysqli_query($con, $get_admin_members_query);

$count_prof = mysqli_num_rows($get_admin_members_query_result) + mysqli_num_rows($get_professor_query_result);

if ($count_prof > 0) {
    echo '
         <div class="blockwrapper">
              <div class="members-header">
                Professors and TAs (' . $count_prof . ')
              </div>

              <div class="members-header-line">

              </div>
         </div>

         <div class="members-list-wrap prof-member-list">';
    while ($row = mysqli_fetch_array($get_professor_query_result)) {
        echo '
            <div class="member" id="' . $row["user_id"] . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(' . get_user_dp($con, $row['user_id']) . ')"></div>
                      <div class="member-bio">
                        <span>' . $row['user_bio'] . '</span> <a href="profile.php?user_id=' . $row["user_id"] . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($row['user_type'] == 's') {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $row['user_id'] . '"><strong class="search_unit">' . $row['firstname'] . ' ' . $row['lastname'] . ' </strong></a>
                    <span><a class="search_unit">' . $row['univ_name'] . '</a></span>
                </h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">Professor ' . $row['lastname'] . '</strong></a>
                <span><a class="search_unit">' . $row['univ_name'] . '</a></span></h3>';
        }
        if ($user_id == $row['user_id']) {
            echo '
                    </div>
                </div>
          </div>';
            continue;
        }
        if (isFollowing($user_id, $row['user_id'])) {
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
                    </div>
                </div>
            </div>
        </div>';
        }
    }
}

if ($count_prof > 0) {
    while ($row = mysqli_fetch_array($get_admin_members_query_result)) {
        echo '
            <div class="member" id="' . $row["user_id"] . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(' . get_user_dp($con, $row['user_id']) . ')"></div>
                      <div class="member-bio">
                        <span>' . $row['user_bio'] . '</span> <a href="profile.php?user_id=' . $row["user_id"] . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($row['user_type'] == 's') {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $row['user_id'] . '"><strong class="search_unit">' . $row['firstname'] . ' ' . $row['lastname'] . ' </strong></a>
                    <span><a class="search_unit">' . $row['univ_name'] . '</a></span>
                </h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">Professor ' . $row['lastname'] . '</strong></a>
                <span><a class="search_unit">' . $row['univ_name'] . '</a></span></h3>';
        }
        if ($user_id == $row['user_id']) {
            if ($admin_flag > 0) {
                echo '
                        <div class="upgrade-student ta_already">TA</div>
                ';
            }
            echo '
                    </div>
                </div>
          </div>';
            continue;
        }
        if (isFollowing($user_id, $row['user_id'])) {
            echo '
                    <div class="follow-btn">
                      <a class="follow tab_followed ready_to_unfollow">Following</a>
                    </div>';
            if ($admin_flag > 0) {
                echo '<div class="upgrade-student ta_already">TA</div>';
            }
            echo '      </div>
                </div>
          </div>';
        } else {
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>';
            if ($admin_flag > 0) {
                echo '<div class="upgrade-student ta_already">TA</div>';
            }
            echo '    </div>
            </div>
        </div>';
        }
    }
}

if ($count_prof > 0) {
    echo '
        </div>
    ';
}

//fetching students for the class
$get_student_query = "SELECT U.*, UN.univ_name FROM university UN, user U WHERE U.user_id IN(SELECT user_id from courses_user
WHERE class_id = '$class_id' AND is_admin = 0) AND U.univ_id = UN.univ_id";
$get_student_query_result = mysqli_query($con, $get_student_query);

$count_student = mysqli_num_rows($get_student_query_result);
if ($count_student > 0) {
    echo "
         <div class='blockwrapper'>
            <div class = 'members-header members-students'>
                Students (" . $count_student . ")
            </div>
            <div style = 'width: 853px'class = 'members-header-line'></div>
         </div>
         <div class = 'members-list-wrap student-member-list'>";
    while ($row = mysqli_fetch_array($get_student_query_result)) {
        echo '
            <div class="member" id="' . $row["user_id"] . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(' . get_user_dp($con, $row['user_id']) . ')"></div>

                      <div class="member-bio">
                        <span>' . $row['user_bio'] . '</span> <a href="profile.php?user_id=' . $row["user_id"] . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($row['user_type'] == 's') {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">' . $row['firstname'] . ' ' . $row['lastname'] . ' </strong></a>
                <span><a class="search_unit">' . $row['univ_name'] . '</a></span></h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">Professor ' . $row['lastname'] . '</strong></a>
                <span><a class="search_unit">' . $row['univ_name'] . '</a></span></h3>';
        }
        if ($user_id == $row['user_id']) {
            if ($admin_flag > 0) {
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
        if (isFollowing($user_id, $row['user_id'])) {
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
        } else {
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>';
            if ($admin_flag > 0) {
                echo '
                        <div class="upgrade-student">TA</div>
                ';
            }
            echo '    </div>
            </div>
        </div>';
        }
    }
    echo '</div>';
}

//closing members-tab-content div
echo '
    </div>';
?>