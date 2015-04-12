<?php
include_once("php/dbconnection.php");
//include_once("php/redirect.php");
include_once("php/onboarding_functions.php");
//print_r($_SESSION);
$professor=get_professor($_SESSION['dept_id'],$con);
$student=get_student($_SESSION['dept_id'],$con);
echo '<div class = "onboarding_step_body_actions">
                                <div class = "onboarding_actions_follow">
                                    <a><img width = "65" height = "65" src = "'.$professor['dp_link'].'" /></a>
                                    <div class = "suggested_follow_action_main">  
                                        <div class = "suggested_follow_details">
                                            <a><h6>Professor '.$professor['firstname'].'</h6></a>
                                            <p>'.$professor['followers'].' Followers</p>
                                        </div>
                                        <div class = "suggested_follow_btn_wrapper user_follow_btn">';
                                            
                                            if($professor['flag']==1){
                                               echo '<button class = "user_follow_btn_id onboard_followed" id="'.$professor['user_id'].'">';
                                              echo "Followed";
                                            }else{
                                                echo '<button class = "user_follow_btn_id " id="'.$professor['user_id'].'">';
                                                echo "Follow";
                                            }    
                                            echo '</button>
                                        </div>
                                    </div>
                                </div>
                                <div class = "onboarding_actions_follow">
                                    <a><img width = "65" height = "65" src = "'.$student['dp_link'].'" /></a>
                                    <div class = "suggested_follow_action_main">  
                                        <div class = "suggested_follow_details">
                                            <a><h6>'.$student['firstname'].'</h6></a>
                                            <p>'.$student['followers'].' Followers</p>
                                        </div>
                                        <div class = "suggested_follow_btn_wrapper">
                                            <button class = "user_follow_btn_id" id="'.$student['user_id'].'">';
                                            if($student['flag']==1){
                                              echo "Followed";
                                            }else{
                                                echo "Follow";
                                            }    
                                            echo '</button>
                                        </div>
                                    </div>
                                </div>
                                <div class = "abs_pos view_more_wrapper">
                                    <button type="button" id="search_people">
                                        <img src = "img/smallSearchIcoDark.png">
                                    </button>
                                    <div class = "help-div" id = "help-view-more">
                                        <div class = "help-wedge">
                                        </div>
                                        <div class = "help-box">
                                            View the members of your department to discover many more inspiring people to follow
                                        </div>
                                    </div>
                                </div>
                            </div>';
?>                            