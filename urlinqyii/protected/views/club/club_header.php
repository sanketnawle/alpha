<?php

//require_once("dbconnection.php");

if(isset($_GET['group_id'])){
    $group=$_GET['group_id'];
}


$user_id = $user->user_id;


}

//$get_group_header_query = "SELECT count(*) as user_count FROM group_users WHERE group_id = ?";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//    $get_group_header_stmt->bind_param("i",$group);
//    $get_group_header_stmt->execute();
//    $get_group_header_stmt->bind_result($user_count);
//    $get_group_header_stmt->fetch();
//    $get_group_header_stmt->close();
//}
//
//$get_group_header_query = "SELECT count(*) as file_count FROM posts p JOIN groups_files gf on (p.target_id = gf.group_id) WHERE
//    ((p.target_type = 'groups' and p.file_id is not null and p.target_id = ?) or gf.group_id = ?)";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//    $get_group_header_stmt->bind_param("ii",$group,$group);
//    $get_group_header_stmt->execute();
//    $get_group_header_stmt->bind_result($file_count);
//    $get_group_header_stmt->fetch();
//    $get_group_header_stmt->close();
//}
//
//$get_group_header_query = "SELECT count(*), is_admin FROM group_users WHERE group_id = ? and user_id = ?";
//$get_group_header_stmt = $con->prepare($get_group_header_query);
//if($get_group_header_stmt != null) {
//    $get_group_header_stmt->bind_param("ii",$group,$user_id);
//    $get_group_header_stmt->execute();
//    $get_group_header_stmt->bind_result($is_member, $is_admin);
//    $get_group_header_stmt->fetch();
//    $get_group_header_stmt->close();
//}

echo '
                        <div class = "group-head-top-sec" style="background-size:cover; background-image:url(includes/get_blob.php?img_id=' . $cover_blob . ') no-repeat scroll 50% center / 100% auto #333;">
                            <div class = "group-head-top-sec-shadow">
                            </div>
                            <div class = "info-scroll-up info-shower">   ';
                            if ($is_admin == "1")
                            {                             
                             echo '<button class = "upload_cover" id="upload_cover_pic">
                                    <i></i>
                                    <span>Upload Cover</span>
                                </button>
                                <div class = "help-div" id = "help-3">
                                    <div class = "help-wedge">
                                    </div>
                                    <div class = "help-box">
                                        Upload a cover photo of this club.
                                    </div>
                                </div>
                                <button class = "upload_cover" id="promote_group" style="margin-left:180px;">
                                    <!--<i></i>-->
                                    <span>Promote Club</span>
                                </button>';
                            }
                            echo '</div>                             
                            <div class = "group-cover-picture">
                                
                            </div>
                        </div>
                        <div class = "group-pic-frame">';
                            if ($is_admin == "1")
                            {
                                echo '<form>
                                    <input class="header_small_img_input" name="img" type="file" style="display:none;"/>
                                </form>';
                            }
                            echo '<div class = "group-pic" style="margin-top: 5px; margin-left: 5px;
                                background-size:cover; background-image:url(includes/get_blob.php?img_id=' . $dp_blob . ') no-repeat scroll 50% center / 100% auto #333;">
                            </div>';
                            if ($is_admin == "1")
                            {
                                echo '<button class="upload_dp">
                                    <i></i>
                                    <span>
                                        Upload Display Picture
                                    </span>
                                </button>';
                            }
                        echo '</div>
                        <div class = "group-header-left group-header-above">
                            <div class = "group-title spec-group-title">
                                <div class = "group-name group-name-mt" id="groupid_' . $group_id . '">'
                                . $group_name .
                                '</div>';
                                if ($is_admin == "1")
                                {
                                    echo '<input id="tb_club_name" maxlength="150" style="width:600px; height:30px; display:none; margin-bottom:10px;" type="text"/>
                                    <button class = "upload_cover" id="done_club_name_edit" style="display:none;margin-left: 10px; margin-top: 3px;">
                                        <!--<i></i>-->
                                        <span>Done</span>
                                    </button>';
                                }
                                if (($website != null) && ($website != ""))
                                {
                                    echo '<a class = "link_website_white" href="' . $website .'" target="_blank" style="text-decoration:none;">
                                     <span>Visit the club\'s website</span>                                
                                    </a>';
                                }
                                if ($is_admin == "1")
                                {
                                    echo '<button class="upload_cover" id="edit_club_name" style="position:relative;float:right;">                                            
                                            <span>Edit Club Name</span>
                                        </button>';
                                }
                            echo '</div>                                                      
                        </div>
                        <div class = "group-head-footer">
                            <div class = "group-header-tab">
                                <ul class = "group-nav" >
                                    <li class = "group-tab" >
                                        <a class = "tab1 tab-anchor group-tab-active" >
                                            <div class = "tab-title" >
                                                CLUB FEED
                                                <span class = "tab-icon tab1-icon-active" ></span >
                                            </div >
                                        </a >
                                    </li >
                                    <li class = "group-tab" >
                                        <a class = "tab2 tab-anchor tab-inactive" >
                                            <div class = "tab-title" >
                                                MEMBERS
                                                <span class = "tab-icon tab2-icon-inactive" ></span >
                                            </div >
                                            <div class = "status tab-number" >

                                            </div >
                                        </a >
                                    </li >
                                    <!--<li class = "group-tab" >
                                        <a class = "tab3 tab-anchor tab-inactive" >
                                            <div class = "tab-title" >
                                                FILES
                                                <span class = "tab-icon tab3-icon-inactive" ></span >
                                            </div >
                                            <div class = "status tab-number" >
                                                <span class = "badge" >
                                                ' . $file_count . '
                                                </span >
                                            </div >
                                        </a >
                                    </li >-->
                                    <li class = "tab-no-badge group-tab" >
                                        <a class = "tabc tab-anchor tab-inactive" >
                                            <div class = "tab-title" >
                                                EVENTS
                                                <span class = "tab-icon tabc-icon-inactive" ></span >
                                            </div >
                                        </a >
                                    </li >';
                                    if ($is_admin == "1")
                                    {
                                        echo '<li class = "tab-no-badge group-tab" >
                                            <a class = "tab4 tab-anchor tab-inactive" >
                                                <div class = "tab-title" >
                                                    ANALYTICS
                                                    <span class = "tab-icon tab4-icon-inactive" ></span >
                                                </div >
                                            </a >
                                        </li >';
                                    }
                                echo '</ul >    
                            </div>
                            <div class = "group-footer-functions">

                                <div class = "join-button">';
                                               if(isset($_GET['group_id'])){                                                
                                                    if($univ_id == $_SESSION['univ_id']){                                                        
                                                        if (($is_member > 0)) {                                                                                                                        
                                                            echo '<a class = "joined">
                                                                     Member
                                                                    </a> <div class = "help-div" id = "help-4" style="margin-left: 80%; margin-top: 35px;">
                                                                    <div class = "help-wedge">
                                                                    </div>
                                                                    <div class = "help-box">
                                                                        You are a member of this club. Click to leave club. 
                                                                    </div>
                                                                </div>';
                                                        }
                                                        else {
                                                            echo '<a class = "join">
                                                                      Join
                                                                    </a> <div class = "help-div" id = "help-4" style="margin-left: 80%; margin-top: 35px;">
                                                                <div class = "help-wedge">
                                                                </div>
                                                                <div class = "help-box">
                                                                    You are not a member of this club. Click to join club. 
                                                                </div>
                                                            </div>';

                                                            }
                                                        }
                                                    }                                              
                                            ?>
                                <?php echo '</div>

                            </div>
                        </div>
                        <div class = "tab-wedge-down">
                        </div>
                    '; ?>