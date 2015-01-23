<script>
	
    $(document).ready(function () {

        $(document).delegate(".member_search", "keyup", function (e) {

            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {

                $(".member").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    /*control the text prompt of the div*/
                    $(".members-list-wrap").each(function(index) {
                        var l=$(this).find(".member").not('.hidden_result').length;
                        if(l==0){
                            $(this).prev(".blockwrapper").addClass("hidden_result");
                        }else{
                            $(this).prev(".blockwrapper").removeClass("hidden_result");   
                        }
                    });
                    /*control the text prompt of the div end*/

                });

            } else {
                $(".hidden_result").removeClass("hidden_result");
            }

        });
    });
</script>

<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../dbconnection.php");
include_once ("../../includes/common_functions.php");
include "../school_other_functions.php";
if(isset($_GET['university'])){
                $university=$_GET['university'];
             }else{
             $university=$_SESSION['univ_id'];}
             $user_id=$_SESSION['user_id'];

									$member_array=get_members_department_tab($con, $university, $user_id);
									//print_r($member_array);
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

								<div class = "members-list-wrap" id="members-list-wrap-professor">';
									foreach($member_array as $key=>$value){
										if($value['user_id']==NULL){}
										    else if($value["user_type"]=="p"){
										    	//echo $value["dp_link"];
											    echo '<div class="member" id="member-professor'.$value["user_id"].'">
													          <div class="member-person prof-member-person" id="prof-member-person'.$value["user_id"].'">
															          <div class="member-wrap prof-member-wrap" id="prof-member-wrap'.$value["user_id"].'">
																	          <div class="person-thumb" id="person-thumb-professor'.$value["user_id"].'">
																			          <div class ="picwrap" id="picwrap-professor'.$value["user_id"].'" style ="background-image:url(/beta/'.$value["dp_link"].')">
															                          </div>
															                          <div class = "member-bio" id="member-bio-professor'.$value["user_id"].'">
															                                <span>
															                                </span>
															                                <strong class="userlink" id="viewProfile_'.$value["user_id"].'">
																                                 <a href="/beta/profile.php?user_id='.$value["user_id"].'" target="_blank" style="text-decoration:none;">View Profile
																                                 </a>
															                                </strong>
															                          </div>
																	          </div>
																	          <h3 class="person-title" id="person-title-professor'.$value["user_id"].'">
																	              <a href="/beta/profile.php?user_id='.$value["user_id"].'" target="_blank" style="text-decoration:none;"><strong class="search_unit">'.$value["firstname"].' '.$value["lastname"].'
																	              </strong></a>
																	              <span><a class="search_unit" href="/beta/school.php?univ_id='.$value["univ_id"].'" style="text-decoration:none;">'.$value["univ_name"].'</a>
																	              </span>
																	          </h3>
																	          <div class="follow-btn">';
																	          if($value["user_id"]==$_SESSION["user_id"]){}
																	              else{ 
		                                                                              if(isset($value["flag_follow"])){
		                                                                                 if($value["flag_follow"]==1){
																			               echo '<a class="follow tab_followed" id="member'.$value["user_id"].'">Following
																			               </a>';
		                                                                                }
		                                                                              }else{
		                                                                                     echo '<a class="follow" id="member'.$value["user_id"].'">Follow';
		                                                                              }
		                                                                          }    
                                                                                  echo  '</div>
                		                                            				</div>
                															  </div>
                											          </div>';	
											}
									}
									echo '</div>';	
									echo '<div class="blockwrapper"><div class = "members-header members-students">
								Students
								</div>
								<div style = "width: 853px"class = "members-header-line">
								</div>
								</div>
								<div class = "members-list-wrap" id="members-list-wrap-student">';

								
									 
									foreach($member_array as $key=>$value){
										if($value['user_id']==NULL){}
										    else if($value["user_type"]=="s"){
										    	//echo $value["dp_link"];
											    echo '<div class="member" id="member-student'.$value["user_id"].'">
													          <div class="member-person prof-member-person" id="student-member-person'.$value["user_id"].'">
															          <div class="member-wrap prof-member-wrap" id="student-member-wrap'.$value["user_id"].'">
																	          <div class="person-thumb" id="person-thumb-student'.$value["user_id"].'">
																			          <div class ="picwrap" id="picwrap-student'.$value["user_id"].'" style ="background-image:url(/beta/'.$value["dp_link"].')">
															                          </div>
															                          <div class = "member-bio" id="member-bio-student'.$value["user_id"].'">
															                                <span>
															                                </span>
															                                <strong class="userlink" id="viewProfile_'.$value["user_id"].'">
																                                 <a href="/beta/profile.php?user_id='.$value["user_id"].'" target="_blank" style="text-decoration:none;">View Profile
																                                 </a>
															                                </strong>
															                          </div>
																	          </div>
																	          <h3 class="person-title" id="person-title-student'.$value["user_id"].'">
																	              <strong class="search_unit">'.$value["firstname"].' '.$value["lastname"].'
																	              </strong>
																	              <span><a class="search_unit" href="/beta/school.php?univ_id='.$value["univ_id"].'" style="text-decoration:none;">'.$value["univ_name"].'</a>
																	              </span>
																	          </h3>
																	     <div class="follow-btn">';
																	     if($value["user_id"]==$_SESSION["user_id"]){}
																	       else{
	                                                                            if(isset($value["flag_follow"])){
	                                                                                if($value["flag_follow"]==1){
	                                                                                  echo '<a class="follow tab_followed" id="member'.$value["user_id"].'">Following
	                                                                                  </a>';
	                                                                                 }
	                                                                            }else{
	                                                                                     echo '<a class="follow" id="member'.$value["user_id"].'">Follow';
	                                                                            }
	                                                                       }     
                                                                                  echo  '</div>
                                                                                    </div>
                                                                              </div>
                                                                      </div>';	
											}
									}
									?>

								<?php echo '</div>

					     </div>';
									?>
                               