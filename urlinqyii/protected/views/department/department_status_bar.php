<?php

$pg_src = ""; //substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1);
$target_type = "profile";
$target_id = 1;

/*
if($pg_src == "profile.php" && isset($_GET['user_id'])) {
    $target_type = "profile";
    $target_id = $_GET['user_id'];
}
elseif($pg_src == "class.php" && isset($_GET['class_id'])) {
    $target_type = "class";
    $target_id = $_GET['class_id'];
}
elseif($pg_src == "courses.php" && isset($_GET['course_id'])) {
    $target_type = "course";
    $target_id = $_GET['course_id'];
}
elseif($pg_src == "clubs.php" && isset($_GET['group_id'])) {
    $target_type = "group";
    $target_id = $_GET['group_id'];
}
elseif($pg_src == "department.php" && isset($_GET['dept_id'])) {
    $target_type = "department";
    $target_id = $_GET['dept_id'];
}
elseif($pg_src == "school.php" && isset($_GET['univ_id'])) {
    $target_type = "school";
    $target_id = $_GET['univ_id'];
}
else{
    $target_type = NULL;
    $target_id = NULL;
}
*/
?>

<!DOCTYPE html>
<html>
<head>


<script src="https://www.google.com/jsapi?key='AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4'"></script>
<script src="https://apis.google.com/js/client.js?onload=initPicker"></script>

<script>
$(document).ready(function() {



});

</script>
</head>
<body>

<div id = "fbar" class = "fb">
<div class='fbar-head'>
    <div class = "post fani fani-hover">
        <div class = "fbtn fbtn-post">
            <?php
            $pg_src = substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1);
            if($pg_src == "home.php" || $pg_src=="profile.php")	echo "Post Status";
            else echo "Start Discussion";
            ?>
        </div>
    </div>
    <div class = "event fani fani-hover">
        <div class = "fbtn fbtn-upload">
            Post Event
        </div>
    </div>
    <div class = "opp fani fani-hover">
        <div class = "fbtn fbtn-opp">
            Post Opportunity
        </div>
    </div>
</div>

<div class = "post-sec">
<div class = "wedge1a">
</div>

<div class = "wedge2a">
</div>

<div class = "wedge3a">
</div>

<div class = "post_state fbar_anchor">
    <div class ="textwrap">
        <textarea name = "message" class = "postTxtarea autogrowth_textarea"placeholder = "What have you read lately?" ></textarea>
    </div>
    <div class = "btmfbar controlpad">
        <div class='fbar_errorprompt'></div>
        <div class = "lfloat-mods">
            <div class = "lfloat-attach">
                <a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
                </a>
            </div>
            <div class="upload_textprompt"></div>

            <form class="attach_form">
                <input type="file" name='file' class="upload_hack">
                <button class="upload_button">Upload</button>
            </form>

        </div>

        <div class = "lfloat-anon">
            <div class='check_wrap fbarcheck_wrap'>
                <input type='checkbox' id='flat_0' class='flat7c'/>
                <label for='flat7' class='flat7b_fbar'>
                    <span class='move'></span>
                </label>
                <span class = 'comment_anon_text'>Post Anonymously</span>
                <input type='hidden' value='0' class='post_anon_val'>
            </div>
            <div class = "post-btn btn-1">Post</div>
            <div class='select_wrap'>
                <input type='hidden' class='visi_val' value='campus'>
                <div class='posttool-select privacy_canedit'>

												<span class='field_fbar'>
													<img class='vstt_icon' src='img/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
                                                    <div class = 'tag-wedge'></div>
                                                    <div class = 'tag-box'>
                                                        <span>Visible to campus</span>
                                                    </div>
                                                </div>
												</span>
                    <div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections'></div>My Connections</div>
													</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class = "upload_state fbar_anchor">
    <div class ="textwrap">
        <form id="event_form">
            <textarea name = "event_name" class = "uploadTxtarea thin_input bottom_border" placeholder = "Event Name" ></textarea>
            <!--
            <textarea id="event_location" name = "event_loc" class = "uploadTxtarea thin_input bottom_border" placeholder = "Event Location" ></textarea>
            -->
            <textarea id="location" name="event_loc" class="uploadTxtarea thin_input bottom_border" placeholder="Event Location"></textarea>
            <div class="bottom_border date_line event_time">
                <p class="time_label">Event Date & Time</p>
                <input class = "set_date" name="event_date" id="add_event_date" readonly />
                <input id="set_time_24hr"  class = "set_time2" name="event_time" />
            </div>
            <textarea name = "event_desc" class = "uploadTxtarea thin_input" placeholder = "Write a brief description of the event..." ></textarea>
        </form>
    </div>
    <div class = "uploadMode">
        <div class = "localUpload">
            <div class = "upl_wrap">
                <form>
                    <div class = "upl_head">
                        Photo From Your Computer
                    </div>
                    <div class = "upl_btn">
                        <a class = "upl_anc">
                            <span class = "uplbtnText">Choose File</span>
                            <div class = "_upl">
                                <input type = "file" class = "_uplI" title = "Choose a file to upload" name = "file">
                            </div>
                        </a>
                    </div>
                    <div class = "uplName">
                        No file chosen
                    </div>
                </form>
            </div>
        </div>
        <div class = "webUpload">
            <div class = "upl_wrap">
                <form>
                    <div class = "upl_head">
                        Photo From Web
                    </div>
                    <input class="fbar_input" type="url" name="event_photo_url" placeholder="url">
                </form>
            </div>
        </div>
    </div>

    <div class = "btmfbar2 controlpad">
        <div class='fbar_errorprompt'></div>
        <div class = "lfloat-mods">
            <div class = "lfloat-attach">
                <a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
                </a>
            </div>
            <div class="upload_textprompt"></div>
            <form class="attach_form">
                <input type="file" name='file' class="upload_hack">
                <button class="upload_button">Upload</button>
            </form>

        </div>
        <div class = "lfloat-anon">
            <div class = "post-btn btn-2">Post</div>

            <div class='select_wrap'>
                <input type='hidden' class='visi_val' value='campus'/>
                <div class='posttool-select privacy_canedit'>

												<span class='field_fbar'>
													<img class='vstt_icon' src='img/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
                                                    <div class = 'tag-wedge'></div>
                                                    <div class = 'tag-box'>
                                                        <span>Visible to campus</span>
                                                    </div>
                                                </div>
												</span>
                    <div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections'></div>My Connections</div>
													</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class = "ask_state fbar_anchor">
    <div class ="textwrap">
        <form id="opp_form">
            <textarea name = "opp_type" class = "uploadTxtarea thin_input bottom_border" placeholder = "Type of opportunity?" ></textarea>
            <textarea name = "event_desc" class = "uploadTxtarea thin_input bottom_border" placeholder = "Write a brief description of the opportunity..." ></textarea>
            <div class="date_line opp_time">
                <p class="time_label">Deadline for Application</p>
                <input class = "set_date" name="event_date" id="add_event_date" readonly />
                <input id="set_time_24hr"  class = "set_time2" name="opp_time" />
            </div>

        </form>
    </div>
    <div class = "uploadMode" id="uploadOpp">
        <div class = "localUpload">
            <div class = "upl_wrap">
                <form>
                    <div class = "upl_head">
                        Upload Application
                    </div>
                    <div class = "upl_btn">
                        <a class = "upl_anc">
                            <span class = "uplbtnText">Choose File</span>
                            <div class = "_upl">
                                <input type = "file" class = "_uplI" title = "Choose a file to upload" name = "file">
                            </div>
                        </a>
                    </div>
                    <div class = "uplName">
                        No file chosen
                    </div>
                </form>
            </div>
        </div>
        <div class = "webUpload">
            <div class = "upl_wrap">
                <form>
                    <div class = "upl_head">
                        Submission Link/Email
                    </div>
                    <input class="fbar_input" type="url" name="event_photo_url" placeholder="url/email">
                </form>
            </div>
        </div>
    </div>

    <div class = "btmfbar3 controlpad" id="btmOpp">
        <div class='fbar_errorprompt'></div>
        <div class = "lfloat-mods">
            <div class = "lfloat-attach">
                <a class = "attach-mod" href = "#" title = "Attach a file to your post">
											<span class = "attach-icon">
											</span>
                </a>
            </div>
            <div class="upload_textprompt"></div>
            <form class="attach_form">
                <input type="file" name='file' class="upload_hack">
                <button class="upload_button">Upload</button>
            </form>

        </div>
        <div class = "lfloat-anon">
            <div class = "post-btn btn-3">Post</div>

            <div class='select_wrap'>
                <input type='hidden' class='visi_val' value='campus'/>
                <div class='posttool-select privacy_canedit'>

												<span class='field_fbar'>
													<img class='vstt_icon' src='img/privacy_icons/privacy_status/campus_status.png'>
												<div class='vstt_wedgeDown'></div>
												<div class = 'card-tag'>
                                                    <div class = 'tag-wedge'></div>
                                                    <div class = 'tag-box'>
                                                        <span>Visible to campus</span>
                                                    </div>
                                                </div>
												</span>
                    <div class = 'visi_functions_box'>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_campus'></div>Campus</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_student'></div>Only Students</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
														<div class = 'visi_functions_option_fbar'><div class='visi_icon i_faculty'></div>Only Faculty</div>
													<hr class = 'post_options_hr'>
													</span>
													<span>
													<div class = 'visi_functions_option_fbar'><div class='visi_icon i_connections'></div>My Connections</div>
													</span>
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

