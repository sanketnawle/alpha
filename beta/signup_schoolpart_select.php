<script>
    $(document).ready(function () {

        $(document).delegate(".search-signup-lists", "keyup", function (e) {
            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".school").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    


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
include_once ("php/dbconnection.php");
include "includes/common_functions.php";
include "php/school_other_functions.php";
$array_univ_signup=array();
$result = $con->query("SELECT university.univ_name,university.parent_univ_id,university.univ_id,
                                       count(*) as members,university.cover_blob_id 
                               FROM university LEFT JOIN user ON user.univ_id=university.univ_id 
                               GROUP BY university.univ_id 
                               HAVING university.parent_univ_id=1");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $array_univ_signup[]=$row;
        }

echo '<div class = "choiceSignUpList schoolsSignUpList scroller niceScroller">
                     <div class = "scroll-inner">
							<div class = "choicesContainer">
								<!-- For JS purposes, the topListItem class should only be found in the first div of the SignupChoiceList -->
								';

							 foreach($array_univ_signup as $key=>$value){	
								echo '<div class = "school unchosen listItem schoolJoin SignUpItem" id="university'.$value['univ_id'].'">
									<!-- Displays schools cover photo in background css, not img tag -->
									<div class = "choiceInner" style = "background-image:url('.get_cover_pic($con,$value['univ_id'],'school').')">
										<img  class = "loadtest" id="schImgLoadTest'.$key.'" src='.get_cover_pic($con,$value['dept_id'],'dept').' style="display: none"></img>
										<div class = "info">
											<div class = "choiceJoin">
												<div class = "schoolsmallImage">
													<img src = "'.get_dp($con,$value['univ_id'],'school').'">
												</div>
												<div class = "name">
													<h3 class="search_unit">'.$value["univ_name"].'</h3>
													<p>'.$value["members"].'people</p>
												</div>
												<div class = "button">
													<div class ="join">
														<button type = "button" class = "joinSchoolBtn joinBtn">
															<i class = "joinIcon">
															</i>
															<span>Join</span>
															<i class = "leaveIcon">
															</i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>';
							}
															
							echo '</div>
						</div>
					</div>';
					


?>