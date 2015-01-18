<html>
<head>
    <title> Feed </title>
    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        feed_url = '<?php echo $feed_url; ?>';
        user_id = '<?php echo $user->user_id; ?>';

        origin_type = '<?php echo $origin_type; ?>';
        origin_id = '<?php echo $origin_id; ?>';


    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/render_post.js"> </script>

    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/ness.js"> </script>
    <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/embedly.js"> </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js"> </script>
    <script>
        moment().format();
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/feed.js"> </script>
    
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
    

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/feed/feed.css"> </link>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>


</head>
<script type="text/javascript">
   
    
    

</script>
    
<body>

    <div class='feed-tab-content'>
        <div class='group_feed_wrap'>
            <div id="posts">



                <?php echo $this->renderPartial('/partial/feed_templates',array('origin_type'=>$origin_type)); ?>


            </div>
            
        </div> 
    </div>
</body>
</html>