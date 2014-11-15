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
                              <a href="/beta/profile.php?user_id=1" target="_blank" style="text-decoration:none;"><strong class="search_unit">Firstname Lastname
                              </strong></a>
                              <span><a class="search_unit" href="/beta/school.php?univ_id=1" style="text-decoration:none;">NYU</a>
                              </span>
                          </h3>
                          <div class="follow-btn">
';

echo '<a class="follow tab_followed" id="member1">Following</a>';

echo  '
</div>
</div>
</div>
</div>
';

echo '</div>';
echo '<div class="blockwrapper"><div class = "members-header members-students">
            Students
            </div>
            <div style = "width: 853px"class = "members-header-line">
            </div>
            </div>
            <div class = "members-list-wrap" id="members-list-wrap-student">
';

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
                      <strong class="search_unit">Firstname Lastname
                      </strong>
                      <span><a class="search_unit" href="/beta/school.php?univ_id=1" style="text-decoration:none;">NYU</a>
                      </span>
                  </h3>
             <div class="follow-btn">
';

echo '<a class="follow tab_followed" id="member1">Following</a>';

echo  '</div>
        </div>
  </div>
</div>
';

echo '</div>
</div>
';


?>