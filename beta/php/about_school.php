 <?php
if(isset($_GET['university'])){
                $university=$_GET['university'];
             }else{
             $university=$_SESSION['univ_id'];}
             $user_id=$_SESSION['user_id'];  
  echo '<div class = "about-content">
                            <div class = "about-tab-leftsec">
                                <div class = "about-tab-about about-tab-block">
                                    <div class = "tab-block-header">
                                        <div class = "block-head-left">
                                            About
                                        </div>
                                        <div class = "block-head-right">
                                            <a class = "edit-about">
                                                Edit
                                                <i class = "edit-icon">

                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class = "tab-block-content">
                                        Receive a potato-salad themed haiku written by me, your name carved into a potato that will be used in the potato salad, a signed jar of mayonnaise, the potato salad recipe, hang out in the kitchen with me while I make the potato salad, choose a potato-salad-appropriate ingredient to add to the potato salad, receive a bite of the potato salad, a photo of me making the potato salad, a 'thank you' posted to our website and I will say your name out loud while making the potato salad.
                                    </div>
                                </div>
                                <div class = "about-tab-members about-tab-block">
                                    <div class = "tab-block-header">
                                        <div class = "block-head-left">
                                            STUDENTS YOU KNOW IN THIS SCHOOL 
                                            <span>';                                                
                                               echo get_people_know_school($con,$university,$user_id);                                               
                                           echo '</span>
                                        </div>
                                        
                                    </div>
                                    <div class = "tab-block-content tab-block-content-scroll">
                                        <div class = "members-scrollwrap">';
                                                     $query=$con->query("SELECT user_id,firstname,lastname FROM user WHERE user_id 
                                                                           IN (SELECT to_user_id FROM connect WHERE from_user_id=$user_id) 
                                                                           AND univ_id=$university");
                                                    echo '<ul class = "people-you-know">';
                                                           while($row=$query->fetch_array()){
                                                           echo '<li class = "people-box">';
                                                               $dp_link=get_user_dp($con,$row['user_id']);
                                                               $user_id_know=$row['user_id']; 
                                                            echo '<div class = "person-pic-wrap"'; echo 'style=';echo 'background-image:url("'; echo $dp_link; echo '")>';
                                                            echo '</div>

                                                            <div class = "person-title-wrap" >';
                                                                echo '<a href="'; echo 'profile?user_id='.$user_id_know;echo '"  style="text-decoration:none;"><p>'.$row['firstname'].' '.$row['lastname'].'</p></a>
                                                            </div>
                                                            <div class = "after-click-effect"></div>
                                                        </li>';

                                                     }
                                                    
                                            echo '</ul>

                                        </div>
                                        <a class = "ddbox-hor-scroller hor-scroller-left">
                                            <div class = "ddbox-hor-scroller-cont">
                                            </div>
                                            <i class = "ddbox-hor-scroll-icon-left">
                                            </i>
                                        </a>
                                        <a class = "ddbox-hor-scroller hor-scroller-right">
                                            <div class = "ddbox-hor-scroller-cont">
                                            </div>
                                            <i class = "ddbox-hor-scroll-icon-right">
                                            </i>
                                        </a>

                                    </div>

                                </div>
                                    
                                </div>
                                
                                </div>
                            </div>
                        </div>';