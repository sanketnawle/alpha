<?php
////if(!isset($con) || is_null($con))
//include('php/dbconnection.php');
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}
//if (isset($_SESSION['user_id']))
//    $user_id = $_SESSION['user_id'];
//else
//    die();
//?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/leftmenu.css">
    
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    -->

    <link type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.jscrollpane.css" rel="stylesheet" media="all"/>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.mousewheel.js"></script>


    <script>
        $(document).ready(function () {
            var dh = $(window).height();
            ////alert(dh);
            $(".groups_list").height(dh - 100);
            $("#tray").height(dh);

            $(window).resize(function () {
                var dh = $(window).height();
                $(".groups_list").height(dh - 100);
                $("#tray").height(dh);
            });


            $(".admin-name").each(function (index) {
                var l = $(this).text().length;
                if (l > 21) {
                    $(this).text($(this).text().substring(0, 18) + "...");
                }
            });
        });
    </script>
</head>
<body>
<div id="tray" class="leftmenu">
    <div class="group_search">
        <input type="text" placeholder="Search your courses & clubs" class="search_groups" id="tray_search">
        <i class="icon_search"></i>
        <a class="join-group">
            <img class="add-icon" src='<?php echo Yii::app()->getBaseUrl(true); ?>/assets/add.png'>
        </a>
    </div>

    <div class="search-results">
    </div>

    <div class="groups_list">
        <div class="course-groups-list sub-list">
            <div class="sub-list-header">
                <span>CLASSES</span>
            </div>
            <div class="lb_group_wrap">
<!--                --><?php
                //REPLACE THIS TYPE OF CODE WITH AJAX OR RENDER PARTIAL
//                $select_stmt = $con->prepare("SELECT c.course_name, c.course_id, cs.dp_blob_id,
//																	cs.professor, cu.class_id, u.lastname
//																 FROM `courses_user` cu
//																 JOIN courses_semester cs
//																 ON (cu.class_id = cs.class_id)
//																 JOIN courses c
//																 ON (cs.course_id = c.course_id
//																 AND cs.dept_id = c.dept_id
//																 AND cs.univ_id = c.univ_id)
//																 LEFT JOIN user u
//                                                                 ON (u.user_id = cs.professor)
//																 WHERE cu.user_id = ?");
//                $select_stmt->bind_param("i", $user_id);
//                $select_stmt->execute();
//                $select_stmt->store_result();
//                $select_stmt->bind_result($cname, $cid, $cpic, $cprof, $class_id, $lastname);
//                if($select_stmt->num_rows==0){
//                  echo '<div class = "no_groups_box">
//                            <div class = "no_groups_img no_groups_img_class">
//                            </div>
//                            <h5 class = "no_groups_header">
//                                Time to sign up for classes
//                            </h5>
//                            <div class = "no_groups_join_btn_container">
//                                <!--Searches classes in your department-->
//                                <a href="https://urlinq.com/search_beta.php?q=classes" style="text-decoration:none;" target="_blank">
//                                <button class = "no_groups_join_btn">
//                                    <font color="white">Join your Classes</font>
//                                </button>
//                                </a>
//                            </div>
//                        </div>';
//                }else{
//                        while ($select_stmt->fetch()) {
//                            echo '<a href = "./class.php?class_id=' . $class_id . '" class = "group course-group">
//        												<div class = "group-pic" style = "background-image:url(' . get_dp($con, $class_id, "class") . ')"></div>
//        												<div class = "details">
//        												<div class = "group-name search_unit">' . $cname . '</div>
//        												<div class = "group-admin">
//                                                ';
//                            if (is_null($lastname) or $lastname == "") {
//                                $lastname = "TBA";
//                                echo '<span class = "admin-name search_unit">' . $lastname . '</span>';
//                            } else {
//                                echo ' <strong class = "admin-title">Professor</strong>
//                                        <span class = "admin-name search_unit">' . $lastname . '</span>
//                                      ';
//                            }
//        	                echo ' </div>
//         						</div>
//                                <div class = "badge"></div>
//                                </a>';
//                        }
//                        $select_stmt->free_result();
//                        $select_stmt->close();
//                   }
//                ?>
            </div>
        </div>
        <div class="clubs-groups-list sub-list">
            <div class="sub-list-header">
                <span>CLUBS</span>
            </div>
            <div class="lb_group_wrap">
<!--                   --><?php

                //REPLACE THIS CODE WITH AJAX OR RENDER PARTIAL
//                $club_group = array();
//                $select_stmt = $con->prepare('SELECT g.group_id, g.group_name, g.dp_blob_id
//                                                                FROM groups g
//                                                                JOIN group_users gu
//                                                                ON gu.group_id = g.group_id
//                                                                WHERE gu.user_id =?');
//                $select_stmt->bind_param("i", $user_id);
//                $select_stmt->execute();
//                $select_stmt->store_result();
//                $select_stmt->bind_result($gid, $gname, $gpic);
//                if($select_stmt->num_rows==0){
//                   echo '<div class = "no_groups_box">
//                            <div class = "no_groups_img no_groups_img_club">
//                            </div>
//                            <h5 class = "no_groups_header">
//                                Find a club that interests you
//                            </h5>
//                            <div class = "no_groups_join_btn_container">
//                                <!--Searches classes in your department-->
//                                <a href="https://urlinq.com/search_beta.php?q=clubs" style="text-decoration:none;" target="_blank">
//                                <button class = "no_groups_join_btn">
//                                    <font color="white">Join your Clubs</font>
//                                </button>
//                                </a>
//                            </div>
//                        </div>';
//                }else{
//
//
//                while ($select_stmt->fetch()) {
//                    $club_group[] = array($gid, $gname, $gpic);
//                }
//                $select_stmt->free_result();
//                $select_stmt->close();
//                foreach ($club_group as $group) {
//                        $admin_names = array();
//                        $result = $con->query("SELECT CONCAT(u.firstname,' ',u.lastname) as name
//                                                                 from user u
//                                                                 where user_id IN (SELECT gu.user_id FROM group_users gu WHERE gu.group_id = " . $group[0] . "
//                                                                 AND gu.is_admin = 1)");
//
//                        while ($gr_name = $result->fetch_array()) {
//                            $admin_names[] = $gr_name['name'];
//                        }
//                        $admin_names = implode(",", $admin_names);
//                        if (strlen($admin_names) > 120) {
//                            $admin_names = substr($admin_names, 0, 120);
//                            $admin_names .= "...";
//                        }
//                        echo '<a class = "group course-group" href="./clubs.php?group_id=' . $group[0] . '">
//                                            <div class = "group-pic" style = "background-image:url(' . get_dp($con, $group[0], "club") . ')"></div>
//                                            <div class = "details">
//                                                <div class = "group-name search_unit">' . $group[1] . '
//                                                </div>
//                                                <div class = "group-admin">
//                                                    <strong class = "admin-title">President</strong>
//                                                    <span class = "admin-name search_unit">' . $admin_names . '</span>
//                                                </div>
//                                            </div>
//                                            </a>';
//                }
//               }
//                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {

        /*
        var api = $('.groups_list').jScrollPane({
            horizontalGutter: 5,
            verticalGutter: 5,
            showArrows: false
        }).data('jsp');

        api.reinitialise();
        */

        //api.scrollToBottom();


        $(document).delegate(".search_groups", "keyup", function (e) {

            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".group").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    /*control the text prompt of the div*/
                    $(".lb_group_wrap").each(function (index) {
                        var l = $(this).find(".group").not('.hidden_result').length;
                        if (l == 0) {
                            $(this).prev(".sub-list-header").addClass("hidden_result");
                        } else {
                            $(this).prev(".sub-list-header").removeClass("hidden_result");
                        }
                    });
                    /*control the text prompt of the div end*/

                });

            } else {
                $(".hidden_result").removeClass("hidden_result");
            }

        });


    $(document).delegate(".search_groups", "keydown", function (e) {

        if (e.which == 13) {
            var q = $(".search_groups").val().trim();
            ////alert(inputval);
            if (q != "") {
                var data = 1;
                window.location = "search_beta.php?q=" + q;

            }

            return false;
        }
    });

    $(document).delegate(".icon_search", "click", function (e) {
            var q = $(".search_groups").val().trim();
            ////alert(inputval);
            if (q != "") {
                var data = 1;
                window.location = "search_beta.php?q=" + q;

            }

            return false;
    });



    });
</script>
