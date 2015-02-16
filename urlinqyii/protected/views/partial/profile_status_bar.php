
<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';
</script>


<div id = "fbar_holder" class = "fbar_homepage" data-post_type = "">
<!--<div class = "dark_overlay" id = "dark_overlay_fbar"></div>-->


<!--  This is the hidden form that is submitting when there are files. Should be in every status bar page  -->
<form action="/post/create" class="dropzone fbar_file_form dz-clickable files_upload_bigbox" id="profile_fbar_file_form" style="display: none;">
    <input type='file' class='post_file_upload_input' style='display:none;'>

</form>

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
            <!-- if user is admin, change text below "notes" to "materials" -->
            <p class = "fbar_button_text notes_button_text">Notes</p>
        </div>
        <div class = "fbar_buttonwrapper" id = "fbar_button_question" data-post_button_type = "question">
            <i class = "fbar_button_icon" id = "fbar_icon_question">
            </i>
            <p class = "fbar_button_text question_button_text">Question</p>
        </div>
    </section>
    <section id = "fbar_postbox">
        <form id = "fbar_form">
            <div class = "form_wrapper">
                <header id = "fbar_header" class = "fbar_contents_fix">
                    <ul class = "menu_audience">
                        <li>
                            <a><div id = "audience_select" data-audience="followers" data-audience_id=""><span>To <span class = "selected_audience">Followers</span></span><em class = "down_arrow"></em></div></a>
                            <ul id="audience_select_list">
                                <li class = "audience_name" data-audience="followers" data-audience_id="">
                                    <a>Followers</a>
                                </li>


                            </ul>
                        </li>
                    </ul>
                    <div id = "discussion_form_content" class = "post_type_header active post_type_discussion"><span>Post</span></div>
                    <div id = "notes_form_content" class = "post_type_header active post_type_notes"><span>Notes/Files</span></div>
                    <div id = "question_form_content" class = "question_type_button active regular_question" id = "hide_both_question_types" data-question_post_type = "question">Regular Question</div><div id = "question_form_content" class = "question_type_button multiple_choice_btn" data-question_post_type = "multiple_choice"><em></em>Multiple Choice</div><div id = "question_form_content" data-question_post_type = "true_false" class = "question_type_button true_or_false_btn"><em></em>True or False</div>
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

                <section id = "question_form" class = "post_form_template fbar_contents_fix">
                    <div class = "input_wrap">
                        <input placeholder = "What is your question?" id = "post_title" class = "autofocus" type = "text" name = "question_title">
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
                                    <input id="check_A" type="radio" value="false">
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
                                    <input id="check_B" type="radio" value="false">
                                    <label></label>
                                    <span>Correct Answer</span>
                                </div>
                            </div>
                            <div class="question_choice_line multiple_line">
                                <div class="fixed_choice_prefix">
                                    <div class="letter_choice"><span>C</span></div>
                                    <div class="add_choice"><span>+</span></div>
                                </div>
                                <input class="multiple_choice_answer"  id="choice_c"placeholder="Add choice C...(optional)">
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
                                    <input id="check_D" type="radio" value="false">
                                    <label></label>
                                    <span>Correct Answer</span>
                                </div>
                            </div>
                        </div>
                        <div class="true_false">
                            <div class="question_choice_line tf_line">
                                <span>True</span>
                                <div class="answer_check">
                                    <input id="check_true" type="radio" value="true">
                                    <label></label>
                                    <span>Correct Answer</span>
                                </div>
                            </div>
                            <div class="question_choice_line tf_line">
                                <span>False</span>
                                <div class="answer_check">
                                    <input id="check_false" type="radio" value="false">
                                    <label></label>
                                    <span>Correct Answer</span>
                                </div>
                            </div>
                        </div>
                    </section>

                </section>

                <footer id = "fbar_footer" class = "fbar_contents_fix">
                    <!--<div id = "post_anonymously"><input type='checkbox' value='0' class='post_anon_val'><span class = 'comment_anon_text'>Post Anonymously</span></div>-->
                    <div id = "post_privacy" class = "help_div_shower">


                        <ul class = "menu privacy_menu">
                            <li class = "no_relative">
                                <a class = "privacy_dropdown_link"></a>
                                <ul class = "privacy_dropdown" data-privacy="">
                                    <li class = "privacy_list active" data-privacy='' style = "position:relative; border-bottom: 1px solid #fff;"><a>All</a><span></span></li>
                                    <li class = "privacy_list" data-privacy='s' style = "position:relative; border-bottom: 1px solid #fff;"><a>Students</a><span></span></li>
                                    <li class = "privacy_list" data-privacy='a' style = "position:relative;"><a>Admins</a><span></span></li>
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
                    <div id = "post_attachments" class = "notes_form_hide_content help_div_shower">


                        <span></span>
                        <div class="help-div fbar_helpers">
                            <div class="help-box">Attach files/notes</div>
                            <div class="help-wedge">
                            </div>
                        </div>
                    </div>
                    <div id="post_anon" class='check_wrap event_form_hide_content opportunity_form_hide_content'>
                        <input type='checkbox' id='flat_0' class='flat7c'/>
                        <label for='flat7' class='flat7b'>
                            <span class='move'></span>
                        </label>
                        <span class = 'comment_anon_text'>Post Anonymously</span>
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



<script id='audience_template' type="text/x-handlebars-template">
    <li class = "audience_name" data-audience='{{audience}}' data-audience_id='{{id}}'>
        <a>{{name}}</a>
    </li>
</script>


<script id='post_file_template' type="text/x-handlebars-template">

    <div class='{{file_type}} post_attachment_review fbar_file' data-name='{{name}}' style='float: none' data-file_name='{{name}}' data-last_modified='{{lastModified}}'>{{name}}</div>

</script>


<?php echo $this->renderPartial('/partial/feed_templates',array('origin_type'=>$origin_type, 'user_id'=>$user->user_id, 'is_admin'=>$is_admin)); ?>



