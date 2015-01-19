<!DOCTYPE html>

<html>

<head>
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.slimscroll.js"></script>


    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/top_bar.js"></script>

    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/topbar/topbar.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/topbar/notify.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel/leftpanel.css' />



</head>
<body>
    <div class="topbar">
        <div id = "topbar_responsive_holder">
            <div class="left">
                <!--<a href="./home.php" class="urlinq"></a>-->
                <a href="<?php echo Yii::app()->getBaseUrl(true); ?>" class="urlinq"><span></span></a>
            </div>
            <div class="center">
                <!--<form method="get" action="./search_beta.php">-->
                <form method="get" action="<?php echo Yii::app()->getBaseUrl(true); ?>/search">
                    <input type="text" name="q" class="mainsearch text" autocomplete="off" placeholder="Search courses, clubs, and people">
                    <button type="submit" class="submit"></button>
                </form>
                <ul class="prelist">
                    <li>
                        <a>
                            <div class="icon dpt"></div>
                            <span><?php echo $department?> Professors</span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="icon crs"></div>
                            <span>Courses in the <?php echo $department?> Department</span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="icon prof"></div>
                            <!--<span>Professors in Your School</span>-->
                            <span>Professors at The <?php echo $school?></span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="icon crs"></div>
                            <span>Courses at The <?php echo $school?></span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="icon clb"></div>
                            <!--<span>Clubs at The <?php echo $school?></span>-->
                            <span>Clubs Your Friends Are In</span>
                        </a>
                    </li>
                    <li>
                        <a>
                            <div class="icon sch"></div>
                            <span>Search Your School</span>
                        </a>
                    </li>
                </ul>
                <ul class="postlist"></ul>
            </div>        

            <div class="right">
                <div class="notify calendar">
                    <div class="button">
                        <div class="icon"></div>
                        <div class = "icon_text">Reminders</div>
                    </div>
                    <div class="notify-window">
                        <div class="wedge"></div>
                        <div class="window">
                            <div class="header">Invitations and Reminders</div>
                            <ul class="entries">
                                <li class="eve">
                                    <div class="icon"></div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="follow btn">Add to calendar</div>
                                            <div class="dismiss">Dismiss</div>
                                            <div class="close"></div>
                                        </div>
                                        <div class="message">Rachel Borowitz invited you to  the event, Cheese Club Bake Sale.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">10 mins ago</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="tdo">
                                    <div class="icon text">
                                        <div>Exam</div>
                                    </div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="dismiss">Dismiss</div>
                                            <div class="close"></div>
                                        </div>
                                        <div class="message">In 1 week, you have a Supply and Demand Exam in the class, Principles of Economics.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">1 day ago</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="tdo">
                                    <div class="icon date">
                                        <div class="month">Nov</div>
                                        <div class="day">20</div>
                                    </div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="dismiss">Dismiss</div>
                                            <div class="close"></div>
                                        </div>
                                        <div class="message">On Thursday, you have a reading due in the class, Principles of Economics.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">1 day ago</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="eve done">
                                    <div class="icon" style="background-image: url(http://lorempixel.com/34/34?1)"></div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="follow msg">Event Added</div>
                                        </div>
                                        <div class="message">MapReduce Gene Analysis was added to Computational Biology's calendar.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">1 hour ago</div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="footer">
                                <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/calendar">
                                    See full calendar
                                    <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/leftpanel/go-arrow.png">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="notify board">
                    <div class="button">
                        <div class="icon"></div>
                        <div class = "icon_text">Notifications</div>
                    </div>
                    <div class="notify-window">
                        <div class="wedge"></div>
                        <div class="window">
                            <div class="header">Notifications</div>
                            <ul class="entries">
                                <li class="per">
                                    <div class="icon" style="background-image: url(http://lorempixel.com/34/34?1)"></div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="follow btn">Follow</div>
                                            <div class="dismiss">Dismiss</div>
                                            <div class="close"></div>
                                        </div>
                                        <div class="message">Shaleen Smith is now following you.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">10 mins ago</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="inf">
                                    <div class="icon" style="background-image: url(http://lorempixel.com/34/34?2)"></div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="dismiss">Dismiss</div>
                                            <div class="close"></div>
                                        </div>
                                        <div class="message">Professor Wolfram has made an announcement in your class, Theories of the French Republic.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">1 day ago</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="qus done">
                                    <div class="icon" style="background-image: url(http://lorempixel.com/34/34?3)"></div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="dismiss">Dismiss</div>
                                            <div class="close"></div>
                                        </div>
                                        <div class="message">Jenna Appleseed has asked a question in your class, Computational Biology.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">1 day ago</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="per done">
                                    <div class="icon"></div>
                                    <div class="content">
                                        <div class="right">
                                            <div class="follow msg">Following</div>
                                        </div>
                                        <div class="message">Dante Aligheri is now following you.</div>
                                        <div class="time">
                                            <div class="icon"></div>
                                            <div class="stamp">1 hour ago</div>
                                        </div>
                                    </div>
                                </li>
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

</body>
</html>

