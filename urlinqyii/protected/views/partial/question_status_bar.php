
<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';


</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css"> 
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>



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
						<div id = "audience_select"><span>To Followers</span><em class = "down_arrow"></em></div>
						<div id = "question_form_content" class = "question_type_button" data-question_post_type = "multiple_choice">Multiple Choice</div><div id = "question_form_content" data-question_post_type = "true_false" class = "question_type_button">True or False</div>
						<div id = "post_anonymously"><span class = 'comment_anon_text'>Post Anonymously</span><input type='checkbox' value='0' class='post_anon_val'></div>
					</header>

					<section id = "discussion_form" class = "post_form_template fbar_contents_fix">
						<header class = "form_function_panel">
							<div class = "3">
							</div>
							<div class = "3">
							</div>
							<div class = "3">
							</div>
						</header>
					</section>

					<section id = "notes_form" class = "post_form_template fbar_contents_fix">
						<header class = "form_function_panel">
							<div class = "2">
							</div>
							<div class = "2">
							</div>
						</header>
						

					</section>

					<section id = "question_form" class = "post_form_template fbar_contents_fix">
						<header class = "form_function_panel">
							<div class = "3">
							</div>
							<div class = "3">
							</div>
							<div class = "3">
							</div>

						</header>
						<section>
							<div class="multiple_choice">
                                <div class="question_choice_line multiple_line">
                                    <div class="fixed_choice_prefix">
                                        <div class="letter_choice"><span>A</span></div>
                                        <div class="add_choice"><span>+</span></div>
                                    </div>
                                    <input class="multiple_choice_answer" id="choice_a"placeholder="Add choice A...">
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
						</section>

					</section>

					<footer id = "fbar_footer" class = "fbar_contents_fix">
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



