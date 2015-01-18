<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';


</script>
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile_fbar.css" type = "text/css">

<div id = "fbar_holder" class = "fbar_homepage" data-post_type = "">
<!--<div class = "dark_overlay" id = "dark_overlay_fbar"></div>-->

<form action="/post/create" class="dropzone fbar_file_form dz-clickable files_upload_bigbox" id="fbar_file_form" style="display: none;">
    <input type='file' class='step_6_upload' style='display:none;'>

</form>

<div id = "profile_fbar_new">
<section id = "profile_fbar_buttons">
    <div class = "fbar_buttonwrapper" id = "profile_fbar_button_discuss" data-post_button_type = "discuss">
        <i class = "fbar_button_icon" id = "profile_fbar_icon_discuss">
        </i>
        <p class = "fbar_button_text post_button_text">Post</p>
    </div>
    <div class = "fbar_buttonwrapper" id = "profile_fbar_button_notes" data-post_button_type = "notes">
        <i class = "fbar_button_icon" id = "profile_fbar_icon_notes">
        </i>
        <!-- if user is admin, change text below "notes" to "materials" -->
        <p class = "fbar_button_text notes_button_text">Notes</p>
    </div>
    <div class = "fbar_buttonwrapper" id = "profile_fbar_button_question" data-post_button_type = "question">
        <i class = "fbar_button_icon" id = "profile_fbar_icon_question">
        </i>
        <p class = "fbar_button_text question_button_text">Question</p>
    </div>
</section>
<section id = "profile_fbar_postbox">
    <form id = "profile_fbar_form">
        <div class = "form_wrapper">
            <header id = "profile_fbar_header" class = "fbar_contents_fix">
                <ul class = "menu_audience">
                    <li>
                        <a><div id = "profile_audience_select"><span>To <span class = "selected_audience">Followers</span></span><em class = "down_arrow"></em></div></a>
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
                <div id = "profile_discussion_form_content" class = "post_type_header active post_type_discussion"><span>Post</span></div>
                <div id = "profile_notes_form_content" class = "post_type_header active post_type_notes"><span>Notes/Files</span></div>
                <div id = "profile_question_form_content" class = "question_type_button active regular_question" id = "hide_both_question_types" data-question_post_type = "question">Regular Question</div><div id = "question_form_content" class = "question_type_button multiple_choice_btn" data-question_post_type = "multiple_choice"><em></em>Multiple Choice</div><div id = "question_form_content" data-question_post_type = "true_false" class = "question_type_button true_or_false_btn"><em></em>True or False</div>
            </header>

            <section id = "profile_discussion_form" class = "post_form_template fbar_contents_fix">
                <div class = "discussion_textarea input_wrap">
                    <textarea class = "autofocus post_text_area" placeholder = "Start a discussion"></textarea>
                </div>
            </section>

            <section id = "profile_notes_form" class = "post_form_template fbar_contents_fix">
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

            <section id = "profile_question_form" class = "post_form_template fbar_contents_fix">
                <div class = "input_wrap">
                    <input placeholder = "What is your question?" id = "profile_post_title" class = "autofocus" type = "text" name = "question_title">
                </div>
                <div class = "question_textarea input_wrap">
                    <textarea class = "post_text_area" placeholder = "Write question details"></textarea>
                </div>
                <section>
                    <div class="multiple_choice">
                        <div class="question_choice_line multiple_line">
                            <div class="fixed_choice_prefix">
                                <div class="letter_choice"><span>A</span></div>
                                <div class="add_choice"><span>+</span></div>
                            </div>
                            <input class="multiple_choice_answer" id="choice_a" placeholder="Add choice A...">
                            <div class="answer_check">
                                <input id="profile_check_A" type="radio" value="false">
                                <label></label>
                                <span>Correct Answer</span>
                            </div>
                        </div>
                        <div class="question_choice_line multiple_line">
                            <div class="fixed_choice_prefix">
                                <div class="letter_choice"><span>B</span></div>
                                <div class="add_choice"><span>+</span></div>
                            </div>
                            <input class="multiple_choice_answer"  id="choice_b" placeholder="Add choice B...">
                            <div class="answer_check">
                                <input id="profile_check_B" type="radio" value="false">
                                <label></label>
                                <span>Correct Answer</span>
                            </div>
                        </div>
                        <div class="question_choice_line multiple_line">
                            <div class="fixed_choice_prefix">
                                <div class="letter_choice"><span>C</span></div>
                                <div class="add_choice"><span>+</span></div>
                            </div>
                            <input class="multiple_choice_answer"  id="profile_choice_c"placeholder="Add choice C...(optional)">
                            <div class="answer_check">
                                <input id="check_C" type="radio" value="false">
                                <label></label>
                                <span>Correct Answer</span>
                            </div>
                        </div>
                        <div class="question_choice_line multiple_line">
                            <div class="fixed_choice_prefix">
                                <div class="letter_choice"><span>D</span></div>
                                <div class="add_choice"><span>+</span></div>
                            </div>
                            <input class="multiple_choice_answer" id="choice_d"placeholder="Add choice D...(optional)">
                            <div class="answer_check">
                                <input id="profile_check_D" type="radio" value="false">
                                <label></label>
                                <span>Correct Answer</span>
                            </div>
                        </div>
                    </div>
                    <div class="true_false">
                        <div class="question_choice_line tf_line">
                            <span>True</span>
                            <div class="answer_check">
                                <input id="profile_check_true" type="radio" value="true">
                                <label></label>
                                <span>Correct Answer</span>
                            </div>
                        </div>
                        <div class="question_choice_line tf_line">
                            <span>False</span>
                            <div class="answer_check">
                                <input id="profile_check_false" type="radio" value="false">
                                <label></label>
                                <span>Correct Answer</span>
                            </div>
                        </div>
                    </div>
                </section>

            </section>

            <footer id = "profile_profile_fbar_footer" class = "fbar_contents_fix">
                <!--<div id = "post_anonymously"><input type='checkbox' value='0' class='post_anon_val'><span class = 'comment_anon_text'>Post Anonymously</span></div>-->
                <div id = "profile_profile_post_privacy" class = "help_div_shower">
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
                    <div id = "profile_privacy_tooltip" class="help-div fbar_helpers">
                        <div class="help-box">Edit privacy</div>
                        <div class="help-wedge">
                        </div>
                    </div>
                </div>
                <div id = "profile_post_attachments" class = "notes_form_hide_content help_div_shower">


                    <span></span>
                    <div class="help-div fbar_helpers">
                        <div class="help-box">Attach files/notes</div>
                        <div class="help-wedge">
                        </div>
                    </div>
                </div>

                <div style = "-webkit-user-select: none;" class = "post_btn fresh_green_button" id = "profile_post_btn">
                    Post
                </div>
                <div style = "-webkit-user-select: none;" class = "cancel_btn" id = "profile_cancel_btn">
                    Cancel
                </div>
            </footer>
        </div>
    </form>
</section>
</div>