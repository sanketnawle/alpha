<!--
<script>
    $(document).ready(function () {
        $(document).delegate(".dept_search", "keyup", function (e) {
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
-->

<?php

echo '<div class = "departments-tab-content">

            <div class = "departmentsTabTop">
               <form>
                  <div class = "searchWrapper">
                     <input placeholder = "Search the departments at New York University (placeholder)" class = "tabSearcher dept_search ajax">
                     </input>
                  </div>
                  <button class = "submitSearch">
                  </button>
              </form>
           </div>';


foreach ($departments as $department){
   // var_dump($department->pictureFile->file_url);
echo '<div class = "item department-selector">';




/*
foreach($dept_array as $key=>$value){
    if($key==0){
    }else if($value['dept_id']==NULL){}else{

        echo '<div class = "department ajax" id="department-ajax'.$value["dept_id"].'">
    			                                        <a class = "departmentSelectWrapper" id="departmentSelectWrapper'.$value["dept_id"].'">
    			                                           <div class = "name search_unit"><a href="/beta/department.php?dept_id='.$value['dept_id'].'" style="text-decoration:none;">'
            .$value['dept_name'].'</a>
    			                                           </div>
    			                                           <div class = "imageWrapper">
    			                                             <span class = "hoverMask">
    			                                             </span>
    			                                             <div class = "deptImage deptImage-dos" id="deptimage'.$value['dept_id'].'">
    			                                                <img class = "floatL deptImg" src = "'.$value['cover_link'].'">
    			                                                <div class = "blackData">
    			                                                	<span class = "group_members">
    			                                                		<em class = "members-icon"></em>
    			                                                		<span>'.$value['member_count'].'</span>

    			                                                	</span>
    			                                                </div>
    			                                                <div class = "dept-short-wrapper">
    				                                                  <div>
    				                                                    <span class="search_unit"><img class="floatL deptImg" src="' . $value['dp_link'] . '">
    				                                                    </span>
    				                                                 </div>
    			                                                </div>
    			                                            </div>
    			                                            <div class = "deptBtns" id="deptBtns'.$value['dept_id'].'">';
        //<img class="floatL deptImg" src="includes/get_blob.php?img_id=17">

        if(isset($value['flag_follow'])){
            if($value['flag_follow']==1){

                echo '<button class = "followBtn unfollowBtn" id="followBtn'.$value["dept_id"].'">
                                                                    <em class = "unfollow-icon"></em>Unfollow
                                                                    </button>';
            }
        }else{
            echo '<button class = "followBtn" id="followBtn'.$value['dept_id'].'">
    			                                            		 <em></em>
    			                                            		  Follow
    			                                            	  </button>';
        }

        if(isset($value['flag'])){
            if($value['flag']==1){
                echo '<button class = "studybtn btn_mymajor" id="studybtn'.$value['dept_id'].'">My Major';
            }else if($value['flag']==2){
                echo '<button class = "studybtn btn_myminor" id="studybtn'.$value['dept_id'].'">My Minor';
            }else if($value['flag']==3){
                echo '<button class = "studybtn btn_unchange" id="studybtn'.$value['dept_id'].'">My Interest';
            }
        }else{
            echo '<button class = "studybtn" id="studybtn'.$value['dept_id'].'">Concentrate';
        }

        echo'</button>
    			                                            	<div class = "study_box_open" id="study_box_open'.$value['dept_id'].'">
    			                                            		<div class = "js_wrap" id="js_wrap'.$value['dept_id'].'">
    																	<span>I am...</span>
    																	<div class = "study_first_option" id="study_first_option'.$value['dept_id'].'">';
        if(isset($value['flag'])){
            if($value['flag']==1){
                echo '<button class = "majorType study_type_btn pressedGraybtn" id="major'.$value['dept_id'].'" type = "button"><em class="check" style="left: 16px; opacity: 1;"></em>Majoring in this subject</button>
                                                                                            ';
            }else{
                echo  '<button class = "majorType study_type_btn " id="major'.$value['dept_id'].'" type = "button">Majoring in this subject</button>
                                                                                               ';
            }
            if($value['flag']==2){
                echo '<button class = "minorType study_type_btn pressedGraybtn" id="minor'.$value['dept_id'].'" type = "button"><em class="check" style="left: 16px; opacity: 1;"></em>Minoring in this subject</button>
                                                                                               ';
            }else{
                echo '<button class = "minorType study_type_btn " id="minor'.$value['dept_id'].'" type = "button">Minoring in this subject</button>';
            }
            if($value['flag']==3){
                echo '<button class = "interestType study_type_btn pressedGraybtn " id="interested'.$value['dept_id'].'" type = "button"><em class="check" style="left: 16px; opacity: 1;"></em>Interested in this subject </button>
                                                                                              ';
            }else{
                echo '<button class = "interestType study_type_btn " id="interested'.$value['dept_id'].'" type = "button">Interested in this subject</button>';
            }
        }else{
            echo '<button class = "majorType study_type_btn " id="major'.$value['dept_id'].'" type = "button">Majoring in this subject</button>
                                                                                  <button class = "minorType study_type_btn " id="minor'.$value['dept_id'].'" type = "button">Minoring in this subject</button>
    													                            <button class = "interestType study_type_btn " id="interested'.$value['dept_id'].'" type = "button">Interested in this subject</button>';
        }
        echo '</div>
    																</div>
    																<div class = "modal_loading2" id="modal_loading2'.$value['dept_id'].'" >
    																	<img class = "modal_animation" src = "school/src/loadingAnimation.gif">
    																</div>
    															</div>
    			                                            </div>
    			                                        </div>
    			                                    </a>
    			                                </div>';
    }
}
*/

//var_dump($departments);
    //var_dump($department);
echo '<div class = "department ajax" id="department-ajax">
    			                                        <a class = "departmentSelectWrapper" id="departmentSelectWrapper">
    			                                           <div class = "name search_unit"><a href="/beta/department.php?dept_id=1" style="text-decoration:none;">';  echo $department->department_name; echo '</a>
    			                                           </div>
    			                                           <div class = "imageWrapper">
    			                                             <span class = "hoverMask">
    			                                             </span>
    			                                             <div class = "deptImage deptImage-dos" id="deptimage1">
    			                                                <img class = "floatL deptImg" src = "">
    			                                                <div class = "blackData">
    			                                                	<span class = "group_members">
    			                                                		<em class = "members-icon"></em>
    			                                                		<span>99</span>

    			                                                	</span>
    			                                                </div>
    			                                               <!--  <div class = "dept-short-wrapper">
    				                                                  <div>
    				                                                    <span class="search_unit"><img class="floatL deptImg" src="">
    				                                                    </span>
    				                                                 </div>
    			                                                </div>-->
    			                                            </div>
    			                                            <div class = "deptBtns" id="deptBtns1">';
//<img class="floatL deptImg" src="includes/get_blob.php?img_id=17">

echo '
    <div class="dept_following" data-deptid="<?php echo $department->department_id ?>">
        <select id="dept_following">
             <option value="follow" class="follow_option">follow</option>
             <option value="unfollow" class="follow_option">unfollow</option>
        </select>
    </div>';

echo'</div></div></a></div></div>';

}
echo '
    </div>
';

?>


<script>
    $(function () {
//        $(".btn_follow").click(function () {
//
//
//            if ($(this).hasClass("followed")) {
//                $(this).removeClass("followed");
//                $(this).html("Follow");
//            } else {
//                $(this).addClass("followed");
//                $(this).html("Unfollow");
//            }
//        });

        $(".dept_following").change(function(){
            var my_div= $( ".dept_following" ).attr('data-deptid');
            var selected_val = $("#dept_following").val();
           // var dept_id = mydiv.getAttribute("data-deptid");
            alert(selected_val, my_div);
            ////  alert (selected_val);
            //$.ajax({
            //    type: "POST",
            //    url: base_url + '/profile/updateHere',
            //    data: {selected: selected_val},
            //    success: function(data) {
            //        alert("updated")
            //    },
            //    error: function(data) {
            //        alert ("error")
            //    }
            //});

        });
    })
</script>