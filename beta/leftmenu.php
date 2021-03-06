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
            $p_query = $con->prepare("SELECT user_email, user_type, firstname, lastname, univ_id, dept_id, user_bio, status FROM user WHERE user_id = ?");
            
            if($p_query){
                $p_query->bind_param('i',$user_id);
                if($p_query->execute()){
                    $p_query->bind_result( $user_email, $user_type, $firstname1, $lastname1, $univ_id, $dept_id, $user_bio, $status);
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
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="leftmenu.css">
    
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    -->

    <link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all"/>
    <!--<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>-->
    <script type="text/javascript" src="scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link type="text/css" rel="stylesheet" href="scroll/jquery.mCustomScrollbar.css">


    <script>
        $(document).ready(function () {
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
    <!--<div class="group_search">
        <input type="text" placeholder="Search your courses & clubs" class="search_groups" id="tray_search">
        <i class="icon_search"></i>
        <a class="join-group">
            <img class="add-icon" src='img/add.png'>
        </a>
    </div>


    <div class="search-results">
    </div>-->
    <div class="sub-list-header">
        <span id="myClasses" class="filters">CLASSES</span>  <span id="myClubs" class="filters">ORGANIZATIONS/GROUPS</span>
    </div>
    <div class="groups_list">
        <div class="scrollable-content" style="height: 100%; max-height: 100%; overflow: auto;">
          <div class="course-groups-list sub-list">
            <div class="lb_group_wrap" id="theClasses">
                <?php
                $select_stmt = $con->prepare("SELECT c.course_name, c.course_id, cs.dp_blob_id,
																	cs.professor, cu.class_id, u.lastname
																 FROM `courses_user` cu
																 JOIN courses_semester cs
																 ON (cu.class_id = cs.class_id)
																 JOIN courses c
																 ON (cs.course_id = c.course_id
																 AND cs.dept_id = c.dept_id
																 AND cs.univ_id = c.univ_id)
																 LEFT JOIN user u
                                                                 ON (u.user_id = cs.professor)
																 WHERE cu.user_id = ?");
                $select_stmt->bind_param("i", $user_id);
                $select_stmt->execute();
                $select_stmt->store_result();
                $select_stmt->bind_result($cname, $cid, $cpic, $cprof, $class_id, $lastname);
                if($select_stmt->num_rows==0){
                  echo '<div class = "no_groups_box">
                            <div class = "no_groups_img no_groups_img_class">
                            </div>
                            <h5 class = "no_groups_header">
                                Time to sign up for classes
                            </h5>
                            <div class = "no_groups_join_btn_container">
                                <!--Searches classes in your department-->
                                <a href="https://urlinq.com/search_beta.php?q=classes" style="text-decoration:none;" target="_blank">
                                <button class = "no_groups_join_btn">
                                    <font color="white">Join your Classes</font>
                                </button>
                                </a>
                            </div>
                        </div>';
                }else{
                        while ($select_stmt->fetch()) {
                            echo '<a href = "./class.php?class_id=' . $class_id . '" class = "group course-group">
        												<div class = "group-pic" style = "background-image:url(' . get_dp($con, $class_id, "class") . ')"></div>
        												<div class = "details">
        												<div class = "group-name search_unit">' . $cname . '</div>
        												<div class = "group-admin">
                                                ';
                            if (is_null($lastname) or $lastname == "") {
                                $lastname = "TBA";
                                echo '<span class = "admin-name search_unit">' . $lastname . '</span>';
                            } else {
                                echo ' <strong class = "admin-title">Professor</strong>
                                        <span onclick="document.location.href="profile.php?user_id?'.$cprof.'"";class = "admin-name search_unit">' . $lastname . '</span>
                                      ';
                            }
        	                echo ' </div>
         						</div>
                                <div class = "badge"></div>
                                </a>';
                        }
                        $select_stmt->free_result();
                        $select_stmt->close();
                   }     
                ?>
            </div>
        </div>
        <div class="clubs-groups-list sub-list" id="theClubsAndGroups">
            
            <div class="lb_group_wrap">
                   <?php
                $club_group = array();
                $select_stmt = $con->prepare('SELECT g.group_id, g.group_name, g.dp_blob_id
                                                                FROM groups g
                                                                JOIN group_users gu
                                                                ON gu.group_id = g.group_id
                                                                WHERE gu.user_id =?');
                $select_stmt->bind_param("i", $user_id);
                $select_stmt->execute();
                $select_stmt->store_result();
                $select_stmt->bind_result($gid, $gname, $gpic);
                if($select_stmt->num_rows==0){
                   echo '<div class = "no_groups_box">
                            <div class = "no_groups_img no_groups_img_club">
                            </div>
                            <h5 class = "no_groups_header">
                                Find a club that interests you
                            </h5>
                            <div class = "no_groups_join_btn_container">
                                <!--Searches classes in your department-->
                                <a href="https://urlinq.com/search_beta.php?q=clubs" style="text-decoration:none;" target="_blank">
                                <button class = "no_groups_join_btn">
                                    <font color="white">Join your Clubs</font>
                                </button>
                                </a>
                            </div>
                        </div>';
                }else{


                while ($select_stmt->fetch()) {
                    $club_group[] = array($gid, $gname, $gpic);
                }
                $select_stmt->free_result();
                $select_stmt->close();
                foreach ($club_group as $group) {
                        $admin_names = array();
                        $result = $con->query("SELECT CONCAT(u.firstname,' ',u.lastname) as name
                                                                 from user u 
                                                                 where user_id IN (SELECT gu.user_id FROM group_users gu WHERE gu.group_id = " . $group[0] . "
                                                                 AND gu.is_admin = 1)");

                        while ($gr_name = $result->fetch_array()) {
                            $admin_names[] = $gr_name['name'];
                        }
                        $admin_names = implode(",", $admin_names);
                        if (strlen($admin_names) > 120) {
                            $admin_names = substr($admin_names, 0, 120);
                            $admin_names .= "...";
                        }
                        echo '<a class = "group course-group" href="./clubs.php?group_id=' . $group[0] . '">
                                            <div class = "group-pic" style = "background-image:url(' . get_dp($con, $group[0], "club") . ')"></div>
                                            <div class = "details">
                                                <div class = "group-name search_unit">' . $group[1] . '
                                                </div>
                                                <div class = "group-admin">
                                                    <strong class = "admin-title">President</strong>
                                                    <span class = "admin-name search_unit">' . $admin_names . '</span>
                                                </div>
                                            </div>
                                            </a>';
                }
               } 
                ?>
            </div>
          </div>
        </div> 

    



    </div>
   

    <div id="user_control" >
       <h5 id="username"><a id="prof_link"href="https://urlinq.com/beta/profile.php?user_id=285 + $user_id"> <?php echo $firstname1 . ' ' . $lastname1; ?> </a></h5>
        <div id="profile_pic" style="background-image: url(<?php echo $dp_link ?>);"></div>
        <div class="user_status_image"></div>
        <h6 id="user_status"> Online </h6>
        <p id="user_department"> Computer Science and Engineering</p>
        <p id="user_school"> NYU Polytechnic School Of Engineering</p>
        <div class="user_menu_image"></div>
        <div id='the_menu'>
            <ul id="menu_list">
               <li class='menu_item' id="menu_item_1"><a href='index.html'><span class="item" id="set_away">Set Yourself Away</span></a></li>
               <li class='menu_item' id="menu_item_2"><a href="https://urlinq.com/beta/profile.php?user_id=285 + $user_id"><span class="item"><div class="edit_profile_menu_image"></div>Edit Profile</span></a></li>
               <li class='menu_item' id="menu_item_3"><a href="https://urlinq.com/beta/profile.php?user_id=285 + $user_id"><span class="item"><div class="see_profile_menu_image"></div>Your Profile</span></a></li>
               <li class='menu_item' id="menu_item_4"><a href='php/logout.php'><span class="item"><div class="signout_menu_image"></div>Sign Out</span></a></li>
            </ul>
        </div>
    </div>


  
   
</div>
 
<script type="text/javascript">
    $(document).ready(function(){
        //Set's the club's display to none
        $("#myClubs").click(function(){
            $(".filters").removeClass("selected");
            $(this).addClass("selected");
            $("#theClasses").hide();
            $("#theClubsAndGroups").show();
        });
        $("#myClasses").click(function(){
            $(".filters").removeClass("selected");
            $(this).addClass("selected");
            $("#theClubsAndGroups").hide();
            $("#theClasses").show();             
        });
        $("#myClasses").click();
        $("#menu_item_3").mouseover(function(){
           $(".see_profile_menu_image").css({
                background: "url('img/left_side_menu_image_map.png') no-repeat -61px -119px",
            });
        });
        $(".user_menu_image").click(function(){
            $("#the_menu").fadeToggle('medium');
        });
        $("#menu_item_3").mouseout(function(){
           $(".see_profile_menu_image").css({
                background: "url('img/left_side_menu_image_map.png') no-repeat -18px -119px",
            });
        });
        $("#menu_item_2").mouseover(function(){
           $(".edit_profile_menu_image").css({
                background: "url('img/left_side_menu_image_map.png') no-repeat -60px -150px",
               
            });
        });
        $("#menu_item_2").mouseout(function(){
           $(".edit_profile_menu_image").css({
                background: "url('img/left_side_menu_image_map.png') no-repeat -17px -150px",
            });
        });
        $("#menu_item_4").mouseover(function(){
           $(".signout_menu_image").css({
                background: "url('img/left_side_menu_image_map.png') no-repeat -61px -89px",
               
            });
        });

        $("#menu_item_4").mouseout(function(){
           $(".signout_menu_image").css({
                background: "url('img/left_side_menu_image_map.png') no-repeat -18px -89px",

            });
        });


    });
</script>

<script>
    (function($){
        $(function(){
            $(".scrollable-content").mCustomScrollbar({
                theme: 'minimal-dark',
                autoHideScrollbar: false,
                scrollInertia: 0
            });
        });
    })(jQuery);
</script>
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

        $(document).click(function (e) {
            var container = $("#user_control");
            if(!container.is(e.target) && container.has(e.target).length === 0) {
                container.find("#the_menu").hide();
            }
        });

    });
</script>
