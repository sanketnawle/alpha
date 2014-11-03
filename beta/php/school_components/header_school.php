<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//require_once("../dbconnection.php");
//include_once ("../includes/common_functions.php");
if (isset($_GET['univ_id'])) {
    $university = $_GET['univ_id'];
} else {
    $university = $_SESSION['univ_id'];
}
$user_id = $_SESSION['user_id'];
echo '
                        <div class = "group-head-top-sec" style="background-size:cover;">
                            <div class = "group-head-top-sec-shadow">
                            </div>
                            <div class = "info-scroll-up info-shower">
                                <div class = "group-cover-pic-info">
                                    <b>' . //php for getting some time at some university
    get_current_semester($con, $university)
    . 'Time At' .
    ucfirst(get_alias_univ($con, $university)) .

    '</b>
</div>
    <button class = "upload_cover upload_school_cover">
    <i></i>
    <span>Submit Cover</span>
    </button>
    <div class = "group_location">
        <em></em>
        <span class = "group_location_name">
            <!--
            <a href="http://maps.google.com/?q=' . get_univ_add($con, $university) . '" target="_blank" style="text-decoration:none;">
                ' . get_univ_add($con, $university) . '
            </a>
            -->
            <a id="school_location_link" href="" target="_blank" style="text-decoration:none;">New York</a>
        </span>
    </div>
    <div class = "help-div" id = "help-3">
        <div class = "help-wedge">
        </div>
        <div class = "help-box">
            Submit a photo of this school for a chance to replace its current cover photo.
        </div>
    </div>
    <div class="location-pic-div-wrap">
        <img id="location_popup" src="" />
    </div>
</div>';

$query = $con->query("SELECT dp_blob_id,cover_blob_id FROM university WHERE univ_id =$university");
while ($row = $query->fetch_array()) {
    $cp_id = $row['cover_blob_id'];
    $dp_id = $row['dp_blob_id'];
    $cv_link = "includes/get_blob.php?img_id=$cp_id";
    $dp_link = "includes/get_blob.php?img_id=$dp_id";
}
echo '<div class = "group-cover-picture" style="background-image:url(' . $cv_link . ');background-size:cover;">';

echo '</div>

                        </div>
                        <div class = "group-pic-frame">
                            <form>
                            <input class="header_small_img_input" name="img" type="file" style="display:none;">
                            </form>
                            <div class = "group-pic" style="background-image:url(' . $dp_link . ');background-size:cover;">
                            </div>
                        </div>
                        <div class = "group-header-left group-header-above">

                            
                            <div class = "group-title spec-group-title">
                                <div class = "group-name group-name-mt">'
    //for getting university name
    . ucwords(get_name_univ($con, $university)) .

    '</div>
    <a class = "group-id school-id" href="' .
    get_parent_univ_weblink($con, $university) . '"
                                                                          target="_blank"  style="text-decoration:none;">
                                    <em></em>
                                    ' . strtoupper(get_alias_parent_univ($con, $university)) . '
                                     
                                </a>
                                <a class = "link_website_white" href="' . get_univ_weblink($con, $university) . '"
                                                           target="_blank"  style="text-decoration:none;">
                                     <span>Visit this school\'s website</span>
                               </a>
                            </div>  
                                                    
                        </div>

                        <div class = "group-head-footer">
                            <div class = "group-header-tab">
                                <ul class = "group-nav">
                                    <li class = "group-tab info-tab">
                                        <a class = "tab1 tabFeed tab-anchor group-tab-active">
                                            <div class = "tab-title">
                                                SCHOOL INFO
                                                <span class = "tab-icon tab1-icon-active"></span>
                                            </div>

                                        </a>
                                    </li>
                                    <li class = "group-tab departments-tab">
                                        <a class = "tabDepartments tab-anchor tab-inactive">
                                            <div class = "tab-title">
                                                DEPARTMENTS
                                                <span class = "tab-icon tab2-icon-inactive"></span>
                                            </div>
                                            <div class = "status tab-number">
                                                <span class = "badge">
                                                    ' . get_department_count($con, $university) . '
                                                    
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class = "group-tab members-tab">
                                        <a class = "tabmembers tab-anchor tab-inactive">
                                            <div class = "tab-title">
                                                MEMBERS
                                                <span class = "tab-icon tab3-icon-inactive"></span>
                                            </div>
                                            <div class = "status tab-number">
                                                <span class = "badge">
                                                   ' . get_member_count($con, $university) . '
                                                </span>
                                            </div>
                                        </a>                        
                                    </li>   
                                    <!--
                                    <li class = "tab-no-badge group-tab">
                                        <a class = "tabc tabevents tab-anchor tab-inactive">
                                            <div class = "tab-title">
                                                EVENTS
                                                <span class = "tab-icon tabc-icon-inactive"></span>
                                            </div>
                                        </a>
                                    </li>-->                           
                                </ul>
                            </div>
                            <div class = "group-footer-functions">

                                <div class = "join-button">';

if (isset($_GET['univ_id'])) {
    if ($_GET['univ_id'] === $_SESSION['univ_id']) {
        echo '<a class = "join disabled">
                                                                         Member
                                                                        </a> <div class = "help-div" id = "help-4">
                                                <div class = "help-wedge">
                                                </div>
                                                <div class = "help-box">
                                                    You are a member of this school. Go to your profile page to change which school you are a part of. 
                                                </div>
                                            </div>';
    } else {
        echo '<a class = "join disabled">
                                                                          Not a Member
                                                                        </a> <div class = "help-div" id = "help-4">
                                                <div class = "help-wedge">
                                                </div>
                                                <div class = "help-box">
                                                    You are not a member of this school. Go to your profile page to change which school you are a part of. 
                                                </div>
                                            </div>';

    }
} else {
    echo '<a class = "join disabled">
                                                                          Member
                                                                        </a> <div class = "help-div" id = "help-4">
                                                <div class = "help-wedge">
                                                </div>
                                                <div class = "help-box">
                                                    You are  a member of this school. Go to your profile page to change which school you are a part of. 
                                                </div>
                                            </div>';

}


?>
<?php echo '</div>

                            </div>
                        </div>
                        <div class = "tab-wedge-down">
                        </div>
                    '; ?>