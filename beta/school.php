
<!DOCTYPE html> 
<html>
<head>
<?php
include_once("php/redirect.php");
require_once("php/dbconnection.php");
include "includes/common_functions.php";
include "php/school_other_functions.php";
if(isset($_GET['univ_id'])){
                $university=$_GET['univ_id'];
             }else{
              if(isset($_SESSION['univ_id'])){
                      $university=$_SESSION['univ_id'];
                      $univ_id=$university;
                      header("location:/beta/school.php?univ_id=$univ_id");
               }else{
                    
               }       
              
             }
             $user_id=$_SESSION['user_id'];
?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="css/backgroundGroup.css">
<!--<link rel = "stylesheet" type = "text/css" href = "school_alpha/feedGroup.css"> -->
<!--<link rel = "stylesheet" type = "text/css" href = "css/group.css"> --> 
<link rel = "stylesheet" type = "text/css" href = "school_alpha/group.css"> 
<link rel = "stylesheet" type = "text/css" href = "school_alpha/school_department.css"> 
<link rel="stylesheet" type="text/css" href="css/datepicker.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

<link rel="shortcut icon" href="img/Ur_FavIcon.jpg" type="image/jpg">
<link rel="icon" href="img/Ur_FavIcon.jpg" type="image/jpg">

<script>


$(document).ready(function() {
    var google_maps_embed = "https://maps.googleapis.com/maps/api/staticmap?";
    var google_maps_web = "https://www.google.com/maps/place/";
    var map_center = "center=";
    var map_location = "40.7308,-73.9975";
    var map_zoom_size = "&zoom=14&size=270x180";
    var map_marker = "&markers=color:red%7Clabel:%7C";

    $.ajax({
        type: 'GET',
        dataType: 'jsonp',
        data: {},
        url: "http://www.nyu.edu/footer/map/jcr:content/genericParsys/map.json?callback=?",
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            $("img#location_popup").attr("src", google_maps_embed+map_center+map_location+map_zoom_size+map_marker+map_location);
            $("#school_location_link").attr("href", google_maps_web+map_location);
        },
        success: function (msg) {
            var locations_array = msg.locations;
            for(var i = 0; i < locations_array.length; i++){
                var loc = locations_array[i];
                if (loc.title == "2 MetroTech Center") {
                    map_location = loc.latitude + "," + loc.longitude;
                    $("img#location_popup").attr("src", google_maps_embed+map_center+map_location+map_zoom_size+map_marker+map_location);
                    $("#school_location_link").attr("href", google_maps_web+map_location);
                    break;
                }
            }
        }
    });

    var originalHTML = "";
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
    var univ_id = $.urlParam('univ_id');


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
                formData.append("school",true);
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
                formData.append("school",true);
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
        formData.append("school",true);
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


    /*
    $('.group_location').mouseenter(function(){
        $(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").show();
    });
    $('.group_location').mouseleave(function(){
        $(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").hide();
    });
    */


    $(document).delegate('.group-cover-pic-info',"click", function(){
        $('body,html').animate({
                scrollTop: 0
            }, 200);
    });


    $(".group-head-top-sec").mouseenter(function() { $(".group-cover-pic-info").css("opacity", "0"); });
    $(".group-head-top-sec").mouseleave(function() { $(".group-cover-pic-info").css("opacity", "1"); });

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
        /* ?? no dept id*/
        var dept_id_follow=$(this).attr('id').replace(/[^\d.]/g,'');

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
            url:'includes/department_follow.php',
            data:{dept_id:dept_id_follow},
            success: function(response) {
            }
        });
    });

    $(document).delegate('.follow',"click", function(){
        var follow_user=$(this).attr('id').replace(/[^\d.]/g,'');
        console.log(follow_user);
        if(!$(this).hasClass(".tab_followed")){
        $(this).text("Following");
        $(this).addClass("tab_followed");
        }
        $.ajax({
            type: "POST",
            url:"includes/followunfollow.php",
            data: {follow_user:follow_user},
            success: function(response) {
                console.log(response);
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

    $(document).delegate(".tab-inactive","click",function(){
        if($(this).hasClass("tab1")){  
             $(".midsec").append(originalHTML);
           
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
            $(".tab-wedge-down").css("left","70px");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"},300);
            $(".about-content").hide();
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide()
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $(".departments-tab-content").stop().animate({ opacity: "0"},300);
            $(".departments-tab-content").hide();

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
            $(".tab-wedge-down").css("left","240px");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            
            $(".feed-tab-content").stop().animate({ opacity: "0"},300);
            $(".feed-tab-content").hide();
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
                            url: "php/school_components/department_school.php?university=<?php echo $university; ?>",
                            success: function(html){
                                $(".departments-tab-content").remove();
                                originalHTML = $(".midsec").html();
                                $(".midsec").html("");
                                $(".midsec").append(html);
                                $(".departments-tab-content").animate({ opacity: "1"},300);
                                $(".departments-tab-content").show();
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
            $(".tab-wedge-down").css("left","407px");
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
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide()
             $.ajax({
                            type: "POST",
                            url: "php/school_components/professor_school.php?university=<?php echo $university; ?>",
                            success: function(html){
                              $(".members-tab-content").remove();
                              originalHTML = $(".midsec").html();
                              $(".midsec").html("");
                              $(".midsec").append(html);
                              $(".members-tab-content").show();
                              $(".members-tab-content").animate({ opacity: "1"},300);
                            }
                        });
            
        }
        if($(this).hasClass("tabc")){
            
            
            
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
            $(this).find(".tab-title").find(".tab-icon").removeClass("tabc-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tabc-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(".tab-wedge-down").css("left","710px");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            $(".feed-tab-content").stop().animate({ opacity: "0"},300);
            $(".feed-tab-content").hide();          
            $(".about-content").stop().animate({ opacity: "0"},300);
            $(".about-content").hide();
            $(".departments-tab-content").stop().animate({ opacity: "0"},300);
            $(".departments-tab-content").hide();
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide();
             $.ajax({
                            type: "POST",
                            url: "php/school_components/events_school.php?university=<?php echo $university; ?>",
                            success: function(html){
                                $(".syllabus-tab-content").remove();

                                $(".midsec").append(html);
                              $(".syllabus-tab-content").show();
                              $(".syllabus-tab-content").animate({ opacity: "1"},300);
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
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide()
            $(".feed-tab-content").stop().animate({ opacity: "0"},300);
            $(".feed-tab-content").hide();

            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").show();
            $(".about-content").animate({ opacity: "1"},300);
            

            
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
    <svg width="0" height="0">
        <clipPath id="clipPolygon">
            <polygon points="135 241,399 241,399 84,326 84,317 66,308 84,135 84">
            </polygon>
        </clipPath>
    </svg>
    <div class = "root">
    <div class='gp_topbar_wrap'>
        <?php include("topbar.php"); ?>
    </div>

    <section>
        <?php include 'leftpanel.php'; ?>
    </section>

        <div class = "modal_coverPhoto_body modal_body">
            <div class = "modal_coverPhoto_container">
                <div class = "modal_loading">
                    <img class = "modal_animation" src = "">
                </div>
                <div class = "modal_content">
                    <div class = "modal_header">
                        <span class = "floatL white">
                            Submit Cover Photo
                        </span>
                        <div class = "floatR cancelBtn close school_modal_close">
                        </div>
                    </div>
                    <div class = "modal_main">
                        <form>
                            <label for = "cover_name" class = "label_left">
                                Cover Photo Name
                            </label>
                            <input class = "inputBig inputPhotoName" id = "cover_name" placeholder = "Enter a name for this photo...">
                            <input class='cover_photo_upload' name='img' type='file' style='display:none;'>

                            <div class = "uploadedPhotoFrame_display" style="background-size:cover;"></div>
                            <div class = "uploadedPhotoFrame">

                                <div class = "noPhotoText">
                                    No photo uploaded
                                </div>
                                <div class = "photoicon">
                                </div>
                                
                                <button class = "uploadPhotoBtn">
                                    Upload Photo
                                </button> 
                            </div>
                            <div class = "btmleft">

                                <button type=  "button" class = "cancelBtn grayBtn">
                                    Cancel
                                </button> 
                                <button type=  "button" class = "blueBtn pt_upload_button">
                                    Submit
                                </button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class = "main">
            <div class = "leftsec">
            </div>
            <div class = "main-mid-sec">
        
                <div class = "mid_right_sec mid_right_sec_school">
                    <div class = "group-head-sec">
                        <?php include "php/school_components/header_school.php"; ?>
                    </div>
                    
                    <div class = "midsec">
                       <div class="section group">
                            <div class="col span_1_of_3">
                                <div class="school_header"> 
                                    ABOUT 
                                </div>
                                <div class="school_info">
                                    <h3 class="school_name">
                                        NEW YORK UNIVERSITY
                                    </h3>
                                    More about the school.More about the school.More about the school.More about the school.
                                    More about the school.More about the school.More about the school.More about the school.
                                    More about the school.More about the school.More about the school.More about the school.
                                    <div class="school_links">
                                        <h3 class="school_links_header">
                                            Links
                                        </h3>
                                        
                                    </div>

                                </div>

                            </div>
                            <div class="col span_1_of_3">
                                <div class="school_header"> 
                                    ANNOUNCEMENTS
                                </div>
                                <div class="school_announcements">
                                    <div class="school_announcement">
                                        <h4 class="school_announcer_name"> Announcer Name </h4>
                                        <div class="school_posted_time"><span>Posted 5 days ago</span></div>
                                        <div class="school_announcer_position"><span>Dean of School Of Engineering</span></div>
                                        <div class="school_the_announcement">
                                            School will be close on this day.School will be close on this day.
                                            School will be close on this day.School will be close on this day.
                                            School will be close on this day.School will be close on this day.
                                            School will be close on this day.School will be close on this day.
                                        </div>

                                    </div>
                                    <div class="school_announcement">
                                        <h4 class="school_announcer_name"> Announcer Name </h4>
                                        <div class="school_posted_time"> Posted 2 days ago</div> 
                                        <p class="school_announcer_position"> Dean of School Of Engineering</p>
                                        <div class="school_the_announcement">
                                            School will be close on this day.School will be close on this day.
                                            School will be close on this day.School will be close on this day.
                                            School will be close on this day.School will be close on this day.
                                            School will be close on this day.School will be close on this day.
                                        </div>
                                    </div>
                                </div> 
                            
                            </div>
                            <div class="col span_1_of_3">
                                <div class="school_header"> 
                                    STUDENTS YOU MAY KNOW 
                                 </div>
                                <div class="school_students_you_may_know">
                                    <ul class="school_list_of_students">
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                        <li class="school_single_student" style="background: url('includes/get_blob.php?img_id=218'); background-size:cover"> <br><br><br><br>Kuan Wang </li>
                                    </ul>
                                </div> 
                            
                            </div>
                    </div>
                        

                        
                                    
                                
                        
                        

                        
                           
                                                 
                       

                        <div class = "about-content">
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
                                            <span> 
                                             <?php 
                                                
                                               echo get_people_know_school($university,$user_id); 
                                              ?>
                                            </span>
                                        </div>
                                        
                                    </div>
                                    <div class = "tab-block-content tab-block-content-scroll">
                                        <div class = "members-scrollwrap">
                                                <?php
                                                     include 'php/dbconnection.php';
                                                     $query=$con->query("SELECT user_id,firstname,lastname FROM user WHERE user_id 
                                                                           IN (SELECT to_user_id FROM connect WHERE from_user_id=$user_id) 
                                                                           AND univ_id=$university");
                                                    ?>
                                                    <ul class = "people-you-know">
                                                     <?php while($row=$query->fetch_array()){
                                                           ?><li class = "people-box">
                                                           <?php 
                                                               $dp_link=get_user_dp($con,$row['user_id']);
                                                               $user_id_know=$row['user_id']; 
                                                           ?>
                                                            <div class = "person-pic-wrap" style='background-image:url("<?php echo $dp_link; ?>")'>
                                                            </div>

                                                            <div class = "person-title-wrap" >
                                                                <a href='<?php echo "profile?user_id=".$user_id_know; ?>'  style="text-decoration:none;"><p><?php echo $row['firstname'].' '.$row['lastname']?></p></a>
                                                            </div>
                                                            <div class = "after-click-effect"></div>
                                                        </li>

                                                    <?php }
                                                    ?>
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
                                    
                                </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<?php
//$con;
?>

</html>

