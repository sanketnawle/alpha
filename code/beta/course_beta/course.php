<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'>
    <link rel='stylesheet' type='text/css' href='backgroundGroup.css'>
    <link rel='stylesheet' type='text/css' href='feedGroup.css'>
    <link rel='stylesheet' type='text/css' href='group.css'>
    <link rel='stylesheet' type='text/css' href='invite_modal.css'>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'>
    </script>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>

    <script src='group.js'></script>
    <script src='jquery-ui-1.11.0/jquery-ui.min.js'></script>


    <script>
    /*add member control*/
    $( document ).ready(function() {
    $('.email_invite').click(function(){
            $(".modal_body").animate({opacity:0},300,function(){
            $(".modal_loading").show();
            $(".modal_loading").css("opacity","1");
            $(".main").addClass("fe");
            $(".modal_coverPhoto_body").show();
            $(".modal_coverPhoto_body").animate({opacity:1},400, function(){
                $(".modal_loading").delay(250).animate({opacity:0},100);
                $(".modal_loading").hide();
                $(".modal_content").show();
                $(".modal_content").delay(500).animate({opacity:1},200);
                $(".modal_coverPhoto_container").animate({
                    height:358,
                    width:520
                },500, function(){
                    $(".inputPhotoName").focus();
                });
            });
            $("html, body").animate({ scrollTop: 150 }, 600);

            return false;
            });
    });
    /*add member control end*/
    });
    </script>
</head>
<body>
<div class='root'>

        <div class = "modal_coverPhoto_body modal_body">
            <div class = "modal_coverPhoto_container">
                <div class = "modal_loading">
                    <img class = "modal_animation" src = "src/loadingAnimation.gif">
                </div>
                <div class = "modal_content">
                    <div class = "modal_header">
                        <span class = "floatL white">
                            Member Invitation
                        </span>
                        <em class = "floatR cancelBtn close">
                        </em>
                    </div>
                    <div class = "modal_main">
                        <form>
                            <label for = "cover_name" class = "label_left">
                                Send Invitation To:  
                            </label>
                            <input class = "inputBig inputPhotoName" id = "cover_name" placeholder = "Email Address">
                            <label for = "cover_name" class = "label_left2">
                                Or:   
                            </label>
                            <button class = "uploadPhotoBtn">
                                Upload Member List Excel Document
                            </button> 
                            <div class='excel_label'>No File Uploaded</div>

                            <div class='modal-mid'>
                                <textarea class='modal-mid-textarea'placeholder='Customize your invitation email!' value=""></textarea>
                            </div>

                            <div class = "btmleft">

                                <button type=  "button" class = "cancelBtn grayBtn">
                                    Cancel
                                </button> 
                                <button type=  "button" class = "blueBtn">
                                    Submit
                                </button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



<div class='main'>

<div class='main-mid-sec'>

<div class='mid_right_sec'>
<?php include('course_header.php'); ?>
<div class='midsec'>
    <div class='feed-tab-content'>

        <div class='feed-tab-rightsec'>
            <div class='group-about'>
                <div class='box-header'>
										<span class='bh-t1'>
											RECENT UPLOAD
										</span>
										<span class='midline-dot'>
											&#183;
										</span>
                    <a style='font-weight:600;' class='bh-t2'>
                        Upload a file
                    </a>
                </div>
                <div class='box-content content-file'>
                    <a class='file-download'>
                        <div class='file-icon'>
                        </div>
                        <div class='file-name'>
                            Who is Ross Kopelman?
                        </div>
                    </a>

                    <div class='file-created'>
                        <a class='file-creator'>Jacob Lazarus</a> <span> uploaded July 8th</span>
                    </div>
                </div>
                <div class='box-header'>
										<span class='bh-t1'>
											ABOUT
										</span>

                </div>
                <div class='box-content content-about'>Urlinq should strive for an 'intimate' connection with customers'
                    feelings. 'We will truly understand their needs better than any other company,' Lazarus wrote.
                </div>
                <div class='box-header'>
                    <a class='bh-t2'>
                        Invite email list
                    </a>
                </div>
                <div class='box-content content-invite'>
                    <form rel='' method='post'>
                        <input type='hidden' autocomplete='off'>
                        <i class='plusIcon'></i>

                        <div class='invite-input-wrap'>
                            <div class='innerWrap'>
                                <input type='text' class='inputText inviteInput' name='Invite form'
                                       placeholder='Invite people to join this course'>

                                <div class='search-icon' title='Search people'>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('course_members_tab.php'); ?>
    <?php include('course_files_tab.php'); ?>
    <?php include('course_syllabus_tab.php'); ?>
</div>


<div class='about-content'>
<div class='about-tab-leftsec'>
<div class='about-tab-about about-tab-block'>
    <div class='tab-block-header'>
        <div class='block-head-left'>
            About
        </div>
        <div class='block-head-right'>
            <a class='edit-about'>
                Edit
                <i class='edit-icon'>

                </i>
            </a>
        </div>
    </div>
    <div class='tab-block-content'>
        Receive a potato-salad themed haiku written by me, your name carved into a potato that will be used in the
        potato salad, a signed jar of mayonnaise, the potato salad recipe, hang out in the kitchen with me while I make
        the potato salad, choose a potato-salad-appropriate ingredient to add to the potato salad, receive a bite of the
        potato salad, a photo of me making the potato salad, a 'thank you' posted to our website and I will say your
        name out loud while making the potato salad.
    </div>
</div>
<div class='about-tab-members about-tab-block'>
    <div class='tab-block-header'>
        <div class='block-head-left'>
            STUDENTS YOU KNOW IN THIS COURSE <span>(8)</span>
        </div>

    </div>
    <div class='tab-block-content tab-block-content-scroll'>
        <div class='members-scrollwrap'>
            <ul class='people-you-know'>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <span class='grade'>Grad</span>

                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>
                <li class='people-box'>
                    <div class='person-pic-wrap'>
                    </div>
                    <div class='person-title-wrap'>
                        <p>Kushal Kadaba</p>
                    </div>
                    <div class='after-click-effect'></div>
                </li>

            </ul>

        </div>
        <a class='ddbox-hor-scroller hor-scroller-left'>
            <div class='ddbox-hor-scroller-cont'>
            </div>
            <i class='ddbox-hor-scroll-icon-left'>
            </i>
        </a>
        <a class='ddbox-hor-scroller hor-scroller-right'>
            <div class='ddbox-hor-scroller-cont'>
            </div>
            <i class='ddbox-hor-scroll-icon-right'>
            </i>
        </a>

    </div>

</div>
<div class='about-tab-prof about-tab-block'>
    <a class='prof-header'>
        <div class='tab-block-header'>
            <div class='block-head-left'>
                PROFESSOR GARRIGAN
            </div>

        </div>
    </a>
</div>
<div class='about-tab-ratings about-tab-block'>
<div class='tab-block-header'>
    <div class='block-head-left'>
        COURSE REVIEWS <span>(28)</span> <span class='tab-block-view'>View all</span>
    </div>


</div>
<div class='tab-block-content tab-block-content-reviews'>
<div class='tab-block-topsec'>
    <div class='tab-block-left'>
        <div class='reviews-average'>
            <div class='reviews-sec-header-2'>Average Rating<span> (28 students reviewed)</span></div>
            <h2>4.6</h2>

            <div class='reviews-rating'>
                <div class='rating-stars-filled'>
                    <div class='rating_star'>
                        <img class='img' src='src/filled_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/filled_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/filled_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/filled_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/filled_star.png'>
                    </div>
                </div>
                <div class='rating-stars-empty'>
                    <div class='rating_star'>
                        <img class='img' src='src/empty_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/empty_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/empty_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/empty_star.png'>
                    </div>
                    <div class='rating_star'>
                        <img class='img' src='src/empty_star.png'>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class='tab-block-right'>

        <div class='reviews-distribution'>
            <div class='reviews-sec-header'>Distribution</div>
            <div class='lfloat dist-stars'>
                <div class='star-dist'>
                    5 &#9733;
                </div>
                <div class='star-dist'>
                    4 &#9733;
                </div>
                <div class='star-dist'>
                    3 &#9733;
                </div>
                <div class='star-dist'>
                    2 &#9733;
                </div>
                <div class='star-dist'>
                    1 &#9733;
                </div>
            </div>
            <div class='rfloat dist-bars'>
                <div class='dist-bar-wrap'>
                    <div class='bar-dist'></div>
                    <div class='bar-val'>9</div>
                </div>
                <div class='dist-bar-wrap'>
                    <div class='bar-dist'></div>
                    <div class='bar-val'>7</div>
                </div>
                <div class='dist-bar-wrap'>
                    <div class='bar-dist'></div>
                    <div class='bar-val'>5</div>
                </div>
                <div class='dist-bar-wrap'>
                    <div class='bar-dist'></div>
                    <div class='bar-val'>2</div>
                </div>
                <div class='dist-bar-wrap'>
                    <div class='bar-dist'></div>
                    <div class='bar-val'>5</div>
                </div>
            </div>
        </div>
        <div class='create-review-btn'>
            Write a Review
        </div>
    </div>
</div>
<div class='tab-block-reviewssec'>
    <div class='tab-block-create-review'>
        <div class='create-rating-stars-filled'>
            <div class='rating_star r_s_ur rating_star_unrated rating_star_unrated1'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star r_s_ur rating_star_unrated rating_star_unrated2'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star r_s_ur rating_star_unrated rating_star_unrated3'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star r_s_ur rating_star_unrated rating_star_unrated4'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star r_s_ur rating_star_unrated rating_star_unrated5'>
                <img class='img' src='src/filled_star.png'>

            </div>

        </div>


        <div class='grade_stars'>
            <div class='rating_star grey_star r_s_ur grating_star_unrated1'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star grey_star r_s_ur grating_star_unrated2'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star grey_star r_s_ur grating_star_unrated3'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star grey_star r_s_ur grating_star_unrated4'>
                <img class='img' src='src/filled_star.png'>

            </div>
            <div class='rating_star grey_star r_s_ur grating_star_unrated5'>
                <img class='img' src='src/filled_star.png'>

            </div>
        </div>


        <div class='create-rating-stars-empty'>
            <div class='r_s_ur rating_star rating_star_empty1'>
                <img class='img' src='src/empty_star.png'>
            </div>
            <div class='r_s_ur rating_star rating_star_empty2'>
                <img class='img' src='src/empty_star.png'>
            </div>
            <div class='r_s_ur rating_star rating_star_empty3'>
                <img class='img' src='src/empty_star.png'>
            </div>
            <div class='r_s_ur rating_star rating_star_empty4'>
                <img class='img' src='src/empty_star.png'>
            </div>
            <div class='r_s_ur rating_star rating_star_empty5'>
                <img class='img' src='src/empty_star.png'>
            </div>
        </div>
        <div class='help-div' id='help-star-1'>
            <div class='help-star-wedge'>
            </div>
            <div class='help-star-box'>
                Poor
            </div>
        </div>
        <div class='help-div' id='help-star-2'>
            <div class='help-star-wedge'>
            </div>
            <div class='help-star-box'>
                Fair
            </div>
        </div>
        <div class='help-div' id='help-star-3'>
            <div class='help-star-wedge'>
            </div>
            <div class='help-star-box'>
                Good
            </div>
        </div>

        <div class='help-div' id='help-star-4'>
            <div class='help-star-wedge'>
            </div>
            <div class='help-star-box'>
                Very Good
            </div>
        </div>
        <div class='help-div' id='help-star-5'>
            <div class='help-star-wedge'>
            </div>
            <div class='help-star-box'>
                Excellent
            </div>
        </div>


    </div>
    <div class='tab-block-review'>
        <div class='review-pic'>
        </div>
        <div class='review-rightsec'>
            <div class='reviewer-name'>
                Jacqueline Herssens
            </div>
            <div class='reviewer-rating'>
            </div>
            <div class='review-text'>
                Neurochemical Foundations of Behavior.... in the title of this establishment alone, you have everything
                that a student interested in psychology and medicine should love and recognize as awesome. Of all the
                courses I took in college, this one was definitely the greatest. For sure a 'must take' class in the
                Neuro department. Professor Miller is the absolute best!
            </div>
            <div class='review-actions'>
                <button class='like-btn'></button>
														<span class='midline-dot'>
															&#183;
														</span>

            </div>
        </div>
    </div>
</div>
</div>
</div>


</div>
<div class='about-tab-rightsec'>
    <div class='group-about group-about-2'>
        <div class='box-header'>
										<span class='bh-t1'>
											RECENT UPLOAD
										</span>
										<span class='midline-dot'>
											&#183;
										</span>
            <a style='font-weight:600;' class='bh-t2'>
                Upload a file
            </a>
        </div>
        <div class='box-content content-file'>
            <a class='file-download'>
                <div class='file-icon'>
                </div>
                <div class='file-name'>
                    Who is Ross Kopelman?
                </div>
            </a>

            <div class='file-created'>
                <a class='file-creator'>Jacob Lazarus</a> <span> uploaded July 8th</span>
            </div>
        </div>

        <div class='box-header'>
            <a class='bh-t2'>
                Invite email list
            </a>
        </div>
        <div class='box-content content-invite'>
            <form rel='' method='post'>
                <input type='hidden' autocomplete='off'>
                <i class='plusIcon'></i>

                <div class='invite-input-wrap'>
                    <div class='innerWrap'>
                        <input type='text' class='inputText inviteInput' name='Invite form'
                               placeholder='Invite people to join this course'>

                        <div class='search-icon' title='Search people'>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class='group-about-subjects'>
        <div class='box-header'>
            Course <strong> Topics</strong>
										<span class='help-icon-right'>
										</span>

            <div class='help-div' id='help-1'>
                <div class='help-wedge'>
                </div>
                <div class='help-box'>
                    Add up to 10 topics that are covered in this course. Drag subjects up or down to order them as you
                    like.
                </div>
            </div>
        </div>
        <div class='group-subjects-wrap'>
            <ul class='group-subjects ui-sortable'>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Genomics
                </li>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Statistical Biology
                </li>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Biological Algorithms
                </li>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Data Mining
                </li>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Neural Networks
                </li>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Neural Networks
                </li>
                <li class='ui-state-default subject'>
                    <div class='sortable_head_icon'></div>
                    Neural Networks
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php mysqli_close($con); ?>

</body>


</html>