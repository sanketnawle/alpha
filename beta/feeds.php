<?php
require_once('includes/dbconfig.php');
require_once('includes/time.php');
require_once('includes/feedchecks.php');
include_once('php/feeds/feeds_priority.php');
include_once('includes/common_functions.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['PHP_SELF'] == '/feed_single.php' AND isset($_GET['post_id'])) {
    $result = $con->query("SELECT * FROM posts WHERE post_id=" . $_GET['post_id']);
} else {
    if ($_SERVER['PHP_SELF'] == '/profile.php' AND isset($_GET['user_id'])) {
        $arr = get_profile_posts($_GET['user_id'], 1);
    } elseif ($_SERVER['PHP_SELF'] == '/courses.php' AND isset($_GET['course_id'])) {
        $arr = get_course_posts($_GET['course_id'], 1);
    } elseif ($_SERVER['PHP_SELF'] == '/class.php' AND isset($_GET['class_id'])) {
        $arr = get_class_posts($_GET['class_id'], 1);
    } elseif ($_SERVER['PHP_SELF'] == '/clubs.php' AND isset($_GET['group_id'])) {
        $arr = get_club_posts($_GET['group_id'], 1);
    } elseif ($_SERVER['PHP_SELF'] == '/department.php' AND isset($_GET['dept_id'])) {
        $arr = get_dept_posts($_GET['dept_id'], 1);
    } elseif ($_SERVER['PHP_SELF'] == '/school.php' AND isset($_GET['univ_id'])) {
        $arr = get_school_posts($_GET['univ_id'], 1);
    } else {
        $arr = prioritize_posts(1, FALSE);
        $home_flag=TRUE;
    }
}

// $arr = array('257', '256');

if (isset($arr)) {

   if(isset($home_flag) && count($arr)==0){
        echo '<div class = "onboarding_main_container">
                    <div class = "onboarding_main_header_container onboarding_main_default_container">
                        <h4>
                            Welcome to Urlinq,';  
                               $user_id=$_SESSION['user_id'];
                               $details=get_user_info($con,$user_id);
                               echo $details["firstname"];
                    
                    echo  '</h4>
                    </div>
                    <div class = "onboarding_main_default_container">
                        <div class = "onboarding_step step_1">
                        </div>
                        <div class = "onboarding_step_body">

                            <h5>
                                Join your first class or club on Urlinq
                            </h5>  
                            <p>
                                Connect with people and keep track of schedules in your groups. Search the classes in your department to get started.
                            </p>

                            <div class = "onboarding_step_body_actions">
                                <!--Preset the value of the search input with the query "User_department Classes"-->
                                <div class = "onboarding_minisearch_wrapper">
                                    <input class = "onboarding_mini_search" placeholder = "Search your classes & clubs" value = "classes" >
                                    <button type="button" title = "Search Urlinq" class = "onboarding_mini_search_gobtn" id="onboarding_mini_search_gobtn">
                                        <i class = "white_search_icon">
                                        </i>
                                    </button>
                                </div>
                            </div>

                            
                        </div> 
                    </div>
                    <div class = "onboarding_main_default_container">
                        <div class = "onboarding_step step_2">
                        </div>
  
                        <div class = "onboarding_step_body">
                            <h5>
                                Get to know professors and peers in your department
                            </h5>
                            <p>
                                Build your academic network by following professors and students at your school who share your interests.
                            </p>
                            <!--First Step is to show the new user 2 people they should follow in their department -->
                              ';
                              include "onboarding_people.php"; 
                        echo '</div>                                          
                    </div>
                    <div class = "onboarding_main_default_container">
                        <div class = "onboarding_step step_3">
                        </div>
                        <div class = "onboarding_step_body">
                            <h5>
                                Fill out your profile information
                            </h5>
                            <p>
                                Your department and school are already filled out. Now add your interests and contact info in profile page to create an academic identity.
                            </p>
                        </div>                     
                    </div>';
                    include "onboarding_profilepic.php"; 
               echo  '</div>';
   } 
    $result = $con->query("SELECT * FROM posts WHERE post_id IN (" . implode(",", $arr) . ") ORDER BY FIELD(post_id," . implode(",", $arr) . ")");
}

// if(isset($_GET['user_id'])){
//  // echo "test";
//  $_GET['user_id'] = 1;
//  $result = mysqli_query($con,"SELECT * FROM posts WHERE user_id = ".$_GET['user_id']." ORDER BY update_timestamp DESC LIMIT 5");
// }
// else{
//  $result = mysqli_query($con,"SELECT * FROM posts ORDER BY update_timestamp DESC LIMIT 5");
//  // echo mysqli_num_rows($result);
// }

?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" type="text/css" href="css/feed.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
        <link
            href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
            rel='stylesheet' type='text/css'>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>

        <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
        <!--<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
        <!--<script src="feed.js"></script>-->
        <!-- // <script src="js/timeago.js" type="text/javascript"></script> -->
    </head>
<script>
    /* if you need new js, please goes here - for onboarding process!!!*/
    $(document).ready(function () {        
        $(".onboarding_mini_search").focus();

        $(document).delegate('.post-btn',"click", function(){
            $(".onboarding_main_container").hide();
        });
        
        $(document).delegate('.green_btn',"click", function(){
            $(".photo_card_user_hidden").click();
        });

        $(document).delegate('.file-thumb-cover',"click", function(){

            window.location = $(this).closest(".file-pic-wrap").find(".file-download").attr('href');
        });


        $(document).delegate(".photo_card_user_hidden","change",function(){

            //append animation
            $(this).closest(".photo_card_user").css({"background":"#fff"});
            $(this).closest(".photo_card_user").append("<img class='waiting_animation_circletype waiting_animation_circletype_sz56' src='img/waiting_animation_circletype.GIF'>");
            //append animation end
            var $ref = $(this);
            var formData = new FormData($ref.closest("form")[0]);
            var editing= "show";
            formData.append("editing", editing);
/*php/profile/update_profile.php
img is the file name*/
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

            $ref.closest(".photo_card_user").find(".waiting_animation_circletype").remove();
            $ref.closest(".photo_card_user").css({"background-image": "url(" + html + ")"});

            var formData = new FormData($ref.closest("form")[0]);
                    $.ajax({
                        type: "POST",
                        url: "php/profile/update_profile.php",
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

                            //alert("success");

                        },
                        error: function (html) {
                            //alert(html);
                        }
                    });

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
<script>
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '237922879690774',
          xfbml      : true,
          version    : 'v2.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
      function fb_login(){
            FB.getLoginStatus(function(response) {
        if (response && response.status === 'connected') {
            testAPI();
        }else{
             FB.login(function(response) {
   if (response.authResponse) {
     console.log('Welcome!  Fetching your information.... ');
     testAPI();
     FB.api('/me', function(response) {
       console.log('Good to see you, ' + response.name + '.');

     });
   } else {
     console.log('User cancelled login or did not fully authorize.');
   }
 });

        }
    });
        }
        function testAPI() {

            //append animation
            $(".photo_card_user").css({"background":"#fff"});
            $(".photo_card_user").append("<img class='waiting_animation_circletype waiting_animation_circletype_sz56' src='img/waiting_animation_circletype.GIF'>");
            //append animation end
    
   console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        var profilepicture="https://graph.facebook.com/"+response.id+"/picture?type=large";
        ////alert(profilepicture);
         $.ajax({  
                    type: "POST", 
                    url:"php/onboarding_functions.php",
                    data: {profilepicture:profilepicture},
                    success: function(response) {
                        //alert("sucess");

                        $(".photo_card_user").find(".waiting_animation_circletype").remove();
                        $(".photo_card_user").css({"background-image": "url(" + profilepicture + ")"});

                    },    
                    error: function(response) {
                        //alert("error");
                    }
                });
      console.log('Successful login for: ' + JSON.stringify(response));
     console.log(JSON.stringify(response));
     
    });
    FB.api(
    "/me/picture",
    function (response) {
      if (response && !response.error) {
        console.log(JSON.stringify(response));
    var url=response.data.url;
    console.log(url);
    
      }
    }
  );

  }
  var d = new Date()
  var n = d.getTimezoneOffset(); 
  document.getElementById('offset').value= -n/60;
  document.getElementById('offset').value=('0' +  document.getElementById('offset').value).slice(-2);
  document.getElementById('fboffset').value=document.getElementById('offset').value;
  console.log(document.getElementById('offset').value);


        </script>



    <!--dummy jquery for leftbar-->
    <script>
        $(document).ready(function () {
            $(".admin-name").each(function (index) {
                var l = $(this).text().length;
                if (l > 21) {
                    $(this).text($(this).text().substring(0, 18) + "...");
                }
            });


            $(document).delegate('.user_follow_btn_id',"click", function(){
                var follow_user=$(this).attr("id");
                var $this= $(this);
                //alert(follow_user);
                  $.ajax({  
                    type: "POST", 
                    url:"includes/followunfollow.php",
                    data: {follow_user:follow_user},
                    success: function(response) {
                        if($this.hasClass("onboard_followed")){
                            $this.removeClass("onboard_followed");
                            $this.text("Follow");
                           
                        }else{
                            $this.addClass("onboard_followed");   
                            $this.text("Followed");
                        }

                    },
                    error: function(response) {
                        //alert(response);
                    }
                });
            });
        });
    </script>

    <script>
$( document ).ready(function() {
            $(document).delegate(".option_report","click",function(){

                    var postid= $(this).closest(".posts").attr("id");
                    ////alert(postid);

                    $(".report_popup").attr("id",postid);
                    $(".blackcanvas").stop().show();
                    $(".blackcanvas").find(".report_popup").stop().show();
                   
    });


    $(document).delegate(".popup_btn_1","click",function(){
        if($(this).closest(".popup_window").hasClass("report_popup")){
            $(".blackcanvas").hide();
        }
    });

    $(document).delegate(".popup_btn_0","click",function(){
        if($(this).closest(".popup_window").hasClass("report_popup")){
            var post_id=$(this).closest(".popup_window").attr("id");
            ////alert(post_id);
            $.ajax({
                        type: "POST",
                        url: "includes/feedops.php",
                        data: {post_id: post_id, report: 1},
                        success: function(html){ 
                                $(".blackcanvas").hide();
                    }
            });
        }
    });


});

    </script>
<script>
$(document).ready(function() {
    $("#onboarding_mini_search_gobtn").click(function(){
      var text=$(".onboarding_mini_search").val();
      //alert(text);
      window.open("https://urlinq.com/search_beta.php?q="+text);
    });
    $("#search_people").click(function(){
        var dept_id=<?php session_start(); echo $_SESSION['dept_id']; ?>;
      window.open("https://urlinq.com/department.php?dept_id="+dept_id+"&orgin=onboard");
    });

});
</script>
    <script>

        // $(document).ready(function(){
        //   jQuery.timeago.settings.allowFuture = true;
        //               jQuery("time.timeago").timeago();
        // });
        navigator.sayswho = (function () {
            var ua = navigator.userAgent, tem,
                M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if (/trident/i.test(M[1])) {
                tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
                return 'IE ' + (tem[1] || '');
            }
            if (M[1] === 'Chrome') {
                tem = ua.match(/\bOPR\/(\d+)/)
                if (tem != null) return 'Opera ' + tem[1];
            }
            M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
            if ((tem = ua.match(/version\/(\d+)/i)) != null) M.splice(1, 1, tem[1]);
            return M.join(' ');
        })();
    </script>
    <script>

    function download(id) {
        window.open("includes/download_file.php?file_id=" + id, "hiddenFrame");
    }

    var j$ = $.noConflict();
    $(document).ready(function () {

        j$.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';

        j$(".new_fd").each(function (index) {

            j$(this).removeClass("new_fd");
            if (j$(this).find(".f_hidden_p").text().trim() != "") {
                j$(this).find('.play').embedly({
                    query: {
                        maxwidth: 500,
                        autoplay: true
                    },
                    display: function (data, elem) {

//Adds the image to the a tag and then sets up the sizing.
                        j$(elem).html('<img src="' + data.thumbnail_url + '"/>')
                            .width(data.thumbnail_width)
                            .height(data.thumbnail_height)
                            .find('span').css('top', data.thumbnail_height / 2 - 36)
                            .css('left', data.thumbnail_width / 2 - 36);
////alert($(elem).html());
                        var j$elhtml = j$(elem).html();
                        j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

                        var t_title = data.title;
                        var t_des = data.description;
                        var t_url = data.url;
////alert(data.title+" , "+data.description+", "+data.url);
                        var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

                        j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
                        j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

                        if (data.type === 'video') {

                        } else {
                            j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
                        }

                    }
                }).on('click', function () {
// Handles the click event and replaces the link with the video.
                    var data = j$(this).data('embedly');

                    if (data.type === 'video') {
                        j$(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                        return false;
                    } else {
                        window.open(data.url, '_blank');
                    }

                });

            }

        });


        j$(document).delegate('.playable_wrap', "click", function () {
            j$(this).closest(".post_lr_link_msg").find(".play").click();
        });


        setTimeout(function () {
            latest_feed();
        }, 5000);


        $(document).delegate(".post_functions_showr", "click", function () {
            if ($(this).closest(".post_functions").hasClass("functions_active")) {
                $(this).closest(".post_functions").find(".post_functions_box").hide();
                $(this).closest(".post_functions").removeClass("functions_active");
            } else {
                $(this).closest(".post_functions").find(".post_functions_box").show();
                $(this).closest(".post_functions").addClass("functions_active");
            }
        });

        var fileList = {};
        var fileCount = 0;

        $(".form-control").on("focus", function FormControlFocus () {
            var attr = $(this).attr("focused");                        
            if(typeof attr === undefined || attr === false || attr === undefined || !attr) {
                var ta = $(this);

                ta.attr("focused", "yes");

                ta.css({"min-height": 65, "padding-bottom": 21, "padding-left": 0});

                ta.parents(".postcomment").find(".comment_owner_container").show();
                ta.closest(".postcomment").find(".reply_user_icon").hide();
                ta.closest(".commentform").find(".dragdrop_functions").show();
                ta.closest(".commentform").find(".reply_functions").show();
                ta.closest(".posts").find(".feed_upload_textprompt").show();
            }
        });

        $(".form-control").on("keyup", function (e) {
            e = e || event;
            if(e.keyCode == 13 && !e.shiftKey) {
                $(this).closest(".commentform").find(".reply_button").click();
                e.preventDefault();
                return false;
            }
            var ta = $(this)[0];
            $(ta).css("height", 0);
            if(ta.scrollHeight > ta.offsetHeight) {
                $(ta).css({"height": ta.scrollHeight});
            }
        });

        function stopDoing(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function handleFiles(files, ele) {            
            fileList[fileCount] = files[0];
            var status = new FileEntry(ele, fileCount);
            status.setFileNameSize(files[0].name, files[0].size);
            ++fileCount;            
        }

        function FileEntry(ele, i) {            
            this.statusbar = $("<div class='status center' data-id='" + i + "' />");
            this.filename = $("<span class='left' />").appendTo(this.statusbar);
            this.close = $("<span class='close'>x</span>").appendTo(this.statusbar);
            this.size = $("<span class='right' />").appendTo(this.statusbar);
            var sb = this.statusbar;
            this.close.click(function () {
                delete fileList[i];
                sb.remove();
                ele.siblings(".fileinputbox, .dragdropbox").show();
                var control = ele.siblings(".fileinputbox .fileinput");
                control.wrap('<form />').parent('form').trigger('reset');
                control.unwrap();
            });
            ele.append(this.statusbar);
            ele.siblings(".fileinputbox, .dragdropbox").hide();
            this.setFileNameSize = function (name, size) {
                var sizeKB = size / 1024;
                var sizeStr = parseInt(sizeKB) > 1024 ? (sizeKB / 1024).toFixed(2) + " MB" : sizeKB.toFixed(2) + " KB";
                this.filename.html(name);
                this.size.html(sizeStr);
            }
        }

        $(".fileinput").change(function () {            
            handleFiles($(this).prop("files"), $(this).parent().siblings(".filelistbox"));
        });

        var dragOrigText = "Drag and drop a file here or Click to upload a file";
        var dragEnterText = "Drop your file here";
        var dragLeaveText = "Drag your file here";
        var dragOnTarget = 0;
        $(".dragdropbox")
                .on("dragenter", function (e) {
                    dragOnTarget += 1;
                    stopDoing(e);
                    $(this).addClass("dragenter");
                    $(this).html(dragEnterText);
                })
                .on("dragleave", function (e) {
                    dragOnTarget -= 1;
                    $(this).removeClass("dragenter");
                    $(this).html(dragLeaveText);                    
                })
                .on("dragover", function (e) {
                    stopDoing(e);
                })
                .on("drop", function (e) {                    
                    $(this).removeClass("dragenter");
                    stopDoing(e);
                    $(".dragdropbox").html(dragOrigText);
                    handleFiles(e.originalEvent.dataTransfer.files, $(this).siblings(".filelistbox"));
                })
                .click(function () {                    
                    $(this).siblings(".fileinputbox").find(".fileinput").click();
                });

        var collection = $();
        var plannerOffset = $(".planner").offset().top;

        $(document).scroll(function() {            
            if(plannerOffset - $(document).scrollTop() <= 70) {
                $(".planner").css({"position": "fixed", "top": 70});
            } else {
                $(".planner").css({"position": "static", "top": "auto"});
            }
        })

        $(document).on("dragenter", function(e) {
            stopDoing(e);            
            if(collection. length === 0) $(".dragdropbox").html(dragLeaveText);
            collection = collection.add(e.target)
        }).on("dragleave drop", function(e) {
            stopDoing(e);
            collection = collection.not(e.target);
            if(collection.length === 0 && dragOnTarget === 0) $(".dragdropbox").html(dragOrigText);
        })

        $(document).click(function (e) {
            var container = $(".commentform");
            if(!container.is(e.target) && container.has(e.target).length === 0) {
                var ata = $(this).find(".form-control");
                ata.each(function(){ minimizeCommentForm($(this)); });
            }
        });

        function minimizeCommentForm(ta) {                        
            var fl = ta.closest(".postcomment").find(".filelistbox").find(".status");
            if(ta.val().trim() == "" && fl.length == 0) {
                ta.removeAttr("focused");

                ta.parents(".postcomment").find(".comment_owner_container").hide();
                ta.closest(".postcomment").find(".reply_user_icon").show();
                ta.closest(".commentform").find(".dragdrop_functions").hide();
                ta.closest(".commentform").find(".reply_functions").hide();
                ta.closest(".posts").find(".feed_upload_textprompt").hide();

                ta.removeAttr("style"); 
            }
        }

        // $(document).delegate(".postcomment", "click", function(e) {
        //     var attr = $(this).find(".form-control").attr("focused");
        //     if(typeof attr !== undefined && attr !== false) {
        //         e.preventDefault();
        //         return false;
        //     }
        // });

        $(document).delegate(".flat7b", "click", function (event) {

            if (!$(this).hasClass("flat_checked")) {
                $(this).css({"border": "1px solid #00A076", "background-color": "#02e2a7"});
                $(this).closest(".check_wrap").find(".move").css({"margin-left": "16px"});
                $(this).addClass("flat_checked");
                $(this).closest(".check_wrap").find(".comment_anon_text").css("color", "rgba(33,33,33,.85)");
                $(this).closest(".posts").find(".post_anon_val").val("1");
            } else {
                $(this).css({"border": "1px solid #C9C9C9", "background-color": "#f5f5f5"});
                $(this).closest(".check_wrap").find(".move").css({"margin-left": "0px"});
                $(this).removeClass("flat_checked");
                $(this).closest(".check_wrap").find(".comment_anon_text").css("color", "rgba(153, 153, 153, 0.64)");
                $(this).closest(".posts").find(".post_anon_val").val("0");
            }
        });

        $(document).delegate(".post_comment_btn", "click", function () {            
            var fa = $(this).closest(".posts").find(".form-control");
            setTimeout(function () { fa.trigger("focus"); }, 1);
        });

        var load = 'yes';
        var feeds = $("#posts");
        var last_time = 0;
        var heightOffset = 550;
        var pg = 1;


        $(document).delegate('.post_functions', "click", function () {
            $(this).find('.post_functions_box').show();
            $(this).addClass('functions_active');
        });

        $(document).delegate('.functions_active', "click", function () {

            //ajax add here

            //appearance change when click
            $(this).find('.post_functions_box').hide();
            $(this).removeClass('functions_active');
        });


        $(window).scroll(function () {
            ////alert($(window).scrollTop() + heightOffset >= $(document).height() - $(window).height());
            if (load == 'yes') {

                if ($(window).scrollTop() + heightOffset >= $(document).height() - $(window).height()) {
                    ////alert(heightOffset);
                    load = 'no';
                    pg = pg + 1;
                    last_time = $("#posts").children().last().attr('id');
                    var $ref = $("#posts");
                    var pullrequest = $.ajax({
                        type: "POST",
                        url: "oldfeed.php",
                        cache: false,
                        data: {last_time: last_time,
                            pg: pg
                            <?php
                            if(isset($_GET['user_id'])) echo ", user_id: ".$_GET['user_id'];
                            elseif(isset($_GET['class_id'])) echo ", class_id: '".$_GET['class_id']."'";
                            elseif(isset($_GET['course_id'])) echo ", course_id: '".$_GET['course_id']."'";
                            elseif(isset($_GET['group_id'])) echo ", club_id: ".$_GET['group_id'];
                            elseif(isset($_GET['dept_id'])) echo ", dept_id: ".$_GET['dept_id'];
                            elseif(isset($_GET['univ_id'])) echo ", univ_id: ".$_GET['univ_id'];
                            ?>
                        },
                        datatype: "html"
                    });
                    pullrequest.done(function (html) {
                        $ref.last().append(html);
                        load = 'yes';

                        j$(".new_fd").each(function (index) {

                            j$(this).removeClass("new_fd");
                            if (j$(this).find(".f_hidden_p").text().trim() != "") {
                                j$(this).find('.play').embedly({
                                    query: {
                                        maxwidth: 500,
                                        autoplay: true
                                    },
                                    display: function (data, elem) {

//Adds the image to the a tag and then sets up the sizing.
                                        j$(elem).html('<img src="' + data.thumbnail_url + '"/>')
                                            .width(data.thumbnail_width)
                                            .height(data.thumbnail_height)
                                            .find('span').css('top', data.thumbnail_height / 2 - 36)
                                            .css('left', data.thumbnail_width / 2 - 36);
////alert($(elem).html());
                                        var j$elhtml = j$(elem).html();
                                        j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

                                        var t_title = data.title;
                                        var t_des = data.description;
                                        var t_url = data.url;
////alert(data.title+" , "+data.description+", "+data.url);
                                        var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

                                        j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
                                        j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

                                        if (data.type === 'video') {

                                        } else {
                                            j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
                                        }

                                    }
                                }).on('click', function () {
// Handles the click event and replaces the link with the video.
                                    var data = j$(this).data('embedly');

                                    if (data.type === 'video') {
                                        j$(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                                        return false;
                                    } else {
                                        window.open(data.url, '_blank');
                                    }

                                });

                            }

                        });


                    });
                }
            }
        });

        /*
         $(document).delegate('.submit',"click", function(){
         var $owner= $(this).closest(".posts");
         var commentid= $owner.find(".comments .post_comment").last().attr("id");
         var postid= $owner.attr("id");
         var commentcontent= $owner.find(".postval").val().trim();

         if(commentcontent!=""){
         $.ajax({
         type: "POST",
         url: "includes/updatecomments.php",
         data: {postid: postid, commentid: commentid, commentcontent: commentcontent},
         success: function(html){
         ////alert("sad");
         $owner.find(".comments").last().append(html);
         $owner.find(".postval").val("");
         }
         });
         }
         });
         */

        $(document).click(function (event) {
            var $target = $(event.target);

            //click outside hide event
            var $container = $(".post_functions");
            if (!$container.is($target) && ($container.has($target).length === 0)) {
                $(".post_functions_box").stop().hide();
                $(".post_functions").removeClass('functions_active');
            }

        });


        //post like
        setInterval(function () {
            flagSetBack();
        }, 2000);

        var likepost_flag = 0;

        $(document).delegate('.post_like', "click", function () {
            if (likepost_flag == 0) {
                likepost_flag = 1;
                var postid = $(this).closest(".posts").attr("id");
                ////alert("b");
                var lk = $(this).find(".like_number");
                var afterlike = lk.text().trim();
                if (afterlike == '') {
                    afterlike = 0;
                } else {
                    afterlike = parseInt(afterlike);
                }
                addlike = afterlike + 1;
                minuslike = afterlike - 1;
                if (minuslike == '0') {
                    minuslike = ' ';
                }

                if ($(this).hasClass("post_liked")) {
                    //de-like
 		    $(this).removeClass("post_liked");


                    $.ajax({
                        type: "POST",
                        url: "includes/feedops.php",
                        data: {post_id: postid, unlike: 1},
                        success: function (html) {
                            lk.text(minuslike);
                        }
                    });

                } else {
                    $(this).addClass("post_liked");

                    $.ajax({
                        type: "POST",
                        url: "includes/feedops.php",
                        data: {post_id: postid, like: 1},
                        success: function (html) {
                            lk.text(addlike);
                        }
                    });

                }
            }
        });


        /*
         $(document).delegate('.mf_liked',"mouseover", function(){
         $(this).closest(".post_lc").find(".mf_name").text($(this).attr("id"));
         $(this).closest(".post_lc").find(".mf_name").stop().show();
         });

         $(document).delegate('.mf_liked',"mouseout", function(){
         $(this).closest(".post_lc").find(".mf_name").delay(1).hide();
         });

         $(document).delegate('.mf_name',"mouseover", function(){
         $(this).stop().show();
         $(this).closest(".post_lc").find(".card-tag").stop().show();
         });

         $(document).delegate('.mf_name',"mouseout", function(){
         $(this).stop().delay(1).hide();
         $(this).closest(".post_lc").find(".card-tag").delay(1).hide(0);
         });
         */

        $(document).delegate('.post_comment', "mouseover", function () {
            $(this).find(".comment_delete").show();
        });

        $(document).delegate('.post_comment', "mouseout", function () {
            $(this).find(".comment_delete").hide();
        });

        $(document).delegate('.field', "click", function () {
            if ($(this).closest(".posttool-select").hasClass("privacy_canedit")) {
                $(this).closest(".posttool-select").find(".visi_functions_box").show();
                cardtag_flag = 1;
                $(this).closest(".field").find(".card-tag").hide();

                $(this).css({"border": "1px solid rgba(60,60,60,0.23)", "background-color": "rgba(60,60,60,0.03)"});

                $(this).find(".vstt_wedgeDown").css({"opacity": "1"});
            }
        });


        $(document).click(function (event) {

            var $target = $(event.target);
            var $container = $(".posttool-select");
            if (!$container.is($target) && ($container.has($target).length === 0)) {
                $container.find(".visi_functions_box").stop().hide();
                cardtag_flag = 0;

                $container.find(".field").css({"border": "1px solid rgba(60,60,60,0)", "background-color": "white"});
                $container.find(".vstt_wedgeDown").css({"opacity": "0"});
            }
            if ($target.hasClass(".visi_functions_option")) {
                $container.find(".visi_functions_box").stop().hide();
                cardtag_flag = 0;
                $container.find(".field").css({"border": "1px solid rgba(60,60,60,0)", "background-color": "white"});
                $container.find(".vstt_wedgeDown").css({"opacity": "0"});
            }
        });

        $(document).delegate(".visi_functions_option", "click", function () {
            //student campus connections faculty
            var ref = $(this).closest(".posttool-select");
            var privacy = "campus";
            if ($(this).find(".visi_icon").hasClass("i_campus")) {
                privacy = "campus";
            }
            if ($(this).find(".visi_icon").hasClass("i_student")) {
                privacy = "students";
            }
            if ($(this).find(".visi_icon").hasClass("i_faculty")) {
                privacy = "faculty";
            }
            if ($(this).find(".visi_icon").hasClass("i_connections")) {
                privacy = "connections";
            }


            var post_id = $(this).closest(".posts").attr("id");

            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {privacy: privacy, post_id: post_id},
                success: function (html) {
                    ref.find(".tag-box").text("Visible to " + privacy);
                }
            });

            $(this).closest(".visi_functions_box").hide();
            cardtag_flag = 0;
            ref.find(".field").css({"border": "1px solid rgba(60,60,60,0)", "background-color": "white"});
            ref.find(".vstt_wedgeDown").css({"opacity": "0"});

            var src_2 = $(this).closest(".posttool-select").find(".visi_icon").css("background-image");
            if (navigator.sayswho.split(" ")[0].toLowerCase() == "firefox") {
                src_2 = src_2.substring(1);
            }
            var srcarr = src_2.split("_");
            srcarr[srcarr.length - 1] = "status.png";
            var subarr = srcarr[srcarr.length - 2].split("/");
            srcarr[srcarr.length - 2] = "status/" + privacy;
            var src_2 = srcarr.join("_").substring(4);
            ////alert(src_2);
            $(this).closest(".posttool-select").find(".vstt_icon").attr("src", src_2);
        });


        $(document).delegate(".option_delete", "click", function () {

            var post_id = $(this).closest(".posts").attr("id");
            $(this).closest(".posts").animate({ opacity: "0", height: "0", marginTop: "0px", marginBottom: "0px", paddingTop: "0px", paddingBottom: "0px"}, 400);
            ////alert(post_id);
            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {post_id: post_id, delete: 1},
                success: function (html) {

                }
            });
        });

        $(document).delegate(".comment_delete", "click", function () {

            var replyid = $(this).closest(".post_comment").find(".comment_msg").attr("id");
            $(this).closest(".post_comment").animate({ opacity: "0", height: "0", marginTop: "0px", marginBottom: "0px", paddingTop: "0px", paddingBottom: "0px", border: "none"}, 400);
            ////alert(replyid);
            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {replyid: replyid, delete: 1},
                success: function (html) {

                }
            });
        });

        $(document).delegate(".option_hide", "click", function () {

            var postid = $(this).closest(".posts").attr("id");
            $(this).closest(".posts").animate({ opacity: "0", height: "0", marginTop: "0px", marginBottom: "0px", paddingTop: "0px", paddingBottom: "0px"}, 400);
            ////alert(postid);
            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {post_id: postid, hide: 1},
                success: function (html) {

                }
            });
        });


        $(document).delegate(".option_report", "click", function () {

            var postid = $(this).closest(".posts").attr("id");
            ////alert(postid);

            $(".report_popup").attr("id", postid);
            $(".blackcanvas").stop().show();
            /*
             $.ajax({
             type: "POST",
             url: "includes/feedops.php",
             data: {post_id: postid, report: 1},
             success: function(html){

             }
             });
             */
        });

        $(document).delegate(".popup_btn_1", "click", function () {
            if ($(this).closest(".popup_window").hasClass("report_popup")) {
                $(".blackcanvas").hide();
            }
        });

        $(document).delegate(".popup_btn_0", "click", function () {
            if ($(this).closest(".popup_window").hasClass("report_popup")) {
                var post_id = $(this).closest(".popup_window").attr("id");
                //alert(post_id);
                $.ajax({
                    type: "POST",
                    url: "includes/feedops.php",
                    data: {post_id: post_id, report: 1},
                    success: function (html) {
                        $(".blackcanvas").hide();
                    },
                    error: function (html) {
                        //alert(html);
                    }
                });
            }
        });

        $(document).delegate(".bt_success", "click", function () {
            var postid = $(this).closest(".popup_box").attr("id");
            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {postid: postid, report: 1},
                success: function (html) {
                    $(".blackcanvas").hide();
                }
            });
        });

        $(document).delegate(".bt_cancel", "click", function () {
            $(".blackcanvas").hide();
        });

        $(document).delegate(".option_edit", "click", function () {
            var postid = $(this).closest(".posts").attr("id");
            var txt = $(this).closest(".posts").find(".msg_span").text().trim();

            $(this).closest(".posts").find(".post_msg").hide();
            $(this).closest(".posts").find(".edit_area").val(txt);
            $(this).closest(".posts").find(".post_edit").show();

        });

        $(document).delegate(".edit_cancel", "click", function () {
            $(this).closest(".posts").find(".post_edit").hide();
            $(this).closest(".posts").find(".post_msg").show();
            $(this).closest(".posts").find(".edit_area").val("");
        });

        $(document).delegate(".edit_done", "click", function () {
            var postid = $(this).closest(".posts").attr("id");
            var txt = $(this).closest(".posts").find(".edit_area").val();

            $(this).closest(".posts").addClass("new_fd");
            //alert($(this).closest(".posts").attr("class"));
            $ref = $(this);

            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {post_id: postid, edit: txt},
                success: function (html) {
                    //$ref.closest(".posts").find(".play").prop("href",)
                    latest_feed();

                }
            });


            $(this).closest(".posts").find(".edit_area").val("");
            $(this).closest(".posts").find(".post_edit").hide();
            $(this).closest(".posts").find(".msg_span").text(txt);
            $(this).closest(".posts").find(".post_msg").show();
        });

        $(document).delegate(".post_seen", "mouseover", function () {
            var p = $(this).find("span").text().trim();
            $(this).find(".tag-box").text("Seen by " + p);
            $(this).find(".card-tag").stop().show();
        });

        $(document).delegate(".post_seen", "mouseout", function () {
            $(this).find(".card-tag").delay(1).hide();
        });

        $(document).delegate(".upload_feed_hack", "change", function () {
            var $hack = $(this);

            var filename = $hack.val();
            ////alert(this.files[0].size);
            ////alert(filename);
            if (filename.length >= 18) {
                filename = filename.substring(0, 15) + "...";
            }

            $(this).closest(".posts").find(".feed_upload_textprompt").text(filename);
            $(this).closest(".posts").find(".feed_upload_textprompt").attr("title", $hack.val());
        });


        //ajax send form tech
        $(document).delegate(".reply_button", "click", function (e) {              
            var ref = $(this).closest(".posts");
            var commentform = $(this).closest(".commentform");

            var reply_msg = $(this).closest(".posts").find(".form-control").val().trim();
            var anon = $(this).closest(".posts").find(".post_anon_val").val();
            var reply_id = $(this).closest(".posts").find(".post_comment").last().attr("id");
            var post_id = $(this).closest(".posts").attr("id");


            var attached_files = commentform.find(".status");            

            if ((attached_files.length == 0) && (reply_msg == "")) {

            } else {
                if (attached_files.length > 0) {

                    var formData = new FormData();
                    attached_files.each(function(){
                        var file_id = $(this).data("id");
                        formData.append('file', fileList[file_id]);                        
                        delete fileList[file_id];
                    })
                    formData.append("reply_msg", reply_msg);
                    formData.append("anon", anon);
                    formData.append("reply_id", reply_id);
                    formData.append("post_id", post_id);


                    var $ref = $(this).closest(".posts").find(".comments");
                    $ref.find(".form-control").val("");

                    $.ajax({
                        type: "POST",
                        url: "includes/updatecomments.php",
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
                            var control = ref.find(".form-control");
                            control.val("");
                            ref.find(".status").remove();
                            ref.find(".fileinputbox, .dragdropbox").show();
                            minimizeCommentForm(control);
                            ref.find(".comments").append(html);
                        }
                    });

                } else {
                    console.log("else");
                    
                    $.ajax({
                        type: "POST",
                        url: "includes/updatecomments.php",
                        data: {reply_msg: reply_msg, reply_id: reply_id, anon: anon, post_id: post_id},
                        success: function (html) {
                            var control = ref.find(".form-control");
                            control.val("");
                            minimizeCommentForm(control);
                            ref.find(".comments").append(html);
                        }
                    });
                }
            }
        });

        function progressHandlingFunction(e) {
            if (e.lengthComputable) {
                $('progress').attr({value: e.loaded, max: e.total});
            }
        }

        function flagSetBack(e) {
            likepost_flag = 0;
        }

        var cmtmore_flag = 0;
        $(document).delegate(".morecmt_bar", "click", function () {
            $(this).prepend("<img class='waiting_animation_circletype waiting_animation_circletype_sz10 circletype_animation_adjust_1' src='img/waiting_animation_circletype.GIF'>");

            if (cmtmore_flag == 0) {
                cmtmore_flag = 1;
                var top_reply = $(this).closest(".posts").find(".post_comment").first().attr("id");
                var post_id = $(this).closest(".posts").attr("id");
                var $ref = $(this).closest(".posts").find(".comments");
                var $this = $(this);
                $.ajax({
                    type: "POST",
                    url: "includes/updatecomments.php",
                    data: {top_reply: top_reply, post_id: post_id},
                    success: function (html) {
                        setTimeout(function () {

                            $ref.find(".morecmt_bar").hide();
                            //$ref.find(".dummy_cmt_div").remove();
                            $ref.prepend(html);
                            cmtmore_flag = 0;
                        }, 1000);


                    },
                    error: function (html) {
                        //alert(html);
                    }
                });
            }
        });


        var cardtag_flag = 0;
        $(document).delegate(".vstt_icon", "mouseover", function () {
            if (cardtag_flag == 0) {
                $(this).closest(".field").find(".card-tag").show();
            }
        });

        $(document).delegate(".vstt_icon", "mouseout", function () {
            $(this).closest(".field").find(".card-tag").hide();
        });


        $(document).delegate(".cmt_vote", "click", function () {

            //post_id vote : upvote downvote
            var reply_id = $(this).closest(".post_comment").find(".comment_msg").attr("id");
            var vote = "";

            if ($(this).hasClass("comment_upvote")) {
                vote = "upvote";
                //$(this).css({"background-image":"url(img/upvote_active.png)"});
                //$(this).closest(".comment_updown").find(".comment_downvote").css({"opacity":"0.4"});
            }
            if ($(this).hasClass("comment_downvote")) {
                vote = "downvote";
                //$(this).closest(".comment_updown").find(".comment_upvote").css({"background-image":"url(src/upvote.png)"});
                //$(this).css({"opacity":"1"});
            }
            var score = parseInt($(this).closest(".post_comment").find(".score").text());

            if ($(this).closest(".comment_updown").hasClass("upvoted")) {
                if (vote == "upvote") {
                    score = score - 1;
                    $(this).closest(".comment_updown").removeClass("upvoted");
                }
                if (vote == "downvote") {
                    score = score - 2;
                    $(this).closest(".comment_updown").removeClass("upvoted");
                    $(this).closest(".comment_updown").addClass("downvoted");
                }

            } else {
                if ($(this).closest(".comment_updown").hasClass("downvoted")) {
                    if (vote == "upvote") {
                        score = score + 2;
                        $(this).closest(".comment_updown").removeClass("downvoted");
                        $(this).closest(".comment_updown").addClass("upvoted");
                    }
                    if (vote == "downvote") {
                        score = score + 1;
                        $(this).closest(".comment_updown").removeClass("downvoted");
                    }

                } else {
                    if (vote == "upvote") {
                        score = score + 1;
                        $(this).closest(".comment_updown").addClass("upvoted");
                    }
                    if (vote == "downvote") {
                        score = score - 1;
                        $(this).closest(".comment_updown").addClass("downvoted");
                    }
                }
            }


            ////alert(score);
            $(this).closest(".comment_updown").find(".score").text(score);

            ////alert(vote);
            $.ajax({
                type: "POST",
                url: "includes/feedops.php",
                data: {reply_id: reply_id, vote: vote},
                success: function (html) {

                }
            });
        });


        $(document).delegate(".pst_seemore", "click", function () {

            $(this).closest(".seemore_anchor").find(".txt_tail").hide();
            $(this).closest(".seemore_anchor").find(".text_hidden").show();
            $(this).hide();
        });

        /*link post animation*/
        $(document).delegate(".playable_wrap > *", "mouseover", function () {
            $(this).closest(".playable_wrap").find(".play_btn").css({"background-position": "0% 100%"});
        });

        $(document).delegate(".playable_wrap > *", "mouseout", function () {
            $(this).closest(".playable_wrap").find(".play_btn").css({"background-position": "0% 0%"});
        });


        //new functions

        $(document).delegate('.q_viewmore', "mouseover", function () {
            var t = $(this).position().top;
            var l = $(this).position().left;
            ////alert(t+","+l);
            $(this).find(".card-tag").css({"margin-left": l - 100});

            $(this).find(".card-tag").stop().show();
        });

        $(document).delegate('.q_viewmore', "mouseleave", function () {
            $(this).find(".card-tag").delay(1).hide(0);
        });

        $(document).delegate('.mf_liked', "mouseover", function () {
            var t = $(this).closest(".q_viewmore").position().top;
            var l = $(this).closest(".q_viewmore").position().left;
            $(this).closest(".q_viewmore").find(".mf_name").css({"margin-left": l - 95});
            $(this).closest(".q_viewmore").find(".mf_name").text($(this).attr("id"));
            $(this).closest(".q_viewmore").find(".mf_name").stop().show();
        });

        $(document).delegate('.mf_liked', "mouseleave", function () {
            $(this).closest(".q_viewmore").find(".mf_name").delay(1).hide();
        });

        $(document).delegate('.mf_name', "mouseover", function () {
            $(this).stop().show();
            //$(this).closest(".post_lc").find(".card-tag").stop().show();
        });

        $(document).delegate('.mf_name', "mouseout", function () {
            $(this).stop().delay(1).hide();
            //$(this).closest(".post_lc").find(".card-tag").delay(1).hide(0);
        });

        $(".delete-comment").click(function(){
            var $this = $(this);
            $.ajax({
                url: "includes/feedops.php",
                data: { "reply_id": $this.data("id"), "delete": true },
                type: "post",
                success: function(e) {
                    $this.closest(".post_comment").remove();
                }
            })
        })


        function latest_feed() {
            var feeds = $("#posts");

            j$(".new_fd").each(function (index) {

                j$(this).removeClass("new_fd");
                if (j$(this).find(".f_hidden_p").text().trim() != "") {
                    j$(this).find('.play').embedly({
                        query: {
                            maxwidth: 500,
                            autoplay: true
                        },
                        display: function (data, elem) {

//Adds the image to the a tag and then sets up the sizing.
                            j$(elem).html('<img src="' + data.thumbnail_url + '"/>')
                                .width(data.thumbnail_width)
                                .height(data.thumbnail_height)
                                .find('span').css('top', data.thumbnail_height / 2 - 36)
                                .css('left', data.thumbnail_width / 2 - 36);
////alert($(elem).html());
                            var j$elhtml = j$(elem).html();
                            j$(elem).closest(".post_lr_link_msg").find(".link-img").html(j$elhtml);

                            var t_title = data.title;
                            var t_des = data.description;
                            var t_url = data.url;
////alert(data.title+" , "+data.description+", "+data.url);
                            var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

                            j$(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
                            j$(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

                            if (data.type === 'video') {

                            } else {
                                j$(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
                            }

                        }
                    }).on('click', function () {
// Handles the click event and replaces the link with the video.
                        var data = j$(this).data('embedly');

                        if (data.type === 'video') {
                            j$(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                            return false;
                        } else {
                            window.open(data.url, '_blank');
                        }

                    });

                }

            });


////alert("a");                   
            <?php if($_SERVER['PHP_SELF']=='/beta/home.php'){ ?>
            var latest = feeds.children().first().attr('id');
            var $ref = $("#posts");
            ////alert(latest);
            $.ajax({
                type: "POST",
                url: "latestfeed.php",
                data: {latest: latest},
                //timeout: 50000,
                success: function (html) {
                    // //alert(html);
                    // //alert("a");
                    $ref.first().prepend(html);
                    setTimeout(function () {
                        latest_feed();
                    }, 1000);
                    ////alert($(".new_fd").attr("id"));

                    //success end
                },
                error: function (x, t, e) {
                    // //alert(t);
                    setTimeout(function () {
                        latest_feed();
                    }, 1000);
                }
            });

            <?php } ?>

            //ajax end

        }


    });
    </script>


    <body>

    <div id="posts">
        <!--a post start-->

        <?php
        if ($result) {
            while ($row = $result->fetch_array()) {
                $create_ts_arr = explode(" ", $row['update_timestamp']);
                $create_time = $create_ts_arr[0] . "T" . $create_ts_arr[1] . "Z";

                if ($row['post_type'] == "status") include "includes/posts.php";
                else if ($row['post_type'] == "notes") include "includes/posts_notes.php";
                else if ($row['post_type'] == "question") include "includes/posts_question.php";
            }
        }
        ?>
        <!--a post end-->
    </div>
    </body>

    </html>

<?php
$con->close();
?>