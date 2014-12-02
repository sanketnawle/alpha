<?php
echo '<div class = "members-tab-content">
        <div class = "members-search-top">
            <form>
                <div class = "searchWrapper searchWrapperMembers">
                    <input placeholder = "Search students and faculty at NYU Polytechnic" class = "tabSearcher member_search ajax">
                    </input>
                </div>
                <button class = "submitSearch submitSearchMembers">
                </button>
            </form>

        </div>
            <div class="blockwrapper">
            <div class = "members-header members-Professors">
                 Professors
            </div>
            <div class = "members-header-line">
            </div>
            </div>

            <div class = "members-list-wrap" id="members-list-wrap-professor">
';
// each professor member
            foreach($members as $member) {

                $default_unfollowed="selected";
                foreach($user->usersFollowed as $mem) {
                    if ($mem->user_id==$member->user_id) {
                        $default_followed = "selected";
                        $default_unfollowed ="";
                        break;
                    }
                    else {
                        $default_followed="";
                        $default_unfollowed="selected";
                    }
                }

                if ($member->user_type == "p") {
                    echo '<div class="member" id="member-professor1">
                                          <div class="member-person prof-member-person" id="prof-member-person1">
                                                  <div class="member-wrap prof-member-wrap" id="prof-member-wrap1">
                                                          <div class="person-thumb" id="person-thumb-professor1">
                                                                  <div class ="picwrap" id="picwrap-professor1" style ="background-image:url()">
                                                                  </div>
                                                                  <div class = "member-bio" id="member-bio-professor1">
                                                                        <span>
                                                                        </span>
                                                                        <strong class="userlink" id="viewProfile_1">
                                                                             <a href="/beta/profile.php?user_id=1" target="_blank" style="text-decoration:none;">View Profile
                                                                             </a>
                                                                        </strong>
                                                                  </div>
                                                          </div>
                                                          <h3 class="person-title" id="person-title-professor1">
                                                              <a href="/beta/profile.php?user_id=1" target="_blank" style="text-decoration:none;"><strong class="search_unit">'.$member->firstname.' '.$member->lastname.'
                                                              </strong></a>
                                                              <span><a class="search_unit" href="/beta/school.php?univ_id=1" style="text-decoration:none;">NYU</a>
                                                              </span>
                                                          </h3>
                                                          <div class="follow-btn">
                                ';
                            
                       // <select class="member_following" data-member_id="' . $member->user_id . '">
                          ///       <option value="follow" class="follow_option"'.$default_followed.'>follow</option>
                           //      <option value="unfollow" class="follow_option"'.$default_unfollowed.'>unfollow</option>
                           // </select>
                    echo '
                        <div class="member_following_wrap" >
                             
                             <button class="member_tab_member">
                                    Followed
                             </button>
                             
                        </div>';

                    echo '
                                </div>
                                </div>
                                </div>
                                </div>
                                ';
                }
            }
// professor member ends here

echo '</div>';
echo '<div class="blockwrapper"><div class = "members-header members-students">
            Students
            </div>
            <div style = "width: 853px"class = "members-header-line">
            </div>
            </div>
            <div class = "members-list-wrap" id="members-list-wrap-student">
';

foreach($members as $member) {

    $default_unfollowed="selected";
    foreach($user->usersFollowed as $mem) {
        if ($mem->user_id==$member->user_id) {
            $default_followed = "selected";
            $default_unfollowed ="";
            break;
        }
        else {
            $default_followed="";
            $default_unfollowed="selected";
        }
    }

    if ($member->user_type == "s") {

        echo '<div class="member" id="member-student1">
                    <div class="member-person prof-member-person" id="student-member-person1">
                          <div class="member-wrap prof-member-wrap" id="student-member-wrap1">
                                  <div class="person-thumb" id="person-thumb-student1">
                                          <div class ="picwrap" id="picwrap-student1" style ="background-image:url()">
                                          </div>
                                          <div class = "member-bio" id="member-bio-student1">
                                                <span>
                                                </span>
                                                <strong class="userlink" id="viewProfile_1">
                                                     <a href="/beta/profile.php?user_id=1" target="_blank" style="text-decoration:none;">View Profile
                                                     </a>
                                                </strong>
                                          </div>
                                  </div>
                                  <h3 class="person-title" id="person-title-student1">
                                      <strong class="search_unit">'.$member->firstname.' '.$member->lastname.'
                                      </strong>

                                      <span>
                                      <span class="university_icon"> </span>
                                      <a class="search_unit" href="/beta/school.php?univ_id=1" style="text-decoration:none;">
                                      
                                      NYU</a>
                                      </span>
                                  </h3>
                             <div class="follow-btn">
                ';

        echo ' <div class="member_following_wrap" >';
          if($default_followed == "selected"){
                echo'<button class="member_tab_member">
                      Followed
                    </button>';
              }
          else{
            echo'<button class="member_tab_not_member">
                      Follow
                  </button>';

          }
        echo' </div>';

        echo '</div>
                        </div>
                  </div>
                </div>
                ';
    }
}

echo '</div>
</div>
';


?>