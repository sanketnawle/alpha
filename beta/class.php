
<!DOCTYPE html>
<?php include('php/redirect.php');?>
<html>
<head>

<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
<link rel='stylesheet' type='text/css' href='css/backgroundGroup.css'>
<link rel='stylesheet' type='text/css' href='css/group.css'>
<link rel='stylesheet' type='text/css' href='css/invite_modal.css'>
<link rel='stylesheet' type='text/css' href='css/photo_modal.css'>
<link rel='stylesheet' type='text/css' href='css/planner_for_class.css'>

<link rel="shortcut icon" href="img/Ur_FavIcon.jpg" type="image/jpg">
<link rel="icon" href="img/Ur_FavIcon.jpg" type="image/jpg">

<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
<script src='jquery-ui-1.11.0/jquery-ui.min.js'></script>

<script>
/*add member control*/
$(document).ready(function () {


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
    var class_id = $.urlParam('class_id').toString();

    var feed_right_sec = $(".feed-tab-rightsec").clone();
    var about_tab = $(".about-content").clone();

    $(document).delegate(".email_invite", "click", function () {
        var $rt = $(".modal_invite_body");
        $rt.animate({opacity: 0}, 300, function () {
            $rt.find(".modal_loading").show();
            $rt.find(".modal_loading").css("opacity", "1");
            $rt.find(".main").addClass("fe");
            $rt.show();
            $rt.animate({opacity: 1}, 400, function () {
                $rt.find(".modal_loading").delay(250).animate({opacity: 0}, 100);
                $rt.find(".modal_loading").hide();
                $rt.find(".modal_content").show();
                $rt.find(".modal_content").delay(500).animate({opacity: 1}, 200);
                $rt.find(".modal_invite_container").animate({
                    height: 358,
                    width: 520
                }, 500, function () {
                    $rt.find(".inviteName").focus();
                });
            });

            return false;
        });
    });

    $(document).delegate(".upload_cover", "click", function () {
        var $rt = $(".modal_coverPhoto_body");
        $rt.find(".modal_loading").show();
        $rt.find(".modal_loading").css("opacity", "1");
        $rt.find(".main").addClass("fe");
        $rt.show();
        $rt.animate({opacity: 1}, 400, function () {
            $rt.find(".modal_loading").delay(250).animate({opacity: 0}, 100);
            $rt.find(".modal_loading").hide();
            $rt.find(".modal_content").show();
            $rt.find(".modal_content").delay(500).animate({opacity: 1}, 200);
            $rt.find(".modal_coverPhoto_container").animate({
                height: 355,
                width: 520
            }, 500, function () {
                $rt.find(".inputPhotoName").focus();
            });
        });

        return false;
    });

    $(document).delegate(".uploadedPhotoFrame_display", "click", function () {
        $(this).closest("form").find(".uploadedPhotoFrame").click();
    });

    $(document).delegate(".uploadedPhotoFrame", "click", function () {
        $(this).closest("form").find(".coverphoto_show").click();
        return false;
    });
    $(document).delegate(".coverphoto_show", "change", function () {

        var $ref = $(this);
        var formData = new FormData($ref.closest("form")[0]);
        var editing = "show";
        formData.append("editing", editing);
        formData.append("id", class_id);
        formData.append("class",true);
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
            contentType: false,
            processData: false,
            success: function (html) {
                ////alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame").hide();
                //alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame_display").css({"background-image": "url(" + html + ")"});
                $ref.closest("form").find(".uploadedPhotoFrame_display").show();

            },
            error: function (html) {
                //alert(html);
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
        formData.append("id", class_id);
        formData.append("class",true);
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
                $ref.closest("form").find(".uploadedPhotoFrame").show();
                //alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame_display").hide();
                $(".cancelBtn").click();


                $ref.closest(".group-pic-frame").find(".group-pic").css({"background-image": "url(" + jsonstring + ")"});

            },
            error: function (html) {
                //alert(html);
            }
        });
    });

    /*
     $(document).delegate(".email_invite", "click", function () {
     $(".modal_coverPhoto_body").animate({opacity:0},300,function(){
     $(".modal_loading").show();
     $(".modal_loading").css("opacity","1");
     $(".main").addClass("fe");
     $(".modal_invite_body").show();
     $(".modal_invite_body").animate({opacity:1},400, function(){
     $(".modal_loading").delay(250).animate({opacity:0},100);
     $(".modal_loading").hide();
     $(".modal_content").show();
     $(".modal_content").delay(500).animate({opacity:1},200);
     $(".modal_invite_container").animate({
     height:358,
     width:520
     },500, function(){
     $(".inviteName").focus();
     });
     });
     $("html, body").animate({ scrollTop: 150 }, 600);

     return false;
     });
     });*/

    $(document).delegate(".inviteBtn", "click", function () {
        $(this).closest(".modal_main_form").find(".upload_excel_list").click();
        return false;
    });

    $(document).delegate(".upload_excel_list", "change", function () {

        var txt = $(this).val();
        $(this).closest(".modal_main_form").find(".excel_label").text(txt);
        $ref = $(this);
        var choice = "upload";

        var formData = new FormData($ref.closest("form")[0]);
        formData.append("choice", choice);
        formData.append("class_id", class_id);
        $.ajax({
            type: "POST",
            url: "invite_email_list.php",
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Check if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },

            data: formData,
            contentType: false,
            processData: false,
            success: function (html) {
                ////alert(html);
                $(".inviteName").val(html);
            },
            error: function (html) {
                //alert(html);
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

    $(document).delegate(".modal_ml_submit", "click", function () {
        var email_list = $(this).closest(".modal_main_form").find(".inviteName").val();
        var email_body = $(this).closest(".modal_main_form").find(".modal-mid-textarea").val();
        var choice = "invite";

        var ct_email_list = $(this).closest(".modal_main_form").find(".inviteName");
        var ct_email_body = $(this).closest(".modal_main_form").find(".modal-mid-textarea");
        var ct_email_xls = $(this).closest(".modal_main_form").find(".upload_excel_list");

        $.ajax({
            type: "POST",
            url: "invite_email_list.php",
            data: {choice: choice, email_body: email_body, email_list: email_list, class_id: class_id},
            success: function (html) {

                ct_email_list.val("");
                ct_email_body.val("");
                ct_email_xls.val("");

                /*temp handle*/
                $(".cancelBtn").click();
            },
            error: function (html) {
                //alert("error");
            }

        });

    });


    $(document).delegate(".pt_upload_button", "click", function () {

        var $ref = $(this);
        var formData = new FormData($ref.closest("form")[0]);
        var editing = "cover";
        formData.append("editing", editing);
        formData.append("id", class_id);
        formData.append("class",true);
        //alert("asw");
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
                $ref.closest("form").find(".uploadedPhotoFrame").show();
                //alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame_display").hide();
                $(".cancelBtn").click();


                $(".group-head-sec").css({"background-image": "url(" + jsonstring + ")"});

            },
            error: function (html) {
                //alert(html);
            }
        });
    });


    /*add member control end*/

    /*edit ctr*/

    
    $(document).delegate(".ch_edit_time_wrap", "mouseenter", function () {
        $(this).stop().find(".ch_edit_time").stop().fadeIn();
    });
    $(document).delegate(".ch_edit_time_wrap", "mouseleave", function () {
        $(this).stop().find(".ch_edit_time").stop().fadeOut();
    });

    $(document).delegate(".ch_edit_location_wrap", "mouseenter", function () {
        $(this).stop().find(".ch_edit_loc").stop().fadeIn();
    });
    $(document).delegate(".ch_edit_location_wrap", "mouseleave", function () {
        if (!$(this).find(".ch_edit_loc").hasClass("ch_in_edit")) {
            $(this).stop().find(".ch_edit_loc").stop().fadeOut();
        }
    });


    $(document).delegate(".ch_edit_loc", "click", function () {
        if (!$(this).hasClass("ch_in_edit")) {
            var txt = $(this).closest(".ch_edit_location_wrap").find(".ghr-head-title-place").text().trim();
            $(this).closest(".ch_edit_location_wrap").find(".ghr-head-title-place").hide();
            $(this).closest(".ch_edit_location_wrap").find(".ed_loc").val(txt);
            $(this).closest(".ch_edit_location_wrap").find(".ed_loc").show();
            $(this).addClass("ch_in_edit");
            $(this).text("OK");
        } else {
            $(this).text("Edit");
            $(this).removeClass("ch_in_edit");
            var txt = $(this).closest(".ch_edit_location_wrap").find(".ed_loc").val().trim();
            var course_location = txt;

            var $this = $(this);


            $.ajax({
                type: "POST",
                url: "php/edit_class_details.php",
                data: {course_location: course_location, class_id: class_id},
                success: function (html) {
                    //alert(html);
                    //alert("asww");
                    $this.closest(".ch_edit_location_wrap").find(".ed_loc").hide();
                    $this.closest(".ch_edit_location_wrap").find(".ghr-head-title-place").text(txt);
                    $this.closest(".ch_edit_location_wrap").find(".ghr-head-title-place").show();
                },
                error: function (html) {
                    //alert(html);
                }
            });

        }
    });


    $(document).delegate(".upload-syla-btn", "click", function () {
        $(this).closest(".syla-evt_ctr").find(".upload-syla-input").click();
    });

    $(document).delegate(".create-schedule", "click", function () {
        $('#btn_add_event_schedule').trigger('click');
    });


    /*group js*/

    $(document).delegate(".joined", "mouseover", function () {
        $(this).text("Withdraw");
    });

    $(document).delegate(".joined", "mouseout", function () {
        $(this).text("Enrolled");
    });

    $(document).delegate(".tab-inactive", "click", function () {

        if ($(this).hasClass("tab2")) {
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
            }
            $(this).find(".tab-title").find(".tab-icon").removeClass("tab2-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tab2-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            $(".feed-tab-content").hide();
            $(".feed-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".syllabus-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"}, 300);
            $(".about-content").hide();
            $(".about-content").remove();

            $(".files-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".files-tab-content").hide()


            $.ajax({
                type: "POST",
                url: "class_members_tab.php",
                data: {class_id: class_id},
                success: function (html) {
                    $(".members-tab-content").remove();
                    $(".midsec").append(html);
                    $(".members-tab-content").animate({ opacity: "1"}, 300);
                    $(".members-tab-content").show();
                }
            });

        }
        if ($(this).hasClass("tab1")) {


            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
            }
            $(this).find(".tab-title").find(".tab-icon").removeClass("tab1-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tab1-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");            
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");

            $(".syllabus-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"}, 300);
            $(".about-content").hide();
            $(".about-content").remove();

            $(".files-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".files-tab-content").hide()
            $(".members-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".members-tab-content").hide();
            $(".feed-tab-content").show();
            $(".feed-tab-content").animate({ opacity: "1"}, 300);


            /* will be replaced by ajax*/
            /*
            $.ajax({
                type: "POST",
                url: "class_feed_tab.php",
                data: {class_id: class_id},
                success: function (html) {
                    $(".midsec").html(html);
                    $(".feed-tab-content").animate({ opacity: "1"}, 300);
                    $(".feed-tab-content").show();


                    var about_text = $(".content-about").text();
                    if (about_text.length >= 73) {
                        about_text = about_text.substring(0, 70) + "..." + "<span class='bh-t2'> <a id = 'group-about-link' class = 'bh-t2'>Read More</a></span>";
                        $(".content-about").html(about_text);
                    }
                }
            });*/

            
            /*
            $(".midsec").queue(function(){
                $(this).html(hope_feed_works);
                $(this).find(".feed-tab-content").animate({ opacity: "1"}, 300);
                $(this).find(".feed-tab-content").show();
                $(this).dequeue();
            }); */



        }
        if ($(this).hasClass("tab3")) {


            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
            }
            $(this).find(".tab-title").find(".tab-icon").removeClass("tab3-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tab3-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");            
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");

            $(".feed-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".feed-tab-content").hide();
            $(".syllabus-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"}, 300);
            $(".about-content").hide();
            $(".about-content").remove();

            $(".members-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".members-tab-content").hide();


            $.ajax({
                type: "POST",
                url: "class_files_tab.php",
                data: {class_id: class_id},
                success: function (html) {
                    $(".files-tab-content").remove();

                    $(".midsec").append(html);
                    $(".files-tab-content").animate({ opacity: "1"}, 300);
                    $(".files-tab-content").show();
                }
            });
        }
        if ($(this).hasClass("tabc")) {


            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
            }
            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")) {
                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
            }
            $(this).find(".tab-title").find(".tab-icon").removeClass("tabc-icon-inactive");
            $(this).find(".tab-title").find(".tab-icon").addClass("tabc-icon-active");
            $(".group-tab-active").addClass("tab-inactive");
            $(".group-tab-active").removeClass("group-tab-active");
            $(this).removeClass("tab-inactive");
            $(this).addClass("group-tab-active");
            $(".feed-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".feed-tab-content").hide();

            $(".about-content").stop().animate({ opacity: "0"}, 300);
            $(".about-content").hide();
            $(".about-content").remove();
            
            $(".members-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".members-tab-content").hide();
            $(".files-tab-content").stop().animate({ opacity: "0"}, 300);
            $(".files-tab-content").hide()


            $.ajax({
                type: "POST",
                url: "class_syllabus_tab.php",
                data: {class_id: class_id},
                success: function (html) {
                    $(".syllabus-tab-content").remove();

                    $(".midsec").append(html);
                    $(".syllabus-tab-content").show();
                    $(".syllabus-tab-content").animate({ opacity: "1"}, 300);
                }
            });
        }
        var grouptabactive = $(".group-tab-active");
        $(".tab-wedge-down").css({left: grouptabactive.offset().left + (grouptabactive.outerWidth() / 2) - $(".group-header-tab").offset().left - 10 });
    });
    $(document).delegate("#group-about-link", "click", function () {
        $(".feed-tab-content").stop().animate({ opacity: "0"}, 300);
        $(".feed-tab-content").hide();


        if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")) {
            $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");
            $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");
        }
        if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab3-icon-active")) {
            $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab3-icon-active");
            $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab3-icon-inactive");
        }
        if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab2-icon-active")) {
            $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab2-icon-active");
            $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab2-icon-inactive");
        }
        if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab1-icon-active")) {
            $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab1-icon-active");
            $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab1-icon-inactive");
        }
        $(".tab-wedge-down").css("left", "-400px");
        $(".group-tab-active").addClass("tab-inactive");
        $(".group-tab-active").removeClass("group-tab-active");
        $(".members-tab-content").stop().animate({ opacity: "0"}, 300);
        $(".members-tab-content").hide();
        $(".files-tab-content").stop().animate({ opacity: "0"}, 300);
        $(".files-tab-content").hide()
        $(".feed-tab-content").stop().animate({ opacity: "0"}, 300);
        $(".feed-tab-content").hide();
        $(".syllabus-tab-content").stop().animate({ opacity: "0"}, 300);
        $(".syllabus-tab-content").hide();

        $(".about-content").remove();
        

        $(".midsec").append(about_tab);

        $(".about-content").animate({ opacity: "1"}, 300);
        $(".about-content").show();


    });

    $(window).scroll(function () {
        var lastScrollTop = 47;
        var scrollTop = $(this).scrollTop();
        ////alert(scrollTop);
        $(".group-head-footer").each(function () {
            var topDistance = $(this).offset().top;

            ////alert(topDistance);
            ////alert(scrollTop);
            if ((topDistance - 48) < scrollTop) {
                $(".urGroupStickyHeader").stop().css({"top": "47px"});
                ////alert("a");
            } else {
                ////alert("a");
                $(".urGroupStickyHeader").stop().css({"top": "-2px"});
            }
            ////alert("a");


        });


        lastScrollTop = scrollTop;

    });

    var about_text = $(".content-about").text();
    ////alert(about_text);
    if (about_text.length >= 73) {
        about_text = about_text.substring(0, 70) + "..." + "<span class='bh-t2'> <a id = 'group-about-link' class = 'bh-t2'>Read More</a></span>";
        $(".content-about").html(about_text);
    }
    $(document).delegate(".search-icon", "click", function () {
        $(".inputText").focus();
    });
    $(document).delegate(".plusIcon", "click", function () {
        $(".inviteInput").focus();
    });


    $(document).delegate('.hor-scroller-right', "click", function () {

        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos + 200}, 400);
    });

    $(document).delegate('.hor-scroller-left', "click", function () {

        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos - 200}, 400);
    });

    $(document).delegate('.hor-scroller-right', "mouseover", function () {
        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos + 15}, 400);
        $(this).stop().show();
    });

    $(document).delegate('.hor-scroller-right', "mouseout", function () {
        if (rightable == 1) {
            var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
            var leftPos = $cardref.scrollLeft();
            $cardref.stop().animate({scrollLeft: leftPos - 15}, 400, function () {
                $(this).find('.hor-scroller-right').hide();
            });
        }
    });

    $(document).delegate('.hor-scroller-left', "mouseover", function () {
        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos - 15}, 400);
        $(this).stop().show();
    });

    $(document).delegate('.hor-scroller-left', "mouseout", function () {
        if (leftable == 1) {
            var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
            var leftPos = $cardref.scrollLeft();
            $cardref.stop().animate({scrollLeft: leftPos + 15}, 400, function () {
                $(this).find('.hor-scroller-left').hide();
            });
        }
    });


    var able_offset = 45;
    var leftable = 0;
    var rightable = 0;
    $('.members-scrollwrap').bind('scroll', function () {
        var $ref = $(this).closest(".tab-block-content-scroll");
        //get scroll width

        var scrollw = ($(this)[0].scrollWidth);


        if ($(this).scrollLeft() <= 0) {
            leftable = 0;
            $ref.find(".hor-scroller-left").stop().hide();
        }

        if ($(this).scrollLeft() >= able_offset) {
            if (leftable == 0) {
                $ref.find(".hor-scroller-left").stop().show();
                leftable = 1;
            }
        }


        if ($(this).scrollLeft() + $(this).innerWidth() >= (scrollw - 40)) {
            $ref.find(".hor-scroller-right").stop().hide();
            rightable = 0;
        }

        if ($(this).scrollLeft() + $(this).innerWidth() <= (scrollw - 40)) {
            if (rightable == 0) {
                $ref.find(".hor-scroller-right").stop().show();
                rightable = 1;
            }
        }
    });


    $(document).delegate('.members-scrollwrap', "mouseover", function () {
        var $ref = $(this).closest(".tab-block-content-scroll");
        var scrollw = ($(this)[0].scrollWidth);

        if ($(this).scrollLeft() + $(this).innerWidth() >= (scrollw - 40)) {

        } else {

            $ref.find(".hor-scroller-right").stop().show();
            rightable = 1;

        }

        if ($(this).scrollLeft() >= able_offset) {
            $ref.find(".hor-scroller-left").stop().show();
            leftable = 1;
        }


    });

    $(document).delegate('.tab-block-content-scroll', "mouseleave", function () {
        var $ref = $(this).closest(".tab-block-content-scroll");
        $ref.find(".hor-scroller-right").stop().hide();
        $ref.find(".hor-scroller-left").stop().hide();
    });

    $(document).delegate('.rating_star_empty1', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $("#help-star-1").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated1', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $("#help-star-1").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated1', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $("#help-star-1").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty1', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $("#help-star-1").css({"opacity": "0", "display": "none"});
    });

    $(document).delegate('.rating_star_empty2', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $("#help-star-2").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated2', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $("#help-star-2").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated2', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $("#help-star-2").css({"opacity": "0", "display": "none"});
        $(".rating_star_unrated2").addClass("rating_star_unrated");
    });
    $(document).delegate('.rating_star_empty2', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $("#help-star-2").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty3', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display", "inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $("#help-star-3").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated3', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display", "inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $("#help-star-3").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated3', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $("#help-star-3").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty3', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $("#help-star-3").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty4', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display", "inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display", "inline-block");

        ////alert("a");
        $("#help-star-4").css({"opacity": "1", "display": "inline-block"});

        $(".rating_star_unrated4").removeClass("rating_star_unrated");
    });
    $(document).delegate('.rating_star_unrated4', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display", "inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display", "inline-block");
        $(".rating_star_unrated4").removeClass("rating_star_unrated");
        $("#help-star-4").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated4', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $("#help-star-4").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty4', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $("#help-star-4").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty5', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display", "inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display", "inline-block");
        $(".rating_star_unrated4").removeClass("rating_star_unrated");
        $(".rating_star_unrated5").css("display", "inline-block");
        $(".rating_star_unrated5").removeClass("rating_star_unrated");
        ////alert("a");
        $("#help-star-5").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated5', "mouseenter", function () {
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display", "inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display", "inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display", "inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display", "inline-block");
        $(".rating_star_unrated4").removeClass("rating_star_unrated");
        $(".rating_star_unrated5").css("display", "inline-block");
        $(".rating_star_unrated5").removeClass("rating_star_unrated");
        $("#help-star-5").css({"opacity": "1", "display": "inline-block"});
    });
    $(document).delegate('.rating_star_unrated5', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $(".rating_star_unrated5").addClass("rating_star_unrated");
        $("#help-star-5").css({"opacity": "0", "display": "none"});
    });
    $(document).delegate('.rating_star_empty5', "mouseleave", function () {
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $("#help-star-5").css({"opacity": "0", "display": "none"});
        $(".rating_star_unrated5").addClass("rating_star_unrated");
    });


    $(document).delegate('.rating_star', "click", function () {
        $(".grey_star").removeClass("grey_star");
        $(".grade_stars").find(".rating_star").addClass("grey_star");
        var rt = 0;
        for (i = 0; i <= 5; i++) {
            if ($(this).hasClass("rating_star_unrated" + i)) {

                for (j = 0; j < i; j++) {
                    var k = j + 1;
                    ////alert($(".grade_stars").find(".rating_star_unrated"+k).attr("class"));
                    $(".grade_stars").find(".grating_star_unrated" + k).removeClass("grey_star");

                }
            }
        }

        $(".grade_stars").show();

    });


    /*sortable drag effect*/
    //$( ".ui-sortable" ).sortable();
    //$( ".ui-sortable" ).disableSelection();


    /*syla*/
    var tooltipflag = 0;
    $(document).delegate('.syla_tag', "click", function () {
        if (!$(this).hasClass("syla_checked")) {
            $(this).addClass("syla_checked");
            $(this).find(".check_syla").css({"background-image": "url(src/checked-syla.png)"});
            $(this).closest(".a_weekview").find(".help-box2").text("Click to remove this event");
        } else {
            $(this).removeClass("syla_checked");
            $(this).find(".check_syla").css({"background-image": "url(src/add.png)"});
            $(this).closest(".a_weekview").find(".help-box2").text("Click to add this event");
        }
    });

    $(document).delegate('.syla_tag', "mouseover", function () {

        $(this).closest(".a_weekview").find(".help-div").animate({opacity: "1"}, 100);
    });

    $(document).delegate('.syla_tag', "mouseout", function () {
        $(this).closest(".a_weekview").find(".help-div").animate({opacity: "0"}, 100);
    });


    /* follow process */

    $(document).delegate('.follow', "click", function () {
        if (!$(this).hasClass(".tab_followed")) {
            $(this).text("Following");
            $(this).addClass("tab_followed");

            var follow_user = $(this).closest(".member").attr("id");

            $.ajax({
                type: "POST",
                url: "includes/followunfollow.php",
                data: {follow_user: follow_user},
                success: function (html) {
                    //alert("a");
                }
            });

        }
    });


    $(document).delegate('.join', "click", function () {
            $ref=$(this);
            $.ajax({
                type: "POST",
                url: "php/class_enroll.php",
                data: {class_id: class_id},
                success: function (html) {
                    if($ref.hasClass("joined")){
                        $ref.removeClass("joined");
                        $ref.text("Enroll");
                    }else{
                        $ref.addClass("joined");
                        $ref.text("Withdraw");
                    }
                    location.reload();
                }
            });

        
    });



    $(document).delegate('.tab_followed', "mouseout", function () {
        if (!$(this).hasClass("ready_to_unfollow")) {
            $(this).addClass("ready_to_unfollow");
        }
    });

    $(document).delegate('.ready_to_unfollow', "click", function () {
        $(this).removeClass("ready_to_unfollow");
        $(this).removeClass("tab_followed");
        $(this).text("Follow");
    });

    $(document).delegate('.ready_to_unfollow', "mouseenter", function () {
        $(this).text("Unfollow");
    });
    $(document).delegate('.ready_to_unfollow', "mouseleave", function () {
        $(this).text("Following");
    });


    /*group js*/


    /*header change time*/
    $(document).delegate('.ch_edit_time', "click", function () {
        ////alert("x");
        if (($('.ghr-head-time').text() != "") && ($('.ghr-head-time').text() != "undefined") && ($('.ghr-head-time').text() != null)) {
            if ($('.ghr-head-time').text().trim() != "TBA") {
                OfficeHours($('.ghr-head-time').text());
            }
        }
        $(".dtp_canvas_trigger").click();
    });

    /*progress function for ajax*/
    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('progress').attr({value: e.loaded, max: e.total});
        }
    }

    /* about tab and its small block*/
    $(document).delegate('.small_upload', "click", function () {
        $(this).closest(".box-header").find(".file_small_upload_input").click();
    });


    $(document).delegate('.file_small_upload_input', "change", function () {
        var $ref = $(this);

        var formData = new FormData($ref.closest("form")[0]);
        formData.append("class_id", class_id);
        $.ajax({
            type: "POST",
            url: "php/class_file_upload.php",
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Check if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },

            data: formData,
            contentType: false,
            processData: false,
            success: function (html) {
                ////alert(html);


            },
            error: function (html) {
                //alert(html);
            }
        });


    });


    $(document).delegate('.small_invite_email', "click", function () {
        $(".email_invite").click();
    });

    $(document).delegate('.inviteInput', "focus", function () {
        $(this).closest(".group-about").find(".small_invite_email").click();
    });


});
</script>
</head>
<body>

<div class='root'>

    <div class='gp_topbar_wrap'>
        <?php include('php/redirect.php');include("topbar.php"); ?>
    </div>

    <section>
        <?php include("leftpanel.php"); ?>
    </section>

    <button class='email_invite email_invite_simulator'></button>

    <div class='dt_picker_wrap'><?php include("add_group_schedule.php");
        include("set_working_hours.php"); ?></div>

    <div class="modal_invite_body modal_body">
        <div class="modal_invite_container">
            <div class="modal_loading">
                <img class="modal_animation" src="src/loadingAnimation.gif">
            </div>
            <div class="modal_content">
                <div class="modal_header">
                        <span class="floatL white">
                            Member Invitation
                        </span>
                    <em class="floatR cancelBtn close">
                    </em>
                </div>
                <div class="modal_main">
                    <div class="modal_main_form">
                        <label for="cover_name" class="label_left">
                            Send Invitation To:
                        </label>
                        <input class="inputBig inviteName" id="cover_name" placeholder="Email Address">
                        <label for="cover_name" class="label_left2">
                            Or:
                        </label>
                        <button class="inviteBtn">
                            Upload Member List Excel Document
                        </button>
                        <form id="upload_excel_form">
                            <input type='file' class='upload_excel_list' name='excel_list'>
                        </form>
                        <div class='excel_label'>No File Uploaded</div>

                        <div class='modal-mid'>
                            <textarea class='modal-mid-textarea' placeholder='Customize your invitation email!'
                                      value=""></textarea>
                        </div>

                        <div class="btmleft">

                            <button type="button" class="cancelBtn grayBtn">
                                Cancel
                            </button>
                            <button type="button" class="blueBtn modal_ml_submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal_coverPhoto_body modal_body">
        <div class="modal_coverPhoto_container">
            <div class="modal_loading">
                <img class="modal_animation" src="src/loadingAnimation.gif">
            </div>
            <div class="modal_content">
                <div class="modal_header">
                        <span class="floatL white">
                            Submit Cover Photo
                        </span>
                    <em class="floatR cancelBtn close">
                    </em>
                </div>
                <div class="modal_main">
                    <form>
                        <label for="cover_name" class="label_left">
                            Cover Photo Name
                        </label>
                        <input class="inputBig inputPhotoName" id="cover_name"
                               placeholder="Enter a name for this photo...">
                        <input class="coverphoto_show" type="file" name="img">

                        <div class="uploadedPhotoFrame_display" style="background-size:cover;"></div>
                        <div class="uploadedPhotoFrame">
                            <div class="noPhotoText">
                                No photo uploaded
                            </div>
                            <div class="photoicon">
                            </div>

                            <button class="uploadPhotoBtn">
                                Upload Photo
                            </button>
                        </div>
                        <div class="btmleft btmleft_photo_adjust">

                            <button type="button" class="cancelBtn grayBtn">
                                Cancel
                            </button>
                            <button type="button" class="blueBtn pt_upload_button">
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

                <?php include('class_header.php'); ?>
                <div class='midsec'>

                    <?php include('class_feed_tab.php'); ?>
                    <?php include('class_about_tab.php'); ?>
                </div>


            </div>
        </div>
    </div>
</div>
</div>
<?php $con->close(); ?>

</body>
<script>
    $(document).ready(function () {
        $.urlParam = function (sParam) {

            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }

        }
        var class_id = $.urlParam('class_id');


        $(document).delegate(".searchFiles", "keyup", function (e) {
            var curstring = $(this).val().toLowerCase().trim();
            if (curstring.length >= 2) {
                $(".file").each(function () {
                    var tagstring_obj = $(this).find(".search_unit");
                    var tagstring = tagstring_obj.text().toLowerCase().trim();

                    if (tagstring.indexOf(curstring) >= 0) {
                        $(this).removeClass("hidden_result");
                    } else {
                        $(this).addClass("hidden_result");
                    }


                    /*control the text prompt of the div*/
                    $(".files-type-content").each(function (index) {
                        var l = $(this).find(".file").not('.hidden_result').length;
                        if (l == 0) {
                            $(this).prev(".blockwrapper").addClass("hidden_result");
                        } else {
                            $(this).prev(".blockwrapper").removeClass("hidden_result");
                        }
                    });
                    /*control the text prompt of the div end*/


                });

            } else {
                $(".hidden_result").removeClass("hidden_result");
            }

        });


        $(document).delegate(".upload-files", "click", function () {
            $(this).closest(".files-search-top").find(".upload_file_at_course").click();

        });

        $(document).delegate(".upload_file_at_course", "change", function () {
            var $ref = $(this);

            var formData = new FormData($ref.closest("form")[0]);
            formData.append("class_id", class_id);
            $.ajax({
                type: "POST",
                url: "php/class_file_upload.php",
                xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },

                data: formData,
                contentType: false,
                processData: false,
                success: function (html) {
                    //alert(html);
                    alert("as");
                    $.ajax({
                        type: "POST",
                        url: "class_files_tab.php",
                        data: {class_id: class_id},
                        success: function (html) {
                            $(".files-tab-content").remove();

                            $(".midsec").append(html);
                            $(".files-tab-content").animate({ opacity: "1"}, 300);
                            $(".files-tab-content").show();
                            alert("ok");
                        },
                        error: function (html) {
                            alert(html);
                            alert("b");
                        }
                    });

                },
                error: function (html) {
                    alert(html);
                    alert("a");
                }
            });


        });


        $(document).delegate(".sortByDropdown", "change", function () {

            var filelist = [];
            if ($(this).val() == "recent-rank") {
                filelist = [];
                $(".file").each(function (index) {
                    filelist.push($(this).clone());
                });
                //alert(filelist[2].attr("id"));

                filelist.sort(function (x, y) {
                    return Date.parse(y.find(".file-cont").attr("id").replace(/-/g, '/')) - Date.parse(x.find(".file-cont").attr("id").replace(/-/g, '/'));
                });

                //alert(filelist[2].attr("id"));

                $.each(filelist, function (index) {
                    $(".file_sortbox").append(filelist[index]);
                });

                $(".hidden_result").removeClass("hidden_result");
                $(".searchFiles").val("");

                $(".blockwrapper").hide();
                $(".files-type-content").hide();
                $(".file_sortbox").show();
            } else {

                filelist = [];
                $(".blockwrapper").show();
                $(".files-type-content").show();
                $(".file_sortbox").hide();

                $(".hidden_result").removeClass("hidden_result");
                $(".searchFiles").val("");
                $(".file_sortbox").empty();

            }


        });


        /*progress function for ajax*/
        function progressHandlingFunction(e) {
            if (e.lengthComputable) {
                $('progress').attr({value: e.loaded, max: e.total});
            }
        }

    });
</script>

</html>