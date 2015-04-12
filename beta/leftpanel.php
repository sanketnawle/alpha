<?php
//if(!isset($con) || is_null($con))
require_once('includes/common_functions.php');
include('php/dbconnection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    
}
if (isset($_SESSION['user_id']))
    $dp_link = get_dp($con, $_SESSION['user_id'], "user");
    $user_id = $_SESSION['user_id'];
    if(isset($user_id)){
        if(!is_null($user_id) AND !trim($user_id)==""){
            $p_query = $con->prepare("SELECT firstname, lastname FROM user WHERE user_id = ?");
            
            if($p_query){
                $p_query->bind_param('i',$user_id);
                if($p_query->execute()){
                    $p_query->bind_result($firstname1, $lastname1);
                    $p_query->fetch();
                    $p_query->close();
                }
                else die("Aw Snap! No such user exists....");
            }
            else die("Aw Snap! No such user exists....");
        }
        else die("Aw Snap! No such user exists....");
    }
else
    die();
?>
<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>    
    <script src="scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="scroll/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    <link href="css/leftpanel.css" rel="stylesheet" type="text/css">
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
                    <a class="nostyle" href="./profile.php?user_id=<?php echo $user_id; ?>">
                        <img class="profile-img" src="<?php echo $dp_link; ?>">
                        <div class="details">
                            <span class="name"><?php echo $firstname1." ".$lastname1; ?></span>
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
                    <li><a href="./profile.php?user_id=<?php echo $user_id; ?>"><div class="icon prof"></div>Your Profile</a></li>
                    <li><a href="./profile.php?user_id=<?php echo $user_id; ?>"><div class="icon edit"></div>Edit Profile</a></li>
                    <li><a href="./php/logout.php"><div class="icon sign"></div>Sign Out</a></li>
                </ul>
            </div>
        </div>
        <div class="listing">
            <?php
                $select_stmt = $con->prepare("SELECT c.course_name, cu.class_id FROM `courses_user` cu 
                                              JOIN courses_semester cs ON (cu.class_id = cs.class_id) 
                                              JOIN courses c 
                                                ON (cs.course_id = c.course_id AND cs.dept_id = c.dept_id AND cs.univ_id = c.univ_id) 
                                              WHERE cu.user_id = ?");
                $select_stmt->bind_param("i", $user_id);
                $select_stmt->execute();
                $select_stmt->store_result();
                $select_stmt->bind_result($cname, $cid);                
            ?>
            <div class="class scrollable <?php echo $select_stmt->num_rows==0?"min":""; ?>">
                <div class="title">
                    <div class="wedge"></div>
                    Classes
                </div>
                <ul>
                <?php while($select_stmt->fetch()) { ?>
                    <li><a href="./class.php?class_id=<?php echo $cid; ?>"><?php echo $cname; ?></a></li>
                <?php }
                    $select_stmt->free_result();
                    $select_stmt->close();
                ?>
                </ul>
            </div>
            <?php                
                $select_stmt = $con->prepare('SELECT g.group_id, g.group_name FROM groups g
                                              JOIN group_users gu ON gu.group_id = g.group_id
                                              WHERE gu.user_id =?');
                $select_stmt->bind_param("i", $user_id);
                $select_stmt->execute();
                $select_stmt->store_result();
                $select_stmt->bind_result($gid, $gname);
            ?>
            <div class="club scrollable <?php echo $select_stmt->num_rows==0?"min":""; ?>">
                <div class="title">
                    <div class="wedge"></div>
                    Clubs
                </div>
                <ul>
                <?php while($select_stmt->fetch()) { ?>
                    <li><a href="./clubs.php?group_id=<?php echo $gid; ?>"><?php echo $gname; ?></a></li>
                <?php }
                    $select_stmt->free_result();
                    $select_stmt->close();
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