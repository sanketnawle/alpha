<html>


    <head>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">


    </head>

    <body>

    <?php echo Yii::app()->runController('partial/topbar'); ?>

    <?php echo Yii::app()->runController('partial/leftmenu'); ?>


    <div id="page">
        <?php echo $this->renderPartial('/partial/nav_bar',array()); ?>




    </div>



<!--        <div id="right_menu_panel">-->
<!---->
<!--        </div>-->

    </body>




</html>