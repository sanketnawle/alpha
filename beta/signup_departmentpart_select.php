<script>
    $(document).ready(function () {

        $(document).delegate(".search-signup-lists", "keyup", function (e) {
            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".department").each(function () {
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
$array_dept_signup=array();

if($_POST['univ_id']){
	$_SESSION['univ_id']=$_POST['univ_id'];
	$univ_id=$_POST['univ_id'];
	$result = $con->query("SELECT department.dept_name,department.univ_id,department.dept_id,
                                       count(*) as members
                           FROM department LEFT JOIN user ON user.dept_id=department.dept_id 
                           GROUP BY department.dept_id
                           HAVING department.univ_id=$univ_id");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $array_dept_signup[]=$row;
        }
 }       


echo '<div class = "choiceSignUpList departmentSignUpList scroller niceScroller" style="overflow-y: scroll; display: block;">	
						<div class = "scroll-inner">
							<div class = "choicesContainer">
								<!-- For JS purposes, the topListItem class should only be found in the first div of the SignupChoiceList -->';
                       foreach($array_dept_signup as $key=>$value){
								echo '<div class = "department unchosen2 listItem deptJoin SignUpItem2" id="department'.$value['dept_id'].'">
									<!-- Displays schools cover photo in background css, not img tag -->
									<div class = "choiceInner" style = "background-image:url('.get_cover_pic($con,$value['dept_id'],'dept').')">
										<img  class = "loadtest" id="imgLoadTest'.$key.'" src='.get_cover_pic($con,$value['dept_id'],'dept').' style="display: none"></img>
										<div class = "info">
											<div class = "choiceJoin">
												<div class = "schoolsmallImage">
													<img src = "'.get_dp($con,$value['dept_id'],'dept').'">
												</div>
												<div class = "name">
													<h3 class="search_unit">'.$value['dept_name'].'</h3>
													<p>'.$value['members'].' engineers</p>
												</div>
												<div class = "button">
													<div class ="join">
														<button type = "button" class = "joinDepartmentBtn joinBtn" id="department'.$value['univ_id'].'">
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
					