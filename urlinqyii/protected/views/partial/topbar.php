<!DOCTYPE html>

<html>

<head>
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.slimscroll.js"></script>

    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->getBaseUrl(true); ?>/../beta/leftpanel_beta/css/topbar.css'/>
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->getBaseUrl(true); ?>/../beta/leftpanel_beta/css/notify.css'/>
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->getBaseUrl(true); ?>/../beta/leftpanel_beta/css/leftpanel.css'/>
</head>
<body>
<div class="topbar">
    <div class="left">
        <!--<a href="./home.php" class="urlinq"></a>-->
        <a href="./" class="urlinq">
            <a class="menu active"></a>
    </div>
    <div class="right">
        <a class="notify calendar">
            <div class="button">
                <div class="day">Tue</div>
                <div class="date">9</div>
            </div>
            <div class='notify-window calendar'>
                <div class="toolbar">
                    <ul>
                        <li class="rem active" data-column="left"><div class="icon"></div></li>
                        <li class="inv" data-column="middle"><div class="icon"></div></li>
                        <li class="cal" data-link="link to somewhere"><div class="icon"></div></li>
                    </ul>
                </div>
                <div class='left column active'>
                    <div class='header'>
                        <span class='text'>Reminders</span>
                        <span class='count'>4</span>
                    </div>
                    <ul>
                        <li class="unseen">
                            <div class='icon exam'><div class='day'>Sep</div><div class="date">12</div></div>
                            <div class='content'>Study For Exam</div>
                            <div class='footer'>1 Week Away &bull; CS Exam</div>
                        </li>
                        <li>
                            <div class='icon club'><div class='day'>Sep</div><div class="date">11</div></div>
                            <div class='content'>Study For Exam</div>
                            <div class='footer'>1 Week Away &bull; CS Exam</div>
                        </li>
                        <li>
                            <div class='icon class'><div class='day'>Sep</div><div class="date">9</div></div>
                            <div class='content'>Study For Exam</div>
                            <div class='footer'>1 Week Away &bull; CS Exam</div>
                        </li>
                        <li>
                            <div class='icon event'><div class='day'>Sep</div><div class="date">1</div></div>
                            <div class='content'>Study For Exam</div>
                            <div class="checkbox_wrapper">
                                <input type="checkbox" name="event1" id="e1" value="#event_data1">
                                <label for="e1" id="label1"></label>
                            </div>
                        </li>
                        <li>
                            <div class="nostyle">No New Event Reminders</div>
                        </li>
                    </ul>
                </div>

                <div class='middle column'>
                    <div class='header'>
                        <span class='text'>Suggested/Invited</span>
                        <span class='count'>2</span>
                    </div>
                    <ul>
                        <li>
                            <div class='icon' style="background-image: url(http://lorempixel.com/50/50?id=1)">
                                <div class="day">Sep</div><div class="date">12</div>
                            </div>
                            <div class='content'>Study For Exam</div>
                            <div class='action add' title="Add to Calendar"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; Jake Invited you</div>
                        </li>

                        <li>
                            <div class='icon' style="background-image: url(http://lorempixel.com/50/50?id=2)">
                                <div class="day">Sep</div><div class="date">12</div>
                            </div>
                            <div class='content'>Study For Exam</div>
                            <div class='action add busy' title="Busy at this time"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; In Biosensor CS3441</div>
                        </li>
                        <li>
                            <div class="nostyle">no new event invitations</div>
                        </li>
                    </ul>
                </div>
                <div class='right column'>
                    <ul>
                        <li><div class='icon mc'></div>Monthly Calendar</li>
                        <li><div class='icon wc'></div>Weekly Calendar</li>
                        <li class="underline"><div class='icon pl'></div>Add New Event</li>
                    </ul>
                </div>
            </div>
        </a>
        <a class="notify board">
            <div class="button">
                <div class="icon"></div>
            </div>
            <div class='notify-window board' style="display: none">
                <div class="toolbar">
                    <ul>
                        <li class="dis active" data-column="left"><div class="icon"></div></li>
                        <li class="fil" data-column="middle"><div class="icon"></div></li>
                        <li class="fol" data-column="right"><div class="icon"></div></li>
                    </ul>
                </div>
                <div class='column left active'>
                    <div class='header'>
                        <span class='text'>Discussions</span>
                        <span class='count count-blue'>2</span>
                    </div>
                    <ul class='cn_sec_content'>
                        <li>
                            <div class='icon' style="background-image: url(http://lorempixel.com/50/50)"></div>
                            <div class='content'><span>Professor Lai</span> made an announcement in <span>Biosensor and Entrepreneurship</span></div>
                            <div class='footer'>September 10 at 5:00pm</div>
                        </li>
                        <li>
                            <div class="nostyle">No New Post Notifications</div>
                        </li>
                    </ul>
                </div>

                <div class='column middle'>
                    <div class='header'>
                        <span class='text'>Files</span>
                        <span class='count count-blue'>2</span>
                    </div>
                    <ul>
                        <li>
                            <div class='icon pdf'><div class='file'>.PDF</div></div>
                            <div class='content'>File Name</div>
                            <div class='action down' title="Download"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; Jake Lazarus</div>
                        </li>
                        <li>
                            <div class='icon doc'><div class='file'>.DOC</div></div>
                            <div class='content'>File Name</div>
                            <div class='action down' title="Download"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; Jake Lazarus</div>
                        </li>
                        <li>
                            <div class='icon xls'><div class='file'>.XLS</div></div>
                            <div class='content'>File Name</div>
                            <div class='action down' title="Download"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; Jake Lazarus</div>
                        </li>
                        <li>
                            <div class='icon ppt'><div class='file'>.PPT</div></div>
                            <div class='content'>File Name</div>
                            <div class='action down' title="Download"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; Jake Lazarus</div>
                        </li>
                        <li>
                            <div class='icon zip'><div class='file'>.ZIP</div></div>
                            <div class='content'>File Name</div>
                            <div class='action down' title="Download"><div class="icon"></div></div>
                            <div class='footer'>1 Week Away &bull; Jake Lazarus</div>
                        </li>
                        <li>
                            <div class="nostyle">no new event invitations</div>
                        </li>
                    </ul>
                </div>
                <div class='column right'>
                    <div class='header'>
                        <span class='text'>Followers</span>
                        <span class='count count-blue'>1</span>
                    </div>
                    <ul>
                        <li>
                            <div class='icon full' style='background-image:url(http://lorempixel.com/50/50?dm.jpg);'></div>
                            <div class='content two-lines'>
                                <div class='line1'>Ross Kopelman</div>
                                <div class='line2'><div class="follow">Follow</div></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </a>
    </div>
    <div class="center">
        <!--<form method="get" action="./search_beta.php">-->
        <form method ="get" action="<?php echo Yii::app()->getBaseUrl(true); ?>/search">
            <input type="text" name="q" class="mainsearch text" autocomplete="off" placeholder="Search courses, clubs, and people">
            <button type="submit" class="submit"></button>
        </form>
        <ul class="prelist">
            <li><a><div class="icon dpt"></div><span>Professors in Your Department</span></a></li>
            <li><a><div class="icon crs"></div><span>Courses in Your Department</span></a></li>
            <li><a><div class="icon prof"></div><span>Professors in Your School</span></a></li>
            <li><a><div class="icon crs"></div><span>Courses in Your School</span></a></li>
            <li><a><div class="icon clb"></div><span>Clubs in Your School</span></a></li>
            <li><a><div class="icon sch"></div><span>Search Your School</span></a></li>
        </ul>
        <ul class="postlist">

        </ul>
    </div>
</div>



<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/lptopbar.js"></script>
</body>
</html>


