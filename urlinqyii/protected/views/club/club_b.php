<!DOCTYPE html>
<?php
//	include('php/redirect.php');
//?>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundGroup.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/group.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/invite_modal.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/photo_modal.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/club/club.css'>
<!--    <link rel='stylesheet' type='text/css' href='--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/css/planner_for_club.css'>-->


    <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
    <link rel="icon" href="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/Ur_FavIcon.jpg" type="image/jpg">




    <!--  This allows us to use club_id in our javascript without having to access the url parameter  -->
    <script type="text/javascript">
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        club_id = '<?php echo $club->group_id; ?>';
        origin = 'group';
        origin_id = '<?php echo $club->group_id; ?>';
    </script>

    <?php //include "timezone.php" ?>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/club/club.js'></script>
</head>
<body>



</body>


</html>