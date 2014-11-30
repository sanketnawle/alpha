

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php echo $userProfile->firstname . ' ' . $userProfile->lastname; ?></title>
        <!--<base href='https://urlinq.com/beta/'/>-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundProfile.css" />
        <link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300,200" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/professor.css" />
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>



        <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
        <link rel="icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">

        <script type="text/javascript">
            base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            user_id = '<?php echo $user->user_id; ?>';
            user_profile_id = '<?php echo $userProfile->user_id; ?>';
        </script>

        <script src="https://www.google.com/jsapi?key='AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4'"></script>
        <script src="https://apis.google.com/js/client.js?onload=initDrivePicker"></script>

        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>

        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/professor-profile.js"></script>

    </head>

    <body class="loadani_parent">

        <section class="loading_animation">
            <?php
                $text = "PROFILE";
                               //  include 'loading.php';
            ?>
        </section>
        <section class="topbar_bag">
            <?php echo Yii::app()->runController('partial/topbar'); ?>
        </section>
		
		<div class="showcase-form">
            <form id="add-showcase">
                <div class="showcase-form-header">
                    Adding a New Showcase<i></i>
                    <textarea id="title-entry" name="title-entry" placeholder="Provide a title for your showcase, or add a link below and we'll do it for you"></textarea>
                    <textarea id="desc-entry" name="desc-entry" placeholder="Add a description"></textarea>
                    <textarea id="link-entry" name="link-entry" placeholder="Paste a link to your showcase"></textarea>
                    <button type="button" id="upload-link-button" ><i></i>Upload Showcase</button>
                    <div style='height: 0px;width:0px; overflow:hidden;'>
                        <input id="upfile" type="file" value="upload"/>
                    </div>
                    <div class="showcase-submit">
                        <span class="cancel-showcase-form">Cancel</span>
                        <input type="submit" class="create-showcase-form" id="create-showcase-form" name="create-showcase-form" value="+ Add this Showcase">
                    </div>
                    <?php if($closedInstructions == 0){
                        echo '<div class="description-section">
                        <i class="close-description"></i>
                        <div class="top-description">
                            - Show your peers and friends what academic research and articles you\'re interested in or have contributed to.
                            </div>
                            <div class="bottom-description">
                        - Display presentations or projects that you want to share with the people in your academic network.
                            </div>
                        </div>';
                    }?>

                </div>
            </form>
		</div>
        <div class="edit-showcase-form">
            <span>Editing this Showcase</span>
            <input id="showcase-name-edit" name="showcase-name" placeholder="change title">
            <input id="showcase-link-edit" name="showcase-link" placeholder="change description">
        <!--    <button type="button" id="edit-upload-button"><i></i>Upload Showcase</button>-->
            <div class="edit-form-bottom">
                <span>Cancel</span>
                <div class="add-showcase-button" id="edit-from-submit">
                    <button type="button">Done Editing</button>
                </div>
            </div>
        </div>
        <div class="root">
            <div class="blacksheet-main editing-mode">
            </div>
            <div class="showcaser">
                <div class="showcase_box">
					
                </div>
            </div>
            <div class="main-2">
                <div class="prof-header-bar-alias">
                    <div class="personal-website-wrap">
                        <div class="personal-website-wrap-header">
                            <label class="user-info-labels" for="user_website">Your Personal Website URL</label>
                        </div>
                        <div class="website-inp-wrap">
                            <input type="text" id="user_website" name="user_website" class="user_website user_inp_full" placeholder="http://www...">
                        </div>
                    </div>
                    <div class="personal-website-wrap" style="left:510px;" id="edit_grad_year" style="display:none;">
                        <div class="personal-website-wrap-header">
                            <label class="user-info-labels" for="user_website">Graduation Details</label>
                        </div>
                        <div class="website-inp-wrap">
                            <input type="text" id="stu_grad_year" name="graduation_year" class="user_website user_inp_full" placeholder="Year of graduation">
                            <ul class="dropdown">
                                <?php $d = date("Y"); for($i = $d - 4; $i <= $d + 6; ++$i): ?>
                                <li><?php echo $i; ?></li>
                                <?php endfor;?>
                            </ul>
                        </div>
                        <div class="website-inp-wrap">
                            <input type="text" id="stu_type" name="graduation_year" class="user_website user_inp_full" placeholder="Graduation Level">
                            <ul class="dropdown">
                                <li>Undergraduate</li>
                                <li>Masters</li>
                                <li>Ph.D</li>
                            </ul>
                        </div>
                        <div class="website-inp-wrap">
                            <input type="text" id="stu_major" name="graduation_major" class="user_website user_inp_full" placeholder="Major">
                            <ul class="dropdown">
                                <?php //include("php/listofmajors.html"); ?>
                            </ul>
                        </div>
                    </div>
                    <div class="orig-edit-btns">

                        <a class="cancel-edit-profile">
							Cancel
                        </a>
                        <a class="save-edit-profile">
							Save Changes
                        </a>
                    </div>
                    <span class="profpic-container profpic-container-edit">
                        <form enctype="multipart/form-data" class="photo_hidden_form">
                            <input class="photo_fileup" id="profile_pic_upload" type="file" name="img">
                        </form>
                        <a class="photoup_simulator">
                            <span class="img img-inset user-pic img-wrap-edit">

                                <div class="user-pic-div user-pic-div-edit"></div>

                            </span>
                        </a>
                        <div class="pic-text-icon-center">
                            <div class="pic-text-icon">
                            </div>
                            <div class="pic-text">
								Change your profile photo
                            </div>
                        </div>
                        <a class="upload-pic-btn">
							Upload a New Photo
                        </a>
                    </span>
                </div>
                <div class="profile-content-2">
                    <div class="user-info-wrapper-2">
                        <div class="user-info-editable full-name-editable">
                            <div class="labels-halfs">
                                <label class="user-info-labels user-info-labels-half" for="user_fname">First name</label>
                                <label class="user-info-labels user-info-labels-half" for="user_lname">Last name</label>
                            </div>
                            <div class="inputs-halfs">
                                <input type="text" id="user_fname" name="user_fname" placeholder="First name" class="user_inp_half user_fname" maxlength="15">
                                <input type="text" id="user_lname" name="user_lname" placeholder="Last name" class="user_inp_half user_lname" maxlength="15">
                            </div>
                        </div>
                        <div class="user-title">
							About
                        </div>
                        <div class="user-info-editable about-editable">
                            <textarea id="user_about" name="user_about" class="user_about user_inp_big" placeholder="Bio" maxlength="250"></textarea>
                        </div>

                        <div class="user-title">
							Interests
                        </div>

                        <div class="user-info-editable interest-editable">
                            <textarea id="user_interest" name="user_interest" class="user_interest user_inp_big" placeholder="Introduce your Interests" maxlength="36"></textarea>
                            <div class="tag-option" style="background: none repeat scroll 0% 0% #FFF;display: none; width: 315px; position: absolute; z-index: 50; border:1px solid #C0C0C0;margin-left:7px">
                                <div class="tag-section tagsec-r">
                                </div>
                            </div>
                            <div id="my_interests">
                            </div>
                        </div>

                        <div class="user-info-editable">
                            <label class="user-info-labels" for="user_school">University</label>
                            <input readonly type="text" id="user_univ" name="user_univ" class="user_school user_inp_full" placeholder="University">
                        </div>
                        <div class="user-info-editable">
                            <label class="user-info-labels" for="user_school">School</label>
                            <input readonly type="text" id="user_school" name="user_school" class="user_school user_inp_full" placeholder="School">
                        </div>
                        <div class="user-info-editable ">
                            <label class="user-info-labels" for="user_dept">Department</label>

                            <div class="status-event-repeat status-add-event-box-dd dept-dropdown" style="display: block;">
                                <span class="status-dd-title">Department</span><span class="down-arrow" style="margin-top: -28px;"></span>
                                <span class="selected-value-to-send" id="user_dept" style="display:none;"></span>
                            </div>
                            <div class="status-click-out status-dd-box" id="school_departments" style="display:none;">
                                <div class="status-repeatoptiont-1" id=""></div>
                            </div>
                        </div>
                        <div id="user_designation" class="user-info-editable ">
                            <label class="user-info-labels" for="user_dept">Designation</label>
                            <input type="text" id="user_designation" name="user_designation" class="user_dept user_inp_full" placeholder="Department" maxlength="25">
                        </div>
                        <div class="user-info-editable">
                            <label class="user-info-labels" for="user_email">Edu Email</label>
                            <input type="text" readonly id="user_email" name="user_email" class="user_email user_inp_full" placeholder="School email address" maxlength="25">
                        </div>
                        <div class="user-info-editable " id="edit_office_loc" style="display:none;">
                            <label class="user-info-labels" for="user_loc" style="top:-2px">Office Location</label>
                            <input type="text" id="user_loc" name="user_loc" placeholder="Building and Office Number" class="user_loc user_inp_full" maxlength="25">
                        </div>

                    </div>
                </div>
            </div>
            <div class="main">
                <header class="professor-header professor-header-nothing">
                    <div class="resource-wrapper resources-vacant">
						<span class="showcase-caption">My Academic Portfolio</span>
                        <?php if($is_user){
                           echo '<div class="add-showcase-button" id="add-showcase-wrap-id">
                                    <button type="button">+ Add a showcase</button>
                                </div>';
                        }?>

						<div class="showcase-bar">
                            <?php
                            foreach($showcase as $i=>$entry){
                                $ext = $entry->file->file_extension;
                                if($ext != 'url'){
                                    $ext = '.'.$ext;
                                }

                                if($i == 0){
                                    echo '<div class="showcase-image center-image blur_class opacity_class" id="img-slot0" data-file-type="'.$ext.'"';
                                }else{
                                    echo '<div class="showcase-image blur_class" id="img-slot'.$i.'" data-file-type="'.$ext.'"';
                                }
                                if($entry->preview_file_id){
                                    echo " style=\"background-image: url('..".$entry->preview_image->file_url."');\">";
                                }else{
                                    echo '>';
                                }
                                echo '
                                        <div class="showcase-label"><span>';
                                if($entry->file->origin_type == 'link'){
                                    echo $entry->file->file_name;
                                }
                                echo '
                                        </span>
                                        </div>
                                        <div class="add-showcase-button download-button-div">';
                              /*  if($entry->file->origin_type == 'link'){
                                     echo '<button type="button" class="download-showcase-button"><i class="download_button_icon">
                                                   </i></button>';

                                }else{
                                     echo ' <a href="..'.$entry->file->file_url.'" download="'.basename($entry->file->file_name).'">
                                                <button type="button" class="download-showcase-button"><i class="download_button_icon">
                                                   </i></button></a>';

                                }*/
                               if($entry->file->origin_type == 'link'){
                                   echo "<button type=\"button\" onclick = \"window.open('".$entry->file->file_url."')\" class=\"download-showcase-button\"><i class=\"download_button_icon\">
                                                   </i></button>";

                               }else{
                                   echo ' <a href="../profile/downloadShowcase/?file_id='.$entry->file->file_id.'">
                                                <button type="button" class="download-showcase-button"><i class="download_button_icon">
                                                   </i></button></a>';
                                /*   echo ' <a href="..'.$entry->file->file_url.'" download="'.basename($entry->file->file_name).'">
                                            <button type="button" class="download-showcase-button"><i class="download_button_icon">
                                               </i></button></a>';*/
                           }

                            echo '    </div>
                                    <div class="showcase-description-wrap">
                                        <div class="showcase-title">'.
                                           $entry->title
                                        .'</div>
                                        <div class="showcase-description">'.
                                            $entry->file_desc
                                       .' </div>
                                    </div>';
                            if($i==0){
                                echo '<div class="image-panel-wrapper">';
                                  if($is_user){
                                      echo '<div class="circle-div" id="circle-div-delete">
                                            </div>
                                            <i></i>';
                                  }
                                echo  '     <div id="hint_wedge-before">

                                            </div>
                                            <div id="delete-on-hover-before">
                                                Delete
                                            </div>
                                            <div class="showcase-image-control">
                                                <div class="add-showcase-button" id="edit-showcase-button">
                                                    <i></i>
                                                    <button type="button"> Edit </button>
                                                </div>
                                                <div class="add-showcase-button" id="remove-showcase-button">
                                                    <i></i>
                                                    <button type="button" id="remove-showcase-button-id"> Remove </button>
                                                </div>
                                            </div>
                                            <div class="switch-image-panel">
                                                <div class="circle-div" id="circle-div-switch">
                                                    <div class="triangle-wedge">
                                                    </div>
                                                    <div class="square-wedge">
                                                    </div>
                                                </div>
                                                <div class="circle-div" id="circle-div-switch-left">
                                                    <div class="triangle-wedge" id="triangle-wedge-left">
                                                    </div>
                                                    <div class="square-wedge" id="square-wedge-left">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                            }
                            echo '</div>';

                        }

                        ?>
                     <!--   <div class="showcase-image center-image" id="img-slot0" data-file-type=".pdf">
                            <div class="showcase-label">
                                <span></span>
                            </div>
                            <button type="button" class="download-showcase-button"><i class="download_button_icon"></i></button>
                            <div class="showcase-description-wrap">
                                <div class="showcase-title">
                                    Adtech and Big Data
                                </div>
                                <div class="showcase-description">
                                    This is a paper on the use of big data in digital marketing.
                                </div>
                            </div>
                            <div class="image-panel-wrapper">
                                <div class="circle-div" id="circle-div-delete">
                                </div>
                                <i></i>
                                <div id="hint_wedge-before">

                                </div>
                                <div id="delete-on-hover-before">
                                    Delete
                                </div>
                                <div class="showcase-image-control">
                                    <div class="add-showcase-button" id="edit-showcase-button">
                                        <i></i>
                                        <button type="button"> Edit </button>
                                    </div>
                                    <div class="add-showcase-button" id="remove-showcase-button">
                                        <i></i>
                                        <button type="button" id="remove-showcase-button-id"> Remove </button>
                                    </div>
                                </div>
                                <div class="switch-image-panel">
                                    <div class="circle-div" id="circle-div-switch">
                                        <div class="triangle-wedge">
                                        </div>
                                        <div class="square-wedge">
                                        </div>
                                    </div>
                                    <div class="circle-div" id="circle-div-switch-left">
                                        <div class="triangle-wedge" id="triangle-wedge-left">
                                        </div>
                                        <div class="square-wedge" id="square-wedge-left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="showcase-image" id="img-slot1" data-file-type="url" style="background-image: url('img/test_image5.jpg');">
                            <div class="showcase-label">
                                <span>http://www.nytimes.com/video/science/100...</span>
                            </div>
                            <button type="button" class="download-showcase-button"><i class="download_button_icon"></i></button>
                            <div class="showcase-description-wrap">
                                <div class="showcase-title">
                                    Economics on the Moon
                                </div>
                                <div class="showcase-description">
                                    I released this article on the New York Times back in my first year of tenure. Boy were those the days.
                                </div>
                            </div>
                        </div>
                        <div class="showcase-image" id="img-slot2" data-file-type=".doc">
                            <div class="showcase-label">
                                <span></span>
                            </div>
                            <button type="button" class="download-showcase-button"><i class="download_button_icon"></i></button>
                            <div class="showcase-description-wrap">
                                <div class="showcase-title">
                                    A Test Document
                                </div>
                                <div class="showcase-description">
                                    This is a paper about the possibility of time travelling.
                                </div>
                            </div>
                        </div>
                        <div class="showcase-image" id="img-slot3" data-file-type=".ppt">
                            <div class="showcase-label">
                                <span></span>
                            </div>
                            <button type="button" class="download-showcase-button"><i class="download_button_icon"></i></button>
                            <div class="showcase-description-wrap">
                                <div class="showcase-title">
                                    Quantum Physics
                                </div>
                                <div class="showcase-description">
                                    This is a PowerPoint lecture I did on Quantum Physics.
                                </div>
                            </div>
                        </div>

                    -->
                    </div>
                    <div class="no-showcase ns-hide" style="display:none;">
                        <div class="ns-title">Add a New Academic Showcase</div>
                        <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/bigno_showcase_arrow.png" id="showcase_arrow" alt="h">
                        <a class="ns-btn" style="padding-bottom:10px;">
                            Add a Showcase
                        </a>
                    </div>

                    <div class="clickable_showcase_step2 showcase_step2" style="display:none;">
                        <form class="hdform"><input type="file" id="fileUpload" class="step2_file" name="file"><input type="hidden" val="" class="googleuploadinfoarchive_fbar"></form>
                        <div class="step2_content_anchor step2_content_anchor_files" style="display:none;">
                            <textarea id="titlefileupload" maxlength="25" class="uploaddes_sc dotline_txtbox" placeholder="Title for the Showcase"></textarea>
                            <div>
                                <div class="uploadafile">
                                    <div class="up_txt">From Your Computer</div>
                                    <a class="cf_bt cf_bt_normal">Choose File</a>
                                    <div class="cf_prompt">No file chosen</div>
                                </div>
                                <div class="driveafile">
                                    <div class="dv_txt">From Your Drive</div>
                                    <a class="cf_bt" id="chooseFromDrive">Choose File</a><div class="cf_prompt">No file chosen</div>
                                </div>
                            </div>
                            <div class="sc_footer">
                                <div class="sc_cancel">Cancel</div> <div class="sc_btn">Showcase</div><div class="sc_add" id="addShowcaseFile">Add</div>
                                <div id="showcase_file_error" style="display:none;font-size: 13px; padding-top: 5px; padding-left: 10px; color: #464646;">* Required title and file</div>
                            </div>
                        </div>
                        <div class="step2_content_anchor step2_content_anchor_link" style="display:none;">
                            <textarea id="titlelinkupload" maxlength="25" class="uploaddes_sc dotline_txtbox" placeholder="Title for the Showcase"></textarea>
                            <textarea id="linkLocation" class="linkbox_sc dotline_txtbox" placeholder="Link for the Showcase"></textarea>
                            <div class="sc_footer sc_link_ft">
                                <div class="sc_cancel">Cancel</div>
                                <div class="sc_btn">Showcase</div>
                                <div class="sc_add" id="addShowcaseLink">Add</div>
                                <div id="showcase_link_error" style="display:none;font-size: 13px; padding-top: 5px; padding-left: 10px; color: #464646;">* Required title and link</div>
                            </div>
                        </div>
                        <div class="showcase_step2_box showcase_left_box">
                            <br>
                            <div class="sc_txt" id="upload_showcase">Upload a Showcase</div>
                            <div class="upload_sc_pic"></div>
                        </div>
                        <div class="showcase_step2_box showcase_right_box">
                            <br>
                            <div class="sc_txt" id="upload_showcase2">Link a Showcase</div>
                            <div class="link_sc_pic"></div>
                        </div>
                    </div>

                    <div class="showcase-photos" style="display:none;">
                        <div class="clearfix-invite-ddbox">
                            <span class="add-more-showcase">
                        Add a New Showcase
                                <br>
                            </span>

                            <div style="display: block;" class="add-event-dd-box-invite" id="divInviteConnections">
                                <div class="dd-box-invite-scrollwrap" onload="showcaseLoaded()">
                                    <div class="showcase-wrapper">
                                        <ul>
                                            <li><img src="http://lorempixel.com/300/200?id=01" data-title="title 1"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=02" data-title="title 2"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=03" data-title="title 3"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=04" data-title="title 4"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=05" data-title="title 5"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=06" data-title="title 6"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=07" data-title="title 7"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=08" data-title="title 8"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=09" data-title="title 9"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=10" data-title="title 10"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=11" data-title="title 11"></li>
                                            <li><img src="http://lorempixel.com/300/200?id=12" data-title="title 12"></li>
                                        </ul>
                                        <div class="controls">
                                            <div class="btn left"><span class="arrow"></span></div>
                                            <div class="btn right"><span class="arrow"></span></div>
                                            <div class="center">
                                                <div class="title">A really long title</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
            </header>
        <div class="profile-main">
            <a class="office-hours-editor oh-editor-fx" id="edit_office_hours_btn" style="display:none;">
                    Edit Office Hours
            </a>
            <!--<div class="profile-options has-dropdown">
                <h1>
                    <a href="#">
                        <span class="info_username" id="profile_name"></span>
                    </a>
                </h1>
                <a class="user-website" target="_blank">
                    <span class="website-icon">
                    </span>
                    <div class="website-title-hider">
                        <span class="website-title" title="" id="profile_link">

                        </span>
                    </div>
                </a>

                <span class="office-hours" id="profOfficeHrs" style="display:none;">
                    <p>OFFICE HOURS</p>
                    <b id="profile_office_hours"></b>
                    <span class="office-hours-status in-office" style="display:none;"></span>
                </span>

                <span class="office-hours" id="studentGradYear" style="display:none;">
                    <p id="student_type"> </p><p style="text-transform:lowercase;">&nbsp;in&nbsp;</p><p id="student_major"> </p>
                    <b style="position: relative; float: left; margin-left: 0px; margin-top: -4px;">Graduating on</b><b id="graduatingOn"></b>
                </span>

            </div>-->

            <div class="blacksheet">

                <div class="edit_office_hours_wrap">
                    <div class="edit_office_hours_frame">
                        <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.22); height: 30px;">
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_mon">Monday</label>
                            </div>
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_tue">Tuesday</label>
                            </div>
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_wed">Wednesday</label>
                            </div>
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_thu">Thursday</label>
                            </div>
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_fri">Friday</label>
                            </div>

                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_fri">Start Time</label>
                            </div>
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_fri">End Time</label>
                            </div>
                            <div class="oh_day_select">
                                <label tabindex="2" for="oh_check_fri"></label>
                            </div>
                        </div>
                        <div>
                            <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
                            <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.10.2.custom.min.js"></script>
                            <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>
                            <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/ampm.js" type="text/javascript"></script>
                        </div>
                        <div class="officeHrsContainer">
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_mon" id="oh_check_mon" type="checkbox">
                                <label tabindex="2" for="oh_check_mon" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_tue" id="oh_check_tue" type="checkbox">
                                <label tabindex="2" for="oh_check_tue" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_wed" id="oh_check_wed" type="checkbox">
                                <label tabindex="2" for="oh_check_wed" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_thu" id="oh_check_thu" type="checkbox">
                                <label tabindex="2" for="oh_check_thu" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_fri" id="oh_check_fri" type="checkbox">
                                <label tabindex="2" for="oh_check_fri" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time startDate" name="event_time" placeholder="Start Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time endDate" name="event_time" placeholder="End Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/liked-button.png" class="addOfficeHrs" width="20" height="20" />
                            </div>
                        </div>
                        <div class="officeHrsContainer" style="display:none;">
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_mon" id="oh_check_mon1" type="checkbox">
                                <label tabindex="2" for="oh_check_mon1" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_tue" id="oh_check_tue1" type="checkbox">
                                <label tabindex="2" for="oh_check_tue1" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_wed" id="oh_check_wed1" type="checkbox">
                                <label tabindex="2" for="oh_check_wed1" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_thu" id="oh_check_thu1" type="checkbox">
                                <label tabindex="2" for="oh_check_thu1" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_fri" id="oh_check_fri1" type="checkbox">
                                <label tabindex="2" for="oh_check_fri1" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time startDate" name="event_time" placeholder="Start Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time endDate" name="event_time" placeholder="End Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/liked-button.png" class="addOfficeHrs" width="20" height="20" />
                            </div>
                        </div>
                        <div class="officeHrsContainer" style="display:none;">
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_mon" id="oh_check_mon2" type="checkbox">
                                <label tabindex="2" for="oh_check_mon2" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_tue" id="oh_check_tue2" type="checkbox">
                                <label tabindex="2" for="oh_check_tue2" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_wed" id="oh_check_wed2" type="checkbox">
                                <label tabindex="2" for="oh_check_wed2" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_thu" id="oh_check_thu2" type="checkbox">
                                <label tabindex="2" for="oh_check_thu2" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_fri" id="oh_check_fri2" type="checkbox">
                                <label tabindex="2" for="oh_check_fri2" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time startDate" name="event_time" placeholder="Start Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time endDate" name="event_time" placeholder="End Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/liked-button.png" class="addOfficeHrs" width="20" height="20" />
                            </div>
                        </div>
                        <div class="officeHrsContainer" style="display:none;">
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_mon" id="oh_check_mon3" type="checkbox">
                                <label tabindex="2" for="oh_check_mon3" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_tue" id="oh_check_tue3" type="checkbox">
                                <label tabindex="2" for="oh_check_tue3" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_wed" id="oh_check_wed3" type="checkbox">
                                <label tabindex="2" for="oh_check_wed3" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_thu" id="oh_check_thu3" type="checkbox">
                                <label tabindex="2" for="oh_check_thu3" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_fri" id="oh_check_fri3" type="checkbox">
                                <label tabindex="2" for="oh_check_fri3" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time startDate" name="event_time" placeholder="Start Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time endDate" name="event_time" placeholder="End Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/liked-button.png" class="addOfficeHrs" width="20" height="20" />
                            </div>
                        </div>
                        <div class="officeHrsContainer" style="display:none;">
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_mon" id="oh_check_mon4" type="checkbox">
                                <label tabindex="2" for="oh_check_mon4" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_tue" id="oh_check_tue4" type="checkbox">
                                <label tabindex="2" for="oh_check_tue4" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_wed" id="oh_check_wed4" type="checkbox">
                                <label tabindex="2" for="oh_check_wed4" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_thu" id="oh_check_thu4" type="checkbox">
                                <label tabindex="2" for="oh_check_thu4" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox oh_check_fri" id="oh_check_fri4" type="checkbox">
                                <label tabindex="2" for="oh_check_fri4" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time startDate" name="event_time" placeholder="Start Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time endDate" name="event_time" placeholder="End Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/liked-button.png" class="addOfficeHrs" width="20" height="20" />
                            </div>
                        </div>
                        <div class="officeHrsContainer" style="display:none;">
                            <div class="oh_day_select">
                                <input class="oh_checkbox" id="oh_check_mon" type="checkbox">
                                <label tabindex="2" for="oh_check_mon" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox" id="oh_check_tue" type="checkbox">
                                <label tabindex="2" for="oh_check_tue" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox" id="oh_check_wed" type="checkbox">
                                <label tabindex="2" for="oh_check_wed" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox" id="oh_check_thu" type="checkbox">
                                <label tabindex="2" for="oh_check_thu" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="oh_checkbox" id="oh_check_fri" type="checkbox">
                                <label tabindex="2" for="oh_check_fri" class="oh_checkbox_label"></label>
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time startDate" name="event_time" placeholder="Start Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <input class="set_time endDate" name="event_time" placeholder="End Time" type="text">
                            </div>
                            <div class="oh_day_select">
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/liked-button.png" class="addOfficeHrs" width="20" height="20" />
                            </div>
                        </div>
                        <script type="text/javascript">


                            $(".set_time").timeAutocomplete({
                                increment: 15,
                                formatter: "ampm",
                                value: '',
                                auto_value: false
                            });
                        </script>


                    </div>
                    <a class="office-hours-editor cancel-edit-officehrs">
                            Cancel
                    </a>
                    <a class="office-hours-editor done-editing">
                            Done Editing
                    </a>
                </div>

            </div>

            <div class="edit-profile-main-wrap" style="display:none;">

            </div>

            <!--<div class="follow-btn user_connection follow" id="user_connection" style="display:none;">
            </div>-->

            <span class="profpic-container profpic-container-real">
                <span class="img img-inset user-pic">
                    <div class="camera-icon-div-before" id="camera-icon-div">
                        <button class="camera-icon-button-before"><span></span></button>
                        <div style='height: 0px;width:0px; overflow:hidden;'>
                            <input id="picture-upfile" type="file" value="upload"/>
                        </div>
                    </div>
                    <div class="user-pic-div user-pic-div-my" id="profile_picture" style="background: url(
                    <?php if($userProfile->pictureFile) {
                        echo Yii::app()->getBaseUrl(true).$userProfile->pictureFile->file_url;
                    }else{
                        echo Yii::app()->getBaseUrl(true).'/assets/default/user.png';
                    } ?>
                        ) 50% 50% / 100% no-repeat scroll rgb(51, 51, 51);"></div>
                    <?php
                    if($both_follow == true){
                        echo '<i class="mutual-follower-icon"></i>';
                    }
                    ?>

                </span>

            </span>

        </div>
        <div class="profile-content">
            <div class="user-info-wrapper">
                <?php if($is_user){
                    echo '<button type="button" class="edit_prof_button"><b></b>Edit Profile</button>';
                }?>
                <div class="edit-mode-control">
                    <button type="button" class="finish-edit-button"><i></i>Done Editing</button>
                    <button type="button" class="cancel-edit-button">Cancel</button>
                </div>
                <div class="user-information">
                    <h1>
                        <a href="#">
                            <span class="info_username" id="profile_name"><?php echo $userProfile->firstname.' '.$userProfile->lastname;?></span>
                        </a>
                    </h1>
                    <div class="username-entry-field">
                        <input type="text" class="username-entry" name="username-entry" value="Ross Kopelman">
                    </div>
                    <p class="school-info"><?php echo $userProfile->studentAttributes->year.' | '.$university->university_name.' | '.$userProfile->studentAttributes->year_name; ?></p>
                    <p class="school-info-dropdown">
                        <select class="yearpicker">
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>| <?php echo $university->university_name; ?> |
                        <select class="levelpicker">
                            <option value="Freshman">Freshman</option>
                            <option value="Sophomore">Sophomore</option>
                            <option value="Junior">Junior</option>
                            <option value="Senior">Senior</option>
                            <option value="Master">Master</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </p>
                    <?php
                        if(!$is_user){
                            echo '<div class="follow_email_wrapper">';
                                if($you_follow){
                                    echo '<button type="button" class="follow_prof_button following_prof_button">Following';
                                }else{
                                    echo '<button type="button" class="follow_prof_button">
                                    <i></i>Follow';
                                }

                             echo'   </button>
                                <button type="button" class="email_button"><i></i></button>
                            </div>';
                        }
                    ?>
                </div>

                <!--<h5>ABOUT</h5>
                <span class="profile-bio-container" id="profile_about">

                </span>-->
                <h3 id="school-section">SCHOOL</h3>

                <div class="info-block">
                    <!--	<div class="info-text-wrapper">-->
                    <input name="school_name" value="<?php echo $school->school_name ?>" title=<?php echo '"'.$school->school_name.'"'; ?> readonly>
                    <!--	</div>-->
                </div>
                <?php
                if($majors) {
                    echo '<h3 id="major-section">MAJOR</h3><i></i>';
                    foreach($majors as $major){
                        echo ' <div class="info-block">
                                    <input name="major_name" value="'.$major->name.'" title="'.$major->name.'" readonly><i></i>
                                </div>';

                    }
                }
                else {
                    echo '<h3 id="major-section"></h3><i></i>';
                }

                ?>

                <?php if($minors){
                    echo '<h3 id="minor-section">MINOR</h3><i></i>';
                    foreach($minors as $minor) {
                        echo '  <div class="info-block">
                                <input name="minor_name" value="' . $minor->name . '" title="'.$minor->name.'" readonly><i></i>
                            </div>';
                    }
                }
                else{
                    echo '<h3 id="minor-section"></h3><i></i>';
                }
                ?>
                <div class="add-interest-button">
                    <i></i>
                    <span>Add your research interests</span>
                </div>

                <div class="user-info" id="about-section">
                    <h3>ABOUT</h3>
                    <div class="info-block" id="about_textarea">
                        <textarea maxlength="140" readonly><?php echo $userProfile->user_bio;?></textarea>
                    </div>
                </div>
                <h3>INTERESTS AND SKILLS</h3>
                <div class="info-block" id="interest-section">
                    <?php
                    foreach($interests as $interest){
                        echo '<span class="interest-block">'.$interest->tag.'</span>'."\n";
                    }

                    ?>
                </div>
                <div class="info-block" id="interest-entry-field">
                    <input name="interest_name" value="" placeholder="+ Add an interest or skill" readonly>
                </div>
                <!--<span class="user-info-piece" style="margin-top: 20px;">
                    <a id="univ_link" style="text-decoration:none;">
                        <div class="small-icon department_icon" id="university_icon" style="background-image: url(src/);">
                        </div>
                        <div class="info-piece-text-wrapper">
                            <h4 class="info_field_0" id="profile_goes_to"></h4>
                        </div>
                    </a>
                </span>
                <span class="user-info-piece">
                    <a id="school_link" style="text-decoration:none;">
                        <div class="small-icon department_icon" id="school_icon" style="background-image: url(src/);">
                        </div>
                        <div class="info-piece-text-wrapper">
                            <p style="float:left;" id="user_task"></p>
                            <h4 class="info_field_0" id="profile_teaches_at" style="padding-left:2px;"></h4>
                        </div>
                    </a>
                </span>

                <span class="user-info-piece">
                    <a id="dept_link" style="text-decoration:none;">
                        <div class="small-icon department_icon" id="dept_icon" style="background-image: url(src/);">
                        </div>
                        <div class="info-piece-text-wrapper">
                            <h4 class="info_field_1" id="profile_dept_name"></h4>

                        </div>
                    </a>
                </span>

                <span class="user-info-piece plainText" id="display_designation">
                    <div class="small-icon department_icon" style="background-image: url(src/designationbadges.png);">
                    </div>
                    <div class="info-piece-text-wrapper">
                        <h4 class="info_field_1 plainText" id="profile_designation"></h4>

                    </div>
                </span>
                <span class="user-info-piece info-piece-oneline plainText">
                    <div class="small-icon email_icon" style="background-image: url(src/email.png);">
                    </div>
                    <div class="info-piece-text-wrapper">
                        <h4 class="info_field_0 plainText" id="profile_mail_id"></h4>
                    </div>
                </span>

                <span class="user-info-piece info-piece-oneline plainText" id="display_office_loc">
                    <div class="small-icon location_icon" style="background-image:url(src/location.png);">
                    </div>
                    <div class="info-piece-text-wrapper">
                        <h4 class="info_field_3 plainText" id="profile_office_location"></h4>
                    </div>
                </span>-->
                <br />
                <div class="user-events">
                </div>
            </div>
            <div class="user-groups">
                <div class="user-groups-tabs">
                    <div class="tab-active professor-tab tab-1">
                        <span class="prof-tab-1">Posts</span>
                        <span class="tab-count prof-tab-1" id="feedCount"></span>
                    </div>
                    <div class="tab-inactive professor-tab tab-2">
                        <span class="prof-tab-2">Courses</span>
                        <span class="tab-count prof-tab-2" id="courseCount"><?php //echo count($courses);?></span>
                    </div>
                    <div class="tab-inactive professor-tab tab-5">
                        <span class="prof-tab-5">Clubs</span>
                        <span class="tab-count prof-tab-5" id="clubsCount"><?php// echo count($clubs);?></span>
                    </div>
                    <div class="professor-tab tab-inactive tab-3">
                        <span class="prof-tab-3">Following</span>
                        <span class="tab-count prof-tab-3" id="followingCount"><?php// echo count($following);?></span>
                    </div>
                    <div class="professor-tab tab-inactive tab-4">
                        <span class="prof-tab-4">Followers</span>
                        <span class="tab-count prof-tab-4" id="followersCount"><?php// echo count($followers);?></span>
                    </div>
                    <b class="tab-indicator">
                        <em class="caret-transform">
                        </em>
                    </b>
                </div>
                <div class="user-tab-discussions-content">
                    <?php
                    /*

                                    if(isset($_GET['user_id'])){
                                        echo '<div id="profile_status_bar" style="margin-bottom: 10px; min-height: 40px; margin-left: 18px;">';
                                        include 'status_bar.php';
                                        echo '</div>';
                                        include 'feeds.php';
                                    } */
                        echo '<div id="profile_status_bar" style="margin-bottom: 10px; min-height: 40px; margin-left: 18px;">';
                        echo $this->renderPartial('/partial/status_bar',array('pg_src'=>'profile.php','target_type'=>'user','target_id'=>$user->user_id));
                        echo "</div>";
                        echo "<div class='group_feed_wrap'>";
                        Yii::app()->runController('partial/feed',array('user'=>$user));

                        echo "</div>";
                        ?>
                    </div>

                    <div class="user-tab-groups-content">
                        <?php foreach($courses as $classuser){
                                $class=$classuser->class;?>
                            <div class="user-groups-courses">
                                <div class="professor-group course-group">
                                    <a class="group-link">
                                        <div class="group-pic classlink" style="background: url(
                                        <?php if($class->pictureFile) {
                                            echo Yii::app()->getBaseUrl(true).$class->pictureFile->file_url;
                                        }else{
                                            echo Yii::app()->getBaseUrl(true).'/assets/default/class.png';
                                        } ?>
                                            ) no-repeat scroll center center / cover transparent">
                                        </div>
                                        <h3 id="<?php echo $class->class_id;?>" class="classlink"><?php echo $class->course->course_name;?></h3>
                                        <?php  if($is_user) {
                                            echo '<div class="user-class-visibility undefined">
                                <div class="container">
                                    <div class="current">';
                                            if($classuser->privacy == "public"){
                                                echo "Public";
                                            }else if($classuser->privacy == "only_me"){
                                                echo "Just Me";
                                            }else if($classuser->privacy == "following"){
                                                echo "People I Follow";
                                            }
                                            echo'<div class="drop"></div>
                                        <div class="hover"></div>
                                    </div>
                                    <div class="options">
                                        <div class="option">Public<div class="tick"></div>
                                        </div>
                                        <div class="option">People I Follow
                                            <div class="tick"></div>
                                        </div>
                                        <div class="option">Just Me
                                            <div class="tick"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                                        } ?>
                                    </a>
                                    <?php
                                    echo '<div class="admin-group-functions">
                                <div class="gfunction"><span>'.$class->section_id.'</span></div>
                                <div class="gfunction"><span>';
                                    foreach($class->schedules as $schedule){
                                        echo $schedule->day.'('.$schedule->start_time.' - '.$schedule->end_time.') ';
                                    }
                                    echo                            '</span></div>
                                <div class="gfunction"><span>'.(count($class->users)).' Students</span></div>
                            </div>';
                                    ?>

                                </div><br>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="user-tab-clubs-content">
                        <div class="user-class-visibility club">
                            <div class="container">
                                <div class="current">
                                    Edit Club Visibility
                                    <div class="drop"></div>
                                    <div class="hover"></div>
                                </div>
                                <div class="visibility_new">

                                    <select id="visibility_new">
                                        <!--                                    <div class="option" >Public<div class="tick"></div></div>-->
                                        <!--                                    <div class="option" >People I Follow<div class="tick"></div></div>-->
                                        <!--                                    <div class="option">Just Me<div class="tick"></div></div>-->
                                        <option value="public" class="option" <?php// echo ($default_privacy == "public")?"selected":"" ?>>Public<div class="tick"></div></option>
                                        <option value="following" class="option" <?php //echo ($default_privacy =="following")?"selected":"" ?>>People I Follow<div class="tick"></div></option>
                                        <option value="only_me" class="option" <?php// echo ($default_privacy =="only_me")?"selected":"" ?>>Just Me<div class="tick"></div></option>
                                    </select>
                                </div>
                            </div>
                            <div class="label">Who Can See My Clubs:</div>
                        </div>

                        <?php foreach($clubs as $club){?>
                            <div class="professor-group course-group">
                                <a class="group-link">
                                    <div class="group-pic group-link"style="background: url(
                                    <?php if($club->pictureFile) {
                                        echo Yii::app()->getBaseUrl(true).$club->pictureFile->file_url;
                                    }else{
                                        echo Yii::app()->getBaseUrl(true).'/assets/default/club.png';
                                    } ?>
                                        ) no-repeat scroll center center / cover transparent"></div>
                                    <h3 class="group-link"><?php echo $club->group_name;?></h3>
                                    <?php  if($is_user) {
                                        echo '<div class="user-class-visibility club"><div class="container">
                            <div class="current">Public<div class="drop"></div>
                                <div class="hover"></div></div><div class="options">
                                    <div class="option">Public<div class="tick"></div></div>
                                    <div class="option">People I Follow<div class="tick"></div></div>
                                    <div class="option">Just Me<div class="tick"></div></div>
                                </div>
                            </div>
                        </div>';
                                    }?>
                                </a>
                                <div class="admin-group-functions">
                                    <div class="gfunction">
                                        <span><?php echo $club->group_desc;?></span>
                                    </div>

                                    <div class="gfunction"><span><?php echo count($club->users); ?> members</span></div>

                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="user-tab-following-content">
                        <?php
                        if (count($following)  > 0) {

                            foreach ($following as $followed) {
                                echo '
            <div class="member" id="' . $followed->user_id . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">';

                                if($followed->picture_file_id){
                                    echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                        $followed->pictureFile->file_url.')"></div>';
                                }else{
                                    echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                        '/assets/default/user.png)"></div>';
                                }

                                echo             '  <div class="member-bio">
                        <span>' . $followed->user_bio . '</span> <a href="profile.php?user_id=' . $followed->user_id . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
                                if ($followed->user_type == 's') {
                                    echo '
        <h3 class="person-title">
                <a href="../profile/' . $followed->user_id . ' "><strong class="search_unit">' . $followed->firstname . ' ' . $followed->lastname . ' </strong></a>
                <span><a class="search_unit">' . $followed->school->school_name . '</a></span></h3>';
                                } else {
                                    echo '
                <h3 class="person-title">
                <a href="../profile/' . $followed->user_id . ' "><strong class="search_unit">Professor ' . $followed->lastname . '</strong></a>
                <span><a class="search_unit">' . $followed->school->school_name . '</a></span></h3>';
                                }
                                if ($followed->user_id == $user->user_id) {

                                    echo '
                                </div>
                            </div>
                      </div>';
                                    continue;
                                }
//        echo $user_id;
//        echo $row['user_id'];
                                /*if (isFollowing($user_id, $row['user_id'])) {
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
                                } else { */
                                if ($user->isFollowing($followed)) {
                                    echo '
                                        <div class="follow-btn">
                                          <a class="follow tab_followed ready_to_unfollow unfollow">Following</a>
                                        </div>
                                      </div>
                                    </div>
                              </div>';
                                } else {
                                    echo '
                    <div class="follow-btn">
                      <a class="follow">Follow</a>
                    </div>';

                                    echo '    </div>
                            </div>
                        </div>';
                                }
                            }
                        }



                        ?>
                    </div>
                    <div class="user-tab-followers-content">
                        <?php
                        if (count($followers)  > 0) {
                            foreach ($followers as $follower) {
                                echo '

            <div class="member" id="' . $follower->user_id . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">';

                                if($follower->picture_file_id){
                                    echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                        $follower->pictureFile->file_url.')"></div>';
                                }else{
                                    echo '<div class="picwrap" style="background-image:url('.Yii::app()->getBaseUrl(true).
                                        '/assets/default/user.png)"></div>';
                                }


                                echo             '  <div class="member-bio">
                        <span>' . $follower->user_bio . '</span> <a href="profile.php?user_id=' . $follower->user_id . '"><strong>View Profile</strong></a>
                      </div>
                    </div>';
                                if ($follower->user_type == 's') {
                                    echo '
        <h3 class="person-title">
                <a href="../profile/' . $follower->user_id . ' "><strong class="search_unit">' . $follower->firstname . ' ' . $follower->lastname . ' </strong></a>
                <span><a class="search_unit">' . $follower->school->school_name . '</a></span></h3>';
                                } else {
                                    echo '
                <h3 class="person-title">
                <a href="../profile/' . $follower->user_id . ' "><strong class="search_unit">Professor ' . $follower->lastname . '</strong></a>
                <span><a class="search_unit">' . $follower->school->school_name . '</a></span></h3>';
                                }
                                if ($follower->user_id == $user->user_id) {

                                    echo '
                                </div>
                            </div>
                      </div>';
                                    continue;
                                }

                                if ($user->isFollowing($follower)) {
                                    echo '
                                    <div class="follow-btn">
                                      <a class="follow tab_followed ready_to_unfollow unfollow">Following</a>
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

                        ?>
                    </div>
                </div>
            </div>
        </div>
		</div>
    </body>
</html>
<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/filepicker.js"></script>
<script>
        init = function(appID,fileID) {
        s = new gapi.drive.share.ShareClient(appID);
        s.setItemIds([fileID]);
    }
    
        function initDrivePicker() {
            var picker = new FilePicker({
                apiKey: 'AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4',
                clientId: '648831685142-djuu0p1kanvmn751rnj189avhde81ckt',
                buttonEl: document.getElementById('chooseFromDrive'),
                onSelect: function(file) {
                    console.log(file);
                    ////////alert(file);
                    $(".googleuploadinfoarchive_fbar").val(file);
                    var nm= file.split("||")[3].trim();
                    var shortnm=nm;
                    if(shortnm.length>=18){
                                    shortnm= shortnm.substring(0,15)+"...";
                                }
    
                    $(".googleuploadinfoarchive_fbar").parents('.clickable_showcase_step2').find(".driveafile").find(".cf_prompt").attr("title",nm);
                    $(".googleuploadinfoarchive_fbar").parents('.clickable_showcase_step2').find(".driveafile").find(".cf_prompt").text(shortnm);
                    ////////alert($(".googleuploadinfoarchive_fbar").val());
                    //gapi.load('drive-share', init('648831685142',file));
                    gapi.client.request({
                        'path': '/drive/v2/files/'+file,
                        'method': 'GET',
                        callback: function (responsejs, responsetxt){
                        var downloadUrl = responsejs.downloadUrl;
       }
                    })
                }
            });	
        }
    
    
    
    
</script>
<script type="text/javascript">
    $ = $.noConflict();
    jQuery(document).ready(function(){
            window.onload = function(){
                $.event.trigger("content_loaded");
            };
            /*setTimeout(function(){
            var interests = $("#profile_interests").text();
            var interestArray = interests.split(",");
            var interestHTMLSTRING;
            for(var i = 0; i < interestArray.length; i++){
                if(i===0){
                    interestHTMLSTRING = ( "<p class='single_interest'>" + interestArray[i] + "</p>");
                }
                else {
                    interestHTMLSTRING = (interestHTMLSTRING + "<p class='single_interest'>" + interestArray[i] + "</p>");
                }
            }
    
            $("#profile_interests").html(interestHTMLSTRING);
            */
    
    
    
        //}, 1000);
    
    setTimeout(function(){
                var feedCount = $("#feedCount").text();
                /*var courseCount = $("#courseCount").text();
                var clubsCount = $("#clubsCount").text();
                var followingCount = $("#followingCount").text();
                var followersCount = $("#followersCount").text();*/
    
                if(feedCount === ""){
                    $(".prof-tab-1").css({
                        "position" : "relative",
                        "top" : "10"});
                }
                /*if(courseCount === ""){
                    $(".prof-tab-2").css({
                        "position" : "relative",
                        "top" : "13"});
                }
                if(clubsCount === ""){
                    $(".prof-tab-3").css({
                        "position" : "relative",
                        "top" : "13"});
                }
                if(clubsFollowing === ""){
                    $(".prof-tab-4").css({
                        "position" : "relative",
                        "top" : "13"});
                }
                if(clubsFollowers === ""){
                    $(".prof-tab-5").css({
                        "position" : "relative",
                        "top" : "13"});
                }*/
        },2000);			
    
    
        var array = ["#profile_office_location", "#profile_mail_id", "#profile_designation", "#profile_dept_name", "#profile_teaches_at", "#profile_goes_to"];
        setTimeout(function(){
            for(var i = 0; i < array.length; i++){
                var location = $(array[i]).text();
                if(location === "Unavailable" ){
                    $(array[i]).parent().parent().addClass("profile_unavaliable");
                }
    
            }
            var about = $("#profile_about").text();
    
            if(about === "Unavailable"){
                    $("#profile_about").addClass("profile_unavaliable");
            }
            var interests = $("#profile_interests").text();
            if(interests === ""){
                    $("#profile_interests").addClass("profile_unavaliable");
                    $(".secondh5").addClass("profile_unavaliable");
            }
        }, 1000);
    
    
    
    
    
    
    });
    
</script>




<?php
    
    // echo '<script type="text/javascript">
    // 		        // 24hr
    // 		        $("#24hr").timeAutocomplete({
    // 		            increment: 15,
    // 		            formatter: "ampm",
    // 		            value: "00:00:00"
    // 		        });
    // 		    </script>';
            // }
            // else if($user_type == 's'){
            // 	echo "It's a student";
            // }
        //}
    //    else die("Aw Snap! No such user exists....");
?>

