
<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';


</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css"> 
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>



<div id = "fbar_holder" class = "fbar_homepage" data-post_type = "">
	<div class = "dark_overlay" id = "dark_overlay_fbar"></div>
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
					<header id = "fbar_header" class = "clearfix">
						<div id = "audience_select"><span>To Followers</span><em class = "down_arrow"></em></div>
						<div id = "question_form_content" class = "question_type_button" data-question_post_type = "multiple_choice">Multiple Choice</div><div id = "question_form_content" data-question_post_type = "true_false" class = "question_type_button">True or False</div>
					</header>

					<section id = "discussion_form" class = "post_form_template">
						<header>
							<div class = "3">
							</div>
							<div class = "3">
							</div>
							<div class = "3">
							</div>
						</header>
					</section>

					<section id = "notes_form" class = "post_form_template">
						<header>
							<div class = "2">
							</div>
							<div class = "2">
							</div>
						</header>
					</section>

					<section id = "question_form" class = "post_form_template">
						<header>
							<div class = "3">
							</div>
							<div class = "3">
							</div>
							<div class = "3">
							</div>
						</header>
					</section>

					<footer id = "fbar_footer">
						<div class = "post_btn" id = "post_btn">
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



