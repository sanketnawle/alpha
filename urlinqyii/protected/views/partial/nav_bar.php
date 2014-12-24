<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/nav_bar/nav_bar.css">
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/nav_bar/nav_bar.js"></script>

<script>
    base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';

</script>

<div id="nav_bar">

    <?php if($origin_type == 'home') { ?>
        <div class="nav_section active nav_section_home" id="home_nav" data-link_url="">
            <div class="nav_picture" id="home_nav_icon"></div>
            <div class="nav_text"><a href='<?php echo Yii::app()->getBaseUrl(true); ?>'>Home</a></div>

        </div>

        <div class="nav_arrow nav_arrow_white"></div>

        <div class="nav_section drop_down" data-link_type="school">
            <div class="nav_picture"></div>
            <div class="nav_text">Schools</div>
            <div id="nav_down_arrow"></div>
            <div id="nav_drop_down_container" class="closed">
                <div id="nav_drop_down_scrollable">
                    <?php foreach($origin->school->university->schools as $school){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $school->school_id; ?>"><?php echo $school->school_name; ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>


    <?php } else { ?>

        <div class="nav_section nav_section_home" data-link_url="">
            <div class="nav_picture" id="home_nav_icon"></div>
            <div class="nav_text"><a href='<?php echo Yii::app()->getBaseUrl(true); ?>'>Home</a></div>

        </div>

    <?php } ?>


    <?php if($origin_type == 'club') { ?>
        <div class="nav_arrow"></div>

        <div class="nav_section" data-link_url="/school/<?php echo $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="/club/<?php echo $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->group_name; ?></div>
        </div>

    <?php } ?>


    <?php if($origin_type == 'class' || $origin_type == 'course') { ?>

        <div class="nav_arrow"></div>

        <div class="nav_section" data-link_url="/<?php echo $origin_type . '/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow"></div>


        <div class="nav_section" data-link_url="/<?php echo 'department/' . $origin->department->department_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department->department_name; ?></div>
        </div>


        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="<?php echo '/' . $origin_type . '/' . $origin_id ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->class_name; ?></div>
        </div>

    <?php } ?>


    <?php if($origin_type == 'department') { ?>
        <div class="nav_arrow"></div>

        <div class="nav_section" data-link_url="/<?php echo 'school/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="/<?php echo 'department/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department_name; ?></div>
        </div>


        <div class="nav_arrow nav_arrow_white"></div>

        <!-- Store the link type so we can use it in the js        -->
        <div class="nav_section drop_down" data-link_url="/<?php echo 'course/' . $origin_id; ?>" data-link_type="course">
            <div class="nav_picture"></div>
            <div class="nav_text">Courses</div>
            <div id="nav_down_arrow"></div>


            <div id="nav_drop_down_container" class="closed">
                <div id="nav_drop_down_scrollable">
                    <?php foreach($origin->courses as $class){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $class->course_id; ?>"><?php echo $class->course_name; ?></div>
                    <?php } ?>
                </div>



                <div id="nav_drop_down_bar_line"></div>

                <div id="nav_drop_down_see_all_button">
                    <div id="nav_drop_down_see_all_courses_text">See all courses</div>
                </div>
            </div>
        </div>



    <?php } ?>


    <?php if($origin_type == 'school') { ?>

        <div class="nav_arrow nav_arrow_white"></div>

        <div class="nav_section active" data-link_url="/<?php echo 'school/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <!-- Store the link type so we can use it in the js        -->
        <div class="nav_section drop_down" id="home_nav" data-link_url="/<?php echo 'department/' . $origin_id; ?>" data-link_type="department">
            <div class="nav_picture"></div>
            <div class="nav_text">Departments</div>
            <div id="nav_down_arrow"></div>
            <div id="nav_drop_down_container" class="closed">
                <div id="nav_drop_down_scrollable">
                    <?php foreach($origin->departments as $department){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></div>
                    <?php } ?>
                </div>



                <div id="nav_drop_down_bar_line"></div>

                <div id="nav_drop_down_see_all_button">
                    <div id="nav_drop_down_see_all_courses_text">See all courses</div>
                </div>
            </div>
        </div>

    <?php } ?>











</div>