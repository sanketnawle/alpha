
<!DOCTYPE html> 
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/fbar/fbar_main.css" type = "text/css"> 
		<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/status_bar/fbar.js"></script>

	</head>
	<body>

		<div id = "fbar_holder" class = "fbar_homepage">
			<div id = "fbar_new">
				<section id = "fbar_buttons">
					<div class = "fbar_buttonwrapper" id = "fbar_button_discuss">
						<i class = "fbar_button_icon" id = "fbar_icon_discuss">
						</i>
						<p class = "fbar_button_text">Discuss</p>
					</div>
					<div class = "fbar_buttonwrapper" id = "fbar_button_notes">
						<i class = "fbar_button_icon" id = "fbar_icon_notes">
						</i>
						<p class = "fbar_button_text">Notes</p>
					</div>
					<div class = "fbar_buttonwrapper" id = "fbar_button_question">
						<i class = "fbar_button_icon" id = "fbar_icon_question">
						</i>
						<p class = "fbar_button_text">Question</p>
					</div>
				</section>
				<section id = "fbar_postbox">
					<form id = "fbar_form">
						<div class = "form_wrapper">
							<header id = "fbar_header" class = "clearfix">
								<div id = "audience_select"></div>
							</header>
						</div>
					</form>
				</section>
			</div>
		</div> 


	</body>
</html>


