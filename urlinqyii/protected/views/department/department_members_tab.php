<script>

    $(document).delegate(".searchMembers_dept", "keyup", function (e) {



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

                        $(this).prev(".members-header-line").prev(".members-header").addClass("hidden_result");

                        $(this).prev(".members-header-line").addClass("hidden_result");

                    } else {

                        $(this).prev(".members-header-line").prev(".members-header").removeClass("hidden_result");

                        $(this).prev(".members-header-line").removeClass("hidden_result");

                    }

                });

                /*control the text prompt of the div end*/



            });



        } else {

            $(".hidden_result").removeClass("hidden_result");

        }



    });

</script>



<?php

/**

 * Created by PhpStorm.

 * User: aditya841

 * Date: 8/14/14

 * Time: 12:14 PM

 */


/*
if (session_status() == PHP_SESSION_NONE) {

    session_start();

}

//include 'php/dbconnection.php';

require_once 'includes/follow.php';



if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

}

if (isset($_POST['dept_id'])) {

    $dept_id = $_POST['dept_id'];

}

if (isset($_SESSION['user_type'])) {

    $user_type = 0; //$_SESSION['user_type'];

}

if (isset($_SESSION['univ_id'])) {

    $univ_id = $_SESSION['univ_id'];

}



$current_semester = 0; //get_current_semester($con, $univ_id);



if ($user_type == 'p') {

    $admin_check_query = "SELECT COUNT(*) as admin_flag FROM user WHERE user_id = $user_id AND dept_id = $dept_id";

    $admin_check_query_result = $con->query($admin_check_query);

    $admin_row = $admin_check_query_result->fetch_array();

    $admin_flag = $admin_row['admin_flag'];

} else {

    $admin_flag = 0;

}



$get_course_members_query = "SELECT U.firstname, U.lastname, U.user_id, U.user_type, U.user_bio, UN.univ_name, UN.univ_id, (SELECT COUNT(*) FROM connect CO WHERE U.user_id = CO.to_user_id AND CO.from_user_id = $user_id)as follow_flag FROM user U

LEFT JOIN university UN ON UN.univ_id = U.univ_id

WHERE U.dept_id = $dept_id AND U.status = 'active'

ORDER BY user_type";



$get_course_members_query_result = $con->query($get_course_members_query);



$prof_count_query = "SELECT COUNT(*) as prof_count FROM user PU WHERE PU.dept_id = $dept_id AND PU.user_type = 'p' AND PU.status = 'active'";

$prof_count_query_result = $con->query($prof_count_query);

$prof_row = $prof_count_query_result->fetch_array();

$prof_count = $prof_row['prof_count'];



$student_count_query = "SELECT COUNT(*) as student_count FROM user SU WHERE SU.dept_id = $dept_id AND SU.user_type = 's' AND SU.status = 'active'";

$student_count_query_result = $con->query($student_count_query);

$student_row = $student_count_query_result->fetch_array();

$student_count = $student_row['student_count'];



echo "

    <div class = 'members-tab-content'>

        <div class = 'members-search-top'>

            <form>

                <div class = 'searchWrapper searchWrapperMembers'>

                    <input placeholder = 'Search students and faculty at this department' class = 'tabSearcher ajax searchMembers_dept'>

                    </input>

                </div>

                <button class = 'submitSearch submitSearchMembers'>

                </button>

            </form>

        </div>

";



$prof_show_count = 0;

$student_show_count = 0;



while ($user_row = $get_course_members_query_result->fetch_array()) {

    if ($user_row['user_type'] == 'p') {

        if ($prof_show_count == 0) {

            echo "

                <div class = 'members-header'>

                    Professors (" . $prof_count . ")

                </div>

                <div class = 'members-header-line'></div>

            ";



            echo "

                <div class = 'members-list-wrap prof-member-list'>

            ";

        }

        $prof_show_count++;

        echo "

            <div class = 'member' id='" . $user_row['user_id'] . "'>

                <div class = 'member-person prof-member-person'>

                    <div class = 'member-wrap prof-member-wrap'>

                        <div class = 'person-thumb'>

                            <div class = 'picwrap' style = 'background-image:url(" . get_dp($con, $user_row['user_id'], 'user') . ")'>

                            </div>

                            <div class = 'member-bio'>

                                <span>" . $user_row['user_bio'] . "</span>

                                <a href='profile.php?user_id=" . $user_row['user_id'] . "'><strong>View Profile</strong></a>

                            </div>

                        </div>

                        <h3 class = 'person-title'>

                            <a href='profile.php?user_id=" . $user_row['user_id'] . "'><strong class='search_unit'>" . $user_row['firstname'] . " " . $user_row['lastname'] . "</strong></a>

                            <span>

                                <a class='search_unit' href='school.php?univ_id=" . $user_row['univ_id'] . "'>" . $user_row['univ_name'] . "</a>

                            </span>

                        </h3>

        ";

        if ($user_row['user_id'] == $user_id) {

            //same user as viewing

        } else {

            if ($user_row['follow_flag'] > 0) {

                echo "

                        <div class = 'follow-btn'>

                            <a class = 'follow tab_followed ready_to_unfollow'>

                                Following

                            </a>

                        </div>";

            } else {

                echo "

                        <div class = 'follow-btn'>

                            <a class = 'follow'>

                                Follow

                            </a>

                        </div>";

            }

        }

        echo "

                    </div>

                </div>

            </div>

        ";

    } else {

        if ($student_show_count == 0) {

            if ($prof_show_count > 0) {

                //closing previous member-list-wrap

                echo "

                    </div>

                ";

            }



            //starting student list

            echo "

                <div class = 'members-header members-students'>

                    Students (" . $student_count . ")

                </div>

                <div style = 'width: 853px'class = 'members-header-line'>

                </div>

                <div class = 'members-list-wrap student-member-list'>

            ";

        }

        $student_show_count++;

        echo "

            <div class = 'member' id='" . $user_row['user_id'] . "'>

                <div class = 'member-person prof-member-person'>

                    <div class = 'member-wrap prof-member-wrap'>

                        <div class = 'person-thumb'>

                            <div class = 'picwrap' style = 'background-image:url(" . get_dp($con, $user_row['user_id'], 'user') . ")'></div>

                            <div class = 'member-bio'>

                                <span>" . $user_row['user_bio'] . "</span>

                                <a href='profile.php?user_id=" . $user_row['user_id'] . "'><strong>View Profile</strong></a>

                            </div>

                        </div>

                        <h3 class = 'person-title'>

                            <strong class='search_unit'>" . $user_row['firstname'] . " " . $user_row['lastname'] . "</strong>

                            <span>

                                <a class='search_unit' href='school.php?univ_id=" . $user_row['univ_id'] . "'>" . $user_row['univ_name'] . "</a>

                            </span>

                        </h3>";

        if ($user_row['user_id'] == $user_id) {

            //same user as viewing

        } else {

            if ($user_row['follow_flag'] > 0) {

                echo "

                        <div class = 'follow-btn'>

                            <a class = 'follow tab_followed ready_to_unfollow'>

                                Following

                            </a>

                        </div>";

            } else {

                echo "

                        <div class = 'follow-btn'>

                            <a class = 'follow'>

                                Follow

                            </a>

                        </div>";

            }

        }

        echo "

                    </div>

                </div>

            </div>

    ";

    }

}



//closing last member-list-wrap

echo "

                </div>

";



//closing tag for member-tab-content

echo "

    </div>

";



$con->close();
*/




echo "

    <div class = 'members-tab-content'>

        <div class = 'members-search-top'>

            <form>

                <div class = 'searchWrapper searchWrapperMembers'>

                    <input placeholder = 'Search students and faculty at NYU Polytechnic' class = 'tabSearcher ajax'>

                    </input>

                </div>

                <button class = 'submitSearch submitSearchMembers'>

                </button>

            </form>

        </div>

        <div class = 'members-header'>

            Professors and TAs (2)

        </div>

        <div class = 'members-header-line'>

        </div>

        <div class = 'members-list-wrap'>

            <div class = 'member'>

                <div class = 'member-person prof-member-person'>

                    <div class = 'member-wrap prof-member-wrap'>

                        <div class = 'person-thumb'>

                            <div class = 'picwrap' style = 'background-image:url()'></div>

                            <div class = 'member-bio'>

                                <span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>

                                <strong>View Profile</strong>

                            </div>

                        </div>

                        <h3 class = 'person-title'>

                            <strong>Professor Zeroni</strong>

                            <span>

                                <a>NYU College of Arts and Sciences</a>

                            </span>

                        </h3>

                        <div class = 'follow-btn'>

                            <a class = 'follow'>

                                Follow

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <div class = 'member'>

                <div class = 'member-person ta-member-person'>

                    <div class = 'member-wrap ta-member-wrap'>

                        <div class = 'person-thumb'>

                            <div class = 'picwrap' style = 'background-image:url()'></div>

                            <div class = 'member-bio'>

                                <span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>

                                <strong>View Profile</strong>

                            </div>

                        </div>

                        <h3 class = 'person-title'>

                            <strong>TA Hector Zeroni</strong>

                            <span>

                                <a>NYU School of Engineering</a>

                            </span>

                        </h3>

                        <div class = 'follow-btn'>

                            <a class = 'follow'>

                                Follow

                            </a>

                        </div>



                    </div>

                </div>

            </div>

        </div>



        <div class = 'members-header members-students'>

            Students (22)

        </div>

        <div style = 'width: 853px'class = 'members-header-line'>

        </div>

        <div class = 'members-list-wrap student-member-list'>

            <div class = 'member'>

                <div class = 'member-person'>

                    <div class = 'member-wrap'>

                        <div class = 'person-thumb'>

                            <div class = 'picwrap' style = 'background-image:url()'></div>

                            <div class = 'member-bio'>

                                <span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>



                                <strong>View Profile</strong>

                            </div>

                        </div>

                        <h3 class = 'person-title'>

                            <strong>TA Hector Zeroni</strong>

                            <span>

                                <a>NYU School of Engineering</a>

                            </span>

                        </h3>

                        <div class = 'follow-btn'>

                            <a class = 'follow'>

                                Follow

                            </a>

                        </div>



                    </div>

                </div>

            </div>



            <div class = 'member'>

                <div class = 'member-person'>

                    <div class = 'member-wrap'>

                        <div class = 'person-thumb'>

                            <div class = 'picwrap' style = 'background-image:url();'></div>

                            <div class = 'member-bio'>

                                <span>Surfing, Beatles, Snowboarding and a whole lot of other exciting stuff</span>

                                <strong>View Profile</strong>



                            </div>

                        </div>

                        <h3 class = 'person-title'>

                            <strong>TA Hector Zeroni</strong>

                            <span>

                                <a>NYU School of Engineering</a>

                            </span>

                        </h3>

                        <div class = 'follow-btn'>

                            <a class = 'follow'>

                                Follow

                            </a>

                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>



";



?>