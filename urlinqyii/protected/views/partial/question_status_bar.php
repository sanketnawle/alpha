
<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';


</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css"> 
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>
<!--BELOW ARE SCRIPTS AND LINKS FOR DROPDOWN MENU API -->
<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropit.js'></script>
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/dropit.css" type="text/css" />


<div id = "fbar_holder" class = "fbar_homepage" data-post_type = "">
	<!--<div class = "dark_overlay" id = "dark_overlay_fbar"></div>-->
	<div id = "fbar_new">
		<section id = "fbar_buttons">
			<div class = "fbar_buttonwrapper" id = "fbar_button_discuss" data-post_button_type = "discuss">
				<i class = "fbar_button_icon" id = "fbar_icon_discuss">
				</i>
				<p class = "fbar_button_text">Post</p>
			</div>
			<div class = "fbar_buttonwrapper" id = "fbar_button_notes" data-post_button_type = "notes">
				<i class = "fbar_button_icon" id = "fbar_icon_notes">
				</i>
				<p class = "fbar_button_text">Notes</p>
			</div>
			<div class = "fbar_buttonwrapper" id = "fbar_button_question" data-post_button_type = "question">
				<i class = "fbar_button_icon" id = "fbar_icon_question">
				</i>
				<p class = "fbar_button_text">Question</p>
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
									<li>
										<a>Faculty</a>
									</li>
									<li>
										<a>Class 1</a>
									</li>
									<li>
										<a>Class 2</a>
									</li>
									<li>
										<a>Class 3</a>
									</li>
									<li>
										<a>Club 1</a>
									</li>
									<li>
										<a>Club 2</a>
									</li>
								</ul>
							</li>
						</ul>
						<div id = "question_form_content" class = "question_type_button active regular_question" id = "hide_both_question_types" data-question_post_type = "hide_both">Regular Question</div><div id = "question_form_content" class = "question_type_button multiple_choice_btn" data-question_post_type = "multiple_choice"><em></em>Multiple Choice</div><div id = "question_form_content" data-question_post_type = "true_false" class = "question_type_button true_or_false_btn"><em></em>True or False</div>
					</header>

					<section id = "discussion_form" class = "post_form_template fbar_contents_fix">
						<div class = "discussion_textarea input_wrap">
							<textarea class = "autofocus post_text_area" placeholder = "Start a discussion"></textarea>
						</div>
					</section>

					<section id = "notes_form" class = "post_form_template fbar_contents_fix">
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
							<input type='hidden' name = "post_privacy">
							<span></span>
							<div class="help-div fbar_helpers">
                                <div class="help-box">Edit privacy</div>
                                <div class="help-wedge">
                                </div>
                            </div>
						</div>
						<div id = "post_attachments" class = "help_div_shower">
							<span></span>
							<div class="help-div fbar_helpers">
                                <div class="help-box">Attach files/notes</div>
                                <div class="help-wedge">
                                </div>
                            </div>
						</div>

						<div class = "post_btn fresh_green_button" id = "post_btn">
							Post
						</div>
						<div class = "cancel_btn" id = "cancel_btn">
							Cancel
						</div>
					</footer>
				</div>
			</form>
		</section>
	</div>
</div> 



