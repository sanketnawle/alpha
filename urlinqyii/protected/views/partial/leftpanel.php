
<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
    <script src="js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="leftpanel">
    <div class="profile">
        <div class="title">
            Profile
            <div class="menu"></div>
        </div>
        <ul>
            <li class="profile-panel">
                <a class="nostyle" href="./profile.php?user_id=<?php echo $user->user_id; ?>">
                    <img class="profile-img" src="<?php echo Yii::app()->getBaseUrl(true) . '' . $user->pictureFile->file_url ?>">
                    <div class="details">
                        <span class="name"><?php echo $user->firstname." ".$user->lastname; ?></span>
                        <!--<span class="status">
                            <img class="status-img" src="http://lorempixel.com/18/18">
                            <span class="status-msg">Online</span>
                        </span>-->
                    </div>
                </a>
            </li>
            <li><a>Department</a></li>
            <li><a>Really Long School Name</a></li>
        </ul>
        <div class="profile-menu">
            <ul>
                <li><a href="./profile.php?user_id=<?php echo $user->user_id; ?>"><div class="icon prof"></div>Your Profile</a></li>
                <li><a href="./profile.php?user_id=<?php echo $user->user_id; ?>"><div class="icon edit"></div>Edit Profile</a></li>
                <li><a href="./php/logout.php"><div class="icon sign"></div>Sign Out</a></li>
            </ul>
        </div>
    </div>
    <div class="listing">
        <div class="class scrollable <?php if(count($classes) == 0){
            echo 'min';
        } ?>">
            <div class="title">
                <div class="wedge"></div>
                Classes
            </div>
            <ul>

                <?php foreach($classes as $class){
                    echo '<li><a href="' .  Yii::app()->getBaseUrl(true) . '/class/' . $class->class_id . '">' . $class->course->course_name . '</a></li>';
                } ?>
            </ul>
        </div>

        <div class="club scrollable <?php if(count($groups) == 0){
            echo 'min';
        } ?>">

            <div class="title">
                <div class="wedge"></div>
                Clubs
            </div>
            <ul>
                <?php foreach ($groups as $group) {
                    echo '<li><a href="./clubs.php?group_id=<?php echo $gid; ?>"><?php echo $gname; ?></a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<script>
    (function($){
        $(function () {
            $(".leftpanel .scrollable .title").click(function () {
                var title = $(this);
                var clubs = $(".leftpanel .scrollable.club");
                var classes = $(".leftpanel .scrollable.class");
                (title.parents(".scrollable")[0] == classes[0] ? function () {
                    //classes.toggleClass("min");
                    // case 1: 50 50
                    if (!(classes.hasClass("full") || classes.hasClass("min"))) {
                        classes.addClass("min");
                        clubs.addClass("full");
                    } else if (classes.hasClass("min")) {
                        if (clubs.hasClass("min")) {
                            classes.removeClass("min").addClass("full");
                        } else {
                            classes.removeClass("min");
                            clubs.removeClass("full");
                        }
                    } else if (classes.hasClass("full")) {
                        classes.removeClass("full").addClass("min");
                    }
                } : function () {
                    if (!(clubs.hasClass("full") || clubs.hasClass("min"))) {
                        clubs.addClass("min");
                        classes.addClass("full");
                    } else if (clubs.hasClass("min")) {
                        if (classes.hasClass("min")) {
                            clubs.removeClass("min").addClass("full");
                        } else {
                            clubs.removeClass("min");
                            classes.removeClass("full");
                        }
                    } else if (clubs.hasClass("full")) {
                        clubs.removeClass("full").addClass("min");
                    }
                })();
            });
            $(".leftpanel .profile .title").click(function () {
                var menu = $(".menu", $(this));
                var profilemenu = $(".profile-menu", $(this).parents(".profile"));
                menu.hasClass("open") ? (function () {
                    menu.removeClass("open")
                        .css({ "background-image": "url(./img/menu-x-bar.gif?p" + new Date().getTime().toString() + ")" });
                    profilemenu.removeClass("open");
                }()) : (function () {
                    menu.addClass("open")
                        .css({ "background-image": "url(./img/menu-bar-x.gif?p" + new Date().getTime().toString() + ")" });
                    profilemenu.addClass("open");
                }());
            });
            $(".leftpanel .scrollable ul").mCustomScrollbar({
                theme: "minimal-dark",
                scrollInertia: 100
            });
        })
    })(jQuery);
</script>
</body>
</html>