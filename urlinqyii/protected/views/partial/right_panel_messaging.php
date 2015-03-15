<html>
	<head>

		<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/rightpanel/rightpanel.css">
		<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/right_panel/right_panel.js"></script>

		<script>

           // var globals = {};

		    globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
		    globals.origin_type = '<?php echo $origin_type; ?>';
		    globals.origin_id = '<?php echo $origin_id; ?>';

		</script>
	</head>
	<body>
		<div id='right_panel'>
			<div id = "right_panel_content_holder">

			</div>
		</div>
	</body>
</html>

