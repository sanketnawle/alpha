<!DOCTYPE html>

<html>

<head>
    <title></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/semantic/packaged/css/semantic.min.css">
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/onboard_files/semantic/packaged/javascript/semantic.min.js"></script>

    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js" > </script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.slimscroll.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/top_bar.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/notifications.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/lptopbar.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,900italic,900,700italic,700,500italic,500,400italic,300italic,300,100italic,100' rel='stylesheet' type='text/css'>



    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/topbar/topbar.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/topbar/notify.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel/leftpanel.css' />
</head>
<body>

    <script id="circle_template" type="text/x-handlebars-template">
        <div class="circle" style = "background:{{color.hex}};" data-class_count ="{{class_count}}">
            <h5>{{department_name}}</h5>
            <div class = "courses_popout">
                {{#each classes}}
                <div class = "circle_classes_item"> 
                   <span class = "circle_class_name">{{class_name}}</span>
                   <div class = "circle_class_detail_container">
                       <span class = "circle_class_component">{{component}}</span>
                       <span class = "circle_class_semester">{{semester}}</span>
                       <span class = "circle_class_year">{{year}}</span>
                   </div>
                </div>
                {{/each}}
            </div>
        </div>
    </script>

    <div class="topbar">
        <div id = "topbar_responsive_holder">
            <div class="left">
                <!--<a href="./home.php" class="urlinq"></a>-->
                <div class = "menu_hider menu_shown">
                    <div class = "menu_hider_icon"></div>
                </div>
                <a href="<?php echo Yii::app()->getBaseUrl(true); ?>" class="urlinq"><span></span></a>
            </div>
            <div class="center">
                <!--<form method="get" action="./search_beta.php">-->
                <form method="get" action="<?php echo Yii::app()->getBaseUrl(true); ?>/search" class = "top_search_bar_form">
                    <input type="text" id="top_search_bar" name="q" class="mainsearch text" autocomplete="off" placeholder="Look up classes, clubs, and people">
                    <button type="submit" class="submit"></button>
                </form>
                <ul class="prelist">






<!--                    <li class="search_preview">-->
<!--                        <a>-->
<!--                            <div class="icon dpt" style="background-image: url(--><?php //echo  Yii::app()->getBaseUrl(true) . $user->department->pictureFile->file_url; ?><!--);"></div>-->
<!--                            <span>--><?php //echo $department?><!-- Professors</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!---->
<!--                    <li class="search_preview">-->
<!--                        <a>-->
<!--                            <div class="icon crs" style="background-image: url(--><?php //echo  Yii::app()->getBaseUrl(true) . $user->department->pictureFile->file_url; ?><!--);"></div>-->
<!--                            <span>Courses in the --><?php //echo $user->department->department_name; ?><!-- Department</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="search_preview">-->
<!--                        <a>-->
<!--                            <div class="icon prof" style="background-image: url(--><?php //echo  Yii::app()->getBaseUrl(true) . $user->department->pictureFile->file_url; ?><!--);"></div>-->
<!--                            <!--<span>Professors in Your School</span>-->
<!--                            <span>Professors at The --><?php //echo $school?><!--</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="search_preview">-->
<!--                        <a>-->
<!--                            <div class="icon crs" style="background-image: url(--><?php //echo  Yii::app()->getBaseUrl(true) . $user->department->pictureFile->file_url; ?><!--);"></div>-->
<!--                            <span>Courses at The --><?php //echo $school?><!--</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="search_preview">-->
<!--                        <a>-->
<!--                            <div class="icon clb" style="background-image: url(--><?php //echo  Yii::app()->getBaseUrl(true) . $user->department->pictureFile->file_url; ?><!--);"></div>-->
<!--                            <!--<span>Clubs at The --><?php //echo $school?><!--</span>-->
<!--                            <span>Clubs Your Friends Are In</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="search_preview">-->
<!--                        <a>-->
<!--                            <div class="icon sch" style="background-image: url(--><?php //echo  Yii::app()->getBaseUrl(true) . $user->department->pictureFile->file_url; ?><!--);"></div>-->
<!--                            <span>Search Your School</span>-->
<!--                        </a>-->
<!--                    </li>-->
                </ul>
                <ul class="postlist"></ul>
            </div>        

            <div class="right">
                <div class="notify board">
                    <div class="button">
                        <div class="icon"></div>
                        <div class = "icon_text">Notices<div id='new_notification_count'></div></div>
                    </div>









                    <div class="notify-window" id="notifications" style="display: none;">
                        <div class="wedge"></div>
                        <div class="window">
                            <div class="header">Notices</div>
                            <span class = "noti_header_hint">Notifications and reminders</span>
                            <div class = "noti-scrollable">
                                <ul class="entries">







                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class = "topbar_profile_link profile_link" data-user_id="<?php echo $user->user_id?>">
                    <div class = "topbar_profile_picture" style="background-image:url(<?php echo Yii::app()->getBaseUrl(true) . $user->pictureFile->file_url; ?>)"></div>
                    <div class = "icon_text">Me</div>
                </div>

            </div>
        </div>
        <div class = "calendar_link">
            <a class = "calendar_link_wrap" href="<?php echo Yii::app()->getBaseUrl(true); ?>/calendar" >
                <h5>Calendar</h5>
                <div class = "quick_cal_arrow">
                </div>
            </a>
        </div>





        <?php
            //If this user went thru onboarding
            //and has not verified their email yet, show a msg
            if($user->status == 'onboarded'){
        ?>

            <?php
                $mail_link = 'http://mail.google.com/a/nyu.edu';
                if($user->university_id == 4){
                    $mail_link = 'https://mytouro.touro.edu/cas/login?service=https%3A%2F%2Fmytouro.touro.edu%2Fpaf%2Fauthorize';
                }
            ?>


            <div id="verify_email_banner">Verify your email <a class = "verify_button" href="<?php echo $mail_link; ?>">here</a></div>
            <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/verify_email_banner.css' rel='stylesheet' type='text/css'>


        <?php
            }
        ?>


    </div>

<script id="search_result_template" type="text/x-handlebars-template">



        <li class="search_result" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}">

            {{#ifCond origin_type '==' 'user'}}
                <a class='profile_link' data-user_id='{{user_id}}' >
                <span>{{origin_name}}</span>
                <div class="icon dpt search_result_icon" style="background-image: url('<?php echo  Yii::app()->getBaseUrl(true); ?>{{pictureFile.file_url}}');"></div>
            {{else}}
                <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/{{origin_type}}/{{origin_id}}" >
                <span>{{origin_name}}</span>
                <div class = "search_result_icon non_profile_icon"></div>
            {{/ifCond}}
            </a>
        </li>
    </script>

</body>












<script id='notification_template' type="text/x-handlebars-template">



    {{#if origin.post_origin}}
        <li class="per notification notification_link" data-url='<?php echo Yii::app()->getBaseUrl(true); ?>/{{origin.origin_type}}/{{origin.origin_id}}' data-id='{{notification_id}}' data-type="{{type}}" data-status='{{status}}'>

    {{else}}
        <li class="per notification" data-id='{{notification_id}}' data-type="{{type}}" data-status='{{status}}'>
    {{/if}}


        {{#ifCond origin.anon '==' '1'}}
            <div class="icon" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true); ?>/assets/avatars/9.png')"></div>
        {{else}}
            <div class="icon" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true); ?>{{actor.pictureFile.file_url}}')"></div>
        {{/ifCond}}


        <div class="close delete_notification"><span class = "close_text">hide</span></div>
        <div class="content">
                {{#ifCond type '==' 'follow'}}


                    {{#if following_back}}
                    <div class = "right">
                        <div class = "suggestion_btn_wrapper notification_follow_button following">
                            <span class = "follow_icon following"></span>Following
                        </div>
                    </div>
                    {{else}}
                    <div class = "right">
                        <div class = "suggestion_btn_wrapper notification_follow_button">
                            <a role = "button" class = "suggested_user_follow_button" data-user_id={{origin.user_id}}>
                                <span class = "follow_icon"></span>Follow
                            </a>
                        </div>
                        <!--<div class="follow btn">Follow</div>-->
                    </div>
                    {{/if}}
                {{/ifCond}}

                {{#ifCond type '==' 'follow'}}
                    <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> is now following you.</div>
                {{/ifCond}}

                {{#ifCond type '==' 'like'}}
                    <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> liked your post.</div>
                {{/ifCond}}

                {{#ifCond type '==' 'reply'}}

                    {{#ifCond origin.user_id '==' '<?php echo $user->user_id; ?>'}}
                        <div class="message full"><span class = "actor_name">{{#ifCond origin.anon '==' '1'}}Anonymous{{else}}{{actor.firstname}} {{actor.lastname}}{{/ifCond}}</span> replied to your post{{#if origin.post_origin}} in <span class = "actor_name">{{origin.post_origin.name}}{{/if}}</span></div>
                    {{else}}
                        <div class="message full"><span class = "actor_name">{{#ifCond origin.anon '==' '1'}}Anonymous{{else}}{{actor.firstname}} {{actor.lastname}}{{/ifCond}}</span> replied to a post{{#if origin.post_origin}} in <span class ="actor_name">{{origin.post_origin.name}}{{/if}}</span></div>
                    {{/ifCond}}
                {{/ifCond}}

                {{#ifCond type '==' 'post'}}
                    {{#ifCond origin.post_type '==' 'event'}}
                        <div class="message"><span class = "actor_name">{{#ifCond origin.anon '==' '1'}}Anonymous{{else}}{{actor.firstname}} {{actor.lastname}}{{/ifCond}}</span> posted the event <span class = "actor_name">{{event.title}}</span> {{#if origin.post_origin}} to <span class = "actor_name">{{origin.post_origin.name}}</span>{{/if}}</div>

                        {{#if event.attending}}
                        <div class = "right">
                            <div class="message event_added"><span class="added_to_cal_icon"></span>Added</div>
                        </div>
                        {{else}}
                        <div class = "right">
                            <div class="add_to_calendar_button" data-event_id='{{event.event_id}}'><span class="add_to_cal_icon"></span>Add to Cal</div>
                        </div>
                        {{/if}}
                    {{else}}
                        <div class="message full"><span class = "actor_name">{{#ifCond origin.anon '==' '1'}}Anonymous{{else}}{{actor.firstname}} {{actor.lastname}}{{/ifCond}}</span> posted{{#if origin.post_origin}} in <span class = "actor_name"><a class = 'noti_group_name' href='<?php echo Yii::app()->getBaseUrl(true); ?>/{{origin.origin_type}}/{{origin.origin_id}}'>{{origin.post_origin.name}}</a></span>{{/if}}</div>
                    {{/ifCond}}

                {{/ifCond}}

                {{#ifCond type '==' 'invite'}}
                    {{#ifCond origin_type '==' 'event'}}
                        <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> invited you to <span class = "actor_name">{{origin.title}}</span></div>

                        {{#ifCond invite_choice '==' 0}}
                        <div class = "right">
                            <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'><span class="add_to_cal_icon"></span>Add to Cal</div>
                        </div>
                        {{else}}
                        <div class = "right">
                            <div class="message event_added"><span class="added_to_cal_icon"></span>Added</div>
                        </div>
                        {{/ifCond}}
                    {{/ifCond}}

                    {{#ifCond origin_type '==' 'class'}}
                        <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> invited you to the class, <span class = "actor_name">{{origin.class_name}}</span></div>

                        {{#ifCond invite_choice '==' 0}}
                        <div class = "right">
                            <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'><span class = "join_group_icon"></span>Join class</div>
                        </div>
                        {{else}}
                        <div class = "right">
                            <div class="message member">Member</div>
                        </div>
                        {{/ifCond}}

                    {{/ifCond}}

                    {{#ifCond origin_type '==' 'club'}}
                        <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> invited you to join <span class = "actor_name">{{origin.group_name}}</span></div>

                        {{#if accepted}}
                        <div class = "right">
                            <div class="message member">Member</div>
                        </div>
                        {{else}}
                        <div class = "right">
                            <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'><span class = "join_group_icon"></span>Join group</div>
                        </div>
                        {{/if}}
                    {{/ifCond}}

                    {{#ifCond origin_type '==' 'group'}}
                        <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> invited you to join <span class = "actor_name">{{origin.group_name}}</span></div>

                        {{#ifCond invite_choice '==' 0}}
                        <div class = "right">
                            <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'><span class = "join_group_icon"></span>Join</div>
                        </div>
                        {{else}}
                        <div class = "right">
                            <div class="message member">Member</div>
                        </div>
                        {{/ifCond}}
                    {{/ifCond}}

                {{/ifCond}}


                {{#ifCond type '==' 'event'}}
                    <div class="message"><span class = "actor_name">{{actor.firstname}} {{actor.lastname}}</span> created the event <span class = "actor_name">{{origin.title}}</span> in <span class ="actor_name"><a href='<?php echo Yii::app()->getBaseUrl(true); ?>/{{origin.origin_type}}/{{origin.origin_id}}'>{{origin.event_origin.name}}</a></span></div>
                {{/ifCond}}


                {{#ifCond type '==' 'announcement'}}
                    <div class="message"><span class = "actor_name">Professor {{actor.lastname}}</span> has made an announcement in your class, <span class = "actor_name">{{origin.class_name}}</span></div>
                {{/ifCond}}

            <div class="time">
                <div class="icon"></div>
                <div class="stamp">{{formatted_created_time}}</div>
            </div>
        </div>

        {{#if origin.post_origin}}
            </a>
        {{/if}}
    </li>





</script>


<!--  <li class="per">-->
<!--        <div class="icon" style="background-image: url(http://lorempixel.com/34/34?1)"></div>-->
<!--        <div class="content">-->
<!--            <div class="right">-->
<!--                <div class="follow btn">Follow</div>-->
<!--                <div class="dismiss">Dismiss</div>-->
<!--                <div class="close"></div>-->
<!--            </div>-->
<!--            <div class="message">Shaleen Smith is now following you.</div>-->
<!--            <div class="time">-->
<!--                <div class="icon"></div>-->
<!--                <div class="stamp">10 mins ago</div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </li>-->
<!---->
<!---->
<!---->
<!--    <li class="inf">-->
<!--        <div class="icon" style="background-image: url(http://lorempixel.com/34/34?2)"></div>-->
<!--        <div class="content">-->
<!--            <div class="right">-->
<!--                <div class="dismiss">Dismiss</div>-->
<!--                <div class="close"></div>-->
<!--            </div>-->
<!--            <div class="message">Professor Wolfram has made an announcement in your class, Theories of the French Republic.</div>-->
<!--            <div class="time">-->
<!--                <div class="icon"></div>-->
<!--                <div class="stamp">1 day ago</div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </li>-->
<!---->
<!---->
<!--    <li class="qus done">-->
<!--        <div class="icon" style="background-image: url(http://lorempixel.com/34/34?3)"></div>-->
<!--        <div class="content">-->
<!--            <div class="right">-->
<!--                <div class="dismiss">Dismiss</div>-->
<!--                <div class="close"></div>-->
<!--            </div>-->
<!--            <div class="message">Jenna Appleseed has asked a question in your class, Computational Biology.</div>-->
<!--            <div class="time">-->
<!--                <div class="icon"></div>-->
<!--                <div class="stamp">1 day ago</div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </li>-->
<!---->
<!---->
<!---->
<!--    <li class="per done">-->
<!--        <div class="icon"></div>-->
<!--        <div class="content">-->
<!--            <div class="right">-->
<!--                <div class="follow msg">Following</div>-->
<!--            </div>-->
<!--            <div class="message">Dante Aligheri is now following you.</div>-->
<!--            <div class="time">-->
<!--                <div class="icon"></div>-->
<!--                <div class="stamp">1 hour ago</div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </li>-->




<!--                                <li class="eve">-->
<!--                                    <div class="icon"></div>-->
<!--                                    <div class="content">-->
<!--                                        <div class="right">-->
<!--                                            <div class="follow btn">Add to calendar</div>-->
<!--                                            <div class="dismiss">Dismiss</div>-->
<!--                                            <div class="close"></div>-->
<!--                                        </div>-->
<!--                                        <div class="message">Rachel Borowitz invited you to  the event, Cheese Club Bake Sale.</div>-->
<!--                                        <div class="time">-->
<!--                                            <div class="icon"></div>-->
<!--                                            <div class="stamp">10 mins ago</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!---->
<!---->
<!--                                <li class="tdo">-->
<!--                                    <div class="icon text">-->
<!--                                        <div>Exam</div>-->
<!--                                    </div>-->
<!--                                    <div class="content">-->
<!--                                        <div class="right">-->
<!--                                            <div class="dismiss">Dismiss</div>-->
<!--                                            <div class="close"></div>-->
<!--                                        </div>-->
<!--                                        <div class="message">In 1 week, you have a Supply and Demand Exam in the class, Principles of Economics.</div>-->
<!--                                        <div class="time">-->
<!--                                            <div class="icon"></div>-->
<!--                                            <div class="stamp">1 day ago</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--                                <li class="eve done">-->
<!--                                    <div class="icon" style="background-image: url(http://lorempixel.com/34/34?1)"></div>-->
<!--                                    <div class="content">-->
<!--                                        <div class="right">-->
<!--                                            <div class="follow msg">Event Added</div>-->
<!--                                        </div>-->
<!--                                        <div class="message">MapReduce Gene Analysis was added to Computational Biology's calendar.</div>-->
<!--                                        <div class="time">-->
<!--                                            <div class="icon"></div>-->
<!--                                            <div class="stamp">1 hour ago</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->


</html>

