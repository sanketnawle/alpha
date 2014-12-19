$(document).ready(function () {

    /*non-member view control*/
    if($(".main").hasClass("non-member")){
        $(".about-content-tab").show();
        $(".about-content-tab").css({ opacity: "1" });
        

        $(".about-content").css({ opacity: "1" });

        $(".about-content").show();
    }

    $(document).delegate(".about-tab", "click", function () {
        $(this).closest(".group-tab").find("#group-about-link").click();
    });
    /*non-member view control end*/



    var profileLoadFlag = 1; // to load the profile load if 1 



    $(window).scrollTop(155);



    // To fetch the queryt string details

    var qs = (function (a) {

        if (a == "") return {};

        var b = {};

        for (var i = 0; i < a.length; ++i) {

            var p = a[i].split('=');

            if (p.length != 2) continue;

            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));

        }

        return b;

    })(window.location.search.substr(1).split('&'));



    var feed_right_sec = $(".feed-tab-rightsec").clone();

    var about_tab = $(".about-content").clone();



        $(window).scroll(function() {

        var y=$(window).scrollTop()*0.32;

        var x=$(window).scrollTop()*1;

        ////alert(y);

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



    $(document).delegate(".email_invite", "click", function () {

        var $rt = $(".modal_invite_body");

        $rt.animate({ opacity: 0 }, 300, function () {

            $rt.find(".modal_loading").show();

            $rt.find(".modal_loading").css("opacity", "1");

            $rt.find(".main").addClass("fe");

            $rt.show();

            $rt.animate({ opacity: 1 }, 400, function () {

                $rt.find(".modal_loading").delay(250).animate({ opacity: 0 }, 100);

                $rt.find(".modal_loading").hide();

                $rt.find(".modal_content").show();

                $rt.find(".modal_content").delay(500).animate({ opacity: 1 }, 200);

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



    $(document).delegate("#upload_cover_pic", "click", function () { 

        var $rt = $(".modal_coverPhoto_body");

        $rt.find(".modal_loading").show();

        $rt.find(".modal_loading").css("opacity", "1");

        $rt.find(".main").addClass("fe");

        $rt.show();

        $rt.animate({ opacity: 1 }, 400, function () {

            $rt.find(".modal_loading").delay(250).animate({ opacity: 0 }, 100);

            $rt.find(".modal_loading").hide();

            $rt.find(".modal_content").show();

            $rt.find(".modal_content").delay(500).animate({ opacity: 1 }, 200);

            $rt.find(".modal_coverPhoto_container").animate({

                height: 355,

                width: 520

            }, 500, function () {

                $rt.find(".inputPhotoName").focus();

            });

        });



        return false;

    });



    $(document).delegate("#promote_group", "click", function () {

        //alert();

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
		
		/***** for loading animation ****/
		$('head').append('<link rel="stylesheet" type="text/css" href="../css/loading.css">');
		var html = "<div class='loading_container' style='background: #eee'><div class='loading_spinner_cover' style='margin-top: 0px'><div class=loading-spinner></div></div>"
		html = html + "<div class='loading_text_cover'><div class='loading_text'>LOADING</div></div></div>";
		$ref.closest("form").find(".uploadedPhotoFrame").prepend(html);

        var formData = new FormData($ref.closest("form")[0]);

        var editing = "show";

        formData.append("editing", editing);

        formData.append("id", qs['group_id']);

        formData.append("group", true);
        //alert("qw");
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
                alert("qw1");
				$ref.closest("form").find(".uploadedPhotoFrame").hide(); 
				
				/**** to remove loading animation ****/                
				$('link[rel=stylesheet][href~="css/loading.css"]').remove();
				$ref.closest("form").find(".uploadedPhotoFrame").children()[0].remove();
				/**** to remove loading animation ****/

                $ref.closest("form").find(".uploadedPhotoFrame_display").css({ "background-image": "url(" + html + ")" });

                $ref.closest("form").find(".uploadedPhotoFrame_display").show();

            },

            error: function (html) {

                alert(html);
				/**** to remove loading animation ****/
				$('link[rel=stylesheet][href~="css/loading.css"]').remove();
				$ref.closest("form").find(".uploadedPhotoFrame").children()[0].remove();
				/**** to remove loading animation ****/

            }

        });

    });







    $(document).delegate(".group-pic", "click", function () {        

        $(this).closest(".group-pic-frame").find(".header_small_img_input").click();

    });



    $(document).delegate(".group-pic", "mouseover", function () {

        $('.upload_dp').show();

    });



    $(document).delegate(".upload_dp", "mouseout", function () {

        $('.upload_dp').hide();

    });



    $(document).delegate(".group-pic", "mouseout", function () {

        $('.upload_dp').hide();

    });



    $(document).delegate(".upload_dp", "mouseover", function () {

        $('.upload_dp').show();

    });



    $(document).delegate(".upload_dp", "click", function () {

        $(this).closest(".group-pic-frame").find('.group-pic').trigger('click');
        return false;
    });



    $(document).delegate(".header_small_img_input", "change", function () {

        var $ref = $(this);

        var formData = new FormData($ref.closest("form")[0]);

        var editing = "display";

        formData.append("editing", editing);

        formData.append("id", qs['group_id']);

        formData.append("group", true);

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

                

                $ref.closest("form").find(".uploadedPhotoFrame_display").hide();

                $(".cancelBtn").click();

                $(".group-pic").css({ "background-image": "url(" + jsonstring + ")" });

            },

            error: function (html) {

                //alert(html);

            }

        });

    });





    $(document).delegate(".inviteBtn", "click", function () {

        $(this).closest(".modal_main_form").find(".upload_excel_list").click();

        return false;

    });

    /*

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

                $(".inviteName").val(html);

            },

            error: function (html) {

                //alert(html);

            }

        });



    });

    */

    $(document).delegate(".cancelBtn", "click", function () {

        $(".modal_body").animate({ opacity: 0 }, 300, function () {

            $(this).closest(".modal_body").hide();

            $(".modal_invite_container").css({ "height": "60px", "width": "320px" });

            $(".modal_content").hide();

            $(".modal_content").css("opacity", "0");

            $(".main").removeClass("fe");



            $(".uploadedPhotoFrame_display").html("");

            $(".uploadedPhotoFrame_display").hide();

            $(".uploadedPhotoFrame").show();



            $(this).closest(".modal_main_form").find(".inviteName").val("");

            $(this).closest(".modal_main_form").find(".modal-mid-textarea").val("");

        });

    });



    $(document).delegate(".modal_ml_submit", "click", function () {

        var email_list = $(this).closest(".modal_main_form").find(".inviteName").val();

        var email_body = $(this).closest(".modal_main_form").find(".modal-mid-textarea").val();

        var choice = "invite";



        var ct_email_list = $(this).closest(".modal_main_form").find(".inviteName");

        var ct_email_body = $(this).closest(".modal_main_form").find(".modal-mid-textarea");

        //var ct_email_xls = $(this).closest(".modal_main_form").find(".upload_excel_list");



        $.ajax({

            type: "POST",

            url: "invite_email_list.php",

            data: { choice: choice, email_body: email_body, email_list: email_list, group_id: qs['group_id'] },

            success: function (html) {

                ct_email_list.val("");

                ct_email_body.val("");        



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

        formData.append("id", qs['group_id']);

        formData.append("group", true);        

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

                $ref.closest("form").find(".uploadedPhotoFrame_display").hide();

                $(".cancelBtn").click();



                $(".group-head-top-sec").css({ "background-image": "url(" + jsonstring + ")" });

            },

            error: function (html) {

                //alert(html);

            }

        });

    });





    /*add member control end*/



    /*edit ctr*/



    $(document).delegate(".create-schedule", "click", function () {

        $('#btn_add_event_schedule').trigger('click');

    });



    /*group js*/



    $(document).delegate(".joined", "mouseover", function () {

        $(this).text("Leave");

    });



    $(document).delegate(".joined", "mouseout", function () {

        $(this).text("Member");

    });



    $(document).delegate(".joined", "click", function () {        

        JoinLeaveClub("Join");

    });



    $(document).delegate(".join", "click", function () {        

        JoinLeaveClub("Member");

    });



    // To jon or leave the club

    function JoinLeaveClub(textVal)

    {

        $.ajax({

            type: "POST",

            url: "php/club_enroll.php",

            data: { group_id: qs['group_id'], member: true },

            success: function (html) {

                if (textVal == "Member") {

                    $('.join').addClass("joined");

                    $('.joined').removeClass("join");

                    $('.joined').text("Member");

                }

                else if (textVal == "Join") {

                    $('.joined').addClass("join");

                    $('.join').removeClass("joined");

                    $('.join').text("Join");

                }
                location.reload();
            },

            error: function (html) {

                //alert("error");

            }

        });

    }



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

            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab4-icon-active")) {

                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab4-icon-active");

                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab4-icon-inactive");

            }

            $(this).find(".tab-title").find(".tab-icon").removeClass("tab2-icon-inactive");

            $(this).find(".tab-title").find(".tab-icon").addClass("tab2-icon-active");

            $(".group-tab-active").addClass("tab-inactive");

            $(".group-tab-active").removeClass("group-tab-active");

            $(this).removeClass("tab-inactive");

            $(this).addClass("group-tab-active");

            $(".feed-tab-content").hide();

            $(".feed-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".syllabus-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".syllabus-tab-content").hide();

            $(".about-content-tab").stop().animate({ opacity: "0" }, 300);

            $(".about-content-tab").hide();

            $(".files-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".files-tab-content").hide();

            $(".analytics-tab").stop().animate({ opacity: "0" }, 300);

            $(".analytics-tab").hide();



            if ($(".members-tab-content").children().length == 0) {

                FetchMembers();

            }

            $(".members-tab-content").animate({ opacity: "1" }, 300);

            $(".members-tab-content").show();

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

            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab4-icon-active")) {

                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab4-icon-active");

                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab4-icon-inactive");

            }

            $(this).find(".tab-title").find(".tab-icon").removeClass("tab1-icon-inactive");

            $(this).find(".tab-title").find(".tab-icon").addClass("tab1-icon-active");

            $(".group-tab-active").addClass("tab-inactive");

            $(".group-tab-active").removeClass("group-tab-active");            

            $(this).removeClass("tab-inactive");

            $(this).addClass("group-tab-active");


            /*non-member view control*/
            /*add if condition to check if tab1 is about*/
            if(!$(this).hasClass("about-tab")){

            $(".about-content-tab").stop().animate({ opacity: "0" }, 300);

            $(".about-content-tab").hide();

            }
            /*non-member view control end*/


            $(".syllabus-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".syllabus-tab-content").hide();

            

            $(".files-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".files-tab-content").hide()

            $(".members-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".members-tab-content").hide();

            $(".analytics-tab").stop().animate({ opacity: "0" }, 300);

            $(".analytics-tab").hide();

            $(".feed-tab-content").show();

            $(".feed-tab-content").animate({ opacity: "1" }, 300);



            /* will be replaced by ajax*/

            //$.ajax({

            //    type: "POST",

            //    url: "php/club_feed_tab.php",

            //    data: { group_id: qs['group_id'] },

            //    success: function (html) {

            //        $(".midsec").html(html);

            //        $(".feed-tab-content").animate({ opacity: "1" }, 300);

            //        $(".feed-tab-content").show();



            //        var about_text = $(".content-about").text();

            //        if (about_text.length >= 73) {

            //            about_text = about_text.substring(0, 70) + "..." + "<span class='bh-t2'> <a id = 'group-about-link' class = 'bh-t2'>Read More</a></span>";

            //            $(".content-about").html(about_text);

            //        }

            //    },

            //    error: function (html) {

            //        //alert("error");

            //    }

            //});

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

            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab4-icon-active")) {

                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab4-icon-active");

                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab4-icon-inactive");

            }

            $(this).find(".tab-title").find(".tab-icon").removeClass("tab3-icon-inactive");

            $(this).find(".tab-title").find(".tab-icon").addClass("tab3-icon-active");

            $(".group-tab-active").addClass("tab-inactive");

            $(".group-tab-active").removeClass("group-tab-active");            

            $(this).removeClass("tab-inactive");

            $(this).addClass("group-tab-active");



            $(".feed-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".feed-tab-content").hide();

            $(".syllabus-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".syllabus-tab-content").hide();

            $(".about-content-tab").stop().animate({ opacity: "0" }, 300);

            $(".about-content-tab").hide();



            $(".members-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".members-tab-content").hide();

            $(".analytics-tab").stop().animate({ opacity: "0" }, 300);

            $(".analytics-tab").hide();



            //if ($(".files-tab-content").children().length == 0) {

                $.ajax({

                    type: "POST",

                    url: "php/club_files_tab.php",

                    data: { club_id: qs['group_id'] },

                    success: function (html) {

                        $(".files-tab-content").html(html);

                    },

                    error: function (html) {

                        //alert("error");

                    }

                });

            //}

            $(".files-tab-content").animate({ opacity: "1" }, 300);

            $(".files-tab-content").show();

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

            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab4-icon-active")) {

                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab4-icon-active");

                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab4-icon-inactive");

            }

            $(this).find(".tab-title").find(".tab-icon").removeClass("tabc-icon-inactive");

            $(this).find(".tab-title").find(".tab-icon").addClass("tabc-icon-active");

            $(".group-tab-active").addClass("tab-inactive");

            $(".group-tab-active").removeClass("group-tab-active");

            $(this).removeClass("tab-inactive");

            $(this).addClass("group-tab-active");

            $(".feed-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".feed-tab-content").hide();



            $(".about-content-tab").stop().animate({ opacity: "0" }, 300);

            $(".about-content-tab").hide();



            $(".members-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".members-tab-content").hide();

            $(".files-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".files-tab-content").hide();

            $(".analytics-tab").stop().animate({ opacity: "0" }, 300);

            $(".analytics-tab").hide();



            //if ($(".syllabus-tab-content").children().length == 0) {

                $.ajax({

                    type: "POST",

                    url: "php/club_events_tab.php",

                    data: { club_id: qs['group_id'] },

                    success: function (html) {

                        $(".syllabus-tab-content").html(html);

                    },

                    error: function (html) {

                        //alert("error");

                    }

                });

            //}

            $(".syllabus-tab-content").show();

            $(".syllabus-tab-content").animate({ opacity: "1" }, 300);

        }



        if ($(this).hasClass("tab4")) {

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

            if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")) {

                $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tabc-icon-active");

                $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tabc-icon-inactive");

            }

            $(this).find(".tab-title").find(".tab-icon").removeClass("tab4-icon-inactive");

            $(this).find(".tab-title").find(".tab-icon").addClass("tab4-icon-active");

            $(".group-tab-active").addClass("tab-inactive");

            $(".group-tab-active").removeClass("group-tab-active");            

            $(this).removeClass("tab-inactive");

            $(this).addClass("group-tab-active");

            $(".feed-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".feed-tab-content").hide();



            $(".about-content-tab").stop().animate({ opacity: "0" }, 300);

            $(".about-content-tab").hide();



            $(".members-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".members-tab-content").hide();

            $(".files-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".files-tab-content").hide();

            $(".syllabus-tab-content").stop().animate({ opacity: "0" }, 300);

            $(".syllabus-tab-content").hide();



            $(".analytics-tab").show();

            $(".analytics-tab").animate({ opacity: "1" }, 300);

        }
        var grouptabactive = $(".group-tab-active");
        $(".tab-wedge-down").css({left: grouptabactive.offset().left + (grouptabactive.outerWidth() / 2) - $(".group-header-tab").offset().left - 10 });
    });



    $(document).delegate("#group-about-link", "click", function () {

       

        $(".feed-tab-content").stop().animate({ opacity: "0" }, 300);

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

        if ($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tab4-icon-active")) {

            $(".group-tab-active").find(".tab-title").find(".tab-icon").removeClass("tab4-icon-active");

            $(".group-tab-active").find(".tab-title").find(".tab-icon").addClass("tab4-icon-inactive");

        }



        $(".tab-wedge-down").css("left", "-400px");

        $(".group-tab-active").addClass("tab-inactive");

        $(".group-tab-active").removeClass("group-tab-active");

        $(".members-tab-content").stop().animate({ opacity: "0" }, 300);

        $(".members-tab-content").hide();

        $(".files-tab-content").stop().animate({ opacity: "0" }, 300);

        $(".files-tab-content").hide();

        $(".analytics-tab").stop().animate({ opacity: "0" }, 300);

        $(".analytics-tab").hide();



        $(".syllabus-tab-content").stop().animate({ opacity: "0" }, 300);

        $(".syllabus-tab-content").hide();




        //        $(".about-tab-content").empty();



        $(".about-content-tab").html(about_tab);

        $(".about-content-tab").show();
        $(".about-content-tab").animate({ opacity: "1" }, 300);
        

        $(".about-content").animate({ opacity: "1" }, 300);

        $(".about-content").show();

    });



    $(window).scroll(function () {

        var lastScrollTop = 47;

        var scrollTop = $(this).scrollTop();

        

        $(".group-head-footer").each(function () {

            var topDistance = $(this).offset().top;

            if ((topDistance - 48) < scrollTop) {

                $(".urGroupStickyHeader").stop().css({ "top": "47px" });                

            } else {                

                $(".urGroupStickyHeader").stop().css({ "top": "-2px" });

            }            

        });

        lastScrollTop = scrollTop;

    });



    var about_text = $(".content-about").text();

    

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

        $cardref.stop().animate({ scrollLeft: leftPos + 200 }, 400);

    });



    $(document).delegate('.hor-scroller-left', "click", function () {



        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");

        var leftPos = $cardref.scrollLeft();

        $cardref.stop().animate({ scrollLeft: leftPos - 200 }, 400);

    });



    $(document).delegate('.hor-scroller-right', "mouseover", function () {

        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");

        var leftPos = $cardref.scrollLeft();

        $cardref.stop().animate({ scrollLeft: leftPos + 15 }, 400);

        $(this).stop().show();

    });



    $(document).delegate('.hor-scroller-right', "mouseout", function () {

        if (rightable == 1) {

            var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");

            var leftPos = $cardref.scrollLeft();

            $cardref.stop().animate({ scrollLeft: leftPos - 15 }, 400, function () {

                $(this).find('.hor-scroller-right').hide();

            });

        }

    });



    $(document).delegate('.hor-scroller-left', "mouseover", function () {

        var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");

        var leftPos = $cardref.scrollLeft();

        $cardref.stop().animate({ scrollLeft: leftPos - 15 }, 400);

        $(this).stop().show();

    });



    $(document).delegate('.hor-scroller-left', "mouseout", function () {

        if (leftable == 1) {

            var $cardref = $(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");

            var leftPos = $cardref.scrollLeft();

            $cardref.stop().animate({ scrollLeft: leftPos + 15 }, 400, function () {

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



    /*sortable drag effect*/

    //$( ".ui-sortable" ).sortable();

    //$( ".ui-sortable" ).disableSelection();



    /*syla*/

    var tooltipflag = 0;

    $(document).delegate('.syla_tag', "click", function () {

        var selector = $(this);

        var event_id = selector.parents('.weekview_content').prop('id');



        if (!selector.hasClass("syla_checked")) {



            // ajax to add events to calendar

            $.ajax({

                type: "POST",

                url: "php/add_event_events_tab.php",

                data: { event_id: event_id, club:true },

                success: function (html) {

                    selector.addClass("syla_checked");

                    selector.html('Added' +

                        '<span class="check_syla" style="background-image: url("src/checked-syla.png");"></span>');                    

                    selector.find(".check_syla").css({ "background-image": "url(src/checked-syla.png)" });

                    selector.closest(".a_weekview").find(".help-box2").text("Click to remove this event");

                },

                error: function (html) {

                    //alert("failed to add to calendar");

                }

            });

        }

        else {

            // To delete the event from the calendar

            $.ajax({

                type: "POST",

                url: "php/add_event_events_tab.php",

                data: { event_id: event_id, club: true },

                success: function (html) {

                    selector.removeClass("syla_checked");

                    selector.html('Add to cal' +

                                '<span class="check_syla" style="background-image: url("src/add.png");"></span>');

                    selector.find(".check_syla").css({ "background-image": "url(src/add.png)" });

                    selector.closest(".a_weekview").find(".help-box2").text("Click to add this event");

                },

                error: function (html) {

                    //alert("failed to remove from calendar");

                }

            });

        }

    });



    /* code for the tooltip of the add to cal and remove from cal */



    $(document).delegate('.syla_tag', "mouseover", function () {



        $(this).closest(".a_weekview").find(".help-div").animate({ opacity: "1" }, 100);

    });



    $(document).delegate('.syla_tag', "mouseout", function () {

        $(this).closest(".a_weekview").find(".help-div").animate({ opacity: "0" }, 100);

    });



    /* end of code for the tooltip of the add to cal and remove from cal */



    /* follow process */



    $(document).delegate('.follow', "click", function () {

        if (!$(this).hasClass(".tab_followed")) {

            $(this).text("Following");

            $(this).addClass("tab_followed");



            var follow_user = $(this).closest(".member").attr("id");



            $.ajax({

                type: "POST",

                url: "includes/followunfollow.php",

                data: { follow_user: follow_user },

                success: function (html) {

                },

                error: function (html) {

                    //alert("failed to follow/ unfollow");

                }

            });

        }

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



    /*progress function for ajax*/

    function progressHandlingFunction(e) {

        if (e.lengthComputable) {

            $('progress').attr({ value: e.loaded, max: e.total });

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

            url: "club_file_upload.php",

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





    // To search for the members 

    $(document).delegate(".searchMembers", "keyup", function (e) {



        var curstring = $(this).val().toLowerCase().trim();

        if (curstring.length >= 2) {

            $(".member").each(function () {

                var tagstring_obj = $(this).find(".search_unit");

                var tagstring = tagstring_obj.text().toLowerCase().trim();



                if (tagstring.indexOf(curstring) >= 0) {

                    $(this).removeClass("hidden_result");

                } else {

                    $(this).addClass("hidden_result");

                }



                /*control the text prompt of the div*/

                    $(".members-list-wrap").each(function(index) {

                        var l=$(this).find(".member").not('.hidden_result').length;

                        if(l==0){

                            $(this).prev(".blockwrapper").addClass("hidden_result");

                        }else{

                            $(this).prev(".blockwrapper").removeClass("hidden_result");   

                        }

                    });

                /*control the text prompt of the div end*/

            });



        } else {

            $(".hidden_result").removeClass("hidden_result");

        }



    });



    // To make members as admin (ta here means admin)

    $(document).delegate(".upgrade-admin", "click", function () {



        var admin_user_id = $(this).parents(".member").attr("id");



        $.ajax({

            type: "POST",

            url: "php/club_enroll.php",

            data: { admin: true, user_id: admin_user_id, group_id: qs['group_id'] },

            success: function (html) {

                FetchMembers();

            },

            error: function (html) {

                //alert(html);

            }

        });

    });



    // To load the profile 

    $(document).delegate('.person-thumb', 'click', function () {

        if (profileLoadFlag == 1) {

            window.location = "profile.php?user_id=" + $(this).parents('.member').prop('id').trim();

        }

        profileLoadFlag = 1;

    });



    function FetchMembers(){

        $.ajax({

            type: "POST",

            url: "php/members.php",

            data: { group_id: qs['group_id'] },

            success: function (html) {

                $(".members-tab-content").html(html);

                $(".members-tab-content").animate({ opacity: "1" }, 300);

                $(".members-tab-content").show();

            },

            error: function (html) {

                //alert("error");

            }

        });

    }



    $(document).delegate('.delete-user', 'click', function () {

        

        var delete_user_id = $(this).parents(".member").attr("id");

        

        $.ajax({

            type: "POST",

            url: "php/club_enroll.php",

            data: { group_id: qs['group_id'], delete_user: true, user_id: delete_user_id },

            success: function (html) {

                FetchMembers();

            },

            error: function (html) {

                //alert("error");

            }

        });

        profileLoadFlag = 0;

    });



    $(document).delegate(".group-head-sec", "mouseover", function () {

        $('#edit_club_name').css("opacity", "1");

    });



    $(document).delegate(".group-head-sec", "mouseout", function () {

        $('#edit_club_name').css("opacity", "0");

    });



    // edit club name 

    $(document).delegate("#edit_club_name", "click", function () {

        $('#tb_club_name').val($('#groupid_'+qs['group_id']).text());

        $('#tb_club_name').show();

        $('#groupid_' + qs['group_id']).hide();

        $('#done_club_name_edit').css("display","inline-block");

        $('#done_club_name_edit').css("opacity", "1");

        $('#edit_club_name').hide();

    });



    $(document).delegate("#done_club_name_edit", "click", function () {

        $('#tb_club_name').hide();

        $('#groupid_' + qs['group_id']).show();

        $('#done_club_name_edit').hide();

        $('#done_club_name_edit').css("opacity", "0");

        $('#edit_club_name').show();



        // ajax call to update the club name 

        $.ajax({

            type: "POST",

            url: "php/club_edit_details.php",

            data: { group_id: qs['group_id'], group_name: $('#tb_club_name').val().trim() },

            success: function (html) {

                if (html != "0") {

                    $('#groupid_' + qs['group_id']).text(html);

                }

            },

            error: function (html) {

                //alert("error");

            }

        });

    });



    /* code for club about tab */





    $(document).delegate(".block-head-right", "click", function () {

        //$(this).closest(".about-tab-about").find(".about_edit").show();

        //$(this).closest(".about-tab-about").find(".about_edit").val($('#tb_about_edit_area').val().trim());

        //$(this).closest(".about-tab-about").find(".tab-block-content").hide();



        $(this).closest(".about-tab-about").find(".about_edit").show();

        $("#tb_about_edit_area").val($('#club_about_desc').text().trim());

        $(this).closest(".about-tab-about").find(".tab-block-content").hide();

        $(this).hide();

    });



    $(document).delegate(".about_edit_cancel", "click", function () {

        $(this).closest(".about-tab-about").find(".about_edit").hide();

        $(this).closest(".about-tab-about").find(".tab-block-content").show();

        $(".block-head-right").show();

    });



    $(document).delegate(".about_edit_done", "click", function () {

        $(this).closest(".about-tab-about").find(".about_edit").hide();

        $(this).closest(".about-tab-about").find(".tab-block-content").show();

        $(".block-head-right").show();

        // ajax call for editing the about section

        $.ajax({

            type: "POST",

            url: "php/club_edit_details.php",

            data: { group_id: qs['group_id'], group_desc: $('#tb_about_edit_area').val().trim() },

            success: function (html) {

                if (html != "0") {

                    $('#club_about_desc').text(html);

                        

                    var appendString = "";

                    if ($('#tb_about_edit_area').val().trim().length >= 80) {

                        appendString += $('#tb_about_edit_area').val().trim().substr(0, 80) + '...';

                    }

                    else {

                        appendString += $('#tb_about_edit_area').val().trim();

                    }

                    appendString += '<span class="bh-t2">' 

                            + '<a id="group-about-link" class="bh-t2">'

                                + 'Read More'

                            + '</a>'    

                        + '</span>';

                    // To edit the about section in the feeds section

                    $('.content-about').html(appendString);

                }

            },

            error: function (html) {

                //alert("error");

            }

        });



        /*last step to go*/

        $(this).closest(".about-tab-about").find(".about_edit").val("");

    });



    $(document).delegate(".group-tab", "click", function () {



        $(".about-tab-about").find(".about_edit").hide();

        $(".about-tab-about").find(".tab-block-content").show();

    });



    /* code for club about tab ends here */

});