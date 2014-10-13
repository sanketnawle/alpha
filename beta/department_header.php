<?php

/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/13/14
 * Time: 3:43 PM

 */

if (session_status() == PHP_SESSION_NONE) {

    session_start();

}

include 'php/dbconnection.php';


if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

}

if (isset($_GET['dept_id'])) {

    $dept_id = $_GET['dept_id'];

}

if (isset($_SESSION['user_type'])) {

    $user_type = $_SESSION['user_type'];

}

if (isset($_SESSION['univ_id'])) {

    $univ_id = $_SESSION['univ_id'];

}


$current_semester = get_current_semester($con, $univ_id);

$admin_flag = 0;


if ($user_type == 'p') {

    $admin_check_query = "SELECT COUNT(*) as admin_flag FROM user WHERE user_id = $user_id AND dept_id = $dept_id";

    $admin_check_query_result = $con->query($admin_check_query);

    $admin_row = $admin_check_query_result->fetch_array();

    $admin_flag = $admin_row['admin_flag'];

} else {

    $admin_flag = 0;

}


$get_department_details_query = "SELECT (SELECT COUNT(*) FROM user U WHERE U.dept_id = D.dept_id AND U.status = 'active') as user_count, D.*, (SELECT COUNT(*) FROM courses C WHERE C.dept_id = D.dept_id) AS course_count, (SELECT COUNT(*) FROM user U WHERE U.dept_id = D.dept_id AND U.user_id = $user_id) as join_flag, (SELECT COUNT(*) FROM department_follow DF WHERE DF.dept_id = $dept_id AND DF.user_id = $user_id) as follow_flag FROM department D WHERE D.dept_id = $dept_id";

$get_department_details_query_result = $con->query($get_department_details_query);

if ($get_department_details_query_result->num_rows == 0) {
    echo "No such department exists";
    exit();
} else {
    $department_row = $get_department_details_query_result->fetch_array();


    echo "

    <div class = 'group-head-sec'>

";

    if ($department_row['follow_flag']) {

        echo "

    <div class= 'btnWrap dept_btnWrap'>

        <button class = 'followBtn dept_fbtn unfollowBtn'>

            <em></em>

            Following

        </button>

    </div>

    ";

    } else {

        echo "

    <div class= 'btnWrap'>

        <button class = 'followBtn dept_fbtn'>

            <em></em>

            Follow this Department

        </button>

    </div>

    ";

    }

    echo "

    <div class = 'group-head-top-sec'>

        <div class = 'group-head-top-sec-shadow'>

        </div>

        <div class = 'info-scroll-up info-shower'>

            <div class = 'group-cover-pic-info'>

                <b><?php

                    ?> Time At <?php

                    ?>

                </b>

                <em class = 'em_hide'></em>

            </div>

";

    if ($admin_flag > 0) {

        echo "

            <button class = 'upload_cover'>

                <i></i>

                <span>Submit Cover</span>

            </button>

";


    } else {

//no option to edit cover photo
//DT Test
echo "

            <button class = 'upload_cover'>

                <i></i>

                <span>Submit Cover</span>

            </button>
";

    }

    echo "
            <div class = 'group_location'>
                <em></em>
                <span class = 'group_location_name'>
                <a href='http://maps.google.com/?q=' target='_blank' style='text-decoration:none;'>New York</a>
                </span>
            </div>

            <div class = 'help-div' id = 'help-3'>

                <div class = 'help-wedge'>

                </div>

                <div class = 'help-box'>

                    Submit a photo of this school for a chance to replace its current cover photo.

                </div>

            </div>

        <!--<div class = 'location-pic-div-wrap'>

                <div class = 'white-wedge-up'>

                </div>

                <div class = 'location-pic-container'>

                    <div class = 'modal_loading3'>

                        <img class = 'modal_animation' src = 'src/loadingAnimation.gif'>

                    </div>

                    <img class = 'location_building_pic' src = 'src/polyMT6.jpg' class = 'location-picture'>

                </div>

            </div>-->

        </div>


    </div>

    <div class = 'group-pic-frame'>

";

    if ($admin_flag > 0) {

        echo "

        <form>

            <input class='header_small_img_input' name='img' type='file' style='display:none;'>

        </form>

    ";

    } else {

//no option to edit pic

    }

    echo "

        <div class = 'group-pic' style='background-image:url(" . get_dp($con, $dept_id, 'dept') . ");background-size:cover;'>

        </div>

    </div>

    <div class = 'group-header-left group-header-above'>





        <div class = 'group-title spec-group-title'>

            <div class = 'group-name group-name-mt'>

                " . $department_row['dept_name'] . "

            </div>

        </div>



    </div>



    <div class = 'group-head-footer'>

        <div class = 'group-header-tab'>

            <ul class = 'group-nav'>

                <li class = 'group-tab'>

                    <a class = 'tab1 tabFeed tab-anchor group-tab-active'>

                        <div class = 'tab-title'>

                            DEPT. FEED

                            <span class = 'tab-icon tab1-icon-active'></span>

                        </div>



                    </a>

                </li>

                <li class = 'group-tab'>

                    <a class = 'tabDepartments tab-anchor tab-inactive'>

                        <div class = 'tab-title'>

                            COURSES

                            <span class = 'tab-icon tab2-icon-inactive'></span>

                        </div>

                        <div class = 'status tab-number'>

                            <span class = 'badge'>

                                " . $department_row['course_count'] . "

                            </span>

                        </div>

                    </a>

                </li>

                <li class = 'group-tab'>

                    <a class = 'tabmembers tab-anchor tab-inactive'>

                        <div class = 'tab-title'>

                            MEMBERS

                            <span class = 'tab-icon tab3-icon-inactive'></span>

                        </div>

                        <div class = 'status tab-number'>

                            <span class = 'badge'>

                                " . $department_row['user_count'] . "

                            </span>

                        </div>

                    </a>

                </li>

            </ul>

        </div>";

    if ($department_row['join_flag'] > 0) {

        echo "

        <div class = 'group-footer-functions'>

            <div class = 'join-button'>

                <a class = 'join disabled'>

                    Member

                </a>

                <div class = 'help-div' id = 'help-4'>

                    <div class = 'help-wedge'>

                    </div>

                    <div class = 'help-box'>

                        You are a member of this department. Go to your profile page to change your department.

                    </div>

                </div>

            </div>

        </div>";

    } else {

        echo "

        <div class = 'group-footer-functions'>

            <div class = 'join-button'>

                <a class = 'join disabled'>

                    Not A Member

                </a>

                <div class = 'help-div' id = 'help-4'>

                    <div class = 'help-wedge'>

                    </div>

                    <div class = 'help-box'>

                        You are not a member of this department. Go to your profile page to change your department.

                    </div>

                </div>

            </div>

        </div>";

    }

    echo "

    </div>

    <div class = 'tab-wedge-down'>

    </div>

</div>

";
}

?>