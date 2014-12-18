<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/nav_bar/nav_bar.css">
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/nav_bar/nav_bar.js"></script>

<script>
    base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';

</script>

<div id="nav_bar">

    <?php if($origin_type == 'club') { ?>
        <div class="nav_section active" id="home_nav" data-link_url="">
            <div class="nav_picture" id="home_nav_icon"></div>
            <div class="nav_text"><a href='<?php echo Yii::app()->getBaseUrl(true); ?>'>Home</a></div>

        </div>

        <div class="nav_arrow"></div>

    <?php } else { ?>

        <div class="nav_section" id="home_nav" data-link_url="">
            <div class="nav_picture" id="home_nav_icon"></div>
            <div class="nav_text"><a href='<?php echo Yii::app()->getBaseUrl(true); ?>'>Home</a></div>

        </div>

        <div class="nav_arrow"></div>

    <?php } ?>


    <?php if($origin_type == 'club') { ?>
        <div class="nav_section" id="home_nav" data-link_url="/school/<?php echo $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" id="home_nav" data-link_url="/club/<?php echo $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->group_name; ?></div>
        </div>

    <?php } ?>


    <?php if($origin_type == 'class' || $origin_type == 'course') { ?>
        <div class="nav_section" id="home_nav" data-link_url="/<?php echo $origin_type . '/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow"></div>


        <div class="nav_section" id="home_nav" data-link_url="/<?php echo '/department/' . $origin->department->department_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department->department_name; ?></div>
        </div>


        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" id="home_nav" data-link_url="/<?php echo '/' . $origin_type . '/' . $origin_id ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->class_name; ?></div>
        </div>

    <?php } ?>


    <?php if($origin_type == 'department') { ?>
        <div class="nav_section" id="home_nav" data-link_url="/<?php echo '/school/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" id="home_nav" data-link_url="/<?php echo '/department/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department_name; ?></div>
        </div>

        <!-- ADD NAV ARROW WHITE AFTER CURRENT DEPARTMENT NAME, then COURSES DROP DOWN - text is #999-->

    

    <?php } ?>


    <?php if($origin_type == 'school') { ?>

        <!--ADD NAV ARROW WHITE BEFORE SCHOOL NAME -->
        <div class="nav_section active" id="home_nav" data-link_url="/<?php echo '/school/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

         <!-- ADD NAV ARROW WHITE AFTER CURRENT SCHOOL NAME, then DEPARTMENTS DROP DOWN - text is #999-->

    <?php } ?>








</div>