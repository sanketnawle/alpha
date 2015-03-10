
<html>
<head>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>
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
  <title>Urlinq</title>
  <meta name="viewport" content="width=device-width, initial-scale=.82">
  <meta name="google-site-verification" content="qv_TWutBCtliggYTCBDzJeXCNfJ3Dd3L5SkIhBSxm5Y" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lp_beta.css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/waiting_animation.css" rel='stylesheet' type='text/css'>
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>

    <!--special css is linked if and only if signup is off& announcement board is up-->
    <!--<link href="lp_beta_announce_special.css" rel='stylesheet' type='text/css'>-->
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>



    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lp_beta.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/getURLPara.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/preload_img.js"></script>

  
  <script>





  $(document).ready(function() {

      globals.supported_email_list = ['nyu.edu', 'urlinq.com','student.touro.edu','touro.edu'];

//        $.getJSON(globals.base_url + '/site/supportedEmailList', function(json_data){
//                console.log(json_data);
//                if(json_data['success']){
//                    globals.supported_email_list = json_data['supported_email_list'];
//                }else{
//                    console.log('Error getting supported email list');
//                }
//            });



//        alert(JSON.stringify(globals.supported_email_list));




      function is_supported_email(email){
            var emails = ['nyu.edu', 'urlinq.com','student.touro.edu','touro.edu'];
          for(var i = 0; i < emails.length; i++){
              //alert(email.indexOf(emails[i]));
              if(email.indexOf(emails[i]) > 0){
                  return true;
              }
          }
          return false;
        }

//
//      var href = $('.forgot').attr('href');
//      $('.forgot').click(function(e){
//        e.preventDefault();
//            $.ajax({
//               url: 'php/forgotemail.php',
//               type: 'POST',
//               data:{forgot:1},
//               success: function(data)
//               {
//                //alert("sucess");
//                window.location.href = href;
//               },
//               error: function(data)
//               {
//                 //alert("fail");
//                 //console.log("fail");
//               }
//
//         });
//         //return false;
//     });
      //window.location.href = href; //causes the browser to refresh and load the requested url
  /*error handling*/
//  var signup_error=$.getUrlVar("error");
//  if(typeof signup_error!=='undefined'){
//    signup_error= signup_error.trim();
//
//    /*different error handling
//      0=sorry cannot signup right now
//      1=select the account type
//      2=All fields are to be filled
//      3=password contains name
//      4=please enter corresponding nyu.edu email
//      5=coming soon to your university
//      6=please enter  nyu.edu email
//      7=password length atleast 6 chars
//      9=already registered please check your mail to activate your account
//      10=link expired
//      11=already registered
//    */
//    if(signup_error==0){
//      $(".reg_error_text_prompt").text("sorry cannot signup right now");
//      $(".registration-sec-texts > input").addClass("error_box_log_color");
//    }
//    if(signup_error==1){
//      $(".registration-sec-header").addClass("error_text_log_color");
//      $("ul.account-types").addClass("error_box_log_color");
//    }
//
//    if(signup_error==2){
//      $(".reg_error_text_prompt").text("All fields are to be filled");
//      $(".registration-sec-texts > input").addClass("error_box_log_color");
//    }
//
//    if(signup_error==3){
//      $(".reg_error_text_prompt").text("Password contains name");
//      $(".registration-sec-texts > #password").addClass("error_box_log_color");
//    }
//
//    if(signup_error==4){
//      $(".reg_error_text_prompt").text("Please enter corresponding nyu.edu email");
//      $(".registration-sec-texts > #email").addClass("error_box_log_color");
//    }
//
//    if(signup_error==5){
//      $(".reg_error_text_prompt").text("Coming soon to your university");
//    }
//
//    if(signup_error==6){
//      $(".reg_error_text_prompt").text("Please enter .edu email");
//      $(".registration-sec-texts > #email").addClass("error_box_log_color");
//    }
//
//    if(signup_error==7){
//      $(".reg_error_text_prompt").text("Password length at least 6");
//      $(".registration-sec-texts > #password").addClass("error_box_log_color");
//    }
//    if(signup_error==11){
//      $(".reg_error_text_prompt").text("This account has already been registered");
//      $(".registration-sec-texts > #email").addClass("error_box_log_color");
//    }
//
//
//  }

  $(document).delegate(".registration-sec-texts > input","click",function(){
    $(this).removeClass("error_box_log_color");
  });
  /*error handling end*/


  $('.after_tab').click(function(){
    var $tab = $(this);
    var panel_id = $tab.attr('data-tab_id');
    $('.after_tab.active').removeClass('active');
    $tab.addClass('active');
    $('.other_panel.active .synced_animation_divs').css({'transition':'opacity .05s linear', '-webkit-transition':'opacity .05s linear', '-moz-transition':'opacity .05s linear','-ms-transition':'opacity .05s linear','opacity':'0'});
    $('.other_panel.active').css({'background':'transparent',"border-color":"transparent"}); 
    $('.other_panel.active').removeClass('active');
    
    $('#other_panel_' + panel_id).addClass('active');
    

    $('#other_panel_' + panel_id).delay(550).queue( function(next){ 
      $(this).css({'background':'rgba(255, 255, 255, 0.95)','border-color':'rgba(105, 105, 105, 0.17)'});
      $('#other_panel_' + panel_id + ' .synced_animation_divs').css({'opacity':'1'});  
      next(); 
    });
  });

  $('.bottom_tab_button').click(function(){
    var $bottom_tab = $(this);
    var sub_panel_id = $bottom_tab.attr('data-bottom_tab_id');

    var panel_count = 3;


    var left_button_tab_id = parseInt(sub_panel_id) - 1;
    var right_button_tab_id = parseInt(sub_panel_id) + 1;


    //alert(sub_panel_id);

    if(left_button_tab_id == 0){
        left_button_tab_id = 3
    }

    if(right_button_tab_id == panel_count + 1){
        right_button_tab_id = 1;
    }


    $('.bottom_tab_left').find('.bottom_tab_button.active').removeClass('active');
    $('.bottom_tab_right').find('.bottom_tab_button.active').removeClass('active');


    $('.bottom_tab_left').find('.bottom_tab_button[data-bottom_tab_id="' + left_button_tab_id.toString() + '"]').addClass('active');
    $('.bottom_tab_right').find('.bottom_tab_button[data-bottom_tab_id="' + right_button_tab_id.toString() + '"]').addClass('active');

//
//    $(this).closest('.bottom_tab').find('.bottom_tab_button.active').removeClass('active');


    //$bottom_tab.addClass('active');
    $('.sub_panel.active').removeClass('active');
    $('#sub_panel_' + sub_panel_id).addClass('active');

  });

  $('.action_item').mouseenter(function(){
    var $action_item = $(this);
    var $action_title = $('.action_description_header');
    var $action_description = $('.action_description_details');

    var data_action_name = $action_item.attr('data-action_name');
    var data_action_details = $action_item.attr('data-action_detail');

    $action_title.text(data_action_name);
    $action_description.text(data_action_details);


    $('.action_item.active').removeClass('active');
    $action_item.addClass('active');
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



      if(!is_supported_email(email)) {
          alert("invalid email");
          //alert('An NYU email address is required.');
          $error_div.text('Email address not supported');
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
      <div class="school_bgd columbia-bgd"></div>
      <div class="school_bgd nyu-bgd"></div>
      <div class="school_bgd stern-bgd"></div>
      <div class="school_bgd rochester-bgd"></div>
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
                  <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/square_logo.png" class = "logo">
                  <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/logo.png" class = "logoText">
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
                                        $error_div.css({'top': email_position.top + 60});
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

//                                            var $forgot_password_div = $("<button id='forgot_password'>Forgot Password? </button>" +
//                                            "                   <form id='reset_password' style='display:none;'>" +
//                                            "                        <input id='reset_password_email' type='text' name='email' placeholder='Enter account email...'/>" +
//                                            "                        <input class = 'forgot_password_submit_button' type='submit' value='submit'/>" +
//                                            "                   </form> ");
//                                            $error_div.append($forgot_password_div);

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


                        <div id="forgot_password_div">
                            <button id='forgot_password'>Forgot Password? </button>
                           <form id='reset_password' style='display:none;'>
                               <input id='reset_password_email' type='text' name='email' placeholder='Enter account email...'/>
                               <input class = 'forgot_password_submit_button' type='submit' value='submit'/>
                           </form>
                        </div>


                    <form name = "login" id = "login" method = "post" action = "<?php echo Yii::app()->request->baseUrl; ?>/login">
                      <input type = "text" name = "login_email" id = "login_email" autocomplete = "on" placeholder = "School Email">
                      <input type = "password" name = "login_password" id = "login_password" placeholder = "Password">
                      <input type="hidden" id="offset" name="offset" value="" >
                       <button name = "submit" id = "submit" type = "submit" class = "rounded Button SignIn smallBtn">
                          <span class = "buttonText">
                            Log In
                          </span>
                        </button>
                        <!--<div class = "forgot_password_2">
                          Forgot your password?
                        </div>-->

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

              <div class = "mobile_wrap mobile_wrap_primary">
                <div class = "mobile_wrap_header_text">
                  <h3>
                    Urlinq
                  </h3>
                  <p>for the iPhone</p>
                  <h6>
                    Urlinq organizes your academic life, giving students and faculty an easier and faster way to access and interact with anything on campus.
                  </h6>
                </div>
                <a class = "main_app_download_btn">
                  <div class = "mobile_wrap_centered_download_button">
                  </div>
                </a>
                <div class = "mobile_wrap_centered_demo">
                  <div class = "iphone_skeleton">
                    <div class = "app_screenshot">
                    </div>
                  </div>
                </div>
                
              </div>

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
            <li style = ""><a style = "color: white; text-decoration:none" class = "cb-link1" href="http://urlinq.com">Home</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link2" href="http://urlinq.com/blog">Blog</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link3" href="https://urlinq.com/team/jobs">Jobs</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link4" href="https://urlinq.com/team/contact">Team</a></li>
          <li><a style = "color: #fff; text-decoration:none" class = "cb-link5" href="https://urlinq.com/about/legal/privacy">Privacy</a></li>
          <li style = "cursor:default!important;"><p style = "color:#fff!important; cursor:default!important;">&#169; 2015 Urlinq</p></li>
          </ul>
          
          </div>

          <div class = "mobile_panel_5 mobile_only_panel big_pic">
            <div class = "mobile_wrap">
              <p>The entire University at your Fingetips</p>
            </div>
          </div>

          <div class = "mobile_panel_1 mobile_only_panel">
            <div class = "mobile_wrap">
              <div class = "dos_panels">
                <div class = "mobile_featurette featurette_1 left">
                  <div class = "featurette_iphone_skeleton skeleton_bottom">
                    <div class = "iphone_screenshot_bottom">
                    </div>
                  </div>
                  <div class = "feature_blurb">
                  </div>
                </div>
                <div class = "mobile_featurette featurette_2 right">
                  <div class = "featurette_iphone_skeleton skeleton_top">
                    <div class = "iphone_screenshot_top">
                    </div>
                  </div>
                  <div class = "feature_blurb">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class = "mobile_panel_2 mobile_only_panel">
            <div class = "mobile_wrap">
              <div class = "big_app_icon">
              </div>
              <div class = "dos_panels">
                <div class = "left">
                  <h2>Features</h2>
                  <h3>The University experience has been re-imagined for mobile. Education is now faster, easier to manage, and more fun than ever. Here are some of the more notable features:</h3>
                  <ul>
                    <li>
                      <h4>Smart Planner</h4>
                      <img width = "60" height = "64">
                      Fast planner to help you stay on top of schoolwork
                    </li>
                    <li>
                      <h4>Ask your Class</h4>
                      <img>
                      Ask questions to people in classes and departments
                    </li>
                    <li>
                      <h4>Follow People who Inspire You</h4>
                      <img>
                      Follow professors on your campus
                    </li>
                  </ul>
                  <ul>
                    <li>
                      <h4>Schoolwork reminders</h4>
                      <img>
                      A intelligent reminder system notifies you to complete homework assignments, or to study for upcoming exams
                    </li>   
                    <li>
                      <h4>Uncover your curriculum</h4>
                      <img>
                      Discover classes and groups on campus
                    </li>   
                    <li>
                      <h4>Stay up-to-date with your academic life</h4>
                      <img>
                      Do better in school through the campus feed, which organizes the conversation in your classes and clubs
                    </li>                  
                  </ul>
                </div>
                <div class = "right">

                  <a>
                    <div class = "big_app_icon small">
                    </div>
                    <div class = "mobile_wrap_centered_download_button">
                    </div>
                    <div class = "made_in_ny">
                    </div>
                  </a>   
                  <div class = "computer_available">
                    <p>
                      Urlinq is also available <span>for the web <strong id = "computer_icon"></strong>.</span>
                    </p>
                  </div>               
                </div>
              </div>
            </div>            
          </div>
          <div class = "mobile_panel_4 mobile_only_panel footer">
            <div class = "mobile_wrap">
              <p >&#169; 2015 Urlinq, Inc. All Rights Reserved.</p>
            </div>
          </div>


          <!--signup form-->
          <div class = "signup-container">
              <div class = "signup_border_fake">
              </div>
              <div class = "signup_after_tabs">
                <div class = "after_tab after_tab_1" data-tab_id = "1">
                  <h4>About</h4> 
                </div>
                <div class = "after_tab after_tab_2" data-tab_id = "2">
                  <h4>Why Join?</h4>
                </div>
                <div class = "after_tab active after_tab_3" data-tab_id = "3">
                  <h4>Sign Up</h4>
                </div>
              </div>
              <div class = "other_panel" id = "other_panel_1">
                  <div class = "header-sec">
                    <div class = "header-sec-left">
                      <h4 class = "header">About</h4>
                    </div>
                    <div class = "header-sec-right">
                      <div class = "time-to-signup">Your link to the university</div>
                      <!--<div class = "signup-slog">seconds to get started</div>-->
                    </div>
                  </div>
                  <div class = "section_contents synced_animation_divs">
                    <div class = "opening_text">Urlinq&#x27;s mission is to improve the connectivity of students and faculty. Universities have become extremely complex and fragmented ecosystems. Urlinq solves this by breaking down the barriers of schools and departments to allow individuals to engage with others outside their major or ethnic groups. Urlinq was designed to reimagine the type of collaboration and communication that we all envision and desire for our educational journeys.</div>
                  </div>                  
              </div>
              <div class = "other_panel" id = "other_panel_2">
                  <div class = "header-sec">
                    <div class = "header-sec-left">
                      <h4 class = "header">Why Join?</h4>
                    </div>
                  </div>
                  <div class = "section_contents synced_animation_divs">
                    <div class = "opening_text sub_panel active" id = "sub_panel_1">
                      Urlinq was built with the vision that we could create a stronger university community by bridging the gaps between individuals who have historically been siloed off into different departments. We want to improve collaboration at the university and we believe that is possible by helping you to better connect within and across disciplines at your university. We created tools that allow you to engage with your favorite professors, to ask questions amongst the smartest body of individuals, and provided you with a new lens of all the resources your university offers. Sign up & tell your peers because together we can create a stronger academic community.
                    </div>
                    <div class = "opening_text sub_panel" id = "sub_panel_2">
                      <div class = "sub_panel_header">What can you do on Urlinq? Here are some of the tools you'll have access to.</div>
                      <div class ="action_sub_panel_graphic">
                        <div class = "actions_list">
                          <div class = "action_item opportunity active" data-action_name = "Opportunities" data-action_detail = "The University is full of highly talented people looking to do amazing things. An opportunity post in the department page helps you find amazing people to work with, or an interesting project or job to work on.">
                            <div class = "action_icon">
                            </div>
                            <div class = "action_name">Opportunity</div>
                          </div>   
                          <div class = "action_item discuss" data-action_name = "Class Discussions" data-action_detail = "Communication between members of classes and clubs is centered on discussion posts. A discussion can be anonymous, include files, and be sent out as an email.">
                            <div class = "action_icon">
                            </div>
                            <div class = "action_name">Discussion</div>
                          </div>
                    
                          <div class = "action_item material" data-action_name = "Notes and Materials" data-action_detail = "Notes, study guides, readings, materials, and of course, the age-old syllabus. Sharing any type of file is easy on Urlinq.">
                            <div class = "action_icon">
                            </div>
                            <div class = "action_name">Notes</div>
                          </div>
                          <div class = "action_item question" data-action_name = "Class and Group Questions" data-action_detail = "Multiple choice and true or false questions let you poll the people in your group or club, and track attendance in your classes.">
                            <div class = "action_icon">
                            </div>
                            <div class = "action_name">Question</div>
                          </div>
                           <div class = "action_item todo" data-action_name = "Group Events and TO-DOs" data-action_detail = "Your planner automatically fills up when people in your classes, clubs, and departments create events, which sync with your calendar.">
                            <div class = "action_icon">
                            </div>
                            <div class = "action_name">Todo</div>
                          </div>
                                                                                                                                                       
                        </div>
                        <div class = "action_description">
                          <div class = "action_description_header">
                            Opportunities
                          </div>
                          <div class = "action_description_details">
                            The University is full of highly talented people looking to do amazing things. An opportunity post in the department page helps you find amazing people to work with, or an interesting project or job to work on.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class = "opening_text sub_panel" id = "sub_panel_3">
                     <div class = "sub_panel_header">Which schools are on board? </div>
                     <div class = "sub_panel_graphic"></div>
                     <div class = "sub_panel_header_2">and many more to come.</div>
                    </div>
                    <div class = "bottom_tabs">
                      <div class = "bottom_tab_left bottom_tab" data-bottom_tab_position = "left">
                        <div class = "bottom_tab_button" data-bottom_tab_id = "2">
                          <div class = "arrow">
                          </div>
                          <div class = "bottom_tab_text">
                            What can you do on Urlinq?
                          </div>
                        </div>
                        <div class = "bottom_tab_button" data-bottom_tab_id = "1">
                          <div class = "arrow">
                          </div>
                          <div class = "bottom_tab_text one_line_text">
                            Why join?
                          </div>
                        </div>  
                        <div class = "bottom_tab_button active" data-bottom_tab_id = "3">
                          <div class = "arrow">
                          </div>
                          <div class = "bottom_tab_text">
                            Which schools are on Urlinq?
                          </div>
                        </div>                                                           
                      </div>
                      <div class = "bottom_tab_right bottom_tab" data-bottom_tab_position = "right">
                        <div class = "bottom_tab_button" data-bottom_tab_id = "3">
                          <div class = "arrow">
                          </div>
                          <div class = "bottom_tab_text">
                            Which schools are on Urlinq?
                          </div>
                        </div>
                        <div class = "bottom_tab_button" data-bottom_tab_id = "1">
                          <div class = "arrow">
                          </div>
                          <div class = "bottom_tab_text one_line_text">
                            Why join?
                          </div>
                        </div>  
                        <div class = "bottom_tab_button  active" data-bottom_tab_id = "2">
                          <div class = "arrow">
                          </div>
                          <div class = "bottom_tab_text">
                            What can you do on Urlinq?
                          </div>
                        </div>                                                        
                      </div>
                    </div>                     
                  </div>
              </div>
              <div class = "signup-form-wrap other_panel active" id = "other_panel_3">
                  <div class = "header-sec">
                    <div class = "header-sec-left">
                      <h4 class = "header">Sign Up</h4>
                    </div>
                    <div class = "header-sec-right">
                      <div class = "time-to-signup" style = "font-size:20px;">your link to the university</div>
                      <!--<div class = "signup-slog">seconds to get started</div>-->
                    </div>
                  </div>
                  <div class = "registration-form synced_animation_divs">
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
                        <input type = "email" name = "email" autocomplete = "off" class = "email" id="email" placeholder = "School email"
                        value="<?php if(isset($_SESSION['register_email'])){
                                             echo $_SESSION['register_email'];
                                        }else{
                                        }                                            
                                  ?>">
                      </div>
                      <div class = "registration-sec-texts signup_password_field">
                        <input type = "password" name = "password" id = "password" placeholder = "Create password">
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
                  <div class = "lp_terms synced_animation_divs">
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
//    window.fbAsyncInit = function() {
//        FB.init({
//          appId      : '237922879690774',
//          xfbml      : true,
//          version    : 'v2.0'
//        });
//      };
//
//      (function(d, s, id){
//         var js, fjs = d.getElementsByTagName(s)[0];
//         if (d.getElementById(id)) {return;}
//         js = d.createElement(s); js.id = id;
//         js.src = "//connect.facebook.net/en_US/sdk.js";
//         fjs.parentNode.insertBefore(js, fjs);
//       }(document, 'script', 'facebook-jssdk'));
//      function fb_login(){
//            FB.getLoginStatus(function(response) {
//        if (response && response.status === 'connected') {
//            testAPI();
//        }else{
//             FB.login(function(response) {
//   if (response.authResponse) {
//     console.log('Welcome!  Fetching your information.... ');
//     testAPI();
//     FB.api('/me', function(response) {
//       console.log('Good to see you, ' + response.name + '.');
//
//     });
//   } else {
//     console.log('User cancelled login or did not fully authorize.');
//   }
// });
//
//        }
//    });
//        }
//        function testAPI() {
    
//   console.log('Welcome!  Fetching your information.... ');
//    FB.api('/me', function(response) {
//    var first=response.first_name;
//    var last=response.last_name;
//    var email=response.email;
//      console.log('Successful login for: ' + JSON.stringify(response));
////      document.getElementById('status').innerHTML =
////        'Thanks for logging in, ' + first + '!';
//     console.log(JSON.stringify(response));
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
//
//document.getElementById('first').value =first;
//document.getElementById('last').value= last;
//document.getElementById('fb_email').value=email;
//document.getElementById('id').value=response.id;
//document.forms["test"].submit();
//
//    });
//    FB.api(
//    "/me/picture",
//    function (response) {
//      if (response && !response.error) {
//        console.log(JSON.stringify(response));
//    var url=response.data.url;
//    console.log(url);
//
//      }
//    }
//  );
//
//  }
//  var d = new Date()
//  var n = d.getTimezoneOffset();
//  document.getElementById('offset').value= -n/60;
//  document.getElementById('offset').value=('0' +  document.getElementById('offset').value).slice(-2);
//  document.getElementById('fboffset').value=document.getElementById('offset').value;
//  console.log(document.getElementById('offset').value);
//

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

