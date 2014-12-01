<html>
<head>
    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        feed_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
    </script>
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
    <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/course/group.css"> </link>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/course/backgroundGroup.css"> </link>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/course/invite_modal.css"> </link>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/ness.js" > </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js" > </script>


</head>

<body>

<div class="search-top-bar-wrap">
    <?php echo Yii::app()->runController('partial/topbar'); ?>
</div>
<section class='leftbar_bag'>
    <?php echo Yii::app()->runController('partial/leftmenu',array('user'=>$user)); ?>
</section>
<script id="course_template" type="text/x-handlebars-template">
    <div class='main'>

        <div class='main-mid-sec'>

            <div class='mid_right_sec'>
                <div class = "group-head-sec">
                    <div class = "group-pic-frame">
                        <div class = "group-pic">
                        </div>
                    </div>
                    <div class = "group-header-left">
                        <div class = "group-title">
                            <div class = "group-name">
                                {{course_name}}
                            </div>

                        </div>
                        <div class = "group-leader">
			                
			                    <span class = "imp-icon leader-icon" >
			                    </span >
			                    <span class = "group-info-title" >

			                    </span >
                            </a >

                        </div >
                    </div >

                    <div class="group_info_head_sec" >
                        <div class = "gih" >


                        </div >
                    </div >
                    <div class = "group-header-right" >
                        <div class="ch_edit_time_wrap" >

                            <div class="ch_edit_time" >Edit</div >

                            <div class = "ghr-1 ghr-box" style = "left:0px" >
                                <div class = "ghr-box-head" >
			                    <span class = "ghr-icon-1 ghr-icon" >
			                    </span >
			                    <span class = "ghr-head-time ghr-head-title" >
			            {{department_name}} <img class="right_arrow" src="img/right_arrow.png"> </img>
			                    </span >

                                </div >
                            </div >
                        </div >


                    </div >
                    <div class = "group-head-footer" >
                        <div class = "group-header-tab" >
                            <ul class = "group-nav" >
                                <li class = "group-tab" >
                                    <a class = "tab1 tab-anchor group-tab-active" >
                                        <div class = "tab-title" >
                                            OPEN CLASSES
                                            <span class = "tab-icon tab1-icon-active" ></span >
                                        </div >
                                    </a >
                                </li >


                            </ul >

                        </div >
                        <div class="class_message">
                            This course has {{open_sections}} open sections this semester
                        </div>
                        <!-- <div class = "group-footer-functions" >


                             <div class = "join-button" >
                                 <a class = "join" >
                                     Edit
                                 </a >
                             </div >
                         </div >
                     -->

                    </div >
                    <div class = "tab-wedge-down" >
                    </div >
                </div >

                <!--
                    <div class = "join-button" >
                                <a class = "join" >
                                    Enroll
                                </a >
                            </div >
                        </div >
                        </div >
                        <div class = "tab-wedge-down" >
                        </div >
                 </div >
                            <div class = "join-button" >
                                <a class = "join joined" >
                Enrolled
                                </a >
                            </div >
                        </div >
                    </div >
                    <div class = "tab-wedge-down" >
                    </div >
                </div >
                -->
                <div class='midsec'>

                    <div class="classes">
                        {{#each data}}
                        <div class="class">
                            <div class="top_section">
                                <div class="prof_img">
                                    <img src="http://www.villard.biz/assets/Uploads/projects/portrait-o.jpg" class="class_prof_pic">
                                    </img>
                                </div>
                                <div class="class_title">
                                    {{courses_name}}
					                        <span class="class_number">
					                            <i>{{section_id}}</i>
					                        </span>

                                    <div class="class_prof_name">
					                            <span class="name">
					                                Taught by <b> {{prof_fname}} {{prof_lname}} </b>
					                            </span>
                                        {{#if member}}
                                        <button class="class_member">
                                            Member
                                        </button>
                                        {{else}}
                                        <button class="class_not_member">
                                            Join this Class
                                        </button>
                                        {{/if}}

                                    </div>
                                </div>
                                <div class="class_time">
                                    <img class="time_icon" src="img/time.png"> </img>
                                    {{schedule.day}} {{schedule.start_time}} {{schedule.end_time}}
                                </div>
                            </div>
                            <div class="mid_section">
                                <div class="class_description">
                                    {{class_description}}
                                </div>
                            </div>
                            <div class="bottom_section">
                                <div class="class_members">
                                    <div class="member_img">
                                        <img src="{{users.picture_file_url}}">
                                        </img>
                                        <div class="class_member_name">

                                            <a class="class_member_link"> {{first_person}} </a>
                                            and {{num_people_taking}} others you know have taken this class
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{/each}}
                    </div>
                </div>
            </div>
</script>
<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/course/course.js"> </script>

</body>

