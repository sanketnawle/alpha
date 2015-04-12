<!DOCTYPE html>
<?php
include "php/redirect.php";
?>
<html>
<head>
<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
<link rel='stylesheet' type='text/css' href='css/backgroundGroup.css'>
<link rel = 'stylesheet' type = 'text/css' href = 'css/group.css'>
<link rel = 'stylesheet' type = 'text/css' href = 'css/coursesCardUI.css'>
<link rel = 'stylesheet' type = 'text/css' href = 'css/courses.css'>
<link rel = 'stylesheet' type = 'text/css' href = 'css/school_department.css'>
<link rel = 'stylesheet' type = 'text/css' href = 'css/planner_for_course.css'>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'>
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

<link rel='stylesheet' href='//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css'>

<script>


$(document).ready(function() {

    var course_id= $(".course-group-title").find(".group-id").text().trim();
/*Start Learn Button Animation JQUERY */

     $(document).delegate('.studybtn','mouseenter',function(){
        var thisBox = $(this).closest('.coursesBtns').find('.study_box_open');
        $(this).closest('.coursesBtns').find('.modal_loading2').css({'display':'none','opacity':'0'});
        $(this).closest('.coursesBtns').find('.js_wrap').css({'height':'auto','opacity':'1'});
        $(this).closest('.coursesBtns').find('.study_box_open').show();
        setTimeout(
            function(){
             $(thisBox).css({'top':'3px','height':'18px','opacity': '1'});
             setTimeout(
            function(){
                $(thisBox).css({'height':'150px'});
            },
            300)
            },
            250)


    });


     $(document).delegate('.study_box_open','mouseleave',function(){
        var thisBox = $(this);
        setTimeout(
            function(){
               $(thisBox).css({'top':'3px','height':'0px','opacity': '0'});
                setTimeout(function(){
                $(thisBox).hide();
            },
            300)
            },
            250)
    });


     $(document).delegate('.study_type_btn','click', function(){

        if(!$(this).hasClass('pressedGraybtn')){
            $(this).find('.check').animate({left:0,opacity:0},150, function(){
                    $(this).find('.check').delay(400).hide();
            });
            $('.pressedGraybtn').removeClass('pressedGraybtn');
            $(this).prepend('<em class = "check"></em>');
            $(this).find('.check').animate({left:16,opacity:1},200, function(){
                $(this).closest('.js_wrap').delay(250).animate({height:0,opacity:0},300);
                $('.modal_loading2').show();
                $('.modal_loading2').delay(500).animate({opacity:1},100, function(){
                    setTimeout(
                        function(){
                            $('.study_box_open').css({'top':'3px','height':'0px','opacity': '0'});

                        },
                        200)

                });


            });

            $(this).addClass('pressedGraybtn');


            if($(this).hasClass('majorType')){
                $(this).closest('.coursesBtns').find('.studybtn').text('My Major');
            }
            if($(this).hasClass('minorType')){
                $(this).closest('.coursesBtns').find('.studybtn').text('My Minor');
            }
            if($(this).hasClass('interestType')){
                $(this).closest('.coursesBtns').find('.studybtn').text('My Interest');
            }


        }




        else{
            $(this).find('.check').animate({left:0,opacity:0},150, function(){
                $(this).find('.check').delay(400).hide();
            });
            $(this).removeClass('pressedGraybtn');
            $('.studybtn').text('Concentrate');

        }

    });

/*End Learn Button Animation JQUERY */







    $('.group_location').mouseenter(function(){
        $(this).closest('.group-head-top-sec').find('.location-pic-div-wrap').show();
        $(this).closest('.group-head-top-sec').find('.modal_loading3').delay(200).animate({opacity:0},150, function(){
                $(this).closest('.group-head-top-sec').find('.location-pic-container').delay(50).css({'height':'160'});
                $(this).closest('.group-head-top-sec').find('.location_building_pic').show();

        });





    });


    $('.group_location').mouseleave(function(){
        $(this).closest('.group-head-top-sec').find('.location-pic-div-wrap').hide();
        $(this).closest('.group-head-top-sec').find('.location-pic-container').css({'height':'60px'});
        $(this).closest('.group-head-top-sec').find('.modal_loading3').css({'opacity':'1'});
        $(this).closest('.group-head-top-sec').find('.location_building_pic').hide();
    });

    /*jQuery for showing more or less classes, and movement of related about div 

    $(document).delegate('.moreClasses','click', function(){

            if(!$(this).hasClass('lessClasses')){
                $(this).addClass('lessClasses');
                $('.hidden').show();
                $(this).find('span').text('Hide 3 Classes');
                $('.moreClassesIcon').addClass('lessClassesIcon');
                $('.feed-tab-rightsec').css('margin-top','182px');

            }
            else{
                $(this).removeClass('lessClasses');
                $('.hidden').hide();
                $(this).find('span').text('3 More Classes');
                $('.moreClassesIcon').removeClass('lessClassesIcon');
                $('.feed-tab-rightsec').css('margin-top','0px');
            }




    });

*/


    $(window).scroll(function() {
        if($('.tabFeed').hasClass('group-tab-active')){
            if($(window).scrollTop()>203){
                $('.uiHeaderFx').css({'border-bottom-color':'transparent','background-image':'none'});

            }
            else{
                $('.uiHeaderFx').css({
                            'border-bottom-color':'#e9eaed',
                            'background-image': '-moz-linear-gradient(45deg,#F7F7F7,#F0F0F0)',
                            'background-image': '-webkit-linear-gradient(45deg,#F7F7F7,#F0F0F0)',
                            'background-image': 'linear-gradient(45deg,#F7F7F7,#F0F0F0)'
                    });
            }
        }

    });

    /*
    $(window).scroll(function() {

        if($('.tabFeed').hasClass('group-tab-active')){
            if($('.moreClasses').hasClass('lessClasses')){
                if($(window).scrollTop()>35){
                    $('.feed-tab-rightsec').css({'position':'fixed','margin-top':'192px'});
                    $('.classesExpandUI').css({'border-radius':'4px','position':'fixed','top':'58px','left':'1028px',
                        '-webkit-box-shadow': '0px 1px 2px rgba(0,0,0,0.2)',
                        '-moz-box-shadow': '0px 1px 2px rgba(0,0,0,0.2)',
                        'box-shadow': '0px 1px 2px rgba(0,0,0,0.2)'
                    });

                }
                else{
                    $('.feed-tab-rightsec').css({'position':'relative','margin-top':'184px'});
                    $('.classesExpandUI').css({'border-radius':'4px', 'position':'absolute','top':'45px','left':'initial',
                        '-webkit-box-shadow': 'none',
                        '-moz-box-shadow': 'none',
                        'box-shadow': 'none'
                    });

                }
            }
            else{
                if($(window).scrollTop()>35){
                    $('.feed-tab-rightsec').css({'position':'fixed','margin-top':'10px'});
                    $('.classesExpandUI').css({'border-radius':'4px','position':'fixed','top':'58px','left':'1028px',
                        '-webkit-box-shadow': '0px 1px 2px rgba(0,0,0,0.2)',
                        '-moz-box-shadow': '0px 1px 2px rgba(0,0,0,0.2)',
                        'box-shadow': '0px 1px 2px rgba(0,0,0,0.2)'
                    });

                }
                else{
                    $('.feed-tab-rightsec').css({'position':'relative','margin-top':'0px'});
                    $('.classesExpandUI').css({'border-radius':'4px', 'position':'absolute','top':'45px','left':'initial',
                        '-webkit-box-shadow': 'none',
                        '-moz-box-shadow': 'none',
                        'box-shadow': 'none'
                    });

                }
            }

        }



    });

*/


/*good mark 2*/
    $('.cancelBtn').click(function(){
        $('.modal_body').animate({opacity:0},300,function(){
            $(this).closest('.modal_body').hide();
            $('.modal_coverPhoto_container').css({'height':'60px','width':'320px'});
            $('.modal_content').hide();
            $('.modal_content').css('opacity','0');
            $('.main').removeClass('fe');
        });

    });

    $('.filterselectorBtn').mousedown(function(){

        if(!$(this).hasClass('selectorBtnDown')){
            $(this).addClass('selectorBtnDown');
            $(this).closest('.uiToggle').addClass('openToggle');
        }
        else{
            $(this).removeClass('selectorBtnDown');
            $(this).closest('.uiToggle').removeClass('openToggle');
        }

    });



     $(document).on('mousedown', function (e) {
        var elem = $(e.target);
        if (elem.hasClass('uiFlyout') || elem.hasClass('uiMenu') || elem.hasClass('MenuInner') || elem.hasClass('menuItem') || elem.hasClass('li.menuItem a') || elem.hasClass('filterselectorBtn')) {
            return;
        }
        else {
           $('.filterselectorBtn').removeClass('selectorBtnDown');
            $('.filterselectorBtn').closest('.uiToggle').removeClass('openToggle');
        }
    });





    $('.upload_cover').click(function(){
        $('.modal_loading').show();
        $('.modal_loading').css('opacity','1');
        $('.main').addClass('fe');
        $('.modal_coverPhoto_body').show();
        $('.modal_coverPhoto_body').animate({opacity:1},400, function(){
            $('.modal_loading').delay(250).animate({opacity:0},100);
            $('.modal_loading').hide();
            $('.modal_content').show();
            $('.modal_content').delay(500).animate({opacity:1},200);
            $('.modal_coverPhoto_container').animate({
                height:355,
                width:520
            },500, function(){
                $('.inputPhotoName').focus();
            });
        });
        $('html, body').animate({ scrollTop: 150 }, 600);

        return false;
     });


/*good mark 1*/
    $(document).delegate('.followBtn','click',function(){
        if(!$(this).hasClass('unfollowBtn')){
            $('.study_box_open').css('left','112px');
            $(this).html('<em class = "unfollow-icon"></em>Following this Course');
            $(this).addClass('unfollowBtn');
        }
        else{
            $('.study_box_open').css('left','88px');
            $(this).html('<em></em>Follow this Course');
            $(this).removeClass('unfollowBtn');
        }

            $ref=$(this);
            $.ajax({
                type: "POST",
                url: "php/course_follow.php",
                data: {id: course_id, course: true},
                success: function (html) {
                    //alert("a");
                },
                error: function (html) {
                    //alert("b");
                }
            });

    });

    $(document).delegate('.joinBtn','click',function(){
        if(!$(this).hasClass('joinedBtn')){
            $(this).html('<img class = "modal_animation" src = "src/loadingAnimation.gif">');
            $(this).delay(450).queue(function(){
                $(this).html('Member');
                $(this).addClass('joinedBtn'); 
            });
        }else{
             $(this).removeClass('joinedBtn');
             $(this).text('Join');
        }

        var class_id="";
        var class_id=($(this).closest(".courses-selector").attr("id"))||($(this).closest(".classLi").attr("id"));
        

        $ref=$(this);
            $.ajax({
                type: "POST",
                url: "php/class_enroll.php",
                data: {class_id: class_id},
                success: function (html) {
                    //alert("a");
                },
                error: function (html) {
                    //alert("b");
                }
            });
    });

    $(document).delegate('.moreClasses','click',function(){
        $(".tabCourse").click();
    });

    $(document).delegate('.joinedBtn','mouseover',function(){
        $(this).html('Leave');
    });
    $(document).delegate('.joinedBtn','mouseleave',function(){
        $(this).html('Member');
    });
    /* THIS IS the navigational javascript for the courses page */

    $(document).delegate('.tab-inactive','click',function(){
        if ($(this).hasClass('tabCourse')) {
            $('.feed-tab-rightsec').css('margin-top','0px');
            $('.classesExpandUI').css({'border-radius':'4px', 'position':'absolute','top':'45px','left':'initial',
                    '-webkit-box-shadow': 'none',
                    '-moz-box-shadow': 'none',
                    'box-shadow': 'none'
            });
            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab1-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab1-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab1-icon-inactive');
            }
            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabAbout-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabAbout-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabAbout-icon-inactive');
            }
            if ($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab2-icon-active')) {
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab2-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab2-icon-inactive');
            }
            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab3-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab3-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab3-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabc-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabc-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabc-icon-inactive');
            }
            //$(this).find('.tab-title').find('.tab-icon').removeClass('tabClasses-icon-inactive');
            //$(this).find('.tab-title').find('.tab-icon').addClass('tabClasses-icon-active');

            $(this).find('.tab-title').find('.tab-icon').removeClass('tabClasses-icon-inactive');
            $(this).find('.tab-title').find('.tab-icon').addClass('tabClasses-icon-active');
            $('.group-tab-active').addClass('tab-inactive');
            $('.group-tab-active').removeClass('group-tab-active');
            $('.tab-wedge-down').css('left','475px');
            $(this).removeClass('tab-inactive');
            $(this).addClass('group-tab-active');
            $('.feed-tab-content').hide();
            $('.feed-tab-content').stop().animate({ opacity: '0'},300);
            $('.syllabus-tab-content').stop().animate({ opacity: '0'},300);
            $('.syllabus-tab-content').hide();
            $('.about-content').stop().animate({ opacity: '0'},300);
            $('.about-content').hide();
            $('.files-tab-content').stop().animate({ opacity: '0'},300);
            $('.files-tab-content').hide();
            $('.members-tab-content').stop().animate({ opacity: '0'},300);
            $('.members-tab-content').hide();
            $('.courses-tab-content').animate({ opacity: '1'},300);
            $('.courses-tab-content').show();
        }
        if($(this).hasClass('tabAbout')){
            $('.feed-tab-rightsec').css('margin-top','0px');

            $('.classesExpandUI').css({'border-radius':'4px', 'position':'absolute','top':'45px','left':'initial',
                    '-webkit-box-shadow': 'none',
                    '-moz-box-shadow': 'none',
                    'box-shadow': 'none'
            });


            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabc-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabc-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabc-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab2-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab2-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab2-icon-inactive');
            }
            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab1-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab1-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab1-icon-inactive');
            }
            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabClasses-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabClasses-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabClasses-icon-inactive');
            }


            $(this).find('.tab-title').find('.tab-icon').removeClass('tabAbout-icon-inactive');
            $(this).find('.tab-title').find('.tab-icon').addClass('tabAbout-icon-active');
            $('.group-tab-active').addClass('tab-inactive');
            $('.group-tab-active').removeClass('group-tab-active');
            $('.tab-wedge-down').css('left','591px');
            $(this).removeClass('tab-inactive');
            $(this).addClass('group-tab-active');

            $('.feed-tab-content').stop().animate({ opacity: '0'},300);
            $('.feed-tab-content').hide();
            $('.departments-tab-content').stop().animate({ opacity: '0'},300);
            $('.departments-tab-content').hide();
            $('.syllabus-tab-content').stop().animate({ opacity: '0'},300);
            $('.syllabus-tab-content').hide();
            $('.about-content').stop().animate({ opacity: '0'},300);
            $('.about-content').hide();
            $('.files-tab-content').stop().animate({ opacity: '0'},300);
            $('.files-tab-content').hide()



            $('.members-tab-content').show();
            $('.members-tab-content').animate({ opacity: '1'},300);




        }

        if($(this).hasClass('tabFeed')){




            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabc-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabc-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabc-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabAbout-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabAbout-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabAbout-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabc-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabc-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabc-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tabClasses-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tabClasses-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tabClasses-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab2-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab2-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab2-icon-inactive');
            }

            if($('.group-tab-active').find('.tab-title').find('.tab-icon').hasClass('tab3-icon-active')){
                $('.group-tab-active').find('.tab-title').find('.tab-icon').removeClass('tab3-icon-active');
                $('.group-tab-active').find('.tab-title').find('.tab-icon').addClass('tab3-icon-inactive');
            }

            $(this).find('.tab-title').find('.tab-icon').removeClass('tab1-icon-inactive');
            $(this).find('.tab-title').find('.tab-icon').addClass('tab1-icon-active');
            $('.group-tab-active').addClass('tab-inactive');
            $('.group-tab-active').removeClass('group-tab-active');
            $('.tab-wedge-down').css('left','310px');
            $(this).removeClass('tab-inactive');
            $(this).addClass('group-tab-active');


            $('.syllabus-tab-content').stop().animate({ opacity: '0'},300);
            $('.syllabus-tab-content').hide();
            $('.about-content').stop().animate({ opacity: '0'},300);
            $('.about-content').hide();
            $('.files-tab-content').stop().animate({ opacity: '0'},300);
            $('.files-tab-content').hide()
            $('.members-tab-content').stop().animate({ opacity: '0'},300);
            $('.members-tab-content').hide();
            $('.courses-tab-content').stop().animate({ opacity: '0'},300);
            $('.courses-tab-content').hide();
            $('.departments-tab-content').stop().animate({ opacity: '0'},300);
            $('.departments-tab-content').hide();
            $('.feed-tab-content').show();
            $('.feed-tab-content').animate({ opacity: '1'},300);

        }
    });

$('.courseDescription').text().substr(0,100) + '...';


    $(document).delegate(".group-pic", "click", function () {
        $(this).closest(".group-pic-frame").find(".courses_pic_input").click();
        return false;
    });

    $(document).delegate(".courses_pic_input", "change", function () {
        var $ref = $(this);
        //var course_id=$(this).closest(".root").find(".group-id").text().trim();
        var formData = new FormData($ref.closest("form")[0]);
        var editing = "display";
        formData.append("editing", editing);
        formData.append("id", course_id);
        formData.append("course",true);
        $.ajax({
            type: "POST",
            url: "php/edit_class_pictures.php",
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Check if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },

            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (html) {
                var jsonstring = "";
                if (html.user_dp.length > 0) {
                    jsonstring = html.user_dp[0]['img_url'];
                }
                ////alert(html);

                $ref.closest(".group-pic-frame").find(".group-pic").css({"background-image": "url(" + jsonstring + ")"});

            },
            error: function (html) {
                //alert(html);
            }
        });

    });

    /*progress function for ajax*/
    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('progress').attr({value: e.loaded, max: e.total});
        }
    }

});

</script>
</head>
<body>
    <div class = 'root'>
    <div class='gp_topbar_wrap'>
        <?php include("topbar.php"); ?>
    </div>

    <section>
        <?php include("leftpanel.php"); ?>
    </section>


        <div class = 'modal_coverPhoto_body modal_body'>
            <div class = 'modal_coverPhoto_container'>
                <div class = 'modal_loading'>
                    <img class = 'modal_animation' src = 'src/loadingAnimation.gif'>
                </div>
                <div class = 'modal_content'>
                    <div class = 'modal_header'>
                        <span claSubmit ss = 'floatL white'>
                            Cover Photo
                        </span>
                        <em class = 'floatR cancelBtn close'>
                        </em>
                    </div>
                    <div class = 'modal_main'>
                        <form>
                            <label for = 'cover_name' class = 'label_left'>
                                Cover Photo Name
                            </label>
                            <input class = 'inputBig inputPhotoName' id = 'cover_name' placeholder = 'Enter a name for this photo...'>
                            <div class = 'uploadedPhotoFrame'>
                                <div class = 'noPhotoText'>
                                    No photo uploaded
                                </div>
                                <div class = 'photoicon'>
                                </div>

                                <button class = 'uploadPhotoBtn'>
                                    Upload Photo
                                </button>
                            </div>
                            <div class = 'btmleft'>

                                <button type=  'button' class = 'cancelBtn grayBtn'>
                                    Cancel
                                </button>
                                <button type=  'button' class = 'blueBtn'>
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class = 'main'>
            <div class = 'main-mid-sec'>

                <div class = 'mid_right_sec mid_right_sec_course'>
                <?php include('course_header.php');?>
                    <div class = 'midsec'>
                        <?php include('course_feed_tab.php')?>
                        <?php include('course_classes_tab.php');?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>


</html> 
