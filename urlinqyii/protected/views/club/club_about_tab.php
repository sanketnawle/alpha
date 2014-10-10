<?php



// $group_id = "92478034-f589-11e3-b732-00259022578e";
// $user_id = 1;
// $user_type = 's';if (isset($_SESSION['user_id'])) {
$user_id = $user->user_id;
//}













//about content starts here
echo "<div class = 'about-content'>";
//about left section starts
echo "<div class = 'about-tab-leftsec'>";
echo "<div class = 'about-tab-about about-tab-block'>
        <div class = 'tab-block-header'>
            <div class = 'block-head-left'>
                About
            </div>";


if ($is_admin == 1) {
    echo "<div class = 'block-head-right'>
            <a class = 'edit-about'>
                Edit
                <i class = 'edit-icon'>	</i>
            </a>
        </div>";
}echo "</div>
        <div class = 'tab-block-content' id='club_about_desc'>
            ". $club->group_desc."
        </div>
        <div class = 'about_edit'>
                    <textarea class = 'about_edit_area' id ='tb_about_edit_area'></textarea>
                    <div class = 'about_edit_toolbar'>
                        <button class = 'about_edit_done'>Done</button>
                        <button class = 'about_edit_cancel'>Cancel</button>
                    </div>
            </div>
    </div>";



$user_count = count($connected_users);


if ($user_count > 0) {
    echo "
           <div class = 'about-tab-members about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        MEMBERS YOU KNOW IN THIS CLUB <span>(" . $user_count . ")</span>
                    </div>
                </div>
                <div class = 'tab-block-content tab-block-content-scroll'>
                    <div class = 'members-scrollwrap'>
                        <ul class = 'people-you-know'>
    ";
    foreach ($connected_users as $row) {
        echo "<li class = 'people-box'>
                <div class = 'person-pic-wrap' style='background-image:url(".  get_user_dp($con, $row['user_id']).")'>
                </div>
              	<span class = 'grade'>";        if($row['type'] == 's')        	echo strtoupper(get_student_grade($row['user_id']));       	elseif($row['type'] == 'a')       		echo "Professor";       	else       		echo "Admin";       	echo "</span>
                <div class = 'person-title-wrap'>
                <a href='profile.php?user_id=".$row['user_id']."'><p>".$row['firstname']." ".                $row['lastname']."</p></a>
                </div>
                <div class = 'after-click-effect'></div>
              </li>";
    }

    echo "           </ul>
                    </div>
                    <a class = 'ddbox-hor-scroller hor-scroller-left'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-left'>
                        </i>
                    </a>
                    <a class = 'ddbox-hor-scroller hor-scroller-right'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-right'>
                        </i>
                    </a>
                </div>
            </div>";

    } else {
        $get_club_student_query = "SELECT U.user_id, U.firstname, U.lastname FROM user U WHERE U.user_id IN(SELECT user_id from group_users WHERE group_id = ? AND is_admin = 0 LIMIT 0,8)";


        $get_club_student_stmt = $con->prepare($get_club_student_query);
        $club_admin = array();
        if($get_club_student_stmt) {
            $get_club_student_stmt->bind_param('i', $group_id);
            $get_club_student_stmt->execute();
            $get_club_student_stmt->bind_result($g_user_id, $g_firstname, $g_lastname);
            while($get_club_student_stmt->fetch()) {
                $club_admin[] = array('user_id'=>$g_user_id, 'firstname'=>$g_firstname, 'lastname'=>$g_lastname);
            }
            $get_club_student_stmt->close();
        }


        $user_count = count($club_admin);



    if ($user_count > 0) {
        echo "
           <div class = 'about-tab-members about-tab-block'>
                <div class = 'tab-block-header'>
                    <div class = 'block-head-left'>
                        MEMBERS IN THIS CLUB <span>(".$user_count.")</span>
                    </div>                </div>
                <div class = 'tab-block-content tab-block-content-scroll'>                    <div class = 'members-scrollwrap'>
                        <ul class = 'people-you-know'>";
        foreach ($club_admin as $row) {
            echo "
                            <li class = 'people-box'>
                                <div class = 'person-pic-wrap' style='background-image:url(" . get_user_dp($con, $row['user_id']) . ")'>
                                </div>
                                <span class = 'grade'>Grad</span>
                                <div class = 'person-title-wrap'>
                                    <a href='profile.php?user_id=" . $row['user_id'] . "'><p></a>" . $row['firstname'] . " " . $row['lastname'] . "</p>
                                </div>
                                <div class = 'after-click-effect'></div>
                            </li>";
        }
        echo "</ul>
             </div>				<a class = 'ddbox-hor-scroller hor-scroller-left'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-left'>
                        </i>
                    </a>
                    <a class = 'ddbox-hor-scroller hor-scroller-right'>
                        <div class = 'ddbox-hor-scroller-cont'>
                        </div>
                        <i class = 'ddbox-hor-scroll-icon-right'>
                        </i>
                    </a>
                </div>
            </div>";
        }


    }

    $get_club_admin_query = "SELECT U.user_id, U.firstname, U.lastname FROM user U WHERE U.user_id IN(SELECT user_id from group_users WHERE group_id = ? AND is_admin = 1 LIMIT 0,8)";

    $get_club_admin_stmt = $con->prepare($get_club_admin_query);


    if($get_club_admin_stmt){
        $get_club_admin_stmt->bind_param('i', $group_id);
        $get_club_admin_stmt->execute();$get_club_admin_stmt->bind_result($g_user_id, $g_firstname, $g_lastname);
    echo "<div class = 'about-tab-prof about-tab-block'>
        <a class = 'prof-header'><div class = 'tab-block-header'>
            <div class = 'block-head-left'>";               while($get_club_admin_stmt->fetch())               {
                echo "<a href='profile.php?user_id=".$g_user_id."'> ".$g_lastname."</a>";               }
    echo "</div>
        </div></a>
    </div>";    $get_club_admin_stmt->close();}//closing about-tab-leftsec
echo "</div>";

//opening about-tab-rightsec and group-about
echo "<div class = 'about-tab-rightsec'>
            <div class = 'group-about group-about-2'>";


$get_course_files_query = "SELECT FU.file_id, FU.file_name, FU.created_timestamp, U.user_id, U.firstname, U.lastname FROM groups_files CF JOIN file_upload FU on FU.file_id = CF.file_id
JOIN user U on CF.user_id = CF.user_id
WHERE CF.group_id = ?
UNION
(SELECT FU.*, U.user_id, U.firstname, U.lastname FROM posts P
JOIN file_upload FU on FU.file_id = P.file_id
JOIN user U on U.user_id = P.user_id
WHERE P.target_id = ? AND P.target_type = 'groups' AND P.file_id IS NOT NULL)
ORDER BY created_timestamp DESC
LIMIT 0,1";

$file_array = array();


$get_club_files_stmt = $con->prepare($get_course_files_query);
if($get_club_files_stmt){
    $get_club_files_stmt->bind_param("ii", $group_id, $group_id);
    $get_club_files_stmt->execute();
    $get_club_files_stmt->bind_result($g_file_id, $g_file_name,$g_created_time, $g_user_id, $g_firstname, $g_lastname);
    while($get_club_files_stmt->fetch()) {
        $file_array[] = array('file_id'=>$g_file_id, 'file_name'=>$g_file_name, 'created_timestamp'=>$g_created_time, 'user_id'=>$g_user_id, 'firstname'=>$g_firstname, 'lastname'=>$g_lastname);
    }
    $get_club_files_stmt->close();
}



if (count($file_array)> 0) {
    echo "<div class = 'box-header'>
                  <span class = 'bh-t1'>                        RECENT UPLOAD
                    </span>
                    <span class = 'midline-dot'>
                        &#183;
                    </span>
                    <a style = 'font-weight:600;' class = 'bh-t2 small_upload'>
                        Upload a file
                    </a>
                    <form>
                    <input class='file_small_upload_input' type='file' name='file'>
                    </form>
                </div>";
    $file_row = $file_array[0];
    $time_string = new DateTime(user_time($file_row['created_timestamp']));
    $time_string = $time_string->format("F j");
    //closing group-about
    echo "
                <div class = 'box-content content-file'>
                    <a class = 'file-download'>
                    <div class = 'file-icon'>
                    </div>
                    <div class= 'file-name'>
                        " . $file_row['file_name'] . "
                    </div>
                    </a>
                    <div class ='file-created'>
                        <a class = 'file-creator'  href='profile.php?user_id=" . $file_row['user_id'] . "'>" . $file_row['firstname'] . " " . $file_row['lastname'] .                         "</a> <span> uploaded " . $time_string . "</span>
                    </div>
                </div>";
}echo "         <div class = 'box-header'>
                    <a class = 'bh-t2 small_invite_email'>
                        Invite email list
                    </a>
                </div>
                <div class = 'box-content content-invite'>
                    <form rel = '' method = 'post'>
                        <input type = 'hidden' autocomplete = 'off'>
                        <i class = 'plusIcon'></i>
                        <div class = 'invite-input-wrap'>
                            <div class = 'innerWrap'>
                                <input type = 'text' class = 'inputText inviteInput' name = 'Invite form' placeholder = 'Invite people to join this course'>
                                <div class = 'search-icon' title = 'Search people'>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
";

//closing about-content
echo "
    </div>
";
?>