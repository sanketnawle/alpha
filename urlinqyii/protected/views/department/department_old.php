<!DOCTYPE html>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundGroup.css'>
<!--<link rel = "stylesheet" type = "text/css" href = "school_alpha/feedGroup.css"> -->
<!--<link rel = "stylesheet" type = "text/css" href = "css/group.css"> -->
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/school/school_alpha/group.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/school/school_alpha/school_department.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/leftmenu.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/datepicker.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/coursesCardUI.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/dept.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/planner_for_dept.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/fbar.css'>
<link rel = "stylesheet" type = "text/css" href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/dropdown_style.css'>


<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
<!--<script src="filepicker.js"></script>-->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="../protected/js/department.js"></script>

<link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
<link rel="icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">

<script>
    base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";
</script>

</head>
<body>
<div class='root'>



    <div class='gp_topbar_wrap'>
        <?php echo Yii::app()->runController('partial/topbar'); ?>
    </div>

    <div class='gp_leftbar_wrap'>
        <?php echo Yii::app()->runController('partial/leftmenu',array()); ?>
    </div>


    <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'department','origin_id'=>$department->department_id,'origin'=>$department)); ?>

    <div class='modal_coverPhoto_body modal_body'>
        <div class='modal_coverPhoto_container'>
            <div class='modal_loading'>
                <img class='modal_animation' src='src/loadingAnimation.gif'>
            </div>
            <div class='modal_content'>
                <div class='modal_header'>
						<span class='floatL white'>
							Submit Cover Photo
						</span>
                    <div class='floatR cancelBtn close'>
                    </div>
                </div>
                <div class='modal_main'>
                    <form>
                        <label for='cover_name' class='label_left'>
                            Cover Photo Name
                        </label>
                        <input class='inputBig inputPhotoName' id='cover_name'
                               placeholder='Enter a name for this photo...'>
                        <input class='cover_photo_upload' name='img' type='file' style='display:none;'>

                        <div class = "uploadedPhotoFrame_display" style="background-size:cover;"></div>
                        <div class='uploadedPhotoFrame'>
                            <div class='noPhotoText'>
                                No photo uploaded
                            </div>
                            <div class='photoicon'>
                            </div>

                            <button class='uploadPhotoBtn'>
                                Upload Photo
                            </button>
                        </div>
                        <div class='btmleft'>

                            <button type='button' class='cancelBtn grayBtn'>
                                Cancel
                            </button>
                            <button type='button' class='blueBtn pt_upload_button'>
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='main'>

        <div class='main-mid-sec'>

            <div class='mid_right_sec mid_right_sec_school'>
                <?php include('department_header.php'); ?>
                <div class='midsec'>
                    <div class='section group'>
                        <?php echo $this->renderPartial('department_feed_tab',array()); ?>

                        <?php echo $this->renderPartial('department_courses_tab',array()); ?>

                        <?php echo $this->renderPartial('department_faculty_tab',array()); ?>

                        <?php echo $this->renderPartial('department_students_tab',array()); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

</body>


</html>