<!DOCTYPE html>
<?php include('php/redirect.php'); ?>
<html>
<head>
<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
<link rel='stylesheet' type='text/css' href='school_alpha/backgroundGroup.css'>

<link rel='stylesheet' type='text/css' href='school_alpha/group.css'>
<link rel='stylesheet' type='text/css' href='school_alpha/school_department.css'>
<link rel='stylesheet' type='text/css' href='css/coursesCardUI.css'>
<link rel='stylesheet' type='text/css' href='css/dept.css'>

<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link
    href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
    rel='stylesheet' type='text/css'>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

<script>


$(document).ready(function() {
    $.urlParam = function (sParam) {

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) 
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) 
            {
                return sParameterName[1];
            }
        }

    }
    var univ_id = $.urlParam('dept_id');


          var feed=$('.feed-tab-content').clone();
          var about=$('.about-content').clone();
           var about_text = feed.find(".content-about").text();
         //alert(about_text);
    if(about_text.length>=73){
        about_text= about_text.substring(0,70)+"..." + "<span class='bh-t2'> <a id = 'group-about-link' class = 'bh-t2'>Read More</a></span>";
        $(".content-about").html(about_text);
    }
    $(document).delegate(".search-icon","click",function(){
            $(".inputText").focus();
    });
    $(document).delegate(".plusIcon","click",function(){
        $(".inviteInput").focus();
    });
     $(document).delegate(".bh-t2","click",function(){

        $(".about-content").stop().animate({ opacity: "1"},300);
            $(".about-content").show();
    
     });


         $(document).delegate(".studybtn","mouseenter",function(){
                var thisBox = $(this).closest(".deptBtns").find(".study_box_open");   
                $(this).closest(".deptBtns").find(".modal_loading2").css({"display":"none","opacity":"0"});
                $(this).closest(".deptBtns").find(".js_wrap").css({"height":"auto","opacity":"1"});
                $(this).closest(".deptBtns").find(".study_box_open").show();
                setTimeout(
                    function(){
                     $(thisBox).stop().css({"top":"3px","height":"18px","opacity": "1"});
                     setTimeout(
                    function(){
                        $(thisBox).stop().css({"height":"150px"});
                    },
                    300)
                    },
                    250)


            });

                  $(document).delegate(".uploadedPhotoFrame","click",function(){
                    $(this).closest("form").find(".cover_photo_upload").click();
                  });
            
            $(document).delegate(".cover_photo_upload","change",function(){
                 var $ref= $(this);
                var formData= new FormData( $ref.closest("form")[0]);
                var editing="show";
                /*
                if(univ_id.trim()!=""){
                    t_univ_id=univ_id;
                }*/

                formData.append("editing",editing);
                formData.append("id", univ_id);
                formData.append("departmet",true);
                $.ajax({
                            type: "POST",
                            url: "edit_school_pictures.php",
                            xhr: function() {  // Custom XMLHttpRequest
                                var myXhr = $.ajaxSettings.xhr();
                                if(myXhr.upload){ // Check if upload property exists
                                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                                    }
                             return myXhr;
                            },

                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(html){
                                //alert(html);
                                $ref.closest("form").find(".uploadedPhotoFrame").hide();
                                alert(html);
                                alert("ad");
                                $ref.closest("form").find(".uploadedPhotoFrame_display").css({"background-image":"url("+html+")"});
                                $ref.closest("form").find(".uploadedPhotoFrame_display").show();

                            },
                            error: function(html){
                                alert(html);
                                alert("asfw");
                            }
                        });
            });

            $(document).delegate(".pt_upload_button", "click", function () {
                alert("a");
                var $ref = $(this);
                var formData = new FormData($ref.closest("form")[0]);
                var editing = "cover";

                formData.append("editing", editing);
                formData.append("id", univ_id);
                formData.append("department",true);
                alert("b");
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
                        alert("4");
                        var jsonstring = "";
                        if (html.user_dp.length > 0) {
                            jsonstring = html.user_dp[0]['img_url'];
                        }
                        alert("c");
                        $ref.closest("form").find(".uploadedPhotoFrame").show();
                        alert("d");
                        $ref.closest("form").find(".uploadedPhotoFrame_display").hide();
                        $(".cancelBtn").click();


                        $(".group-cover-picture").css({"background-image": "url(" + jsonstring + ")"});

                    },
                    error: function (html) {
                        alert(html);
                    }
                });
            });

    $(document).delegate(".group-pic", "click", function () {
        $(this).closest(".group-pic-frame").find(".header_small_img_input").click();
    });

    $(document).delegate(".header_small_img_input", "change", function () {
        var $ref = $(this);
        var formData = new FormData($ref.closest("form")[0]);
        var editing = "display";

        formData.append("editing", editing);
        formData.append("id", univ_id);
        formData.append("department",true);
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
                //alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame").show();
                alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame_display").hide();
                $(".cancelBtn").click();


                $ref.closest(".group-pic-frame").find(".group-pic").css({"background-image": "url(" + jsonstring + ")"});

            },
            error: function (html) {
                alert(html);
            }
        });
    });


    $(document).delegate(".cancelBtn", "click", function () {
        $(".modal_body").animate({opacity: 0}, 300, function () {
            $(this).closest(".modal_body").hide();
            $(".modal_invite_container").css({"height": "60px", "width": "320px"});
            $(".modal_content").hide();
            $(".modal_content").css("opacity", "0");
            $(".main").removeClass("fe");

            $(".uploadedPhotoFrame_display").html("");
            $(".uploadedPhotoFrame_display").hide();
            $(".uploadedPhotoFrame").show();
        });
    });

             $(document).delegate('.study_box_open',"mouseleave",function(){

                var thisBox = $(this);    
                setTimeout(
                    function(){

                       $(thisBox).stop().css({"top":"3px","height":"0px","opacity": "0"});
                        setTimeout(function(){
                        $(thisBox).stop().hide();
                    },
                    300)
                    }, 
                    250)
            });

             $(document).delegate('.study_type_btn',"click", function(){
                    var $rtbtn= $(this);
                   
                        if($rtbtn.hasClass("majorType")){
                            $(".btn_mymajor").text("Concentrate");
                            $(".btn_mymajor").removeClass("btn_mymajor");
                        }
                        if($rtbtn.hasClass("minorType")){
                            $(".btn_myminor").text("Concentrate");
                            $(".btn_myminor").removeClass("btn_myminor");
                        }


                  var type=$(this).attr('id').replace(/\d+/g, '');
                        var dept_id=$(this).attr('id').replace(/[^\d.]/g, '');
                        alert("selected dept"+dept_id);

                        dept_id=parseInt(dept_id);
                        if(type=="major"){
                            type=1;
                            alert("in major"+type);
                        }else if(type=="minor"){
                            type=2;
                            alert("in minor"+type);
                        }else{
                            type=3;
                            alert("in interested"+type);
                        }
                        $.ajax({  
                            type: "POST", 
                                    url:"php/getdepartment.php",
                                    data: {dept_id:dept_id,type:type},
                                    success: function(response) {
                                        console.log(response);
                                    }
                            });
                
                if(!$(this).hasClass("pressedGraybtn")){
                        /*clean part*/
                        $(this).closest(".study_first_option").find(".majorType").removeClass("pressedGraybtn");
                        $(this).closest(".study_first_option").find(".minorType").removeClass("pressedGraybtn");
                        $(this).closest(".study_first_option").find(".interestType").removeClass("pressedGraybtn");
                        $(this).closest(".study_first_option").find(".majorType").find(".check").remove();
                        $(this).closest(".study_first_option").find(".minorType").find(".check").remove();
                        $(this).closest(".study_first_option").find(".interestType").find(".check").remove();

                        /*add part*/
                        $(this).addClass("pressedGraybtn");
                        $(this).prepend("<em class = 'check'></em>");
                        $(this).find(".check").animate({left:16,opacity:1},200, function(){
                            $(this).closest(".js_wrap").delay(250).animate({height:0,opacity:0},300);
                            $(".modal_loading2").show();
                            $(".modal_loading2").delay(500).animate({opacity:1},100, function(){
                                setTimeout(
                                    function(){
                                        $(".study_box_open").css({"top":"3px","height":"0px","opacity": "0"});

                                    },
                                    200) 
                            });
                        });


                      
                        if($(this).hasClass("majorType")){
                            
                           
                            $(this).closest(".deptBtns").find(".studybtn").text("My Major");
                            $(this).closest(".deptBtns").find(".studybtn").addClass("btn_mymajor");
                        }else
                        if($(this).hasClass("minorType")){
                            $(this).closest(".deptBtns").find(".studybtn").text("My Minor");
                            $(this).closest(".deptBtns").find(".studybtn").addClass("btn_myminor");
                        }else
                        if($(this).hasClass("interestType")){
                            console.log($(this).attr('id'));
                            console.log("in interested type");
                            $(this).closest(".deptBtns").find(".studybtn").text("My Interest");
                        }


                }else{
                    
                    $(this).find(".check").animate({left:0,opacity:0},150, function(){
                        $(this).find(".check").delay(400).hide();
                    });
                    $(this).removeClass("pressedGraybtn");
                    $(".studybtn").text("Concentrate");
                    
                }
                
            });



    $('.group_location').mouseenter(function(){
        $(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").show();
        $(this).closest(".group-head-top-sec").find(".modal_loading3").delay(200).animate({opacity:0},150, function(){
                $(this).closest(".group-head-top-sec").find(".location-pic-container").delay(50).css({"height":"160"});
                $(this).closest(".group-head-top-sec").find(".location_building_pic").show();

        });





    });


    $('.group_location').mouseleave(function(){
        $(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").hide();
        $(this).closest(".group-head-top-sec").find(".location-pic-container").css({"height":"60px"});
        $(this).closest(".group-head-top-sec").find(".modal_loading3").css({"opacity":"1"});
        $(this).closest(".group-head-top-sec").find(".location_building_pic").hide();
    });




    $(document).delegate('.group-cover-pic-info',"click", function(){
        $('body,html').animate({
                scrollTop: 0
            }, 200);
    });

    $(window).scroll(function() {
        var y=$(window).scrollTop()*0.32;
        var x=$(window).scrollTop()*1;
        //alert(y);
        $(".group-cover-picture").css({"transform":"translateY("+y+"px)"});
        $(".spec-group-header-right").css({"height":y+"px"});

        if($(window).scrollTop()>=5){
            $(".info-scroll-up").css("cursor","pointer");
            $(".em_hide").css({
                "width":"12px",
                "opacity":"1"
            });
        }
        else{
            $(".info-scroll-up").css("cursor","default");
            $(".em_hide").css({
                "width":"0",
                "opacity":"0"
            });
        }


    });

    $(window).scroll(function() {

        if($(window).scrollTop()>175){
            $(".info-scroll-up").css({"position":"absolute","top":"175px"});
            $(".spec-group-header-right").css({"position":"absolute","top":"177px","left":"777px"})
        }
        else{
            $(".info-scroll-up").css({"position":"fixed","top":"50px"});
            $(".spec-group-header-right").css({"position":"fixed","top":"50px","left":"1097px"});
        }

    });

    $('.cancelBtn').click(function(){
        $(".modal_body").animate({opacity:0},300,function(){
            $(this).closest(".modal_body").hide();
            $(".modal_coverPhoto_container").css({"height":"60px","width":"320px"});
            $(".modal_content").hide();
            $(".modal_content").css("opacity","0");
            $(".main").removeClass("fe");
        });

    });

    $('.upload_cover').click(function(){
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
                height:355,
                width:520
            },500, function(){
                $(".inputPhotoName").focus();
            });
        });
        $("html, body").animate({ scrollTop: 150 }, 600);

        return false;
     });


    $(document).delegate(".followBtn","click",function(){
        
        if(!$(this).hasClass("unfollowBtn")){
            $(".study_box_open").css("left","112px");
            $(this).html("<em class = 'unfollow-icon'></em>Unfollow");
            $(this).addClass("unfollowBtn");
        }
        else{
            $(".study_box_open").css("left","88px");
            $(this).html("<em></em>Follow");
            $(this).removeClass("unfollowBtn");
        }
        $.ajax({
            type:'post',
            url:'php/course_follow.php',
            data:{id:univ_id, dept: true},
            success: function(response) {
                alert("qq");
            },
            error: function(response) {
                alert("ww");
            }
        });
    });
    $(document).delegate('.follow',"click", function(){
                var follow_user=$(this).closest(".member").attr('id');

                if(!$(this).hasClass(".tab_followed")){
                $(this).text("Following");
                $(this).addClass("tab_followed");          
                }
                $.ajax({  
                    type: "POST", 
                    url:"includes/followunfollow.php",
                    data: {follow_user:follow_user},
                    success: function(response) {
                        
                    }
                });    
            });


            $(document).delegate('.tab_followed',"mouseout", function(){
                if(!$(this).hasClass("ready_to_unfollow")){
                    $(this).addClass("ready_to_unfollow");
                }
            });    

            $(document).delegate('.ready_to_unfollow',"click", function(){
                $(this).removeClass("ready_to_unfollow");
                $(this).removeClass("tab_followed");
                $(this).text("Follow");
                var follow_user=$(this).attr('id');

            });

            $(document).delegate('.ready_to_unfollow',"mouseenter", function(){
                $(this).text("Unfollow");
            });
            $(document).delegate('.ready_to_unfollow',"mouseleave", function(){
                $(this).text("Following");
            });
           

            $(document).delegate('.joinBtn',"click", function(){
                if($(this).hasClass("joinedBtn")){
                    $(this).text("Follow");
                    $(this).removeClass("joinedBtn");
                }else{
                    $(this).text("Followed");
                    $(this).addClass("joinedBtn");
                }

                var course_id="";
                var course_id=($(this).closest(".courses-selector").attr("id"))||($(this).closest(".classLi").attr("id"));
                $.ajax({
                        type: "POST",
                        url: "php/course_follow.php",
                        data: {id: course_id, course: true},
                        success: function (html) {
                            alert("a");
                        },
                        error: function (html) {
                            alert("b");
                        }
                    });
            });



    $(document).delegate(".tab-inactive","click",function(){
        if($(this).hasClass("tab1")){           
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
            }
            $(this).find(".tab-title").find(".tab-icon").removeClass("tab1-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tab1-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(".tab-wedge-down").css("left","310px");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"},300);
            $(".about-content").hide();

            $(".courses-tab-content").stop().animate({ opacity: "0"},300);
            $(".courses-tab-content").hide()
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            
            $(".feed-tab-content").show();
            $(".feed-tab-content").animate({ opacity: "1"},300);
           
            
        }

        if($(this).hasClass("tabDepartments")){
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
            }

            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }

            $(this).find(".tab-title").find(".tab-icon").removeClass("tab2-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tab2-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(".tab-wedge-down").css("left","460px");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            $(".feed-tab-content").hide();
            $(".feed-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"},300);
            $(".about-content").hide();
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide();
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $.ajax({
                            type: "POST",
                            url: "department_courses_tab.php",
                            data: {dept_id: univ_id},
                            success: function(html){
                                $(".courses-tab-content").remove();

                                $(".midsec").append(html);
                               $(".courses-tab-content").animate({ opacity: "1"},300);
                               $(".courses-tab-content").show();
                            }
                        });
            
            
        }
        if($(this).hasClass("tabmembers")){
            
            
            
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
            }
            $(this).find(".tab-title").find(".tab-icon").removeClass("tab3-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tab3-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(".tab-wedge-down").css("left","591px");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");

            $(".feed-tab-content").stop().animate({ opacity: "0"},300);
            $(".feed-tab-content").hide();
            $(".departments-tab-content").stop().animate({ opacity: "0"},300);
            $(".departments-tab-content").hide();
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"},300);
            $(".about-content").hide();
            $(".courses-tab-content").stop().animate({ opacity: "0"},300);
            $(".courses-tab-content").hide()
             $.ajax({
                            type: "POST",
                            url: "department_members_tab.php",
                            data:{dept_id:univ_id},
                            success: function(html){
                                $(".members-tab-content").remove();

                                $(".midsec").append(html);
                              $(".members-tab-content").show();
                              $(".members-tab-content").animate({ opacity: "1"},300);
                            }
                        });
            
            

            

            
            
            
        }
        
    });
    $(document).delegate("#group-about-link","click",function(){
            $(".feed-tab-content").stop().animate({ opacity: "0"},300);
            $(".feed-tab-content").hide();
            
            
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
            }
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")){
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
            }
            $(".tab-wedge-down").css("left","-400px");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $(".courses-tab-content").stop().animate({ opacity: "0"},300);
            $(".courses-tab-content").hide()
            
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();

            $(".about-content").show();
            $(".about-content").animate({ opacity: "1"},300);
            
    });


$(document).ready(function() {

       window.scroll(0,175); 



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
<div class='root'>
    <div class='gp_topbar_wrap'>
            <?php include ("topbar.php");?>
        </div>

        <div class='gp_leftbar_wrap'>
            <?php include("leftmenu.php"); ?>
        </div>
        
    <div class='modal_coverPhoto_body modal_body'>
        <div class='modal_coverPhoto_container'>
            <div class='modal_loading'>
                <img class='modal_animation' src='src/loadingAnimation.gif'>
            </div>
            <div class='modal_content'>
                <div class='modal_header'>
						<span class='floatL white'>
							Submit Cover Photo
						</span>
                    <em class='floatR cancelBtn close'>
                    </em>
                </div>
                <div class='modal_main'>
                    <form>
                        <label for='cover_name' class='label_left'>
                            Cover Photo Name
                        </label>
                        <input class='inputBig inputPhotoName' id='cover_name'
                               placeholder='Enter a name for this photo...'>
                        <input class='cover_photo_upload' name='img' type='file' style='display:none;'>

                        <div class = "uploadedPhotoFrame_display" style="background-size:cover;"></div>
                        <div class='uploadedPhotoFrame'>
                            <div class='noPhotoText'>
                                No photo uploaded
                            </div>
                            <div class='photoicon'>
                            </div>

                            <button class='uploadPhotoBtn'>
                                Upload Photo
                            </button>
                        </div>
                        <div class='btmleft'>

                            <button type='button' class='cancelBtn grayBtn'>
                                Cancel
                            </button>
                            <button type='button' class='blueBtn pt_upload_button'>
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

            <div class='mid_right_sec mid_right_sec_school'>
                <?php include('department_header.php'); ?>
                <div class='midsec'>
                    <?php include('department_feed_tab.php'); ?>
 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

</body>


</html>