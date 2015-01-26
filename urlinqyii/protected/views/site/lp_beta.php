  <?php
/*
In this page getting the user's login info both for fb and normal login
if he is logging in with fb sending him to fblogin.php
normal login goes to afterlogin.php
also we are checking if the cookies are set if they are set we are sending him to home
If he registring with fb we are getting his details from fb javascript plugin and grabbing his first last and email
1=select the account type
2=All fields are to be filled
3=password contains name
4=please enter corresponding nyu.edu email
5=coming soon to your university
6=please enter  nyu.edu email
7=password length atleast 6 chars
to render the firstname,lastname,email,usertype if something goes wrong in the registeration 
I am using session varaibles register_firstname,register_lastname,register_email,register_user_type

*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['session'])){
  session_destroy();
}
if(isset($_SESSION['id'])){
   $_SESSION['id'] = false;
     unset($_SESSION['id']);
     $_SESSION['firstname'] = false;
     unset($_SESSION['firstname']);
     $_SESSION['lastname'] = false;
     unset($_SESSION['lastname']);
     $_SESSION['fbemail'] = false;
     unset($_SESSION['fbemail']);

}
if(isset($_COOKIE['beta_user_id'])){
header('location:home.php');
}else{
}
?>
<html>
<head>
    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';


        var globals = {};
        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';


    </script>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  <title>Welcome to Urlinq</title>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>



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

  setTimeout(function() {
    $('div.icon_section.icon_green').addClass('animated fadeInLeft');
    $('div.icon_section.icon_green').css({"opacity":"1"});
  },1000);

  setTimeout(function() {
    $('div.icon_section.icon_red').addClass('animated fadeInLeft');
    $('div.icon_section.icon_red').css({"opacity":"1"});
  },1300);

  setTimeout(function() {
    $('div.icon_section.icon_blue').addClass('animated fadeInLeft');
    $('div.icon_section.icon_blue').css({"opacity":"1"});
  },1600);

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

        //Check if the user seleted a user type
        var $account_type_chosen = $('.account-type-chosen');
        if($account_type_chosen.length){
            if($account_type_chosen.hasClass('student')){
                account_types = 's';
            }else{
                account_types = 'p';
            }
        }else{
            alert('Please select if you are a student or professor.');
            return;
        }

        if(firstname.length == 0){
            alert('Please input a first name');
            return;
        }

        if(lastname.length == 0){
            alert('Please input a last name');
            return;
        }

        if(email.indexOf('nyu.edu') < 0){
            alert('An NYU email address is required.');
            return;
        }

        if(password.length < 5){
            alert('Password must be atleast 5 characters');
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
                        //The user is already active, so just send them to /home
                        window.location.href = base_url + '/home';
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

                        $(document).on('submit', '#reset', function(e){
                          var $form = $(this);
                          e.preventDefault();
                          e.stopPropagation();
                          var post_url = globals.base_url + '/sendReset';
                          var post_data = $form.serializeArray();
                          $.post(
                            post_url,
                            post_data,
                            function(response){
                              //alert(JSON.stringify(response));
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
                                        if(response['error_id'] == 2){
                                            alert('Email is not supported');

                                            var email_position = $('input#login_email').offset();
                                            var $error_div = $("<div id='login_error_popup'>Invalid email <form id='reset'><input type='text' name='email' value='email'/><input type='submit' value='submit'/></form></div>");
                                            $error_div.css({'position': 'absolute'});
                                            $error_div.css({'top': email_position.top + 50});
                                            $error_div.css({'left': email_position.left});



                                            $('body').append($error_div);

                                        }else if(response['error_id'] == 3){
                                            alert('Invalid login');
                                        }
                                    }
                                }, 'json'
                            );
                        });

                      </script>

                    <form name = "login" id = "login" method = "post" action = "<?php echo Yii::app()->request->baseUrl; ?>/login">
                      <input type = "text" name = "login_email" id = "login_email" autocomplete = "on" placeholder = "School Email">
                      <input type = "password" name = "login_password" id = "login_password" placeholder = "Password">
                      <input type="hidden" id="offset" name="offset" value="" >
                       <button name = "submit" id = "submit" type = "submit" class = "rounded Button SignIn smallBtn">
                          <span class = "buttonText">
                            Sign In
                          </span>
                        </button>
                        
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
                  <div class = "icon_section icon_green" style = "opacity:0">
                    <em class = "icon_img icon_img_g">
                    </em>
                    <h5>
                      The planner that plans for you - it's never been easier to keep track of everything happening in your academic life. 
                    </h5>
                  </div>
                  <div class = "icon_section icon_red" style = "opacity:0">
                    <em class = "icon_img icon_img_r">
                    </em>
                    <h5 style = "top:20px;">
                      Ask questions, share notes, and discover events with the students and professors at your school.
                    </h5>
                  </div>
                  <div class = "icon_section icon_blue" style = "opacity:0">
                    <em class = "icon_img icon_img_b">
                    </em>
                    <h5>
                      Search your university - nothing is off limits when you can search for classes, clubs, departments, and your friends within them. 
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
            <li style = "background-color:#565a5c;"><a style = "color: white; text-decoration:none" class = "cb-link1" href="http://urlinq.com/beta/lp_beta.php">Home</a></li>
          <li><a style = "color: #1DA7D3; text-decoration:none" class = "cb-link2" href="http://urlinq.com/blog">Blog</a></li>
          <li><a style = "color: rgba(253, 112, 45, 0.74); text-decoration:none" class = "cb-link3" href="https://urlinq.com/team/jobs">Jobs</a></li>
          <li><a style = "color: rgba(177, 104, 226, 0.8); text-decoration:none" class = "cb-link4" href="https://urlinq.com/team/contact">Team</a></li>
          <li><a style = "color: #ff5a5f; text-decoration:none" class = "cb-link5" href="https://urlinq.com/about/legal/privacy">Privacy</a></li>
          <li><p>&#169; 2014 Urlinq</p></li>
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
                      <div class = "time-to-signup">Learn extra</div>
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
                      <div class = "registration-sec-texts">
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
                      By clicking Create Your Account, you agree to our <a href = "/legal/terms" target = "_blank">Terms</a> and that you have read our <a href = "/legal/privacy" target = "_blank">Data Use Policy</a>.
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

