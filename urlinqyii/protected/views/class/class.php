
<!DOCTYPE html>
<?php //include('php/redirect.php');?>
<html>
<head>

<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundGroup.css'>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/group.css'>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/invite_modal.css'>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/photo_modal.css'>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/planner_for_class.css'>


<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">

<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script type="text/javascript">
    base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
    class_id = '<?php echo $class->course_id; ?>';
</script>

<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/class/class.js'></script>


</head>
<body>

<div class='root'>

    <div class='gp_topbar_wrap'>
        <?php include("topbar.php"); ?>
    </div>

    <div class='gp_leftbar_wrap'>
        <?php

        echo Yii::app()->runController('partial/leftmenu',array('user'=>$user));


        ?>

    </div>
  <!--  <section>
        <?php// include("leftpanel.php"); ?>
    </section> -->

    <button class='email_invite email_invite_simulator'></button>

    <div class='dt_picker_wrap'><?php include("add_group_schedule.php");
       // include("set_working_hours.php"); ?></div>
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
                        <label for="cover_name" class="label_left2">
                            Or:
                        </label>
                        <button class="inviteBtn">
                            Upload Member List Excel Document
                        </button>
                        <form id="upload_excel_form">
                            <input type='file' class='upload_excel_list' name='excel_list'>
                        </form>
                        <div class='excel_label'>No File Uploaded</div>

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
                <img class="modal_animation" src="assets/loadingAnimation.gif">
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

    <div class='main'>

        <div class='main-mid-sec'>

            <div class='mid_right_sec'>

                <?php $this->renderPartial('class_header',array('user'=>$user,'class'=>$class, 'course'=>$course, 'professor'=>$professor
                , 'department'=>$department, 'is_member'=>$is_member,'is_admin'=>$is_admin, 'schedules'=>$schedules)); ?>
                <div class='midsec'>

                    <?php echo $this->renderPartial('class_feed_tab',array('course'=>$course,'user'=>$user)); ?>


                    <div class="members-tab-content">
                        <?php echo $this->renderPartial('class_members_tab',array('user'=>$user,'class'=>$class,
                            'is_admin'=>$is_admin, 'following' =>$following) );
                        ?>
                    </div>

                    <div class='files-tab-content'>
                        <?php
                           echo $this->renderPartial('class_files_tab',array('class'=>$class,'user'=>$user, 'files'=>$files));
                        ?>

                    </div>
                    <div class='syllabus-tab-content'>
                        <?php
                    //        echo $this->renderPartial('class_syllabus_tab',array('class'=>$class,'user'=>$user));
                        ?>

                    </div>

                    <div class='about-content-tab'>
                        <?php echo $this->renderPartial('class_about_tab',array('class'=>$class,'user'=>$user, 'professor'=>$professor
                            ,'course'=>$class->course, 'department'=>$department,'other_courses'=>$other_courses,'schedules'=>$schedules
                            ,'all_following'=>$all_following)); ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!--<?php// $con->close(); ?>-->

</body>
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


        $(document).delegate(".searchFiles", "keyup", function (e) {
            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".file").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    /*control the text prompt of the div*/
                    $(".files-type-content").each(function (index) {
                        var l = $(this).find(".file").not('.hidden_result').length;
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


        $(document).delegate(".upload-files", "click", function () {
            $(this).closest(".files-search-top").find(".upload_file_at_course").click();

        });

        $(document).delegate(".upload_file_at_course", "change", function () {
            var $ref = $(this);

            var formData = new FormData($ref.closest("form")[0]);
            formData.append("class_id", class_id);
            $.ajax({
                type: "POST",
                url: "php/class_file_upload.php",
                xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },

                data: formData,
                contentType: false,
                processData: false,
                success: function (html) {
                    //alert(html);
                    alert("as");
                    $.ajax({
                        type: "POST",
                        url: "class_files_tab.php",
                        data: {class_id: class_id},
                        success: function (html) {
                            $(".files-tab-content").remove();

                            $(".midsec").append(html);
                            $(".files-tab-content").animate({ opacity: "1"}, 300);
                            $(".files-tab-content").show();
                            alert("ok");
                        },
                        error: function (html) {
                            alert(html);
                            alert("b");
                        }
                    });

                },
                error: function (html) {
                    alert(html);
                    alert("a");
                }
            });


        });


        $(document).delegate(".sortByDropdown", "change", function () {

            var filelist = [];
            if ($(this).val() == "recent-rank") {
                filelist = [];
                $(".file").each(function (index) {
                    filelist.push($(this).clone());
                });
                //alert(filelist[2].attr("id"));

                filelist.sort(function (x, y) {
                    return Date.parse(y.find(".file-cont").attr("id").replace(/-/g, '/')) - Date.parse(x.find(".file-cont").attr("id").replace(/-/g, '/'));
                });

                //alert(filelist[2].attr("id"));

                $.each(filelist, function (index) {
                    $(".file_sortbox").append(filelist[index]);
                });

                $(".hidden_result").removeClass("hidden_result");
                $(".searchFiles").val("");

                $(".blockwrapper").hide();
                $(".files-type-content").hide();
                $(".file_sortbox").show();
            } else {

                filelist = [];
                $(".blockwrapper").show();
                $(".files-type-content").show();
                $(".file_sortbox").hide();

                $(".hidden_result").removeClass("hidden_result");
                $(".searchFiles").val("");
                $(".file_sortbox").empty();

            }


        });


        /*progress function for ajax*/
        function progressHandlingFunction(e) {
            if (e.lengthComputable) {
                $('progress').attr({value: e.loaded, max: e.total});
            }
        }

    });
</script>

</html>