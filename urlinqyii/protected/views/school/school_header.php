<?php

$user_id = 1;
$user = 1;
$school_id = 1;
$cp_id = 1;
$dp_id = 1;
$is_admin = 1;
$con = 1;
$cv_link = "includes/get_blob.php?img_id=$cp_id";
$dp_link = "includes/get_blob.php?img_id=$dp_id";

echo '
    <div class = "group-head-top-sec">
        <div class = "group-head-top-sec-shadow">
        </div>
        <div class = "info-scroll-up info-shower">
            <div class = "group-cover-pic-info">
                <b>Caption Here</b>
            </div>
            <button class = "upload_cover upload_school_cover">
                <i></i>
                <span>Submit Cover</span>
            </button>
            <div class = "group_location">
                <em></em>
                <span class = "group_location_name">
                    <!--
                    <a href="http://maps.google.com/?q=1" target="_blank" style="text-decoration:none;">
                        1
                    </a>
                    -->
                    <a id="school_location_link" href="" target="_blank" style="text-decoration:none;">New York</a>
                </span>
            </div>
            <div class = "help-div" id = "help-3">
                <div class = "help-wedge">
                </div>
                <div class = "help-box">
                    Submit a photo of this school for a chance to replace its current cover photo.
                </div>
            </div>
            <div class="location-pic-div-wrap"></div>
        </div>

        <div class = "group-cover-picture"></div>
    </div>

    <div class = "group-pic-frame">
        <form>
        <input class="header_small_img_input" name="img" type="file" style="display:none;">
        </form>
        <div class = "group-pic"></div>
    </div>
    <div class = "group-header-left group-header-above">
        <div class = "group-title spec-group-title">
            <div class = "group-name group-name-mt">'; echo $school->school_name; echo '</div>
        </div>
    </div>


    <div class = "group-head-footer">
        <div class = "group-header-tab">
            <ul class = "group-nav">
                <li class = "group-tab info-tab">
                    <a class = "tab1 tabFeed tab-anchor group-tab-active">
                        <div class = "tab-title">
                            SCHOOL INFO
                            <span class = "tab-icon tab1-icon-active"></span>
                        </div>

                    </a>
                </li>
                <li class = "group-tab departments-tab">
                    <a class = "tabDepartments tab-anchor tab-inactive">
                        <div class = "tab-title">
                            DEPARTMENTS
                            <span class = "tab-icon tab2-icon-inactive"></span>
                        </div>
                        <div class = "status tab-number">
                            <span class = "badge">
                                99
                            </span>
                        </div>
                    </a>
                </li>
                <li class = "group-tab members-tab">
                    <a class = "tabmembers tab-anchor tab-inactive">
                        <div class = "tab-title">
                            MEMBERS
                            <span class = "tab-icon tab3-icon-inactive"></span>
                        </div>
                        <div class = "status tab-number">
                            <span class = "badge">
                               99
                            </span>
                        </div>
                    </a>
                </li>
                <li class="group-tab club-tab">
                    <a class="tabmembers tab-anchor tab-inactive">
                        <div class="tab-title">
                            CLUBS
                            <span class="tab-icon tab3-icon-inactive"></span>
                        </div>                        
                    </a>
                </li>
                <!--
                <li class = "tab-no-badge group-tab">
                    <a class = "tabc tabevents tab-anchor tab-inactive">
                        <div class = "tab-title">
                            EVENTS
                            <span class = "tab-icon tabc-icon-inactive"></span>
                        </div>
                    </a>
                </li>
                -->
            </ul>
        </div>
        <div class = "group-footer-functions">
            <div class = "join-button">
                <a class = "join disabled">Member</a>
                <div class = "help-div" id = "help-4">
                    <div class = "help-wedge">
                    </div>
                    <div class = "help-box">
                        You are a member of this school. Go to your profile page to change which school you are a part of.
                    </div>
                </div>
            </div>
        </div>
        <div class = "tab-wedge-down"></div>
    </div>
';

/*
if (isset($_GET['univ_id'])) {
    if ($_GET['univ_id'] === $_SESSION['univ_id']) {
        echo '<a class = "join disabled">
                                                                         Member
                                                                        </a> <div class = "help-div" id = "help-4">
                                                <div class = "help-wedge">
                                                </div>
                                                <div class = "help-box">
                                                    You are a member of this school. Go to your profile page to change which school you are a part of.
                                                </div>
                                            </div>';
    } else {
        echo '<a class = "join disabled">
                                                                          Not a Member
                                                                        </a> <div class = "help-div" id = "help-4">
                                                <div class = "help-wedge">
                                                </div>
                                                <div class = "help-box">
                                                    You are not a member of this school. Go to your profile page to change which school you are a part of.
                                                </div>
                                            </div>';

    }
} else {
    echo '<a class = "join disabled">
                                                                          Member
                                                                        </a> <div class = "help-div" id = "help-4">
                                                <div class = "help-wedge">
                                                </div>
                                                <div class = "help-box">
                                                    You are  a member of this school. Go to your profile page to change which school you are a part of.
                                                </div>
                                            </div>
';
}
*/

?>