<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='content-type' content='text/html; charset=UTF-8'>
    <link rel='stylesheet' type='text/css' href='backgroundGroup.css'>
    <link rel='stylesheet' type='text/css' href='group.css'>
    <link rel='stylesheet' type='text/css' href='invite_modal.css'>

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'>
    </script>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>
    <script src='jquery-ui-1.11.0/jquery-ui.min.js'></script>

    <script>
    /*add member control*/
    $( document ).ready(function() {

    $('.email_invite').click(function(){
            $(".modal_body").animate({opacity:0},300,function(){
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
    });

    $(document).delegate(".inviteBtn", "click", function () {
        $(this).closest(".modal_main_form").find(".upload_excel_list").click();
        return false;
    });

    $(document).delegate(".upload_excel_list", "change", function () {

        var txt=$(this).val();
        $(this).closest(".modal_main_form").find(".excel_label").text(txt);
        $ref=$(this);
        var choice="upload";
        
        var formData= new FormData( $ref.closest("form")[0]);
        formData.append("choice",choice);

        $.ajax({
                            type: "POST",
                            url: "invite_email_list.php",
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
                                $(".inviteName").val(html);
                            },
                            error: function(html){ 
                                alert(html);
                            }
                        });

    });

    $(document).delegate(".cancelBtn", "click", function () {
        $(".modal_body").animate({opacity:0},300,function(){
            $(this).closest(".modal_body").hide();
            $(".modal_invite_container").css({"height":"60px","width":"320px"});
            $(".modal_content").hide();
            $(".modal_content").css("opacity","0");
            $(".main").removeClass("fe");
        });
    });

    $(document).delegate(".modal_ml_submit", "click", function () {
        var email_list=$(this).closest(".modal_main_form").find(".inviteName").val();
        var email_body=$(this).closest(".modal_main_form").find(".modal-mid-textarea").val();
        var choice="invite";

        var ct_email_list=$(this).closest(".modal_main_form").find(".inviteName");
        var ct_email_body=$(this).closest(".modal_main_form").find(".modal-mid-textarea");
        var ct_email_xls=$(this).closest(".modal_main_form").find(".upload_excel_list");

        $.ajax({
                    type: "POST",
                    url: "invite_email_list.php",
                    data: {choice:choice,email_body:email_body,email_list:email_list},
                    success: function(html){ 
                        ct_email_list.val("");
                        ct_email_body.val("");
                        ct_email_xls.val("");
                        alert(html);

                        /*temp handle*/
                        $(".cancelBtn").click();
                    }
                });

    });

    /*add member control end*/

    /*edit ctr*/

    $(document).delegate(".ch_edit_time_wrap", "mouseenter", function () {
        $(this).stop().find(".ch_edit_time").animate({"marginLeft":"-50px"},200);
    });
    $(document).delegate(".ch_edit_time_wrap", "mouseleave", function () {
        $(this).stop().find(".ch_edit_time").animate({"marginLeft":"0px"},200);
    });

    $(document).delegate(".ch_edit_location_wrap", "mouseenter", function () {
        $(this).stop().find(".ch_edit_loc").animate({"marginLeft":"-50px"},200);
    });
    $(document).delegate(".ch_edit_location_wrap", "mouseleave", function () {
        if(!$(this).find(".ch_edit_loc").hasClass("ch_in_edit") ){
            $(this).stop().find(".ch_edit_loc").animate({"marginLeft":"0px"},200);
        }
    });


    $(document).delegate(".ch_edit_loc", "click", function () {
        if(!$(this).hasClass("ch_in_edit")){
        var txt=$(this).closest(".ch_edit_location_wrap").find(".ghr-head-title-place").text().trim();
        $(this).closest(".ch_edit_location_wrap").find(".ghr-head-title-place").hide();
        $(this).closest(".ch_edit_location_wrap").find(".ed_loc").val(txt);
        $(this).closest(".ch_edit_location_wrap").find(".ed_loc").show();
        $(this).addClass("ch_in_edit");
        $(this).text("OK");
        }else{
        $(this).text("Edit");
        $(this).removeClass("ch_in_edit");
        var txt=$(this).closest(".ch_edit_location_wrap").find(".ed_loc").val().trim();

        $(this).closest(".ch_edit_location_wrap").find(".ed_loc").hide();
        $(this).closest(".ch_edit_location_wrap").find(".ghr-head-title-place").text(txt);
        $(this).closest(".ch_edit_location_wrap").find(".ghr-head-title-place").show();
        }
    });


        $(document).delegate(".upload-syla-btn", "click", function () {
            $(this).closest(".syla-evt_ctr").find(".upload-syla-input").click();
        });




        /*group js*/

            $(document).delegate(".joined","mouseover",function(){
            $(this).text("Withdraw");
    });

    $(document).delegate(".joined","mouseout",function(){
            $(this).text("Enrolled");
    });
    $(document).delegate(".tab-inactive","click",function(){
        if($(this).hasClass("tab2")){
            if($(".group-tab-active").find(".tab-title").find(".tab-icon").hasClass("tabc-icon-active")){
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
            $(".files-tab-content").hide()
            $(".members-tab-content").animate({ opacity: "1"},300);
            $(".members-tab-content").show();
        }
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
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide()
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $(".feed-tab-content").show();
            $(".feed-tab-content").animate({ opacity: "1"},300);
            
        }
        if($(this).hasClass("tab3")){
            
            
            
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
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").stop().animate({ opacity: "0"},300);
            $(".about-content").hide();
            
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $(".files-tab-content").show()
            $(".files-tab-content").animate({ opacity: "1"},300);
            
            
            
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
            
            $(".members-tab-content").stop().animate({ opacity: "0"},300);
            $(".members-tab-content").hide();
            $(".files-tab-content").stop().animate({ opacity: "0"},300);
            $(".files-tab-content").hide()
            $(".syllabus-tab-content").show();
            $(".syllabus-tab-content").animate({ opacity: "1"},300);
            
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
            
            $(".syllabus-tab-content").stop().animate({ opacity: "0"},300);
            $(".syllabus-tab-content").hide();
            $(".about-content").show();
            $(".about-content").animate({ opacity: "1"},300);
            
    });

    $(window).scroll(function(){ 
        var lastScrollTop= 47;
        var scrollTop = $(this).scrollTop();
        //alert(scrollTop);
        $(".group-head-footer").each(function(){
            var topDistance = $(this).offset().top;
            
                //alert(topDistance);
                //alert(scrollTop);
                if((topDistance-48) < scrollTop ){      
                    $(".urGroupStickyHeader").stop().css({"top": "47px"});
                    //alert("a");
                }else{
                    //alert("a");
                    $(".urGroupStickyHeader").stop().css({"top": "-2px"});
                }
                //alert("a");
            

        });

            

        lastScrollTop = scrollTop;

    });

    var about_text = $(".content-about").text();
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


    $(document).delegate('.hor-scroller-right',"click", function(){

        var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos + 200}, 400);
    });

    $(document).delegate('.hor-scroller-left',"click", function(){

        var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos - 200}, 400);
    });

    $(document).delegate('.hor-scroller-right',"mouseover", function(){
        var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos + 15}, 400);
        $(this).stop().show();
    });

    $(document).delegate('.hor-scroller-right',"mouseout", function(){
        if(rightable==1){
        var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos - 15}, 400, function(){
            $(this).find('.hor-scroller-right').hide();
        });
        }
    });

    $(document).delegate('.hor-scroller-left',"mouseover", function(){
        var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos - 15}, 400);
        $(this).stop().show();
    });

    $(document).delegate('.hor-scroller-left',"mouseout", function(){
        if(leftable==1){
        var $cardref=$(this).closest(".tab-block-content-scroll").find(".members-scrollwrap");
        var leftPos = $cardref.scrollLeft();
        $cardref.stop().animate({scrollLeft: leftPos + 15}, 400, function(){
            $(this).find('.hor-scroller-left').hide();
        });
    }
    });


    var able_offset=45;
    var leftable=0;
    var rightable=0;
    $('.members-scrollwrap').bind('scroll', function(){
        var $ref=$(this).closest(".tab-block-content-scroll");
        //get scroll width

        var scrollw= ($(this)[0].scrollWidth);
        

        if($(this).scrollLeft()<=0){
            leftable=0;
            $ref.find(".hor-scroller-left").stop().hide();
        }

        if($(this).scrollLeft()>=able_offset)
        {
            if(leftable==0){
                $ref.find(".hor-scroller-left").stop().show();
                leftable=1;
            }
        }
        

        if($(this).scrollLeft()+$(this).innerWidth()>=(scrollw-40)){
            $ref.find(".hor-scroller-right").stop().hide();
            rightable=0;
        }
        
        if($(this).scrollLeft()+$(this).innerWidth()<=(scrollw-40)){
            if(rightable==0){
                $ref.find(".hor-scroller-right").stop().show();
                rightable=1;
            }
        }
    });


    $(document).delegate('.members-scrollwrap',"mouseover", function(){
        var $ref=$(this).closest(".tab-block-content-scroll");
        var scrollw= ($(this)[0].scrollWidth);

        if($(this).scrollLeft()+$(this).innerWidth()>=(scrollw-40)){

        }else{
            
            $ref.find(".hor-scroller-right").stop().show();
            rightable=1;
            
        }

        if($(this).scrollLeft()>=able_offset)
        {
                $ref.find(".hor-scroller-left").stop().show();
                leftable=1;
        }


    });

    $(document).delegate('.tab-block-content-scroll',"mouseleave", function(){
        var $ref=$(this).closest(".tab-block-content-scroll");
        $ref.find(".hor-scroller-right").stop().hide();
        $ref.find(".hor-scroller-left").stop().hide();
    });
    
    $(document).delegate('.rating_star_empty1',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $("#help-star-1").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated1',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $("#help-star-1").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated1',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $("#help-star-1").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty1',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $("#help-star-1").css({"opacity":"0","display":"none"});
    });

    $(document).delegate('.rating_star_empty2',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $("#help-star-2").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated2',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $("#help-star-2").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated2',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $("#help-star-2").css({"opacity":"0","display":"none"});
        $(".rating_star_unrated2").addClass("rating_star_unrated");
    });
    $(document).delegate('.rating_star_empty2',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $("#help-star-2").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty3',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display","inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $("#help-star-3").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated3',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display","inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $("#help-star-3").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated3',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $("#help-star-3").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty3',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $("#help-star-3").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty4',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display","inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display","inline-block");

        //alert("a");
        $("#help-star-4").css({"opacity":"1","display":"inline-block"});

        $(".rating_star_unrated4").removeClass("rating_star_unrated");
    });
    $(document).delegate('.rating_star_unrated4',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display","inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display","inline-block");
        $(".rating_star_unrated4").removeClass("rating_star_unrated");
        $("#help-star-4").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated4',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $("#help-star-4").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty4',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $("#help-star-4").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty5',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display","inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display","inline-block");
        $(".rating_star_unrated4").removeClass("rating_star_unrated");
        $(".rating_star_unrated5").css("display","inline-block");
        $(".rating_star_unrated5").removeClass("rating_star_unrated");
        //alert("a");
        $("#help-star-5").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated5',"mouseenter", function(){
        $(".grade_stars").hide();
        $(".rating_star_unrated1").css("display","inline-block");
        $(".rating_star_unrated1").removeClass("rating_star_unrated");
        $(".rating_star_unrated2").css("display","inline-block");
        $(".rating_star_unrated2").removeClass("rating_star_unrated");
        $(".rating_star_unrated3").css("display","inline-block");
        $(".rating_star_unrated3").removeClass("rating_star_unrated");
        $(".rating_star_unrated4").css("display","inline-block");
        $(".rating_star_unrated4").removeClass("rating_star_unrated");
        $(".rating_star_unrated5").css("display","inline-block");
        $(".rating_star_unrated5").removeClass("rating_star_unrated");
        $("#help-star-5").css({"opacity":"1","display":"inline-block"});
    });
    $(document).delegate('.rating_star_unrated5',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $(".rating_star_unrated5").addClass("rating_star_unrated");
        $("#help-star-5").css({"opacity":"0","display":"none"});
    });
    $(document).delegate('.rating_star_empty5',"mouseleave", function(){
        $(".grade_stars").show();
        $(".rating_star_unrated1").addClass("rating_star_unrated");
        $(".rating_star_unrated2").addClass("rating_star_unrated");
        $(".rating_star_unrated3").addClass("rating_star_unrated");
        $(".rating_star_unrated4").addClass("rating_star_unrated");
        $("#help-star-5").css({"opacity":"0","display":"none"});
        $(".rating_star_unrated5").addClass("rating_star_unrated");
    });



    $(document).delegate('.rating_star',"click", function(){
        $(".grey_star").removeClass("grey_star");
        $(".grade_stars").find(".rating_star").addClass("grey_star");
        var rt=0;
        for (i = 0; i <= 5; i++) {
        if($(this).hasClass("rating_star_unrated"+i)){

            for (j = 0; j < i; j++) {
                    var k=j+1;
                    //alert($(".grade_stars").find(".rating_star_unrated"+k).attr("class"));
                    $(".grade_stars").find(".grating_star_unrated"+k).removeClass("grey_star");
                
            }
        }
        }

        $(".grade_stars").show();       

    });




    /*sortable drag effect*/
    $( ".ui-sortable" ).sortable();
    $( ".ui-sortable" ).disableSelection();


    /*syla*/
    var tooltipflag=0;
    $(document).delegate('.syla_tag',"click", function(){
        if(!$(this).hasClass("syla_checked")){
        $(this).addClass("syla_checked");
        $(this).find(".check_syla").css({"background-image":"url(src/checked-syla.png)"});
        $(this).closest(".a_weekview").find(".help-box2").text("Click to remove this event");
        }else{
        $(this).removeClass("syla_checked");
        $(this).find(".check_syla").css({"background-image":"url(src/add.png)"});
        $(this).closest(".a_weekview").find(".help-box2").text("Click to add this event");
        }
    });

    $(document).delegate('.syla_tag',"mouseover", function(){

        $(this).closest(".a_weekview").find(".help-div").animate({opacity:"1"},100);
    });    

    $(document).delegate('.syla_tag',"mouseout", function(){
        $(this).closest(".a_weekview").find(".help-div").animate({opacity:"0"},100);
    });    

    $(document).delegate('.follow',"click", function(){
        if(!$(this).hasClass(".tab_followed")){
        $(this).text("Following");
        $(this).addClass("tab_followed");
        }
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
    });

    $(document).delegate('.ready_to_unfollow',"mouseenter", function(){
        $(this).text("Unfollow");
    });
    $(document).delegate('.ready_to_unfollow',"mouseleave", function(){
        $(this).text("Following");
    });

        /*group js*/




            /*progress function for ajax*/
            function progressHandlingFunction(e){
                if(e.lengthComputable){
                    $('progress').attr({value:e.loaded,max:e.total});
                }
            }

    });
    </script>
</head>
<body>
<div class='root'>

        <div class = "modal_invite_body modal_body">
            <div class = "modal_invite_container">
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
                        <div class="modal_main_form">
                            <label for = "cover_name" class = "label_left">
                                Send Invitation To:
                            </label>
                            <input class = "inputBig inviteName" id = "cover_name" placeholder = "Email Address">
                            <label for = "cover_name" class = "label_left2">
                                Or:
                            </label>
                            <button class = "inviteBtn">
                                Upload Member List Excel Document
                            </button>
                            <form id="upload_excel_form">
                                <input type='file' class='upload_excel_list' name='excel_list'>
                            </form>
                            <div class='excel_label'>No File Uploaded</div>

                            <div class='modal-mid'>
                                <textarea class='modal-mid-textarea'placeholder='Customize your invitation email!' value=""></textarea>
                            </div>

                            <div class = "btmleft">

                                <button type=  "button" class = "cancelBtn grayBtn">
                                    Cancel
                                </button>
                                <button type=  "button" class = "blueBtn modal_ml_submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<div class='main'>

<div class='main-mid-sec'>

<div class='mid_right_sec'>
    <div class = "group-head-sec">
        <div class = "group-pic-frame">
            <div class = "group-pic">
            </div>
        </div>
        <div class = "group-header-left">


            <div class = "group-title">
                <div class = "group-name">
                    Sample Name
                </div>
                <a class = "group-id">
                1234
                </a>
            </div>
            <div class = "group-leader">
                
                    <span class = "imp-icon leader-icon" >
                    </span >
                    <span class = "group-info-title" >

                    </span >
                </a > 
  
            </div >
        </div >

        <div class="group_info_head_sec" >
            <div class = "gih" >


            </div >
        </div >
        <div class = "group-header-right" >
            <div class="ch_edit_time_wrap" >
    
     <div class="ch_edit_time" >Edit</div >
    
    <div class = "ghr-1 ghr-box" style = "left:0px" >
                <div class = "ghr-box-head" >
                    <span class = "ghr-icon-1 ghr-icon" >
                    </span >
                    <span class = "ghr-head-time ghr-head-title" >
    $schedule_string 
                    </span >

                </div >
            </div >
            </div >

            <div class="ch_edit_location_wrap" >
            
    <div class = "ghr-2 ghr-box" style = "left:0px" >
                <div class = "ghr-box-head" >
                    <span class = "ghr-icon-2 ghr-icon" >
                    </span >
                    <span class = "ghr-head-title-place ghr-head-title" >
    course_location 
                    </span >
                    <input type = "text" class="edit_header ed_loc" >
                </div >
            </div >
            </div >

            <div class = "ghr-3 ghr-box" >
                <a class = "department-link" >
                    <div class = "ghr-box-head" >
                        <span class = "ghr-icon-3 ghr-icon" >
                        </span >
                        <span class = "ghr-head-title" id = "' . $dept_id . '" >
        Department Name
                        </span >
                    </div >
                </a >
            </div >
        </div >
        <div class = "group-head-footer" >
            <div class = "group-header-tab" >
                <ul class = "group-nav" >
                    <li class = "group-tab" >
                        <a class = "tab1 tab-anchor group-tab-active" >
                            <div class = "tab-title" >
                                CLASS FEED
                                <span class = "tab-icon tab1-icon-active" ></span >
                            </div >
                        </a >
                    </li >
                    <li class = "group-tab" >
                        <a class = "tab2 tab-anchor tab-inactive" >
                            <div class = "tab-title" >
    MEMBERS
                                <span class = "tab-icon tab2-icon-inactive" ></span >
                            </div >
                            <div class = "status tab-number" >
                                <span class = "badge" >
    24
                                </span >
                            </div >
                        </a >
                    </li >
                    <li class = "group-tab" >
                        <a class = "tab3 tab-anchor tab-inactive" >
                            <div class = "tab-title" >
    FILES
                                <span class = "tab-icon tab3-icon-inactive" ></span >
                            </div >
                            <div class = "status tab-number" >
                                <span class = "badge" >
    23
                                </span >
                            </div >
                        </a >
                    </li >
                    <li class = "tab-no-badge group-tab" >
                        <a class = "tabc tab-anchor tab-inactive" >
                            <div class = "tab-title" >
    SYLLABUS
                                <span class = "tab-icon tabc-icon-inactive" ></span >
                            </div >
                        </a >
                    </li >
                </ul >
            </div >
            <div class = "group-footer-functions" > ';

    
                <div class = "join-button" >
                    <a class = "join" >
                        Edit
                    </a >
                </div >
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
    </div > 
  
                <div class = "join-button" >
                    <a class = "join" >
    Enroll
                    </a >
                </div >
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
    </div >  
                <div class = "join-button" >
                    <a class = "join joined" >
    Enrolled
                    </a >
                </div >
            </div >
        </div >
        <div class = "tab-wedge-down" >
        </div >
    </div > 

<div class='midsec'>
    <div class='feed-tab-content'>

      
   
</div>


<?php mysqli_close($con); ?>

</body>


</html>