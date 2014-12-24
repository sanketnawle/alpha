<html>
	<head>

		<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/rightpanel/rightpanel.css">
		<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/right_panel/right_panel.js"></script>

		<script>
		    base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
		    origin = '<?php echo $origin_type; ?>';
		    origin_id = '<?php echo $origin_id; ?>';
		</script>
	</head>
	<body>
		<div id='right_panel'>
			<div id = 'panel_header'>
				<div>
					<span>                        
						<?php
			                if($origin_type == 'home'){
			                    echo 'Campus';
			                }
			                if($origin_type == 'search'){
			                    echo 'Campus';
			                }
			                else{
			                    echo ucfirst($origin_type);
			                }
			             ?> 
			             Activity
			         </span>
			         <span class = "activity_icon right_panel_assets">
			         </span>
		         </div>
			</div>
		</div>
	</body>
</html>

