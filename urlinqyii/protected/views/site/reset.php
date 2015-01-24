<html>
	<head>
    	<script>
        	base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        	var globals = {};
        	globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
    	</script>
  		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  		<title>Your University - On Urlinq</title>
  		<meta name="viewport" content="width=device-width, initial-scale=.68">
    	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lp_beta.css" />
    	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/waiting_animation.css" rel='stylesheet' type='text/css'>
    	<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  		<script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>
  		<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
  		<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
  		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/getURLPara.js"></script>
  		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/preload_img.js"></script>
	</head>
	<body>
		<div id="resetForm">
			<form id="passwordReset" style="font-size: 11px; margin-left: 30%; margin-top: 10%;">
				Reset password for <?php echo $email?> <br/><br/><br/>
				<b>Password</b> <br/>
				<input name='password' id='password' type="password"/> <br/><br/>
				<b>Confirm Password</b> <br/>
				<input name='confirm_password' id='confirm_password' type="password"/> <br/><br/>
				<input type="submit" value="Reset Password"/>
				<input type="hidden" name="token" value="<?php echo $token?>">
			</form>
		</div>
		<script>
            $(document).on('submit', '#passwordReset', function(e){
            	var $form = $(this);
                e.preventDefault();
               	e.stopPropagation();
                var post_url = globals.base_url + '/doReset';
                var post_data = $form.serializeArray();
                $.post(
                	post_url,
                    post_data,
                    function(response){
                       	alert(JSON.stringify(response));
                    }, 'json'
                );
            });
		</script>
	</body>
</html>