<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 7/21/14
 * Time: 5:26 PM
 */

echo '
    
        <div class="members-search-top">
          <div class="searchmemberwrapper">
            <input type="text" class="inputText searchMembers" name="Search Users"
            placeholder="Search the members of this club..." />
          </div>';
          if ($is_admin){
            echo '<div class="invite-users email_invite">
              Invite email list
            </div>';
          }
        echo '</div>';
        if(count($admin_array) > 0) { 
           echo "
                 <div class='blockwrapper'>
                    <div class = 'members-header members-students'>
                        Administrators (" . count($admin_array) . ")
                    </div>
                    <div style = 'width: 853px'class = 'members-header-line'></div>
                 </div>";
        }
echo '<div class="members-list-wrap prof-member-list">';
    foreach ($admin_array as $row1) {
      // if ($user_id == $row1['user_id'])
      // {
      //   $is_admin = true;
      // }
        echo '
            <div class="member" id="' . $row1['user_id'] . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(' . $row1['dp_link'] . ')"></div>
                      <div class="member-bio">
                        <span>' . $row1['interest'] . '</span> <a href="profile.php?user_id=' . $row1['user_id'] . '"><strong>View Profile</strong></a>
                      </div>';
                      if ($is_admin){
                        if ($row1['user_id'] != $user_id) {
                          echo '<img class="delete-user" title="delete member"/>';
                        }
                      }
                    echo '</div>
                    <h3 class="person-title">
                    <a href="profile.php?user_id=' . $row1['user_id'] . '"><strong class="search_unit">' . $row1['firstname'] . ' ' . $row1['lastname'] . ' </strong></a>
                        <span><a class="search_unit" href="school/school.php?univ_id=' . $row1['univ_id'] . '">' . $row1['univ_name'] . '</a></span>
                    </h3>';
        if ($row1['user_id'] != $user_id) {
          if ($is_admin){
                echo '<div class="follow-btn" style="margin-left:auto;">';
              }
              else
              {
                echo '<div class="follow-btn">'; 
              }
          if ($row1['follow'] == "true") {              
              echo '<a class="follow tab_followed ready_to_unfollow">Following</a></div>';                    
          } 
          else {
              echo '<a class="follow">Follow</a></div>';
          }      
          if (($is_admin) && (count($admin_array) > 1))
          { 
            echo '<div class="upgrade-admin upgrade-student" title="remove as admin" style="padding: 0px 10px; width:auto;">Remove</div>';
          } 
        }
        echo '</div></div></div>';
    }
    echo '</div>';

$admin_array = array();

//fetching members for the club
if(count($user_array) > 0) { 
   echo "
         <div class='blockwrapper'>
            <div class = 'members-header members-students'>
                Members (" . count($user_array) . ")
            </div>
            <div style = 'width: 853px'class = 'members-header-line'></div>
         </div>
         <div class = 'members-list-wrap student-member-list'>";
}

    foreach ($user_array as $row1) {
        echo '
            <div class="member" id="' . $row1['user_id'] . '">
                <div class="member-person prof-member-person">
                  <div class="member-wrap prof-member-wrap">
                    <div class="person-thumb">
                      <div class="picwrap" style="background-image:url(' . $row1['dp_link'] . ')"></div>
                      <div class="member-bio">
                        <span>' . $row1['interest'] . '</span> <a href="profile.php?user_id=' . $row1['user_id'] . '"><strong>View Profile</strong></a>
                      </div>';
                      if ($is_admin){
                        echo '<img class="delete-user" title="delete member"/>';
                      }
                    echo '</div>
                    <h3 class="person-title">
                      <a href="profile.php?user_id=' . $row1['user_id'] . ' ">
                        <strong class="search_unit">' . $row1['firstname'] . ' ' . $row1['lastname'] . ' </strong>
                      </a>
                      <span>
                        <a class="search_unit" href="school/school.php?univ_id=' . $row1['univ_id'] . '">' .  $row1['univ_name'] . '</a>
                      </span>
                      </h3>';        
      if ($row1['user_id'] != $user_id) {
        if ($is_admin){
            echo '<div class="follow-btn" style="margin-left:auto;">';
           }
           else
           {
              echo '<div class="follow-btn">';
           }
          if ($row1['follow'] == "true") {           
              echo '<a class="follow tab_followed ready_to_unfollow">Following</a></div>';              
          }
           else {
              echo '<a class="follow">Follow</a></div>';
          }
          if ($is_admin) 
          {
            echo '<div class="upgrade-admin upgrade-student" style="padding: 0px 16px; width:auto;">Admin</div>';
          }    
        }
        echo '</div>
            </div>
        </div>';  
    }
    if(count($user_array) > 0) { 
      echo '</div>';
    }
// }

//closing members-tab-content div
echo '
    </div>';
?>