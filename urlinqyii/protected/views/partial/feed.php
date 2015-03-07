<html>
<head>
    <title> Feed </title>
    <script>
        //var globals = {};



        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        globals.feed_url = '<?php echo $feed_url; ?>';


        globals.origin_type = '<?php echo $origin_type; ?>';
        globals.origin_id = '<?php echo $origin_id; ?>';

        globals.user_id = '<?php echo $user->user_id; ?>';



    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/render_post.js"> </script>

    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/ness.js"> </script>
    <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/embedly.js"> </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js"> </script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/Chart.js-master/Chart.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/club/analytics.css">

    <script>
        moment().format();
    </script>

    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>


    

    
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/icon_font/styles.css" rel="stylesheet" type="text/css">
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



                <?php echo $this->renderPartial('/partial/feed_templates',array('origin_type'=>$origin_type,'user_id'=>$user->user_id,'is_admin'=>$is_admin)); ?>

                <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/feed.js"> </script>
            </div>
            
        </div> 
    </div>
</body>
</html>