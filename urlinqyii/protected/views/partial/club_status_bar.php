
<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';


</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css"> 
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/location_input/location_input.js"></script>
<!--BELOW ARE SCRIPTS AND LINKS FOR DROPDOWN MENU API -->
<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropit.js'></script>
<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/autocomplete.js'></script>
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/dropit.css" type="text/css" />
<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/jquery.autosize.js'></script>


<div id = "fbar_holder" class = "fbar_homepage" data-post_type = "">
    <!--<div class = "dark_overlay" id = "dark_overlay_fbar"></div>-->
    <div id = "fbar_new">
        <section id = "fbar_buttons">
            <div class = "fbar_buttonwrapper" id = "fbar_button_discuss" data-post_button_type = "discuss">
                <i class = "fbar_button_icon" id = "fbar_icon_discuss">
                </i>
                <p class = "fbar_button_text post_button_text">Post</p>
            </div>
            <div class = "fbar_buttonwrapper" id = "fbar_button_notes" data-post_button_type = "notes">
                <i class = "fbar_button_icon" id = "fbar_icon_notes">
                </i>
                <p class = "fbar_button_text files_button_text">Files</p>
            </div>
            <div class = "fbar_buttonwrapper" id = "fbar_button_event" data-post_button_type = "event">
                <i class = "fbar_button_icon" id = "fbar_icon_event">
                </i>
                <p class = "fbar_button_text events_button_text">Event</p>
            </div>
        </section>
        <section id = "fbar_postbox">
            <form id = "fbar_form">
                <div class = "form_wrapper">
                    <header id = "fbar_header" class = "fbar_contents_fix">
                        <ul class = "menu_audience">
                            <li>
                                <a><div id = "audience_select"><span>To <span class = "selected_audience">Followers</span></span><em class = "down_arrow"></em></div></a>
                                <ul>
                                    <li class = "audience_name">
                                        <a>Faculty</a>
                                    </li>
                                    <li class = "audience_name">
                                        <a>Class 1</a>
                                    </li>
                                    <li class = "audience_name">
                                        <a>Class 2</a>
                                    </li>
                                    <li class = "audience_name">
                                        <a>Class 3</a>
                                    </li>
                                    <li class = "audience_name">
                                        <a>Club 1</a>
                                    </li>
                                    <li class = "audience_name">
                                        <a>Club 2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <div id = "discussion_form_content" class = "post_type_header active post_type_discussion"><span>Post</span></div>  
                        <div id = "event_form_content" class = "post_type_header active post_type_events"><span>Event</span></div> 
                        <div id = "notes_form_content" class = "post_type_header active post_type_notes"><span>Notes/Files</span></div>                 
                        <div id = "question_form_content" class = "question_type_button active regular_question" id = "hide_both_question_types" data-question_post_type = "hide_both">Regular Question</div><div id = "question_form_content" class = "question_type_button multiple_choice_btn" data-question_post_type = "multiple_choice"><em></em>Multiple Choice</div><div id = "question_form_content" data-question_post_type = "true_false" class = "question_type_button true_or_false_btn"><em></em>True or False</div>
                    </header>

                    <section id = "discussion_form" class = "post_form_template fbar_contents_fix">
                        <div class = "discussion_textarea input_wrap">
                            <textarea class = "autofocus post_text_area" placeholder = "Start a discussion"></textarea>
                        </div>
                    </section>

                    <section id = "notes_form" class = "post_form_template fbar_contents_fix">
                        <div class = "upload_file_wrap">

                            <div class = "upload_half half_1">
                                <div><p class = "upload_hint">From your computer</p></div>
                                <div><div class = "upload_button">Choose File</div><p class = "drag_hint">or drag &#x26; drop</p></div>
                            </div>

                            <div class = "upload_half half_2">
                                <div><em class = "google_drive"></em><p class = "upload_hint">From your Google Drive</p></div>
                                <div><div class = "upload_button upload_button_alone">Choose File</div></div>
                            </div>

                        </div>  

                        <div class = "file_textarea input_wrap">
                            <textarea class = "autofocus post_text_area" placeholder = "Write file details"></textarea>
                        </div>
                    </section>

                    <section id = "event_form" class = "post_form_template fbar_contents_fix">
                        
                        <div class = "input_wrap">
                            <input placeholder = "Event title" id = "event_title" class = "autofocus" type = "text" name = "event_title">
                        </div>
                        <div class = "input_wrap event_when">
                            <input placeholder = "Start date" id = "event_start_date" class = "fbar_date_time" type = "text" name = "event_start_date"><input placeholder = "Start time" id = "start_time" class = "fbar_date_time fbar_time_input" type = "text" name = "event_start_time"><em class = "event_time_to_arrow"></em><input placeholder = "End time" id = "event_end_time" class = "fbar_date_time fbar_time_input" type = "text" name = "event_end_time"><input placeholder = "End date" id = "event_end_date" class = "fbar_date_time" type = "text" name = "event_end_date">
                        </div>
                        <div class = "input_wrap" style = "position:relative;">
                            <label for = "event_location">Where:</label><input placeholder = "Enter a location" id = "event_location" class = "location_input autocomplete_location fbar_date_time" type = "text" name = "event_title"><span class = "where_icon"></span>
                        </div>

                        <div class = "event_textarea input_wrap">
                            <textarea class = "post_text_area" placeholder = "Write event description"></textarea>
                        </div>

                        <div class = "upload_file_wrap photo_flier_upload_box">

                            <div class = "upload_half half_1">
                                <div><p class = "upload_hint">Flier/photo from your computer</p></div>
                                <div><div class = "upload_button">Choose File</div><p class = "drag_hint">or drag &#x26; drop</p></div>
                            </div>

                            <div class = "upload_half half_2">
                                <div><p class = "upload_hint">Photo from web</p></div>
                                <div><input placeholder = "url" id = "event_photo_url" class = "fbar_date_time" type = "text" name = "event_photo_url"><div class = "www_prefix">www</div></div>
                            </div>

                        </div>                         
                    </section>

                    <footer id = "fbar_footer" class = "fbar_contents_fix">
                        <!--<div id = "post_anonymously"><input type='checkbox' value='0' class='post_anon_val'><span class = 'comment_anon_text'>Post Anonymously</span></div>-->
                        <div id = "post_privacy" class = "help_div_shower">
                            <ul class = "menu privacy_menu">
                                <li class = "no_relative">
                                    <a class = "privacy_dropdown_link"></a>
                                    <ul class = "privacy_dropdown">
                                        <li class = "privacy_list" style = "position:relative; border-bottom: 1px solid #fff;"><a>Members</a><span></span></li>
                                        <li class = "privacy_list" style = "position:relative; border-bottom: 1px solid #fff;"><a>Admin</a><span></span></li>
                                        <li class = "privacy_list" style = "position:relative;"><a>Members</a><span></span></li>
                                        <div class="help-wedge">
                                        </div>
                                    </ul>

                                    <input type='hidden' name = "post_privacy">
                                    <span></span>
                                </li>

                            </ul>
                            <div id = "privacy_tooltip" class="help-div fbar_helpers">
                                <div class="help-box">Edit privacy</div>
                                <div class="help-wedge">
                                </div>
                            </div>
                        </div>
                        <div id = "post_attachments" class = "notes_form_hide_content event_form_hide_content help_div_shower">
                            <span></span>
                            <div class="help-div fbar_helpers">
                                <div class="help-box">Attach files/notes</div>
                                <div class="help-wedge">
                                </div>
                            </div>
                        </div>
                        <div id = "post_photos" style = "display:none" class = "event_form_content help_div_shower">
                            <span></span>
                            <div class="help-div fbar_helpers">
                                <div class="help-box">Add photo/flier</div>
                                <div class="help-wedge">
                                </div>
                            </div>
                        </div>

                        <div style = "-webkit-user-select: none;" class = "post_btn fresh_green_button" id = "post_btn">
                            Post
                        </div>
                        <div style = "-webkit-user-select: none;" class = "cancel_btn" id = "cancel_btn">
                            Cancel
                        </div>
                    </footer>
                </div>
            </form>
        </section>
    </div>
</div> 



