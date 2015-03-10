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
    	<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  		<script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>
  		<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
  		<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">

	</head>
	<body>
		<?php if($success){ ?>
            <div>Successfully unsubscribed</div>
        <?php }else { ?>
            <div>Failed to unsubscribe. Try again later</div>
        <?php } ?>
	</body>
</html>