
<?php
include_once("php/dbconnection.php");
session_start();
$user_id=$_SESSION['user_id'];
$query=$con->query("SELECT dp_flag FROM user WHERE user_id=$user_id");
$row=$query->fetch_array();
if($row['dp_flag']=='blob' || $row['dp_flag']=='link'){

}else{
echo '<div class = "onboarding_main_default_container" style = "border-bottom:none;">
                        <div class = "onboarding_step step_4">
                        </div>
                        <div class = "onboarding_step_body">
                            <h5>
                                Upload a profile picture
                            </h5> 
                            <div class = "onboarding_step_body_actions">
                                <div class = "photo_card_user" ><form><input type="file" name="img" class="photo_card_user_hidden" style="display:none;"></form></div>
                                <!--Preset the value of the search input with the query "User_department Classes"-->
                                <img width = "167" height = "208" src = "img/photo_id.png" class = "photo_card"/>

                                <div class = "add_photo_btns_wrapper">
                                    <button class = "green_btn"><span class = "photo_icon"></span>Add Photo</button>
                                    <h6>OR</h6>
                                    <button class = "gray_btn" onclick="fb_login();">Grab it from Facebook</button>
                                </div>
                            </div>                                  
                        </div>                    
                    </div>';
}                    
                    
?>                    