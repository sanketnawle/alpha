
<html>
<head>
    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';


        var globals = {};
        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';


    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-59124667-1', 'auto');
      ga('send', 'pageview');

    </script>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  <title>Welcome to Urlinq</title>
  <meta name="google-site-verification" content="qv_TWutBCtliggYTCBDzJeXCNfJ3Dd3L5SkIhBSxm5Y" />
  <meta name="viewport" content="width=device-width, initial-scale=.68">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lp_beta.css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/waiting_animation.css" rel='stylesheet' type='text/css'>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>

    <!--special css is linked if and only if signup is off& announcement board is up-->
    <!--<link href="lp_beta_announce_special.css" rel='stylesheet' type='text/css'>-->
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>



  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/getURLPara.js"></script>

  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/preload_img.js"></script>
  
  <script>
  $(document).ready(function() {
      var href = $('.forgot').attr('href');
      $('.forgot').click(function(e){
        e.preventDefault();
            $.ajax({
               url: 'php/forgotemail.php',
               type: 'POST',
               data:{forgot:1},
               success: function(data)
               {
                //alert("sucess");
                window.location.href = href;
               },
               error: function(data)
               { 
                 //alert("fail");
                 //console.log("fail");
               }
           
         }); 
         //return false;        
     });      
      //window.location.href = href; //causes the browser to refresh and load the requested url
  /*error handling*/
  var signup_error=$.getUrlVar("error"); 
  if(typeof signup_error!=='undefined'){
    signup_error= signup_error.trim();

    /*different error handling
      0=sorry cannot signup right now
      1=select the account type
      2=All fields are to be filled
      3=password contains name
      4=please enter corresponding nyu.edu email
      5=coming soon to your university
      6=please enter  nyu.edu email
      7=password length atleast 6 chars
      9=already registered please check your mail to activate your account
      10=link expired
      11=already registered
    */
    if(signup_error==0){
      $(".reg_error_text_prompt").text("sorry cannot signup right now");
      $(".registration-sec-texts > input").addClass("error_box_log_color");
    } 
    if(signup_error==1){
      $(".registration-sec-header").addClass("error_text_log_color");
      $("ul.account-types").addClass("error_box_log_color");
    }

    if(signup_error==2){
      $(".reg_error_text_prompt").text("All fields are to be filled");
      $(".registration-sec-texts > input").addClass("error_box_log_color");
    }

    if(signup_error==3){
      $(".reg_error_text_prompt").text("Password contains name");
      $(".registration-sec-texts > #password").addClass("error_box_log_color");
    }

    if(signup_error==4){
      $(".reg_error_text_prompt").text("Please enter corresponding nyu.edu email");
      $(".registration-sec-texts > #email").addClass("error_box_log_color");
    }

    if(signup_error==5){
      $(".reg_error_text_prompt").text("Coming soon to your university");
    }

    if(signup_error==6){
      $(".reg_error_text_prompt").text("Please enter .edu email");
      $(".registration-sec-texts > #email").addClass("error_box_log_color");
    }

    if(signup_error==7){
      $(".reg_error_text_prompt").text("Password length at least 6");
      $(".registration-sec-texts > #password").addClass("error_box_log_color");
    }
    if(signup_error==11){
      $(".reg_error_text_prompt").text("This account has already been registered");
      $(".registration-sec-texts > #email").addClass("error_box_log_color");
    }


  }

  $(document).delegate(".registration-sec-texts > input","click",function(){
    $(this).removeClass("error_box_log_color");
  });
  /*error handling end*/



  $(window).scroll(function() {


    var y=$(window).scrollTop()*0.1;
    var x=$(window).scrollTop()*0.1;

    
    
    $(".signup-container").css({"transform":"translateY("+y+"px)"});
    


    if($(window).scrollTop()>=105){
      $(".color-changing-div").css("background-color","#02e2a7");
      

    }
    else{
      $(".color-changing-div").css("background-color","#1DA7D3");

    }




  });



  $(document).on('submit','#register',function(e){
      e.preventDefault();

      var $form = jQuery(this);


      var post_url = $form.attr('action');



      var account_types = 's';




      var password = $('#password').val();
      var email = $('#email').val();
      var firstname = $('#fname').val();
      var lastname = $('#lname').val();



      //Error checking

      var email_position = $('#email').offset();
      var account_types_position = $('.account-types').offset();
      var names_position = $('.fname-lname-sec').offset();
      var password_position = $('#password').offset();
      $('#register_error_popup').remove();
      var $error_div = $("<div id='register_error_popup'></div>");

      //Check if the user seleted a user type
      var $account_type_chosen = $('.account-type-chosen');
      if($account_type_chosen.length){
          if($account_type_chosen.hasClass('student')){
              account_types = 's';
          }else{
              account_types = 'p';
          }
      }else{
          //alert('Please select if you are a student or professor.');
          $error_div.text('Please select if you are a student or professor.');
          $error_div.css({'top': account_types_position.top});
          $error_div.css({'left': account_types_position.left - 400});
          $('body').append($error_div).hide().fadeIn(250);
          return;
      }

      if(firstname.length == 0){
          //alert('Please input a first name');
          $error_div.text('Please input a first name');
          $error_div.css({'top': names_position.top});
          $error_div.css({'left': names_position.left - 230});
          $('body').append($error_div).hide().fadeIn(250);
          return;
      }

      if(lastname.length == 0){
          //alert('Please input a last name');
          $error_div.text('Please input a last name');
          $error_div.css({'top': names_position.top});
          $error_div.css({'left': names_position.left - 230});
          $('body').append($error_div).hide().fadeIn(250);
          return;
      }

      if(email.indexOf('nyu.edu') < 0 && email.indexOf('urlinq.com') < 0) {
          //alert('An NYU email address is required.');
          $error_div.text('An NYU email address is required');
          $error_div.css({'left': email_position.left - 310});
          $error_div.css({'top': email_position.top});
          $('body').append($error_div).hide().fadeIn(250);
          return;
      }

      if(password.length < 5){
          //alert('Password must be atleast 5 characters');
          $error_div.text('Password must be at least 5 characters');
          $error_div.css({'top': password_position.top});
          $error_div.css({'left': password_position.left - 330});
          $('body').append($error_div).hide().fadeIn(250);
          return;
      }






      var post_data = {
          password: password,
          firstname: firstname,
          lastname: lastname,
          account_types: account_types,
          email: email
      };



      console.log(JSON.stringify(post_data));


      $.post(
          post_url,
          post_data,
          function(response) {

              //alert(JSON.stringify(response));

              if(response['success']){

                  window.location.href = base_url + '/onboard';
              }else{

                  if(response['error_id'] == 10){
                      //The user is already active

                      //The user is already active, so just send them to /home
                      window.location.href = base_url + '/home';
                  }else if(response['error_id'] == 11){
                      //alert('Account already exists for this email');
                      $error_div.text('Account already exists for this email');
                      $error_div.css({'top': email_position.top});
                      $error_div.css({'left': email_position.left - 330});
                      $('body').append($error_div).hide().fadeIn(250);
                  }else if(response['error_id'] == 6){
                      //alert('Account already exists for this email');
                      $error_div.text(response['error']);
                      $error_div.css({'top': email_position.top});
                      $error_div.css({'left': email_position.left - 330});
                      $('body').append($error_div).hide().fadeIn(250);
                  }else{
                      $error_div.text(response['error']);
                      $error_div.css({'top': password_position.top});
                      $error_div.css({'left': password_position.left - 330});
                      $('body').append($error_div).hide().fadeIn(250);
                  }
              }
          }, 'json'
      );
  });



  setTimeout(function () {
    $('.ur-video-playing').show();
    $('.ur-video-playing').animate({opacity:1},200);

  }, 600);

  $(function () {
    var $header = $(".marketing_animation");
    var header = ['Stay on top of your Courses and Clubs', 'Build your academic identity and network with your Peers', 'Discover more opportunities and events happening on your Campus'];
    var position = -1;
    
    !function loop() {
        position = (position + 1) % header.length;
        $header.html(header[position])
        .fadeIn()
        .delay(1400)
        .fadeOut(2200, loop);

    }();

/*
    !function loop2() {
        $(".marketing_animation").css({"-ms-transform":"translate(0px,70px)","-webkit-transform":"translate(0px,70px)","transform":"translate(0px,70px)"});
        .delay(5000);
        alert();
        $(".marketing_animation").css({"-ms-transform":"translate(0px,-50px)","-webkit-transform":"translate(0px,-50px)","transform":"translate(0px,-50px)"},loop2);
    }();

*/

});

  $('.account-type').bind('touchstart touchend', function(e) {
      e.preventDefault();

    if($(this).hasClass("student")){
      $(".faculty").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#student").prop("checked", true);
      $("#faculty").prop("checked", false);
      //$(this).val('s');
    }
    if($(this).hasClass("faculty")){
      $(".student").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#faculty").prop("checked", true);
      $("#student").prop("checked", false);
      //$(this).val('p');
            
      
    }
  });

  $(document).delegate(".account-type","click",function(){
    if($(this).hasClass("student")){
      $(".faculty").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#student").prop("checked", true);
      $("#faculty").prop("checked", false);
      //$(this).val('s');
    }
    if($(this).hasClass("faculty")){
      $(".student").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#faculty").prop("checked", true);
      $("#student").prop("checked", false);
      //$(this).val('p');
    }

  });


  $(".announce_support_input").keyup(function(event){
    if(event.keyCode == 13){
        $(".announce_support_button").click();
      }
  });

  $(document).delegate(".announce_support_button","click",function(){

            var email=$(".announce_support_input").val().trim();

            if(email!=""){

            $this=$(this);
            /*pre animation*/
            $(this).find("span").css({"visibility":"hidden"});
            $(".announce_support_wrap").prepend("<img class='waiting_animation_beadtype bead_animation_adjust_1' src='img/bead_animation.gif'>");
            /*pre animation end*/

            

            $.ajax({
                    type: "POST",
                    url: "php/preregister.php",
                    data: {email:email},
                    success: function(html){ 
                      setTimeout(function(){
                        /*suc animation*/
                        $this.find("span").css({"visibility":"visible"});
                        $(".announce_support_wrap").find(".waiting_animation_beadtype").remove();
                        /*suc animation end*/

                        $(".announce_support_input").val("");
                        $(".announce_support_input").removeAttr('value');
                        $(".announce_support_input").attr("placeholder", "Thanks, You will hear from us shortly.");
                        //$(".textprompt_announce").delay(4000).fadeOut(1000);
                      }, 670);

                      
                        
                    },
                    error: function(html){ 
                        
                    }

            });

          }
  });
  


  var dw= $(document).width();
  $(".ur-video-playing").width(dw);
  $( window ).resize(function() {
    var dw= $(document).width();
    $(".ur-video-playing").width(dw);
  });
  
});


  </script>

</head>



  <body>
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=445824712127438&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
      <div class = "lp-main">

          <div class = "header">
            <div class = "top-bar">
              <div class = "top-bar-wrapper content">
                  <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/logo.png" class = "logo">
                  <div class = "forgotPassword">
                    <a class="forgot" href="PasswordReset.php" style="text-decoration: none">Forgot password?</a>
                  </div>
                  <div class = "signin-wrap">
                    <!-- php/afterlogin.php -->

                      <script>

                        $(document).on('submit', '#reset_password', function(e){
                          var $form = $(this);
                          e.preventDefault();
                          e.stopPropagation();

                          var email = $('#reset_password_email').val();


                          var post_url = globals.base_url + '/sendReset';
                          var post_data = {email: email};
                          $.post(
                            post_url,
                            post_data,
                            function(response){
                                if(response['success']){
                                    alert('Reset password email sent');
                                }else{
                                    //error sending reset password email
                                    alert(JSON.stringify(response));
                                }
                            }, 'json'
                          );
                        });

                        $(document).on('submit', '#login', function(e){
                            var $form = $(this);
                            e.preventDefault();
                            e.stopPropagation();

                            var post_url = globals.base_url + '/login';

                            var post_data = $form.serializeArray();




                            $.post(
                                post_url,
                                post_data,
                                function(response){
                                    //alert(JSON.stringify(response));

                                    if(response['success']){
                                        window.location.replace(globals.base_url + '/home');
                                    }else{
                                        $('#login_error_popup').remove();
                                        var email_position = $('input#login_email').offset();
                                        var $error_div = $("<div id='login_error_popup'></div>");
                                        $error_div.css({'top': email_position.top + 48});
                                        $error_div.css({'left': email_position.left});
                                        if(response['error_id'] == 2){
                                            //alert('Email is not supported');
                                            $error_div.text('Incorrect login information');


                                        }else if(response['error_id'] == 3){

                                            $error_div.text('Incorrect login information');



                                            $('body').append($error_div);
                                        }else if(response['error_id'] == 4){
                                            //alert('Invalid login');
                                            $error_div.text('Incorrect password');
                                            var $forgot_password_div = $("<button id='forgot_password'>Forgot Password? </button>" +
                                            "                   <form id='reset_password' style='display:none;'>" +
                                            "                        <input id='reset_password_email' type='text' name='email' placeholder='Enter account email...'/>" +
                                            "                        <input class = 'forgot_password_submit_button' type='submit' value='submit'/>" +
                                            "                   </form> ");
                                            $error_div.append($forgot_password_div);

                                            //var $forgot_pass_div = $("<button id='forgot_password'>Forgot Password? </button> <form id='reset_password'><input type='text' name='email' placeholder='email'/><input type='submit' value='submit'/></form> </div>")
                                            //$error_div.append($forgot_pass_div);
                                        }else if(response['error_id'] == 6){
                                            window.location.replace(globals.base_url + '/onboarding');
                                        }


                                        $('body').append($error_div).hide.fadeIn(250);
                                    }
                                }, 'json'
                            );
                        });

                        $(document).on('click','#forgot_password',function(){
                            $("#login_error_popup").css({"font-size":"0px"});
                            $('#forgot_password').hide();
                            $('form#reset_password').show();
                            $('form#reset_password input#email').val($('input#login_email').val());
                        });

                        $(document).on('click','.forgot_password_2',function(){
                            $('#login_error_popup').remove();
                            var email_position = $('input#login_email').offset();
                            var $error_div = $("<div id='login_error_popup'></div>");
                            $error_div.css({'top': email_position.top + 48});
                            $error_div.css({'left': email_position.left + 70});
                        });

                      </script>

                    <form name = "login" id = "login" method = "post" action = "<?php echo Yii::app()->request->baseUrl; ?>/login">
                      <input type = "text" name = "login_email" id = "login_email" autocomplete = "on" placeholder = "School Email">
                      <input type = "password" name = "login_password" id = "login_password" placeholder = "Password">
                      <input type="hidden" id="offset" name="offset" value="" >
                       <button name = "submit" id = "submit" type = "submit" class = "rounded Button SignIn smallBtn">
                          <span class = "buttonText">
                            Log In
                          </span>
                        </button>
                        <div class = "forgot_password_2">
                          Forgot your password?
                        </div>

                        <!--<div class = "fb_signin_wrap">
                          <button name = "fb_signin" id = "fb_signin" onclick="fb_login();" type = "button" class = "rounded Button fb_signin smallBtn">
                            <em class = "fb_icon">
                            </em>
                          </button>
                          <div class = "help-div" id ="help-1">
                            <div class ="help-wedge">

                            </div>
                            <div class = "help-box">
                              Sign In with Facebook
                            </div>
                          </div>
                        </div>-->

                    </form>
                  </div>
                  
              </div>

            </div>
          </div>
          <div class = "main-content-wrap">
            <div class = "main-market-area">
              <!--announcement board-->
              <!--<div class="announcement_board">
                <div class="announcement_board_writtable">
                  <h4>

                    <span>Hello Students and Teachers,</span>

                    On September 2nd, Urlinq will open its doors to the NYU community. After numerous months in development and brainstorming, we are thrilled to be releasing this platform at a school we can call our home. Together, we can make education easier. 

                  </h4>

                  <div class='announce_support_wrap'>
                  <input type="text" class="announce_support_input" name="email" placeholder="Pre-Register with your Email">
                  <button type = "submit" class="announce_support_button"><span>Submit</span></button>
                  </div>

                </div>
              </div>-->
              <div class="fb-like" data-href="https://facebook.com/urlinq" data-width="60" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>


              <video preload = 'auto' autoplay loop preload = "auto" id = "ur-video-loop" class = "ur-video-playing" style='width:100%;' muted>
                  
                  <source src="<?php echo Yii::app()->request->baseUrl; ?>/assets/UrMovieLoop4.mp4" type = "video/mp4">
                  <source src="<?php echo Yii::app()->request->baseUrl; ?>/assets/UrMovieLoop4.webm" type = "video/webm">
                  
              </video>
              <div class = "about_section">
                <div class = "focus_area">
                  <div class = "icon_section icon_green">
                    <em class = "icon_img icon_img_g">
                    </em>
                    <h5 style = "top:18px;">
                      Keep track of everything with a planner that automatically fills itself out.
                    </h5>
                  </div>
                  <div class = "icon_section icon_red">
                    <em class = "icon_img icon_img_r">
                    </em>
                    <h5 style = "top:18px;">
                      Ask questions, share notes, and discover events with your peers and professors.
                    </h5>
                  </div>
                  <div class = "icon_section icon_blue">
                    <em class = "icon_img icon_img_b">
                    </em>
                    <h5 style = "top:18px;">
                      Search and navigate your entire University - nothing is off limits. 
                    </h5>
                  </div>
                  <div class = "icon_section icon_orange">
                    <em class = "icon_img icon_img_o">
                    </em>
                    <h5 style = "top:18px;">
                      Get reminders about upcoming homeworks, meetings, and exams. 
                    </h5>
                  </div>                  
                </div>
              </div>
             

            </div>
            <!--
            <div class  = "welcome-message">
                The Future of Education Technology is Here
            </div>
            -->
            
          </div>
          <div class = "bottom-container">


          <ul class = "color-border">
            <li style = "background-color:rgba(0,0,0,.35);"><a style = "color: white; text-decoration:none" class = "cb-link1" href="http://urlinq.com/beta/lp_beta.php">Home</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link2" href="http://urlinq.com/blog">Blog</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link3" href="https://urlinq.com/team/jobs">Jobs</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link4" href="https://urlinq.com/team/contact">Team</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link5" href="https://urlinq.com/about/legal/privacy">Privacy</a></li>
          <li style = "cursor:default!important;"><p style = "color:#fff!important; cursor:default!important;">&#169; 2015 Urlinq</p></li>
          </ul>
          
          </div>

          <!--signup form-->
          <div class = "signup-container">
              <div class = "signup-form-wrap">
                  <div class = "header-sec">
                    <div class = "header-sec-left">
                      <h4 class = "header">Sign Up
                    </div>
                    <div class = "header-sec-right">
                      <div class = "time-to-signup">Your digital campus awaits</div>
                      <!--<div class = "signup-slog">seconds to get started</div>-->
                    </div>
                  </div>
                  <div class = "registration-form">
                    <form name = "register" id = "register" class = "register" method = "post" action = "<?php echo Yii::app()->request->baseUrl; ?>/register" autocomplete="on">
                      <div class = "registration-sec">
                        <div class="reg_error_text_prompt"></div>
                        <div class = "registration-sec-header">
                          Choose Your Account Type
                        </div>
                        <ul class = "account-types">
                          <li class = "account-type student">
                            <input name = "account-types" type = "radio" id = "student" class = "typecheck" value="s"
                             <?php
                               if(isset($_SESSION['register_user_type'])){
                                    if($_SESSION['register_user_type']=='s'){
                                        echo "checked";
                                    }
                               }
                             ?>>
                            <label for = "student">Student</label>
                            <div id = "account-type-label">Student</div>
                          </li>
                          <li class = "account-type faculty">
                            <input name = "account-types" type = "radio" id = "faculty" class = "typecheck" value="p"
                            <?php
                               if(isset($_SESSION['register_user_type'])){
                                    if($_SESSION['register_user_type']=='p'){
                                        echo "checked";
                                    }
                               }
                             ?>>
                            <label for = "faculty">Faculty</label>
                            <div id = "account-type-label">Faculty</div>
                          </li>
                        </ul>
                      </div>
                      <div class = "fname-lname-sec registration-sec-texts">
                        <input type = "text" name ="firstname" id = "fname" autocomplete = "on" placeholder = "First name"
                          value="<?php if(isset($_SESSION['register_firstname'])){
                                             echo $_SESSION['register_firstname'];
                                        }else{
                                        }                                            
                                  ?>">
                        <input type = "text" name ="lastname" class = "lname" id = "lname" autocomplete = "on" placeholder = "Last name"
                         value="<?php if(isset($_SESSION['register_lastname'])){
                                             echo $_SESSION['register_lastname'];
                                        }else{
                                        }                                            
                                  ?>">
                      </div>
                      <div class = "registration-sec-texts">
                        <input type = "email" name = "email" autocomplete = "off" id="email" placeholder = "School email"
                        value="<?php if(isset($_SESSION['register_email'])){
                                             echo $_SESSION['register_email'];
                                        }else{
                                        }                                            
                                  ?>">
                      </div>
                      <div class = "registration-sec-texts signup_password_field">
                        <input type = "password" name = "password" id = "password" placeholder = "Password">
                        <?php 
                           //session_destroy();
                        ?>
                      </div>
                      <button type = "submit" class = "rounded Button SignUp largeBtn">
                        <em></em>
                        <span class = "buttonText">
                          Create Your Account
                        </span>
                      </button>
                    </form>
                  </div>

                  <!--<div class = "footer-sec">
                    <div class = "leftLine">
                    </div>
                    <div class = "or-head">
                      or
                    </div>
                    <div class = "rightLine">
                    </div>
                    <button type = "button" onclick="fb_login();" class = "rounded Button FacebookConnect loginButton largeBtn">
                      <em></em>
                      <span class = "buttonText">Continue with Facebook</span>
                    </button>

                  </div>-->
                  <div class = "lp_terms">
                    <p class = "lp_terms_p">
                      By clicking Create Your Account, you agree to our <a href = "https://urlinq.com/about/legal/terms" target = "_blank">Terms</a> and that you have read our <a href = "https://urlinq.com/about/legal/privacy" target = "_blank">Privacy Policy</a>.
                    </p>
                  </div>
              </div>
          </div>
          

          
    </div>

    <form name="test" id="test" method="post" action="php/fblogin.php">
      <input id="first" type="hidden" name="first"   value="">
        <input type="hidden" id="last" name="last" value="" >
        <input type="hidden"  id="fb_email" name="fb_email" value="">
        <input type="hidden" id="id" name="id" value="">
        <input type="hidden" id="fboffset" name="offset" value="" >
    </form>
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
    
   console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
    var first=response.first_name;
    var last=response.last_name;
    var email=response.email;
      console.log('Successful login for: ' + JSON.stringify(response));
//      document.getElementById('status').innerHTML =
//        'Thanks for logging in, ' + first + '!';
     console.log(JSON.stringify(response));
     /*$.ajax({
       url: 'fblogin.php',
       type: 'POST',
       data:{firstname:first,lastname:last,email:email, id: response.id},
       success: function(data)
       {
        $("#fbmessage").html(data);  
       },
       error: function(data)
       {
        $("#fbmessage").html(data); 
       }
       
     });*/

document.getElementById('first').value =first;
document.getElementById('last').value= last;
document.getElementById('fb_email').value=email;
document.getElementById('id').value=response.id;
document.forms["test"].submit();

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
<script>
/*var ajax_call = function() {
        $.ajax({  
                  type: "POST", 
                  data:{check:1}, 
                  url: "php/setsession.php",
                  //var department=document.getElementById('department');
                  //department.innerHTML='';
                  //var select = document.getElementById("department");
                  //var length = select.options.length;
                  success: function(response) {
                     console.log(response);
                     if(response!=0){
                        window.location.href="https://www.urlinq.com/beta/home.php";
                     }
                  }
      });
}

var interval = (1000 * 60 * 1); // where X is your every X minutes

setInterval(ajax_call, interval);*/
</script>

  </body>

</html>

