<script>
$( document ).ready(function() {
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
        

        if($(this).hasClass("ta_already")){
          $(this).removeClass("ta_already");
          var clone= $(this).closest(".member").clone();
          $(this).closest(".member").remove();
          $(".student-member-list").append(clone);
        }else{
          $(this).addClass("ta_already");
          var clone= $(this).closest(".member").clone();
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

include '../php/dbconnection.php';
include '../includes/follow.php';
session_start();

$class_id = "92478034-f589-11e3-b732-00259022578e";
$user_id = 1;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
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

//fetching admin members of the course
$get_admin_members_query = "SELECT U.*, UN.univ_name FROM user U, university UN WHERE U.user_id IN
(SELECT professor from
    courses_semester
  WHERE class_id = '$class_id'
    UNION
  SELECT user_id from
    courses_user
  WHERE class_id = '$class_id' AND is_admin = 1) AND U.univ_id = UN.univ_id";

$get_admin_members_query_result = mysqli_query($con, $get_admin_members_query);
$count_prof = mysqli_num_rows($get_admin_members_query_result);
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
    while ($row = mysqli_fetch_array($get_admin_members_query_result)) {
        echo '
            <div class="member" id="' . $row["user_id"] . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(../' . get_user_dp($con, $row['user_id']) . ')"></div>
                      <div class="member-bio">
                        <span>' . $row['user_bio'] . '</span> <a href="../profile.php?user_id=' . $row["user_id"] . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($row['user_type'] == 's') {
            echo '
                <h3 class="person-title">
                <a href="../profile.php?user_id=' . $row['user_id'] . '"><strong class="search_unit">' . $row['firstname'] . ' ' . $row['lastname'] . ' </strong></a>
                    <span><a class="search_unit">' . $row['univ_name'] . '</a></span>
                </h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="../profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">Professor ' . $row['lastname'] . '</strong></a>
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
                    <div class="upgrade-student">TA</div>
                  </div>
                </div>
          </div>';
        } else {
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>
                    <div class="upgrade-student">TA</div>
                </div>
            </div>
        </div>';
        }
    }
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
            <div class="member">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(../' . get_user_dp($con, $row['user_id']) . ')"></div>

                      <div class="member-bio">
                        <span>' . $row['user_bio'] . '</span> <a href="../profile.php?user_id=' . $row["user_id"] . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
        if ($row['user_type'] == 's') {
            echo '
                <h3 class="person-title">
                <a href="../profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">' . $row['firstname'] . ' ' . $row['lastname'] . ' </strong></a>
                <span><a class="search_unit">' . $row['univ_name'] . '</a></span></h3>';
        } else {
            echo '
                <h3 class="person-title">
                <a href="../profile.php?user_id=' . $row['user_id'] . ' "><strong class="search_unit">Professor ' . $row['lastname'] . '</strong></a>
                <span><a class="search_unit">' . $row['univ_name'] . '</a></span></h3>';
        }
        if ($user_id == $row['user_id']) {
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
                    </div>
                    <div class="upgrade-student">TA</div>
                  </div>
                </div>
          </div>';
        } else {
            echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>
                    <div class="upgrade-student">TA</div>
                </div>
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