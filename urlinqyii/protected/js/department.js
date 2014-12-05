//I couldn't find the code for faculty and students but for when it's written I am assuming master div's would be named
//.department_students_tab and .department_faculty_tab



$(document).ready(function(){
	
	$('.tabFeed').on('click', function(){
		$('.department_courses_tab').hide();
		$('.department_faculty_tab').hide();
		$('.department_students_tab').hide();
		$('.department_feed_tab').show();
		$('.department_feed_right_about').show();
	});

	$('.tabDepartments').on('click', function() {
		$('.department_faculty_tab').hide();
		$('.department_students_tab').hide();
		$('.department_feed_tab').hide();
		$('.department_feed_right_about').hide();
		$('.department_courses_tab').show();
		
	});

	$('.tabmembers').on('click', function() {
		$('.department_students_tab').hide();
		$('.department_feed_tab').hide();
		$('.department_feed_right_about').hide();
		$('.department_courses_tab').hide();
		$('.department_faculty_tab').show();
	});

	$('.tabstudents').on('click', function() {
		$('.department_feed_tab').hide();
		$('.department_feed_right_about').hide();
		$('.department_courses_tab').hide();
		$('.department_faculty_tab').hide();
		$('.department_students_tab').show();
	});

    var google_maps_embed = "https://maps.googleapis.com/maps/api/staticmap?";
    var google_maps_web = "https://www.google.com/maps/place/";
    var map_center = "center=";
    var map_location = "40.7308,-73.9975";
    var map_zoom_size = "&zoom=14&size=270x180";
    var map_marker = "&markers=color:red%7Clabel:%7C";

    /*
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
     */

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
    /*var orgin="null";
     var orgin=$.urlParam('orgin');
     if(orgin=="onboard"){
     //alert("in if");
     $('.tabmembers').removeClass('tab-inactive');
     $('.tabmembers').addClass('group-tab-active');
     }*/

    var feed=$('.feed-tab-content').clone();
    var about=$('.about-content').clone();
    var about_text = feed.find(".content-about").text();
    ////alert(about_text);
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
                ////alert(html);
                $ref.closest("form").find(".uploadedPhotoFrame").hide();
                //alert(html);
                //alert("ad");
                $ref.closest("form").find(".uploadedPhotoFrame_display").css({"background-image":"url("+html+")"});
                $ref.closest("form").find(".uploadedPhotoFrame_display").show();

            },
            error: function(html){
                //alert(html);
                //alert("asfw");
            }
        });
    });

    $(document).delegate(".pt_upload_button", "click", function () {
        //alert("a");
        var $ref = $(this);
        var formData = new FormData($ref.closest("form")[0]);
        var editing = "cover";

        formData.append("editing", editing);
        formData.append("id", univ_id);
        formData.append("department",true);
        //alert("b");
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
                //alert("4");
                var jsonstring = "";
                if (html.user_dp.length > 0) {
                    jsonstring = html.user_dp[0]['img_url'];
                }
                //alert("c");
                $ref.closest("form").find(".uploadedPhotoFrame").show();
                //alert("d");
                $ref.closest("form").find(".uploadedPhotoFrame_display").hide();
                $(".cancelBtn").click();


                $(".group-cover-picture").css({"background-image": "url(" + jsonstring + ")"});

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
        //alert("selected dept"+dept_id);

        dept_id=parseInt(dept_id);
        if(type=="major"){
            type=1;
            //alert("in major"+type);
        }else if(type=="minor"){
            type=2;
            //alert("in minor"+type);
        }else{
            type=3;
            //alert("in interested"+type);
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
     */

    $('.group_location').mouseenter(function(){
        $(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").show();
    });
    $('.group_location').mouseleave(function(){
        $(this).closest(".group-head-top-sec").find(".location-pic-div-wrap").hide();
    });



    $(document).delegate('.group-cover-pic-info',"click", function(){
        $('body,html').animate({
            scrollTop: 0
        }, 200);
    });

    /*
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
     */

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


    $(document).delegate(".dept_fbtn","click",function(){

        if(!$(this).hasClass("unfollowBtn")){
            $(".study_box_open").css("left","112px");
            $(this).html("<em class = 'unfollow-icon'></em>Member");
            $(this).addClass("unfollowBtn");
        }
        else{
            $(".study_box_open").css("left","88px");
            $(this).html("<em></em>Join this Department");
            $(this).removeClass("unfollowBtn");
        }
        /*
         $.ajax({
         type:'post',
         url:'php/course_follow.php',
         data:{id:univ_id, dept: true},
         success: function(response) {
         //alert("qq");
         },
         error: function(response) {
         //alert("ww");
         }
         });
         */
    });

    $(document).delegate('.follow',"click", function(){
        var follow_user=$(this).closest(".member").attr('id');

        if(!$(this).hasClass(".tab_followed")){
            $(this).text("Member");
            $(this).addClass("tab_followed");
        }
        /*
         $.ajax({
         type: "POST",
         url:"includes/followunfollow.php",
         data: {follow_user:follow_user},
         success: function(response) {

         }
         });
         */
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
        $(this).text("Leave");
    });
    $(document).delegate('.ready_to_unfollow',"mouseleave", function(){
        $(this).text("Member");
    });


    $(document).delegate('.joinBtn',"click", function(){
        if($(this).hasClass("joinedBtn")){
            $(this).text("Join");
            $(this).removeClass("joinedBtn");
        }else{
            $(this).text("Joined");
            $(this).addClass("joinedBtn");
        }

        var course_id="";
        var course_id=($(this).closest(".courses-selector").attr("id"))||($(this).closest(".classLi").attr("id"));
        /*
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
         */
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
            $(".tab-wedge-down").css("left","57px");
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
            $(".tab-wedge-down").css("left","200px");
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
            /*
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
             */


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
            $(".tab-wedge-down").css("left","345px");
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
            /*
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
             */


        }

        if($(this).hasClass("tabstudents")){



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
            $(".tab-wedge-down").css("left","495px");
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
            /*
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
             */
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


    /*progress function for ajax*/
    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('progress').attr({value: e.loaded, max: e.total});
        }
    }

    /*
     $.ajax({
     type: 'GET',
     dataType: 'jsonp',
     data: {},
     url: "http://www.nyu.edu/footer/map/jcr:content/genericParsys/map.json?callback=?",
     error: function (jqXHR, textStatus, errorThrown) {
     console.log("Could not retrieve NYU JSON");
     console.log(jqXHR);
     },
     success: function (msg) {
     var locations_array = msg.locations;

     for(var i = 0; i < locations_array.length; i++){
     var loc = locations_array[i];
     loc.label = loc.title;
     }

     $(function() {
     $( "#event_location" ).autocomplete(
     {
     source: locations_array,
     select: function( event, ui ) {
     $( "#event_location" ).text( ui.item.address );
     return false;
     }
     }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
     return $( "<li></li>" )
     .data( "item.autocomplete", item )
     .append(item.label + " / " + item.address)
     .appendTo( ul );
     };
     });

     $("ul.ui-autocomplete").on("click", "li", function() {
     var location_text = this.text();
     alert(location_text);
     $("#event_location").text(location_text);
     });
     }
     });
     */

    $('.post').click(function(){

        $('#fbar').css('height','auto');
        $("#fbar").find('.postTxtarea').show();
        $("#fbar").find('.postTxtarea').focus();
        $("#fbar").find('.post').css('cursor','default');

        $("#fbar").find('.post').removeClass('fani');
        $("#fbar").find('.post-sec').show();
        $("#fbar").find('.event').addClass('fani');
        $("#fbar").find('.opp').addClass('fani');
        $("#fbar").find('.event').css('cursor','pointer');
        $("#fbar").find('.opp').css('cursor','pointer');
        $("#fbar").find('.fbtn-post ').css('color','#333');
        $("#fbar").find('.fbtn-post ').css('color','#333');
        $("#fbar").find('.fbtn-opp').css('color','#666');
        $("#fbar").find('.fbtn-upload ').css('color','#666');
        $("#fbar").find(".wedge1a").show();
        $("#fbar").find(".wedge1b").show();
        $("#fbar").find(".wedge2a").hide();
        $("#fbar").find(".wedge2b").hide();
        $("#fbar").find(".wedge3a").hide();
        $("#fbar").find(".wedge3b").hide();
        $("#fbar").find('.btmfbar2').hide();
        $("#fbar").find('.btmfbar3').hide();
        $("#fbar").find('.btmfbar').show();
        $("#fbar").find(".ask_state").hide();
        $("#fbar").find('.uploadTxtarea').hide();
        $("#fbar").find('.uploadMode').hide();
        $('.event_time').hide();
        $('.opp_time').hide();
        $('#uploadOpp').css('display', 'none');
        $('#btmOpp').css('display', 'none');

        /*clean text rendering*/
        $(".postTxtarea").val("");
        $(".uploadTxtarea").val("");
        $(".questtxt").val("");
        $(".askTxtArea").val("");
        /*clean text rendering end*/
    });

    $('.event').click(function(){
        $('#fbar').css('height','auto');
        $("#fbar").find('.event').css('cursor','default');
        $("#fbar").find('.opp').css('cursor','pointer');

        $("#fbar").find('.post').css('cursor','pointer');
        $("#fbar").find('.event').removeClass('fani');
        $("#fbar").find('.post-sec').show();
        $("#fbar").find('.opp').addClass('fani');
        $("#fbar").find('.post').addClass('fani');
        $("#fbar").find('.fbtn-upload ').css('color','#333');
        $("#fbar").find('.fbtn-post ').css('color','#666');
        $("#fbar").find('.fbtn-opp ').css('color','#666');
        $("#fbar").find(".wedge2a").show();
        $("#fbar").find(".wedge2b").show();
        $("#fbar").find(".wedge1a").hide();
        $("#fbar").find(".wedge1b").hide();
        $("#fbar").find(".wedge3a").hide();
        $("#fbar").find(".ask_state").hide();
        $("#fbar").find(".wedge3b").hide();
        $("#fbar").find('.postTxtarea').hide();
        $("#fbar").find('.btmfbar').hide();
        $("#fbar").find('.btmfbar3').hide();
        $("#fbar").find('.upload_state').show();
        $("#fbar").find('.btmfbar2').show();
        $("#fbar").find('.uploadTxtarea').show();
        $("#fbar").find('.uploadTxtarea').focus();
        $("#fbar").find('.uploadMode').show();
        $('.event_time').show();
        $('.opp_time').hide();
        $('#uploadOpp').css('display', 'none');
        $('#btmOpp').css('display', 'none');

        /*clean text rendering*/
        $(".postTxtarea").val("");
        $(".uploadTxtarea").val("");
        $(".questtxt").val("");
        $(".askTxtArea").val("");
        /*clean text rendering end*/
    });

    $('.opp').click(function(){
        $('#fbar').css('height','auto');
        $("#fbar").find('.opp').css('cursor','default');
        $("#fbar").find('.opp').removeClass('fani');
        $("#fbar").find('.post-sec').show();
        $("#fbar").find('.event').addClass('fani');
        $("#fbar").find('.post').addClass('fani');
        $("#fbar").find('.event').css('cursor','pointer');
        $("#fbar").find('.post').css('cursor','pointer');
        $("#fbar").find('.fbtn-opp ').css('color','#333');
        $("#fbar").find('.fbtn-upload ').css('color','#666');
        $("#fbar").find('.fbtn-post ').css('color','#666');
        $("#fbar").find(".wedge3a").show();
        $("#fbar").find(".wedge3b").show();
        $("#fbar").find(".wedge1a").hide();

        $("#fbar").find(".wedge1b").hide();
        $("#fbar").find(".wedge2a").hide();
        $("#fbar").find(".wedge2b").hide();
        $("#fbar").find('.postTxtarea').hide();
        $("#fbar").find('.btmfbar').hide();
        $("#fbar").find('.uploadTxtarea').hide();
        $("#fbar").find('.uploadMode').hide();
        $("#fbar").find('.btmfbar2').hide();
        $("#fbar").find(".ask_state").show();
        $("#fbar").find(".topfbar").focus();
        $('.event_time').hide();
        $('.opp_time').show();
        $('#uploadOpp').css('display', 'block');
        $('#btmOpp').css('display', 'block');

        /*clean text rendering*/
        $(".postTxtarea").val("");
        $(".uploadTxtarea").val("");
        $(".questtxt").val("");
        $(".askTxtArea").val("");
        /*clean text rendering end*/
    });


    $('.who-dyn').mouseover(function(){
        $('.who-explain').css('visibility','visible');
        $('.who-explain').mouseover(function(){
            $('.who-explain').css('visibility','visible');
        });
        $('.who-explain').mouseout(function(){
            $('.who-explain').css('visibility','hidden');
        });
        $('.who-dyn').mouseout(function(){
            $('.who-explain').css('visibility','hidden');
        });
    });

    $(document).delegate(".fani","mouseover",function(){
        $(this).find(".fbtn").css({"color":"#333"});
    });

    $(document).delegate(".fani","mouseout",function(){
        $(this).find(".fbtn").css({"color":"#666"});
    });

    $('.select').on('click','li',function(){
        var $t = $(this),
            $f = $(this).closest(".search-select").find('.field_fbar');
        text = $t.text(),
            icon = $t.find('i').attr('class');
        $f.find('label').text(text);
        $f.find('i').attr('class',icon)
    });
    $('.field_fbar').click(function(e){
        e.preventDefault();
        $('#open').click();
    });



    $(document).delegate(".field_fbar","click",function(){
        $(".select").stop().fadeIn(200);

        var cur= $(this).closest(".field_fbar").find("i").attr("class");

        $( ".select li" ).each(function( index ) {
            if($(this).find("i").attr("class")==cur){
                $(this).hide();
            }else{
                $(this).show();
            }
        });

    });

    $(document).click(function(event){
        var $target= $(event.target);
        var $container= $(".search-select");
        if(!$container.is($target)&&($container.has($target).length===0)){
            $(".select").stop().fadeOut(150);
        }

        if($target.hasClass("selitem")){
            $(".select").stop().fadeOut(150);
        }

        var $container2= $(".tag-option");
        var $container3= $(".midfbar-exp");
        if(!$container2.is($target)&&($container2.has($target).length===0)){
            if(!$container3.is($target)&&($container3.has($target).length===0)){
                $(".tag-option").stop().fadeOut(150);
            }
        }

    });


    /*upload hack process.*/
    $(document).delegate(".attach-mod","click",function(){

        $(this).closest(".controlpad").find('.upload_hack').click();

        return false;
    });

    /*The following process need to be further modified according to backend*/

    /*
     $(".upload_button").click(function() {
     $(".upload_hack").click();
     });
     */
    $(document).delegate(".upload_hack","change",function(){
        var $hack=$(this).closest(".controlpad").find('.upload_hack');
        //alert($hack.val());

        var filename= $hack.val();

        if(filename.length>=18){
            filename= filename.substring(0,15)+"...";
        }

        $(this).closest(".controlpad").find(".upload_textprompt").text(filename);
        $(this).closest(".controlpad").find(".upload_textprompt").attr("title",$hack.val());
        //need to modify
        //$('.attach_form').submit();
    });






    $(document).delegate("._uplI","change",function(){
        var $hack=$(this).closest(".upl_wrap").find('._uplI');
        //alert($hack.val());

        $(this).closest(".upl_wrap").find(".uplName").text($hack.val());
        $(this).closest(".upl_wrap").find(".uplName").attr("title",$hack.val());
        //need to modify
        //$('.attach_form').submit();
    });



    //textara auto growth
    $(".autogrowth_textarea").mousemove(function(e) {
        var myPos = $(this).offset();
        myPos.bottom = $(this).offset().top + $(this).outerHeight();
        myPos.right = $(this).offset().left + $(this).outerWidth();

        if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16) {
            $(this).css({ cursor: "nw-resize" });
        }
        else {
            $(this).css({ cursor: "" });
        }
    })
        //  the following simple make the textbox "Auto-Expand" as it is typed in
        .keyup(function(e) {
            //  the following will help the text expand as typing takes place
            while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
                $(this).height($(this).height()+1);
            };
        });




    /*tagging function*/

    var tags=new Array();


    $(document).delegate(".midfbar-exp","click",function(e){
        $(".add_who").focus();
    });

    /*
     $(document).delegate(".add_who","keydown",function(e){
     $(".tag-option").show();
     });
     */

    $(document).delegate(".add_who","keyup",function(e){
        var code = e.keyCode || e.which;
        var $input= $(this);
        var len_detect=$(this).val().trim().length;
        var query=$(this).val().trim();
        //alert(len_detect);

        if(len_detect>=2){
            $.ajax({
                type: "POST",
                url: "includes/fbarexp.php",
                data: {query:query},
                success: function(html){
                    $(".tag-option").html(html);
                    $(".tag-option").show();
                }
            });
        }else{
            $(".tag-option").hide();
        }
        /*
         if(code==32){
         var tag= $input.val().split(" ").join("").trim().toLowerCase();

         if(tag!=""){
         $(".midfbar-exp").prepend("<div class='who-is-tagged' id='wit_"+tag+"'><div class='tag-name'>"+tag+"</div><div class='tag-close'></div></div>");
         tags.push(tag);
         $input.val(" ");
         }
         }
         */

        if(code==8){
            if($input.val()==""){
                var tag= tags[0];
                tags.shift();
                $("#wit_"+tag).remove();
            }
        }
    });


    var tags_type=new Array();
    $(document).delegate(".tag-col","click",function(e){
        var tagname=$(this).text();
        var tag= $(this).attr("id").trim();
        var tp= "";
        if($(this).hasClass("user")){tp="user";}
        if($(this).hasClass("courses")){tp="courses";}
        var isin=$.inArray(tag, tags);

        if(isin==-1){
            tags.push(tag);
            tags_type.push(tp);

            $(".midfbar-exp").find(".add_who").remove();
            $(".midfbar-exp").append("<div class='who-is-tagged' id='wit_"+tag+"'><div class='tag-name'>"+tagname+"</div><div class='tag-close'></div></div>");
            $(".midfbar-exp").append("<input placeholder = '+ Ask experts' class = 'add_who'>");
            $(".add_who").val("");
            $(".add_who").focus();
            $(".tag-option").hide();
        }

    });



    $(document).delegate(".tag-close","click",function(e){
        var tag= $(this).closest(".who-is-tagged").attr("id").trim().substring(4);
        //alert("a");
        var isin=tags.indexOf(tag);

        if(isin>-1){
            tags.splice(isin,1);
            tags_type.splice(isin,1);
            $("#wit_"+tag).remove();
        }
        return false;

    });

    $(document).delegate(".flat7b_fbar","click",function(event){

        if(!$(this).hasClass("flat_checked")){

            $(this).css({"border":"1px solid #00A076","background-color":"#02e2a7"});
            $(this).closest(".check_wrap").find(".move").css({"margin-left":"19px"});
            $(this).addClass("flat_checked");
            $(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(33,33,33,.85)");
            $(this).closest(".controlpad").find(".post_anon_val").val("1");
        }else{
            $(this).css({"border":"1px solid #C9C9C9","background-color":"#E8E8E8"});
            $(this).closest(".check_wrap").find(".move").css({"margin-left":"0px"});
            $(this).removeClass("flat_checked");
            $(this).closest(".check_wrap").find(".comment_anon_text").css("color","rgba(153, 153, 153, 0.64)");
            $(this).closest(".controlpad").find(".post_anon_val").val("0");
        }
    });

    var cardtag_flag=0;
    $(document).delegate(".vstt_icon","mouseover",function(){
        if(cardtag_flag==0){
            $(this).closest(".field_fbar").find(".card-tag").show();
        }
    });

    $(document).delegate(".vstt_icon","mouseout",function(){
        $(this).closest(".field_fbar").find(".card-tag").hide();
    });

    $(document).delegate(".visi_functions_option_fbar","mouseover",function(){
        var src=$(this).closest("span").find(".visi_icon").css("background-image");
        srcarr=src.split("_");
        srcarr[srcarr.length-1]="hover.png)";
        //if($.browser.mozilla){srcarr[srcarr.length-1]="hover.png";}
        if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="hover.png";}
        src=srcarr.join("_");
        //alert(src);
        $(this).closest("span").find(".visi_icon").css("background-image",src);
    });

    $(document).delegate(".visi_functions_option_fbar","mouseout",function(){
        var src=$(this).closest("span").find(".visi_icon").css("background-image");
        srcarr=src.split("_");
        srcarr[srcarr.length-1]="normal.png)";
        if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){srcarr[srcarr.length-1]="normal.png";}
        src=srcarr.join("_");
        //alert(src);
        $(this).closest("span").find(".visi_icon").css("background-image",src);
    });

    $(document).delegate('.field_fbar',"click", function(){
        if($(this).closest(".posttool-select").hasClass("privacy_canedit")){
            $(this).closest(".posttool-select").find(".visi_functions_box").show();
            cardtag_flag=1;
            $(this).closest(".field_fbar").find(".card-tag").hide();

            $(this).css({"border":"1px solid rgba(60,60,60,0.23)","background-color":"rgba(60,60,60,0.03)"});

            $(this).find(".vstt_wedgeDown").css({"opacity":"1"});
        }
    });

    $(document).click(function(event){

        var $target= $(event.target);
        var $container= $(".posttool-select");
        if(!$container.is($target)&&($container.has($target).length===0)){
            $container.find(".visi_functions_box").stop().hide();
            cardtag_flag=0;

            $container.find(".field_fbar").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
            $container.find(".vstt_wedgeDown").css({"opacity":"0"});
        }
        if($target.hasClass(".visi_functions_option_fbar")){
            $container.find(".visi_functions_box").stop().hide();
            cardtag_flag=0;
            $container.find(".field_fbar").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
            $container.find(".vstt_wedgeDown").css({"opacity":"0"});
        }
    });

    $(document).delegate(".visi_functions_option_fbar","click",function(){
        //student campus connections faculty
        var ref=$(this).closest(".posttool-select");
        var privacy= "campus";
        if($(this).find(".visi_icon").hasClass("i_campus")){privacy="campus";}
        if($(this).find(".visi_icon").hasClass("i_student")){privacy="students";}
        if($(this).find(".visi_icon").hasClass("i_faculty")){privacy="faculty";}
        if($(this).find(".visi_icon").hasClass("i_connections")){privacy="connections";}


        ref.find(".tag-box").text("Visible to "+privacy);
        ref.closest(".select_wrap").find(".visi_val").val(privacy);
        //alert(ref.closest(".select_wrap").find(".visi_val").val());

        $(this).closest(".visi_functions_box").hide();
        cardtag_flag=0;
        ref.find(".field_fbar").css({"border":"1px solid rgba(60,60,60,0)","background-color":"transparent"});
        ref.find(".vstt_wedgeDown").css({"opacity":"0"});

        var src_2=$(this).closest(".posttool-select").find(".visi_icon").css("background-image");
        var srcarr= src_2.split("_");
        srcarr[srcarr.length-1]="status.png";
        var subarr=srcarr[srcarr.length-2].split("/");
        srcarr[srcarr.length-2]="status/"+privacy;
        var src_2=srcarr.join("_").substring(4);
        if(navigator.sayswho.split(" ")[0].toLowerCase()=="firefox"){src_2=src_2.substring(1);}
        $(this).closest(".posttool-select").find(".vstt_icon").attr("src",src_2);
    });


    // setting target page vars for AJAX calls
    /*
    <?php if(isset($target_type) AND isset($target_id)){ ?>

        var target_type = <?php echo json_encode($target_type); ?>;
        var target_id = <?php echo json_encode($target_id); ?>;
        // alert(target_type);

        <?php }
    else{ ?>
        var target_type = null;
        var target_id = null;
        <?php }?>
    // setting target vars closed

    //ajax
    $(document).delegate(".btn-1","click",function(){
        var fbar_type="status";
        var $ref=$(this).closest(".fbar_anchor");
        var post_status=$ref.find(".postTxtarea").val().trim();
        var anon=$ref.find(".post_anon_val").val();
        var privacy= $ref.find(".visi_val").val();

        // var target_type = "class";
        // var target_id = "924c83c4-f589-11e3-b732-00259022578e";
        //alert($ref.find(".visi_val").attr(""));

        if(post_status==""){

        }else{

            if($ref.find(".upload_hack").val()!=''){
                alert("we");
                var formData= new FormData( $ref.find(".upload_hack").closest("form")[0]);
                formData.append("fbar_type",fbar_type);
                formData.append("anon",anon);
                formData.append("post_status",post_status);
                formData.append("privacy",privacy);
                formData.append("target_type",target_type);
                formData.append("target_id",target_id);

                alert(fbar_type+","+post_status+","+anon+","+privacy);


    $.ajax({
        type: "POST",
        url: "includes/fbarops.php",
        xhr: function() {  // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if(myXhr.upload){ // Check if upload property exists
        myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
        }
        return myXhr;
        },

        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function(html){
        <?php if($pg_src != "home.php") { ?>
                        alert(html.pid);
                        var pid= html.pid;

                        $.ajax({
                            type: "POST",
                            url: "latestfeed.php",

                            data: {latest_feed_id: pid},

                            success: function(html){
                                $("#posts").prepend(html);

                            },
                            error:function(html){
                                alert(html.statusText);
                            }
                        });
                        <?php } ?>
                    }
                });


    //reset
    $ref.find(".postTxtarea").val("");
                $ref.find(".upload_hack").val("");
                $ref.find(".upload_textprompt").attr("title","");
                $ref.find(".upload_textprompt").text("");
            }else{
                /*
                $.ajax({
                    type: "POST",
                    url: "includes/fbarops.php",

                    data: {fbar_type: fbar_type, post_status: post_status, anon: anon, privacy:privacy,
                        target_id:target_id, target_type:target_type},
                    dataType: "json",
                    success: function(html){
                        alert(html.pid);
                        var pid= html.pid;
                        <?php if($pg_src != "home.php") { ?>
                        $.ajax({
                            type: "POST",
                            url: "latestfeed.php",

                            data: {latest_feed_id: pid},

                            success: function(html){
                                $("#posts").prepend(html);

                            },
                            error:function(html){
                                alert(html.statusText);
                            }
                        });
                        <?php } ?>
                    },
                    error:function(html){
                        alert(html.statusText);
                    }
                });

                $ref.find(".postTxtarea").val("");
                $ref.find(".upload_hack").val("");
                $ref.find(".upload_textprompt").attr("title","");
                $ref.find(".upload_textprompt").text("");

            }
        }
    });
    */


    $(document).delegate(".btn-2","click",function(){
        var fbar_type="events";
        var $ref=$(this).closest(".fbar_anchor");
        var notes_desc=$ref.find(".uploadTxtarea").val().trim();
        var fileexistproof=$ref.find("._uplI").val();
        var privacy= $ref.find(".visi_val").val();

        var fileexistproof2=$(".googleuploadinfoarchive_fbar").val();

        //alert(fileexistproof);

        if((fileexistproof=="")&&(fileexistproof2=="")){

        }else{
            if(fileexistproof!=""){

                var formData= new FormData( $ref.find("._uplI").closest("form")[0]);
                formData.append("fbar_type",fbar_type);
                formData.append("notes_desc",notes_desc);
                formData.append("privacy",privacy);
                formData.append("target_type",target_type);
                formData.append("target_id",target_id);
                /*
                $.ajax({
                    type: "POST",
                    url: "includes/fbarops.php",
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
                    dataType: "json",
                    success: function(html){
                        <?php if($pg_src != "home.php") { ?>
                        alert(html.pid);
                        var pid= html.pid;

                        $.ajax({
                            type: "POST",
                            url: "latestfeed.php",

                            data: {latest_feed_id: pid},

                            success: function(html){
                                $("#posts").prepend(html);

                            },
                            error:function(html){
                                alert(html.statusText);
                            }
                        });
                        <?php } ?>
                    }

                });
                */
            }else{
                var fileinfo= $(".googleuploadinfoarchive_fbar").val().trim().split("||");
    var gdrive_id= fileinfo[0].trim();
    var gdrive_type= fileinfo[1].trim();
    var gdrive_url= fileinfo[2].trim();
    var gdrive_name= fileinfo[3].trim();
    /*
    $.ajax({
        type: "POST",
        url: "includes/fbarops.php",
        data: {fbar_type: fbar_type, notes_desc:notes_desc, privacy:privacy, gdrive_id:gdrive_id, gdrive_name:gdrive_name,gdrive_url:gdrive_url,gdrive_type:gdrive_type,
        target_id:target_id, target_type:target_type},
        dataType: "json",

        success: function(html){
        <?php if($pg_src != "home.php") { ?>
                        alert(html.pid);
                        var pid= html.pid;

                        $.ajax({
                            type: "POST",
                            url: "latestfeed.php",

                            data: {latest_feed_id: pid},

                            success: function(html){
                                $("#posts").prepend(html);

                            },
                            error:function(html){
                                alert(html.statusText);
                            }
                        });
                        <?php } ?>
                    }
                });
    */
    }



    //reset
    $ref.find(".uploadTxtarea").val("");
            $ref.find(".uplName").text("No file chosen");
            $ref.find("._uplI").val("");
        }


    });


    $(document).delegate(".btn-3","click",function(){
        var fbar_type="question";
        var $ref=$(this).closest(".fbar_anchor");
        var privacy= $ref.find(".visi_val").val();
        var que_title=$ref.find(".questtxt").val().trim();
        var que_desc=$ref.find(".askTxtArea").val().trim();

        /*
         $.each( tags_type, function( key, value ) {
         alert(value);
         });*/



        $.each( tags, function( key, value ) {
            tags[key]=tags_type[key]+"$$"+value;
    });

    /*
    $.each( tags, function( key, value ) {
        alert(value);
        });
    */
    //tags=['1','2','3'];
    $.each( tags, function( key, value ) {
        alert(value);
        });

    var experts = JSON.stringify(tags);
    var anon=$(this).closest(".controlpad").find(".post_anon_val").val();


        var fileexistproof=$ref.find(".upload_hack").val();

        if(que_title==""){

        }else{


            if(fileexistproof!=""){
                var formData= new FormData( $ref.find(".upload_hack").closest("form")[0]);
                formData.append("fbar_type",fbar_type);
                formData.append("que_title",que_title);
                formData.append("que_desc",que_desc);
                formData.append("experts",experts);
                formData.append("anon",anon);
                formData.append("privacy",privacy);
                formData.append("target_type",target_type);
                formData.append("target_id",target_id);

                /*
                $.ajax({
                    type: "POST",
                    url: "includes/fbarops.php",
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
                    dataType: "json",
                    success: function(html){
                        <?php if($pg_src != "home.php") { ?>
                        alert(html.pid);
                        var pid= html.pid;

                        $.ajax({
                            type: "POST",
                            url: "latestfeed.php",

                            data: {latest_feed_id: pid},

                            success: function(html){
                                $("#posts").prepend(html);

                            },
                            error:function(html){
                                alert(html.statusText);
                            }
                        });
                        <?php } ?>
                    }
                });
                */

            }else{
                //alert(fbar_type+","+que_title+","+que_desc+","+anon+","+privacy);
                /*
                $.ajax({
                    type: "POST",
                    url: "includes/fbarops.php",
                    data: {fbar_type: fbar_type, que_title:que_title, que_desc:que_desc, anon:anon, privacy:privacy, experts:experts,
                    target_id:target_id, target_type:target_type},
                    dataType: "json",
                    success: function(html){
                    <?php if($pg_src != "home.php") { ?>
                                    alert(html.pid);
                                    var pid= html.pid;
                                    $.ajax({
                                        type: "POST",
                                        url: "latestfeed.php",

                                        data: {latest_feed_id: pid},

                                        success: function(html){
                                            $("#posts").prepend(html);

                                        },
                                        error:function(html){
                                            alert(html.statusText);
                                        }
                                    });
                                    <?php } ?>
                                }
                            });
                */

            }

    //reset
    while(tags.length > 0) {
        tags.pop();
        }
    while(tags_type.length > 0) {
        tags_type.pop();
        }
    $(".who-is-tagged").remove();
    $ref.find(".add_who").val("");
    $ref.find(".askTxtArea").val("");
    $ref.find(".topfbar").val("");
    $ref.find(".upload_hack").val("");
    $ref.find(".upload_textprompt").text("");
    $ref.find(".upload_textprompt").attr("title","");

    }
    });


    var curkeypos=$(".tag-col").first();
    $(document).delegate(".add_who","keydown",function(e){
        //alert(curkeypos.attr("id"));
        //down
        if(e.which=='40'){
        curkeypos.next().addClass("opt_jshover");
        }

        //up
        if(e.which=='38'){

        }
        });



    /*progress handling function for ajax*/
    function progressHandlingFunction(e){
        if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
        }
    }


});

init = function(appID,fileID) {
    s = new gapi.drive.share.ShareClient(appID);
    s.setItemIds([fileID]);
}

function initPicker() {
    var picker = new FilePicker({
        apiKey: 'AIzaSyDXcdGwlZUFArSbExSC81-g4PIlAA6vzD4',
        clientId: '648831685142-djuu0p1kanvmn751rnj189avhde81ckt',
        buttonEl: document.getElementById('pick'),
        onSelect: function(file) {
            console.log(file);
            //alert(file);
            $(".googleuploadinfoarchive_fbar").val(file);
            var nm= file.split("||")[3].trim();
            var shortnm=nm;
            if(shortnm.length>=18){
                shortnm= shortnm.substring(0,15)+"...";
            }

            $(".googleuploadinfoarchive_fbar").closest(".driveUpload").find(".drive_link").attr("title",nm);
            $(".googleuploadinfoarchive_fbar").closest(".driveUpload").find(".drive_link").text(shortnm);
            //alert($(".googleuploadinfoarchive_fbar").val());
            // gapi.load('drive-share', init('648831685142',file));
            gapi.client.request({
                'path': '/drive/v2/files/'+file,
                'method': 'GET',
                callback: function (responsejs, responsetxt){
                    var downloadUrl = responsejs.downloadUrl;
                }
            })
        }
    });
}

navigator.sayswho= (function(){
    var ua= navigator.userAgent, tem,
        M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\bOPR\/(\d+)/)
        if(tem!= null) return 'Opera '+tem[1];
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();