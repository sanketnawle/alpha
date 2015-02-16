<?php
/*
echo '
    <div class = "about-tab-members about-tab-block">
        <div class = "tab-block-header">
            <div class = "block-head-left">
                STUDENTS YOU KNOW IN THIS SCHOOL
                <span>
                    placeholder
                </span>
            </div>

        </div>
        <div class = "tab-block-content tab-block-content-scroll">
            <div class = "members-scrollwrap">
                <ul class = "people-you-know">
                    <li class = "people-box">
                        <div class = "person-pic-wrap" style="">
                        </div>

                        <div class = "person-title-wrap" >
                            <a href=""></a>
                        </div>
                        <div class = "after-click-effect"></div>
                    </li>
                </ul>
            </div>
            <a class = "ddbox-hor-scroller hor-scroller-left" >
                <div class = "ddbox-hor-scroller-cont">
                </div>
                <i class = "ddbox-hor-scroll-icon-left">
                </i>
            </a>
            <a class = "ddbox-hor-scroller hor-scroller-right" >
                <div class = "ddbox-hor-scroller-cont">
                </div>
                <i class = "ddbox-hor-scroll-icon-right">
                </i>
            </a>
        </div>
    </div>
';
*/


$followed_students=$user->usersFollowed;
//var_dump($followed_students);




echo '
    <div class="col span_1_of_3">
        <div class="school_header">
            STUDENTS YOU FOLLOW HERE
         </div>
        <div class="school_students_you_may_know">
            <ul class="school_list_of_students">';
foreach($followed_students as $student_know) {
    echo '
               <li class="school_single_student" style=""> <br><br><br>'; echo $student_know->firstname; echo '<br></li>';
}
echo '
            </ul>
        </div>
    </div>
';
//background-image:url(' . Yii::app()->getBaseUrl(true) . '' . $student_know->pictureFile->file_url .')
?>

