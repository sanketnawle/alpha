<!DOCTYPE html>
<?php
    include "php/redirect.php";
    include_once("php/dbconnection.php");
    include_once("includes/common_functions.php");
    require_once('php/time_change.php');
   
?>
<html>

    <head>

        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        </script>
        <link rel = "stylesheet" type = "text/css" href = "css/home.css">

        <!--css&js for leftbar-->
        <link rel="stylesheet" type="text/css" href="leftmenu.css">
        <link rel="stylesheet" type="text/css" href="css/feed.css">
        <link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all"/>
        <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>

    </head>

    <script>
    /* if you need new js, please goes here - for onboarding process!!!*/
    $(document).ready(function () {
        $(".onboarding_mini_search").focus();


        
        $(document).delegate('.green_btn',"click", function(){
            $(".photo_card_user_hidden").click();
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

                            alert("success");

                        },
                        error: function (html) {
                            alert(html);
                        }
                    });

            },
            error: function (html) {
                alert(html);
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
        //alert(profilepicture);
         $.ajax({  
                    type: "POST", 
                    url:"php/onboarding_functions.php",
                    data: {profilepicture:profilepicture},
                    success: function(response) {
                        alert("sucess");

                        $(".photo_card_user").find(".waiting_animation_circletype").remove();
                        $(".photo_card_user").css({"background-image": "url(" + profilepicture + ")"});

                    },    
                    error: function(response) {
                        alert("error");
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
            var dh = $(window).height();
            //alert(dh);
            $(".groups_list").height(dh - 100);
            $("#tray").height(dh);

            $(window).resize(function () {
                var dh = $(window).height();
                $(".groups_list").height(dh - 100);
                $("#tray").height(dh);
            });


            $(".admin-name").each(function (index) {
                var l = $(this).text().length;
                if (l > 21) {
                    $(this).text($(this).text().substring(0, 18) + "...");
                }
            });


            $(document).delegate('.user_follow_btn_id',"click", function(){
                var follow_user=$(this).attr("id");
                var $this= $(this);
                alert(follow_user);
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
                        alert(response);
                    }
                });
            });
        });
    </script>

    <script>
$( document ).ready(function() {
            $(document).delegate(".option_report","click",function(){

                    var postid= $(this).closest(".posts").attr("id");
                    //alert(postid);

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
            //alert(post_id);
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
      alert(text);
      window.open("https://urlinq.com/beta/search_beta.php?q="+text);
    });
    $("#search_people").click(function(){
        var dept_id=<?php session_start(); echo $_SESSION['dept_id']; ?>;
      window.open("https://urlinq.com/beta/department.php?dept_id="+dept_id+"&orgin=onboard");
    });

});
</script>
    <body>
    <section class='popup_section'><?php include "popup.html";?></section>

    <!--topbar section is real-->
    <section class='topbar_bag'>
        <?php include 'topbar.php';?>
    </section>

    

    <section class='content_bag'>       

    <section class='midsec'>

        <div class='midsec_indent'>
        
        <!--dummy feeds, structure is exactly what we have in real product-->
        <section class='feeds_bag'>
            <div id = "posts">
                <!--fill in dummy feeds here-->
                <!-- TO BE SHOWN ONLY ON FIRST HOME PAGE VISIT -->
                <div class = "onboarding_main_container">
                    <div class = "onboarding_main_header_container onboarding_main_default_container">
                        <h4>
                            Welcome to Urlinq, 
                            <?php 
                               $user_id=$_SESSION['user_id'];
                               $details=get_user_info($con,$user_id);
                               echo $details["firstname"];
                            ?>.
                        </h4>
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
                                    <input class = "onboarding_mini_search" placeholder = "Search your classes & clubs" value = "Department Classes" >
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
                              <?php include "onboarding_people.php"; ?> 
                        </div>                                          
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
                    </div>
                    <!-- HIDE THE UPLOAD PROF PIC SECTION IF USER HAS DONE SO ALREADY -->
                    <?php include "onboarding_profilepic.php"; ?>
                </div>
            </div>
        </section>

        </div>
    </section>
   
    <section class='rightbar_bag'>

    </section>

     <!--dummy leftbar, structure is exactly what we have in real product-->
    <section class='leftbar_bag'>

        <div id="tray" class="leftmenu">
            <div class="group_search">
                <input type="text" placeholder="Search your courses & clubs" class="search_groups" id="tray_search">
                <i class="icon_search"></i>
                <a class="join-group">
                    <img class="add-icon" src='img/add.png'>
                </a>
            </div>

            <div class="search-results">
            </div>

            <div class="groups_list">
                <div class="course-groups-list sub-list">
                    <div class="sub-list-header">
                        <span>CLASSES</span>
                        <div class = "no_groups_box">
                            <div class = "no_groups_img no_groups_img_class">
                            </div>
                            <h5 class = "no_groups_header">
                                Time to sign up for classes
                            </h5>
                            <div class = "no_groups_join_btn_container">
                                <!--Searches classes in your department-->
                                <button class = "no_groups_join_btn">
                                    <a href="https://urlinq.com/beta/search_beta.php?q=courses" style="text-decoration:none;" target="_blank"><font color="white">Join your Classes</font></a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="lb_group_wrap">
                        <!--normal classes populated here-->
                    </div>
                </div>
                <div class="clubs-groups-list sub-list">
                    <div class="sub-list-header">
                        <span>CLUBS</span>
                        <div class = "no_groups_box">
                            <div class = "no_groups_img no_groups_img_club">
                            </div>
                            <h5 class = "no_groups_header">
                                Find a club that interests you
                            </h5>
                            <div class = "no_groups_join_btn_container">
                                <!--Searches classes in your department-->
                                <button class = "no_groups_join_btn">
                                    <a href="https://urlinq.com/beta/search_beta.php?q=clubs" style="text-decoration:none;" target="_blank"><font color="white">Join your Clubs</font></a>
                                </button>
                            </div>
                        </div>                       
                    </div>
                    <div class="lb_group_wrap">
                        <!--normal clubs populated here-->
                    </div>
                </div>
            </div>
        </div>


    </section>

    </section>
    </body>
</html>

