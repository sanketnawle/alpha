<!DOCTYPE html>

<html>

<head>
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/moment.js" > </script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.slimscroll.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/top_bar.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/notifications.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/lptopbar.js"></script>




    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/topbar/topbar.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/topbar/notify.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel/leftpanel.css' />
</head>
<body>
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
                        <div class = "icon_text">Notifications</div>
                    </div>









                    <div class="notify-window" id="notifications" style="display: none;">
                        <div class="wedge"></div>
                        <div class="window">
                            <div class="header">Notifications</div>
                            <ul class="entries">







                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class = "calendar_link">
            <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/calendar" >
                <div class = "calendar_icon">
                </div>
                <div class = "quick_cal_arrow">
                </div>
            </a>
        </div>
    </div>

<script id="search_result_template" type="text/x-handlebars-template">

        <li class="search_result" data-origin_type='{{origin_type}}'>
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
    <li class="per notification" data-id='{{notification_id}}' data-type="{{type}}" data-status='{{status}}'>
        <div class="icon" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true); ?>{{actor.pictureFile.file_url}}')"></div>
        <div class="content">
            <div class="right">
                {{#ifCond type '==' 'follow'}}
                    {{#if following_back}}
                        <div class="follow msg">Following</div>
                    {{else}}
                        <div class="follow btn">Follow</div>
                    {{/if}}
                {{/ifCond}}

                <div class="dismiss">Dismiss</div>
                <div class="close"></div>
            </div>


            {{#ifCond type '==' 'follow'}}
                <div class="message">{{actor.firstname}} {{actor.lastname}} is now following you.</div>
            {{/ifCond}}

            {{#ifCond type '==' 'like'}}
                <div class="message">{{actor.firstname}} {{actor.lastname}} liked your post: {{origin.text}}</div>
            {{/ifCond}}

            {{#ifCond type '==' 'reply'}}
                <div class="message">{{actor.firstname}} {{actor.lastname}} replied to your post: {{origin.reply_msg}}</div>
            {{/ifCond}}

            {{#ifCond type '==' 'post'}}
                <div class="message">{{actor.firstname}} {{actor.lastname}} posted{{#if origin.post_origin}} in {{origin.post_origin.name}}{{/if}}: {{origin.text}}</div>
            {{/ifCond}}

            {{#ifCond type '==' 'invite'}}
                {{#ifCond origin_type '==' 'event'}}
                    <div class="message">{{actor.firstname}} {{actor.lastname}} invited you to the event {{origin.title}}</div>

                    {{#ifCond invite_choice '==' 0}}
                        <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'>Add to calendar</div>
                    {{else}}
                        <div class="message">Added to calendar</div>
                    {{/ifCond}}
                {{/ifCond}}

                {{#ifCond origin_type '==' 'class'}}
                    <div class="message">{{actor.firstname}} {{actor.lastname}} invited you to the class {{origin.class_name}}</div>

                    {{#ifCond invite_choice '==' 0}}
                        <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'>Join class</div>
                    {{else}}
                        <div class="message">Member</div>
                    {{/ifCond}}

                {{/ifCond}}

                {{#ifCond origin_type '==' 'club'}}
                    <div class="message">{{actor.firstname}} {{actor.lastname}} invited you to the club {{origin.group_name}}</div>

                    {{#ifCond invite_choice '==' 0}}
                        <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'>Join club</div>
                    {{else}}
                        <div class="message">Member</div>
                    {{/ifCond}}
                {{/ifCond}}

                {{#ifCond origin_type '==' 'group'}}
                    <div class="message">{{actor.firstname}} {{actor.lastname}} invited you to the group {{origin.group_name}}</div>

                    {{#ifCond invite_choice '==' 0}}
                        <div class="accept_invite_button" data-invite_id='{{invite_id}}' data-origin_type='{{origin_type}}' data-origin_id='{{origin_id}}'>Join group</div>
                    {{else}}
                        <div class="message">Member</div>
                    {{/ifCond}}
                {{/ifCond}}

            {{/ifCond}}


            {{#ifCond type '==' 'announcement'}}
                <div class="message">Professor {{actor.lastname}} has made an announcement in your class, {{origin.class_name}}</div>
            {{/ifCond}}

            <div class="time">
                <div class="icon"></div>
                <div class="stamp">{{formatted_created_time}}</div>
            </div>
        </div>
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

