<?php

$user_id = 1;
$user = 1;
$school_id = 1;
$cp_id = 1;
$dp_id = 1;
$university = 1;
$is_admin = 1;
$con = 1;
$cv_link = "includes/get_blob.php?img_id=$cp_id";
$dp_link = "includes/get_blob.php?img_id=$dp_id";

echo'
    <div class = "modal_coverPhoto_body modal_body">
        <div class = "modal_coverPhoto_container">
            <div class = "modal_loading">
                <img class = "modal_animation" src = "">
            </div>
            <div class = "modal_content">
                <div class = "modal_header">
                            <span class = "floatL white">
                                Submit Cover Photo
                            </span>
                    <em class = "floatR cancelBtn close">
                    </em>
                </div>
                <div class = "modal_main">
                    <form>
                        <label for = "cover_name" class = "label_left">
                            Cover Photo Name
                        </label>
                        <input class = "inputBig inputPhotoName" id = "cover_name" placeholder = "Enter a name for this photo...">
                        <input class="cover_photo_upload" name="img" type="file" style="display:none;">

                        <div class = "uploadedPhotoFrame_display" style="background-size:cover;"></div>
                        <div class = "uploadedPhotoFrame">

                            <div class = "noPhotoText">
                                No photo uploaded
                            </div>
                            <div class = "photoicon">
                            </div>

                            <button class = "uploadPhotoBtn">
                                Upload Photo
                            </button>
                        </div>
                        <div class = "btmleft">

                            <button type=  "button" class = "cancelBtn grayBtn">
                                Cancel
                            </button>
                            <button type=  "button" class = "blueBtn pt_upload_button">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>';

echo '
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