<!DOCTYPE html>

<html>

    <head>
        <script>


            var globals = {};


            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'user'; ?>';
            globals.origin_id = '<?php echo $user->user_id; ?>';
            globals.user_id = '<?php echo $user->user_id; ?>';




        </script>

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-59124667-1', 'auto');
          ga('send', 'pageview');

        </script>        
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
          <title>Urlinq</title>

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/site/main.css">
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/home/home_adjustments.css">
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/reminders.js"></script>


        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/tooltip.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/pulser.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/intro_tutorial.js"></script>

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/reminders/reminders.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/time_selector/time_selector.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/time_selector/time_selector.css" type = "text/css" rel = "stylesheet">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/date_selector/date_selector.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/lightbox.min.js" type="text/javascript"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/lightbox.css" type = "text/css" rel = "stylesheet">
 
    </head>


    <body id = "body_home" <?php if($first_time) { ?>class="first_visit first_visit_two"<?php } else { ?>class="first_visit_two"<?php } ?>>

        <?php echo Yii::app()->runController('partial/topbar');     ?>

        <div id = "wrapper">
            <div id="page">
                <div id = "main_panel">
                    <div id="content_holder">
                        <div id="left_panel">
                            <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'home','origin_id'=>'')); ?>
                        </div>
                        <div id = "content_panel" class = "content_panel_home">
                            <?php echo $this->renderPartial('/partial/nav_bar',array('user' => $user, 'origin_type'=>'home','origin_id'=>$user->user_id,'origin'=>$user)); ?>
                            <div id = "planner_column" class = "planner_column_home intro_div intro_div_2">
                                <div id = "right_column_specs">
                                    <div id = "fixed_element">
                                        <?php
                                        echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'home','origin_id'=>''));
                                        ?> 

                                        <?php
                                        echo $this->renderPartial('/partial/reminders',array('user'=>$user,'origin_type'=>'home','origin_id'=>''));
                                        ?>    
                                    </div>
                                </div>                           
                            </div>
                            <div id = "feed_column" class = "feed_column_home">
                                <div id = "stream_holder" class = "stream_holder_home">
                                    <div id = "fbar_wrapper" class = "fbar_home intro_div intro_div_3">
                                        <?php echo $this->renderPartial('/partial/question_status_bar',array('user'=>$user,'origin_type'=>'user','origin_id'=>$user->user_id ,'is_admin'=>false)); ?>
                                    </div>

                                    <div id = "tutorial_starter" class = "welcome_button <?php echo $show_fbar_tutorial.' '.$show_planner_tutorial;?>">
                                        <h5>Discover how Urlinq can improve your education</h5>
                                    </div>

                                    <div id = "filter_wrapper" class = "filter_bar filter_bar_home">
                                        <div class = "filter_wrapper_left">
                                            <span><h5 class = "feed_header">Home Feed</h5></span>
                                        </div>
                                        <div class = "filter_wrapper_right">
                                            <span class = "filters_header">Filters:</span>
                                            <span class = "filter_type active">Faculty posts</span>
                                            <span class = "filter_type active">Student posts</span>
                                            <span class = "filter_type active">Question</span>
                                            <span class = "filter_type active">Notes</span>
                                            <span class = "filter_type active">Events</span>
                                        </div>
                                    </div>

                                    <div id = "feed_wrapper" class = "feed_wrapper_home">
                                     <?php if($first_time){ ?>
                                     <div class = 'post new_fd' id = 'welcome_post'>
                                        <div class = "welcome_post_banner"></div>
                                        <div class="post_main welcome_post">
                                        <div class = "post_type_marker reg_post_type">
                                            <span class = "post_type_icon"></span>
                                        </div>
                                        <div class="post_head">
                                        <div class="post_title">
                                            <div class = 'image_container'>

                                                    <div class = 'post_user_icon'  style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>/assets/professor_urlinq.png')">
                                                    </div>


                                            </div>


                                                <span class = 'post_owner prof_urlinq_post_owner' >
                                                    Professor Urlinq
                                                </span>









                                         </div>
                                            <div class = 'post_time'> <span class = "time_icon"></span>
                                                <time class='timeago'>
                                                    A few seconds ago
                                                </time>
                                            </div>

                                            <div class = 'post_msg post_lr_link_msg'>
                                                    <span class='msg_span seemore_anchor'>
                                                        Hi <?php echo $user->firstname ?>,
                                                        <br>
                                                        I am Professor Urlinq. Welcome to your university's Academic Network. We are excited to have you join this growing community. Use Urlinq to search classes, departments, faculty, and groups on your campus. The planner to the right will help you keep track of everything happening in your busy schedule. These tools, and many others you'll soon discover, will put you on track to a more successful academic journey. 
                                                    </span>





                                             </div>

                                        </div>

                                       </div>
                                    </div>
                                  <?php } ?>
                                  <?php if($user->show_edit_profile_post){?>
                                    <div class = 'post new_fd' id = 'welcome_post_2'>

                                        <div class="post_main welcome_post">
                                        <div class = "post_type_marker reg_post_type">
                                            <span class = "post_type_icon"></span>
                                        </div>
                                        <div class = "profile_post_banner"></div>
                                        <div class="post_head">
                                        <div class="post_title">
                                            <div class = 'image_container'>

                                                    <div class = 'post_user_icon'  style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>/assets/professor_urlinq.png')">
                                                    </div>


                                            </div>


                                                <span class = 'post_owner prof_urlinq_post_owner' >
                                                    Professor Urlinq
                                                </span>









                                         </div>
                                            <div class = 'post_time'> <span class = "time_icon"></span>
                                                <time class='timeago'>
                                                    A few seconds ago
                                                </time>
                                            </div>

                                            <div class = 'post_msg post_lr_link_msg'>
                                                    <span class='msg_span seemore_anchor'>
                                                         <div class="welcome_post_header">Please help us get to know you better by entering the following information.</div>
                                                         <?php if($user->user_type == "s" && $user->studentAttributes){
                                                                if(sizeof($user->majors)==0){?>
                                                                   <div class="post_major_section">
                                                                       <div class="post_major_add welcome_post_label">Add your major<br><span>What is your focus?</span></div>
                                                                       <input class = "post_major_input">
                                                                   </div>
                                                              <?php  }?>
                                                                 <div class="post_year_name_section">
                                                                     <div class="post_year_name_add welcome_post_label">Add your year</div>
                                                                     <select class="post_year_name_input">
                                                                         <option value="Freshman">Freshman</option>
                                                                         <option value="Sophomore">Sophomore</option>
                                                                         <option value="Junior">Junior</option>
                                                                         <option value="Senior">Senior</option>
                                                                         <option value="Master">Master</option>
                                                                         <option value="PhD">PhD</option>
                                                                     </select>
                                                                 </div>

                                                             <?php if(!$user->studentAttributes->year){?>
                                                                 <div class="post_year_section">
                                                                     <div class="post_year_add welcome_post_label">Add your year of graduation</div>
                                                                     <select class="post_year_input">
                                                                         <option value="2014">2014</option>
                                                                         <option value="2015">2015</option>
                                                                         <option value="2016">2016</option>
                                                                         <option value="2017">2017</option>
                                                                         <option value="2018">2018</option>
                                                                         <option value="2019">2019</option>
                                                                         <option value="2020">2020</option>
                                                                     </select>
                                                                 </div>

                                                             <?php }?>

                                                         <?php }?>
                                                        <?php if($user->user_type == "p" && $user->professorAttribute){?>
                                                            <?php if(!$user->professorAttribute->office_location){?>
                                                                <div class="post_office_section">
                                                                    <div class="post_office_add welcome_post_label">Add your office location</div>
                                                                    <input class = "post_office_input">
                                                                </div>

                                                            <?php }if(!$user->professorAttribute->office_hours){?>
                                                                <div class="post_office_hours_section">
                                                                    <div class="post_office_hours_add welcome_post_label">Add your office hours</div>

                                                                   <!-- <div class="post_office_hours_day_holder">
                                                                        <input placeholder="Start time" class = "post_office_hours_input start_time time_input">
                                                                        <em class="event_time_to_arrow"></em>
                                                                        <input placeholder="End time" class = "post_office_hours_input end_time time_input">
                                                                        <select class = "post_office_hours_day_input">
                                                                            <option value="Monday">Monday</option>
                                                                            <option value="Tuesday">Tuesday</option>
                                                                            <option value="Wednesday">Wednesday</option>
                                                                            <option value="Thursday">Thursday</option>
                                                                            <option value="Friday">Friday</option>
                                                                            <option value="Saturday">Saturday</option>
                                                                            <option value="Sunday">Sunday</option>
                                                                        </select>
                                                                        <div class="post_add_office_hours_button"></div>
                                                                    </div>-->

                                                                   <input class="post_office_hours_input" placeholder="Wed 2:00pm - 4:00pm">
                                                                </div>
                                                            <?php }?>

                                                        <?php }?>
                                                        <?php if(!$user->user_bio){?>
                                                            <div class="post_bio_section">
                                                                <div class="post_bio_add welcome_post_label">Add a Description<br><span>Tell members of the university who you are and what you're passionate about.</span></div>
                                                                <textarea maxlength="240" type="text" class="post_bio_input" id="bio_input" cols="29" wrap="hard"></textarea>
                                                            </div>
                                                        <?php }?>
                                                            <button class="post_submit_edit_profile">Save</button>
                                                    </span>





                                             </div>

                                    </div>

                                    </div>
                                    </div>
                                    <?php } ?>
                                        <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/home/feed', 'origin_type'=>'user', 'origin_id'=>$user->user_id ,'is_admin'=>false)); ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="right_panel" class = "group_responsiveness">
                    <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'home','origin_id'=>$user->user_id)); ?>
                </div>
            </div>
        </div>
        <div class='pulse_container' style='left:50%;top:50%;position:absolute;'>
            <div class='pulse_tp_0'></div>
        </div> 
        <div class='black_canvas hidden'></div>
    </body>


    

 <!--<!-- INCLUDE THIS AND date_selector.js and add class name date_input to your date input fields to use this -->

    <div id = "calLayer" style="display: none;">
        <section id = "mounth" class="mounth">
            <header class="minical-header">
                <h1 class="minical-h1"></h1>

                <nav role="padigation">
                    <span class="m-prev"></span>
                    <span class="m-next"></span>
                </nav>
            </header>

            <article>
                <div class="days">
                    <b>SU</b>
                    <b>MO</b>
                    <b>TU</b>
                    <b>WE</b>
                    <b>TH</b>
                    <b>FR</b>
                    <b>SA</b>
                </div>
                <div class="dates">
                    <span id="calcell_su_0" class="calcell disable cl_0"></span>
                    <span id="calcell_mo_1" class="calcell disable cl_1"></span>
                    <span id="calcell_tu_2" class="calcell disable cl_2"></span>
                    <span id="calcell_we_3" class="calcell disable cl_3"></span>
                    <span id="calcell_th_4" class="calcell disable cl_4"></span>
                    <span id="calcell_fr_5" class="calcell disable cl_5"></span>
                    <span id="calcell_sa_6" class="calcell disable cl_6"></span>
                    <span id="calcell_su_7" class="calcell disable cl_7"></span>
                    <span id="calcell_mo_8" class="calcell disable cl_8"></span>
                    <span id="calcell_tu_9" class="calcell disable cl_9"></span>
                    <span id="calcell_we_10" class="calcell disable cl_10"></span>
                    <span id="calcell_th_11" class="calcell disable cl_11"></span>
                    <span id="calcell_fr_12" class="calcell disable cl_12"></span>
                    <span id="calcell_sa_13" class="calcell disable cl_13"></span>
                    <span id="calcell_su_14" class="calcell disable cl_14"></span>
                    <span id="calcell_mo_15" class="calcell disable cl_15"></span>
                    <span id="calcell_tu_16" class="calcell disable cl_16"></span>
                    <span id="calcell_we_17" class="calcell disable cl_17"></span>
                    <span id="calcell_th_18" class="calcell disable cl_18"></span>
                    <span id="calcell_fr_19" class="calcell disable cl_19"></span>
                    <span id="calcell_sa_20" class="calcell disable cl_20"></span>
                    <span id="calcell_su_21" class="calcell disable cl_21"></span>
                    <span id="calcell_mo_22" class="calcell disable cl_22"></span>
                    <span id="calcell_tu_23" class="calcell disable cl_23"></span>
                    <span id="calcell_we_24" class="calcell disable cl_24"></span>
                    <span id="calcell_th_25" class="calcell disable cl_25"></span>
                    <span id="calcell_fr_26" class="calcell disable cl_26"></span>
                    <span id="calcell_sa_27" class="calcell disable cl_27"></span>
                    <span id="calcell_su_28" class="calcell disable cl_28"></span>
                    <span id="calcell_mo_29" class="calcell disable cl_29"></span>
                    <span id="calcell_tu_30" class="calcell disable cl_30"></span>
                    <span id="calcell_we_31" class="calcell disable cl_31"></span>
                    <span id="calcell_th_32" class="calcell disable cl_32"></span>
                    <span id="calcell_fr_33" class="disable calcell cl_33"></span>
                    <span id="calcell_sa_34" class="disable calcell cl_34"></span>
                    <span id="calcell_su_35" class="disable calcell cl_35"></span>
                    <span id="calcell_mo_36" class="disable calcell cl_36"></span>
                    <span id="calcell_tu_37" class="disable calcell cl_37"></span>
                    <span id="calcell_we_38" class="disable calcell cl_38"></span>
                    <span id="calcell_th_39" class="disable calcell cl_39"></span>
                    <span id="calcell_fr_40" class="disable calcell cl_40"></span>
                    <span id="calcell_sa_41" class="disable calcell cl_41"></span>
                </div>
            </article>
        </section>
    </div>




<!--Include this and js/time_selector/time_selector.js to use this.
Set the class name on your input to 'time_input' -->
<div id="time_selector">
    <div class='time_selector_div' data-time='00:00:00' value="00:00:00">12:00am</div>
    <div class='time_selector_div' data-time='00:30:00' value="00:30:00">12:30am</div>

    <div class='time_selector_div' data-time='01:00:00' value="01:00:00">1:00am</div>
    <div class='time_selector_div' data-time='01:30:00' value="01:30:00">1:30am</div>

    <div class='time_selector_div' data-time='02:00:00' value="02:00:00">2:00am</div>
    <div class='time_selector_div' data-time='02:30:00' value="02:30:00">2:30am</div>

    <div class='time_selector_div' data-time='03:00:00' value="03:00:00">3:00am</div>
    <div class='time_selector_div' data-time='03:30:00' value="03:30:00">3:30am</div>

    <div class='time_selector_div' data-time='04:00:00' value="04:00:00">4:00am</div>
    <div class='time_selector_div' data-time='04:30:00' value="04:30:00">4:30am</div>

    <div class='time_selector_div' data-time='05:00:00' value="05:00:00">5:00am</div>
    <div class='time_selector_div' data-time='05:30:00' value="05:30:00">5:30am</div>

    <div class='time_selector_div' data-time='06:00:00' value="06:00:00">6:00am</div>
    <div class='time_selector_div' data-time='06:30:00' value="06:30:00">6:30am</div>

    <div class='time_selector_div' data-time='07:00:00' value="06:00:00">7:00am</div>
    <div class='time_selector_div' data-time='07:30:00' value="06:30:00">7:30am</div>


    <div class='time_selector_div' data-time='08:00:00' value="08:00:00">8:00am</div>
    <div class='time_selector_div' data-time='08:30:00' value="08:30:00">8:30am</div>

    <div class='time_selector_div' data-time='09:00:00' value="09:00:00">9:00am</div>
    <div class='time_selector_div' data-time='09:30:00' value="09:30:00">9:30am</div>

    <div class='time_selector_div' data-time='10:00:00' value="10:00:00">10:00am</div>
    <div class='time_selector_div' data-time='10:30:00' value="10:30:00">10:30am</div>

    <div class='time_selector_div' data-time='11:00:00' value="11:00:00">11:00am</div>
    <div class='time_selector_div' data-time='11:30:00' value="11:30:00">11:30am</div>


    <!-- NOON -->
    <div class='time_selector_div' data-time='12:00:00' value="12:00:00">12:00pm</div>
    <div class='time_selector_div' data-time='12:30:00' value="12:30:00">12:30pm</div>



    <div class='time_selector_div' data-time='13:00:00' value="13:00:00">1:00pm</div>
    <div class='time_selector_div' data-time='13:30:00' value="13:30:00">1:30pm</div>

    <div class='time_selector_div' data-time='14:00:00' value="14:00:00">2:00pm</div>
    <div class='time_selector_div' data-time='14:30:00' value="14:30:00">2:30pm</div>

    <div class='time_selector_div' data-time='15:00:00' value="15:00:00">3:00pm</div>
    <div class='time_selector_div' data-time='15:30:00' value="15:30:00">3:30pm</div>

    <div class='time_selector_div' data-time='16:00:00' value="16:00:00">4:00pm</div>
    <div class='time_selector_div' data-time='16:30:00' value="16:30:00">4:30pm</div>

    <div class='time_selector_div' data-time='17:00:00' value="17:00:00">5:00pm</div>
    <div class='time_selector_div' data-time='17:30:00' value="17:30:00">5:30pm</div>

    <div class='time_selector_div' data-time='18:00:00' value="18:00:00">6:00pm</div>
    <div class='time_selector_div' data-time='18:30:00' value="18:30:00">6:30pm</div>

    <div class='time_selector_div' data-time='19:00:00' value="19:00:00">7:00pm</div>
    <div class='time_selector_div' data-time='19:30:00' value="19:30:00">7:30pm</div>


    <div class='time_selector_div' data-time='20:00:00' value="20:00:00">8:00pm</div>
    <div class='time_selector_div' data-time='20:30:00' value="20:30:00">8:30pm</div>

    <div class='time_selector_div' data-time='21:00:00' value="21:00:00">9:00pm</div>
    <div class='time_selector_div' data-time='21:30:00' value="21:30:00">9:30pm</div>

    <div class='time_selector_div' data-time='22:00:00' value="22:00:00">10:00pm</div>
    <div class='time_selector_div' data-time='22:30:00' value="22:30:00">10:30pm</div>

    <div class='time_selector_div' data-time='23:00:00' value="23:00:00">11:00pm</div>
    <div class='time_selector_div' data-time='23:30:00' value="23:30:00">11:30pm</div>

</html>

