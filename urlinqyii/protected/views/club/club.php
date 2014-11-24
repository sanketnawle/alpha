



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
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundGroup.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/group.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/invite_modal.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/photo_modal.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/club/club.css'>
<!--    <link rel='stylesheet' type='text/css' href='--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/css/planner_for_club.css'>-->

    
    <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
    <link rel="icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">


    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>


    <!--  This allows us to use club_id in our javascript without having to access the url parameter  -->
    <script type="text/javascript">
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        club_id = '<?php echo $club->group_id; ?>';
        origin = 'group';
        origin_id = '<?php echo $club->group_id; ?>';
    </script>

    <?php //include "timezone.php" ?>

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/club/club.js'></script>
</head>
<body>
<div class='root'>

    <div class='gp_topbar_wrap'>
        <?php echo Yii::app()->runController('partial/topbar'); ?>
    </div>

    <div class='gp_leftbar_wrap'>
        <?php

            echo Yii::app()->runController('partial/leftmenu');


            //echo $this->renderPartial('/partial/leftmenu',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count));
            //include("leftmenu.php");
        ?>

    </div>

    <button class='email_invite email_invite_simulator'></button>

    <div class='dt_picker_wrap'><?php //include("add_group_schedule.php"); ?></div>

    <div class="modal_invite_body modal_body">
        <div class="modal_invite_container">
            <div class="modal_loading">
                <img class="modal_animation" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/loadingAnimation.gif">
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
                <img class="modal_animation" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/loadingAnimation.gif">
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
	    //if(!is_member_of($con,$_SESSION['user_id'],'club',$_GET['group_id']))
	    //{
		//    echo " non-member";
	    //}
    ?>'>

        <div class='main-mid-sec'>

            <div class='mid_right_sec'>
                <div class="group-head-sec">

                    <?php

                        //Yii::app()->runController('club/header',array('user'=>$user));
                        //$this->render('//partial/feeds');
                        //echo $this->renderPartial('/partial/feeds',array('posts'=>'lol'));

                        echo $this->renderPartial('club_header',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count));

                    ?>

                </div>
                <?php
                //echo Yii::app()->runController('partial/planner');
                echo $this->renderPartial('/partial/planner',array('club'=>$club,'user'=>$user));

                //echo $this->renderPartial('/partial/homePlanner',array('base_url'=>Yii::app()->getBaseUrl(true),'user'=>$user));

                ?>

                        <div class="rightsec" style="position: fixed; margin-top: 200px;">


                        </div>
	                <?php
	                if($is_member){
                    ?>
                            <div class='feed-tab-content'>

                            <?php
                                echo $this->renderPartial('club_feed_tab',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count));
                            ?>
                            </div>
                    <?php
	                }
	                ?>
                    <div class="members-tab-content">

                        <?php
                            echo $this->renderPartial('club_members_tab',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count));
                        ?>

                    </div>

                    <?php
	                if($is_member){
                      ?>
                    <div class='files-tab-content'></div>
                    <div class='syllabus-tab-content'>
                        <?php
                            echo $this->renderPartial('club_events_tab',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count));
                        ?>

                    </div>

                    <?php
	                }
	                ?>
	                <div class='analytics-tab'>
                        <?php echo $this->renderPartial('club_analytics',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count)); ?>
                    </div>
                    <div class='about-content-tab'>
                        <?php echo $this->renderPartial('club_about_tab',array('club'=>$club,'user'=>$user,'is_admin'=>$is_admin,'file_count'=>$file_count,'connected_users'=>$connected_users)); ?>
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