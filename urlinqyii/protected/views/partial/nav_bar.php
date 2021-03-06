<?php


$department_front_end_name = 'department';
if($user->school->university_id == 4){
    $department_front_end_name = 'program';
}
?>


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
            <div id="nav_drop_down_container" class="home_nav_dropdown closed">
                <div class="nav_drop_down_scrollable">

                    <?php

                        function compare_school_names($a, $b){
                            if ($a->school_name == $b->school_name) {
                                return 0;
                            }
                            return ($a->school_name < $b->school_name) ? -1 : 1;
                        }

                        $schools = $origin->school->university->schools;
                        usort($schools, "compare_school_names");
                    ?>


                    <?php foreach($schools as $school){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $school->school_id; ?>"><?php echo $school->school_name; ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="nav_arrow"></div>

        <div class="nav_section drop_down" id="home_nav" data-link_url="/<?php echo 'program/' . $origin_id; ?>" data-link_type="<?php echo $department_front_end_name; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo ucfirst($department_front_end_name);?>s</div>
            <div id="nav_down_arrow"></div>
            <div id="nav_drop_down_container" class="home_nav_dropdown closed">
                <div class="nav_drop_down_scrollable">
                    <?php
                        function compare_department_names($a, $b){
                            if ($a->department_name == $b->department_name) {
                                return 0;
                            }
                            return ($a->department_name < $b->department_name) ? -1 : 1;
                        }

                        $departments = $user->school->departments;
                        usort($departments, "compare_department_names");
                    ?>
                    <?php foreach($departments as $department){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $department->department_id; ?>"><?php echo $department->department_name; if($department->department_tag != ''){echo ' (' . $department->department_tag . ')'; }?></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="nav_arrow"></div>

        <div class="nav_section drop_down" id="home_nav" data-link_url="/<?php echo 'club/' . $origin_id; ?>" data-link_type="club">
            <div class="nav_picture"></div>
            <div class="nav_text">Groups</div>
            <div id="nav_down_arrow"></div>
            <div id="nav_drop_down_container" class="last_nav_drop_down_home home_nav_dropdown closed">
                <div class="nav_drop_down_scrollable">

                    <?php

                        function compare_group_names($a, $b){
                            if ($a->group_name == $b->group_name) {
                                return 0;
                            }
                            return ($a->group_name < $b->group_name) ? -1 : 1;
                        }

                        $clubs = $user->school->groups;
                        usort($clubs, "compare_group_names");
                    ?>

                    <?php foreach($clubs as $club){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $club->group_id; ?>"><?php echo $club->group_name; ?></div>
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

        <div class="nav_section" data-link_url="/school/<?php echo $origin->school->school_id;; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="/club/<?php echo $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->group_name; ?></div>
        </div>

    <?php } ?>



    <?php if($origin_type == 'class') { ?>
        <div class="nav_arrow"></div>

        <div class="nav_section" data-link_url="/school/<?php echo $origin->school->school_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow"></div>


        <div class="nav_section" data-link_url="/<?php echo $department_front_end_name . '/' . $origin->department->department_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department->department_name; ?></div>
        </div>


        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="<?php echo '/' . $origin_type . '/' . $origin_id ?>">
            <div class="nav_picture"></div>

            <div class="nav_text"><?php echo $origin->class_name; ?></div>
        </div>

    <?php } ?>

    <?php if($origin_type == 'course') { ?>
        <div class="nav_arrow"></div>

        <div class="nav_section" data-link_url="/school/<?php echo $origin->school->school_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow"></div>


        <div class="nav_section" data-link_url="/<?php echo $department_front_end_name . '/' . $origin->department->department_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department->department_name; ?></div>
        </div>


        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="<?php echo '/' . $origin_type . '/' . $origin_id ?>">
            <div class="nav_picture"></div>

            <div class="nav_text"><?php echo $origin->course_name; ?></div>
        </div>

    <?php } ?>



    <?php if($origin_type == 'department') { ?>
        <div class="nav_arrow"></div>

        <div class="nav_section" data-link_url="/<?php echo 'school/' . $origin->school->school_id; ?>">

            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white"></div>


        <div class="nav_section active" data-link_url="/<?php echo $department_front_end_name . '/' . $origin_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->department_name; ?></div>
        </div>


        <div class="nav_arrow nav_arrow_white nav_bar_no_repeat"></div>

        <!-- Store the link type so we can use it in the js        -->
        <div class="nav_section drop_down nav_bar_no_repeat" data-link_url="/<?php echo 'course/' . $origin_id; ?>" data-link_type="course">
            <div class="nav_picture"></div>
            <div class="nav_text">Courses</div>
            <div id="nav_down_arrow"></div>


            <div id="nav_drop_down_container" class="closed">
                <div class="nav_drop_down_scrollable">
                    <?php foreach($origin->courses as $course){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $course->course_id; ?>"><?php echo $course->course_name; if($course->course_tag != ''){ echo ' (' . $course->course_tag . ')'; }?></div>
                    <?php } ?>
                </div>



                <div id="nav_drop_down_bar_line"></div>

                <div id="nav_drop_down_see_all_button" class = "courses">
                    <div id="nav_drop_down_see_all_courses_text" data-panel_id="2">See all courses</div>
                </div>
            </div>
        </div>



    <?php } ?>


    <?php if($origin_type == 'school') { ?>

        <div class="nav_arrow nav_arrow_white"></div>

        <div class="nav_section active" data-link_url="/<?php echo 'school/' . $origin->school_id; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo $origin->school_name; ?></div>
        </div>

        <div class="nav_arrow nav_arrow_white nav_bar_no_repeat"></div>


        <!-- Store the link type so we can use it in the js        -->
        <div class="nav_section drop_down nav_bar_no_repeat" id="home_nav" data-link_url="/<?php echo $department_front_end_name . '/' . $origin_id; ?>" data-link_type="<?php echo $department_front_end_name; ?>">
            <div class="nav_picture"></div>
            <div class="nav_text"><?php echo ucfirst($department_front_end_name); ?>s</div>
            <div id="nav_down_arrow"></div>
            <div id="nav_drop_down_container" class="closed">
                <div class="nav_drop_down_scrollable">

                    <?php
                        function compare_department_names($a, $b){
                            if ($a->department_name == $b->department_name) {
                                return 0;
                            }
                            return ($a->department_name < $b->department_name) ? -1 : 1;
                        }

                        $departments = $origin->departments;
                        usort($departments, "compare_department_names");
                    ?>


                    <?php foreach($origin->departments as $department){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $department->department_id; ?>"><?php echo $department->department_name; if($department->department_tag != ''){ echo ' (' . $department->department_tag . ')'; } ?></div>
                    <?php } ?>




                </div>



                <div id="nav_drop_down_bar_line"></div>

                <div id="nav_drop_down_see_all_button" class = "departments">
                    <div id="nav_drop_down_see_all_departments_text">See all <?php echo $department_front_end_name; ?>s</div>
                </div>
            </div>
        </div>

        <div class="nav_arrow nav_bar_no_repeat"></div>

        <div class="nav_section drop_down nav_bar_no_repeat" id="home_nav" data-link_url="/<?php echo 'club/' . $origin_id; ?>" data-link_type="club">
            <div class="nav_picture"></div>
            <div class="nav_text">Groups</div>
            <div id="nav_down_arrow"></div>
            <div id="nav_drop_down_container" class="home_nav_dropdown closed">
                <div class="nav_drop_down_scrollable">

                    <?php

                        function compare_group_names($a, $b){
                            if ($a->group_name == $b->group_name) {
                                return 0;
                            }
                            return ($a->group_name < $b->group_name) ? -1 : 1;
                        }

                        $clubs = $origin->groups;
                        usort($clubs, "compare_group_names");
                    ?>


                    <?php foreach($clubs as $club){ ?>
                        <div class="nav_drop_down_section" data-id="<?php echo $club->group_id; ?>"><?php echo $club->group_name; ?></div>
                    <?php } ?>
                </div>
                <div id="nav_drop_down_bar_line"></div>

                <div id="nav_drop_down_see_all_button" class = "clubs">
                    <div id="nav_drop_down_see_all_clubs_text">See all groups</div>
                </div>
            </div>
        </div>


    <?php } ?>











</div>