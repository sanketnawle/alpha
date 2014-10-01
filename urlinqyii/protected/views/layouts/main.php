<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'/>
    <title><?php echo $user->firstname . ' ' . $user->lastname; ?></title>
    <!--<base href='https://urlinq.com/beta/'/>-->
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/backgroundProfile.css'/>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'/>
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->request->baseUrl; ?>/css/add_event.css'/>
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->request->baseUrl; ?>/css/professor.css'/>




    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.jpg" type="image/jpg">


    <!--<script src='//code.jquery.com/jquery-1.10.2.js'></script>
    <script src='//code.jquery.com/ui/1.10.4/jquery-ui.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type="text/javascript" src="http://cdn.embed.ly/jquery.embedly-3.1.1.min.js"></script>	-->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/professor-profile.js"></script>

</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Home', 'url'=>array('post/index')),
                array('label'=>'About', 'url'=>array('site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('site/contact')),
                array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        )); ?>
    </div><!-- mainmenu -->

    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->



    <!--  SPECIFIC CONTENT FOR PAGE GETS INSERTED HERE  -->
    <?php echo $content; ?>

    <div id="footer">
    This is the footer
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
