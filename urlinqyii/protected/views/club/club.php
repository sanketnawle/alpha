<!DOCTYPE html>
<?php
//	include('php/redirect.php');
//?>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'>
    <link rel='stylesheet' type='text/css' href='css/backgroundGroup.css'>
    <link rel='stylesheet' type='text/css' href='css/group.css'>
    <link rel='stylesheet' type='text/css' href='css/invite_modal.css'>
    <link rel='stylesheet' type='text/css' href='css/photo_modal.css'>
    <link rel='stylesheet' type='text/css' href='css/clubs.css'>
    <link rel='stylesheet' type='text/css' href='css/planner_for_club.css'>

    
    <link rel="shortcut icon" href="img/Ur_FavIcon.jpg" type="image/jpg">
    <link rel="icon" href="img/Ur_FavIcon.jpg" type="image/jpg">


    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src='jquery-ui-1.11.0/jquery-ui.min.js'></script>
    <script src='js/clubs.js'></script>
</head>
<body>
<div class='root'>

    <div class='gp_topbar_wrap'>
        <?php include("topbar.php"); ?>
    </div>

    <div class='gp_leftbar_wrap'>
        <?php include("leftmenu.php"); ?>
    </div>

    <button class='email_invite email_invite_simulator'></button>

    <div class='dt_picker_wrap'><?php include("add_group_schedule.php"); ?></div>

    <div class="modal_invite_body modal_body">
        <div class="modal_invite_container">
            <div class="modal_loading">
                <img class="modal_animation" src="src/loadingAnimation.gif">
            </div>
            <div class="modal_content">
                <div class="modal_header">
                        <span class="floatL white">
                            Member Invitation
                        </span>
                    <em class="floatR cancelBtn close">
                    </em>
                </div>
                <div class="modal_main">
                    <div class="modal_main_form">
                        <label for="cover_name" class="label_left">
                            Send Invitation To:
                        </label>
                        <input class="inputBig inviteName" id="cover_name" placeholder="Email Address">
                        <!--<label for = "cover_name" class = "label_left2">
                            Or:
                        </label>
                        <button class = "inviteBtn">
                            Upload Member List Excel Document
                        </button>
                        <form id="upload_excel_form">
                            <input type='file' class='upload_excel_list' name='excel_list'>
                        </form>
                        <div class='excel_label'>No File Uploaded</div>-->

                        <div class='modal-mid'>
                            <textarea class='modal-mid-textarea' placeholder='Customize your invitation email!'
                                      value=""></textarea>
                        </div>

                        <div class="btmleft">

                            <button type="button" class="cancelBtn grayBtn">
                                Cancel
                            </button>
                            <button type="button" class="blueBtn modal_ml_submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal_coverPhoto_body modal_body">
        <div class="modal_coverPhoto_container">
            <div class="modal_loading">
                <img class="modal_animation" src="src/loadingAnimation.gif">
            </div>
            <div class="modal_content">
                <div class="modal_header">
                        <span class="floatL white">
                            Submit Cover Photo
                        </span>
                    <em class="floatR cancelBtn close">
                    </em>
                </div>
                <div class="modal_main">
                    <form>
                        <label for="cover_name" class="label_left">
                            Cover Photo Name
                        </label>
                        <input class="inputBig inputPhotoName" id="cover_name"
                               placeholder="Enter a name for this photo...">
                        <input class="coverphoto_show" type="file" name="img">

                        <div class="uploadedPhotoFrame_display" style="background-size:cover;"></div>
                        <div class="uploadedPhotoFrame">
                            <div class="noPhotoText">
                                No photo uploaded
                            </div>
                            <div class="photoicon">
                            </div>

                            <button class="uploadPhotoBtn">
                                Upload Photo
                            </button>
                        </div>
                        <div class="btmleft btmleft_photo_adjust">

                            <button type="button" class="cancelBtn grayBtn">
                                Cancel
                            </button>
                            <button type="button" class="blueBtn pt_upload_button">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='main<?php
	    if(!is_member_of($con,$_SESSION['user_id'],'club',$_GET['group_id']))
	    {
		    echo " non-member";
	    }
    ?>'>

        <div class='main-mid-sec'>

            <div class='mid_right_sec'>
                <div class="group-head-sec">
                    <?php include "php/club_header.php"; ?>
                </div>
                <div class='midsec'>
	                <?php
	                if(is_member_of($con,$_SESSION['user_id'],'club',$_GET['group_id']))
	                {
		            ?>
		                <div class='feed-tab-content'>
                        <?php
	                            include('php/club_feed_tab.php');
                        ?>
                    </div>
	                <?php
	                }
	                ?>
                    <div class="members-tab-content"></div>
	                <?php
	                if(is_member_of($con,$_SESSION['user_id'],'club',$_GET['group_id']))
	                {
	                ?>
                    <div class='files-tab-content'></div>
                    <div class='syllabus-tab-content'></div>
	                <?php
	                }
	                ?>
	                <div class='analytics-tab'>
                        <?php include('analytics.php'); ?>
                    </div>
                    <div class='about-content-tab'>
                        <?php include('php/club_about_tab.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--<?php //mysqli_close($con); ?>-->

</body>


</html>