  <?php
/*
In this page getting the user's login info both for fb and normal login
if he is logging in with fb sending him to fblogin.php
normal login goes to afterlogin.php
also we are checking if the cookies are set if they are set we are sending him to home
If he registring with fb we are getting his details from fb javascript plugin and grabbing his first last and email and send him to php/fblogin.php

*/
session_start();
if(isset($_COOKIE['user_id'])){
header('location:/beta/home.php');
}else{

}
?>
<html>
<head>

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  <title>Welcome to Urlinq</title>
  <script src="/beta/jquery_plugins/jquery.countdown.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=.68">
    <link href="lp_beta_jk.css" rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>
  
  <script>
  $(document).ready(function() {
  

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



  setTimeout(function () {
    $('.ur-video-playing').show();
    $('.ur-video-playing').animate({opacity:1},200);

  }, 800);


  

  // set the date we're counting down to
  var target_date = new Date("Sep 02, 2014").getTime();
   
  // variables for time units
  var days, hours, minutes, seconds;
   
  // get tag element
  /*var countdown = document.getElementById("countdown");
   
  // update the tag with id "countdown" every 1 second
  setInterval(function () {
   
      // find the amount of "seconds" between now and target
      var current_date = new Date().getTime();
      var seconds_left = (target_date - current_date) / 1000;
   
      // do some time calculations
      days = parseInt(seconds_left / 86400);
      seconds_left = seconds_left % 86400;
       
      hours = parseInt(seconds_left / 3600);
      seconds_left = seconds_left % 3600;
       
      minutes = parseInt(seconds_left / 60);
      seconds = parseInt(seconds_left % 60);
       
      // format countdown string + set tag value
      countdown.innerHTML = days + " days " + hours + " hours" + "<br>"
      + minutes + " minutes " + seconds + " seconds";  
   
  }, 1000);
*/

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


  windowHeight = $(window).innerHeight();
  windowHeight = windowHeight;
  $('.main-market-area').css('min-height', windowHeight);
  
  function pinclick_trigger(){
    pcount=pcount+1;
    if(pcount>=3){pcount=0;}
    //alert(pcount);
    $("#lgnavi_"+pcount).click();
    //alert("a");
  }
  var mytimer=setInterval(function() {pinclick_trigger(); }, 7000);


  var dw= $(document).width();
  $(".ur-video-playing").width(dw);
  $( window ).resize(function() {
    var dw= $(document).width();
    $(".ur-video-playing").width(dw);
  });
  
});
  function submitForm() {
    //alert("clicked");
   // Get the first form with the name
   // Hopefully there is only one, but there are more, select the correct index
   //var frm = document.getElementsByName('register')[0];
   //frm.submit(); // Submit
   //frm.reset();  // Reset
   //return false; // Prevent page refresh
}


  </script>



</head>



  <body>
      <div class = "lp-main">

          <div class = "header">
            <div class = "top-bar">
              <div class = "top-bar-wrapper content">
                  <img src = "src/logo.png" class = "logo">
                  <div class = "forgotPassword">
                    <a href="PasswordReset.php" style="text-decoration: none">Forgot password?</a>
                  </div>
                  <div class = "signin-wrap">
                    <form name = "login" id = "login" method = "post" action = "/beta/php/afterlogin.php">
                      <input type = "text" name = "login_email" id = "login_email" autocomplete = "on" placeholder = "School Email">
                      <input type = "password" name = "login_password" id = "login_password"placeholder = "Password">
                      <input type="hidden" id="offset" name="offset" value="" >
                       <button name = "submit" id = "submit"type = "submit" class = "rounded Button SignIn smallBtn">
                          <span class = "buttonText">
                            Sign In
                          </span>
                        </button>
                        
                        <div class = "fb_signin_wrap">
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
                        </div>

                    </form>
                  </div>
                  
              </div>

            </div>
          </div>
          <div class = "main-content-wrap">
            <div class = "main-market-area">

              <video preload = 'auto' autoplay loop preload = "auto" id = "ur-video-loop" class = "ur-video-playing" muted>
                  
                  <source src = "src/UrMovieLoop.mp4" type = "video/mp4">
                  <source src = "src/UrMovieLoop.webm" type = "video/webm">
                  
              </video>
              <div class = "urlinq-marketing">
                <div class = "wrapper-1280">
                  <div class = "grabber">
                  <div class = "grabber-container">
                      <div class = "slider-items-wrapper">
                        <div class = "text-switcher state0 text-grabber-active">
                         <div class = "feature-description">
                            <p><b>Stay on top </b> of what is happening in your Courses and Clubs</p>
                          </div>
                        </div>
                        <div class = "text-switcher state1 text-grabber-inactive">
                          
                           <div class = "feature-description">
                            <p><b>Build your academic identity </b> amongst your peers in your Academic Network</p>
                          </div>

                        </div>
                        <div class = "text-switcher state2 text-grabber-inactive">

                          <div class = "feature-description">
                            <p class = "push-down-p"><b>Discover more </b> of what you&#x27;re looking for on your Campus</p>
                          </div>

                        </div>
                      </div>
                      <div class = "feature-description-pagination">
                        <span class = "pagination-item flag-active" id='lgnavi_0'>
                        </span>
                        <span class = "pagination-item flag-inactive" id='lgnavi_1'>
                        </span>
                        <span class = "pagination-item flag-inactive" id='lgnavi_2'>
                        </span>
                      </div>
                  </div>
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
            <li style = "background-color:#565a5c;"><a style = "color: white; text-decoration:none" class = "cb-link1" href="https://urlinq.com">Home</a></li>
          <li><a style = "color: #1DA7D3; text-decoration:none" class = "cb-link2" href="https://urlinq.com/blog">Blog</a></li>
          <li><a style = "color: rgba(253, 112, 45, 0.74); text-decoration:none" class = "cb-link3" href="https://urlinq.com/team/jobs">Jobs</a></li>
          <li><a style = "color: rgba(177, 104, 226, 0.8); text-decoration:none" class = "cb-link4" href="https://urlinq.com/team/contact">Team</a></li>
          <li><a style = "color: #ff5a5f; text-decoration:none" class = "cb-link5" href="https://urlinq.com/about/legal/privacy">Privacy</a></li>
          <li><p>&#169; 2014 Urlinq</p></li>
          </ul>
          
          </div>
          <div class = "signup-container">
           
              <div class = "signup-form-wrap">
                  <h4>
                    Hi Students and Faculty,
                    <br>
                    <br>

                    On September 2nd, Urlinq will be opening its doors to NYU. After nearly one year in development and brainstorming, we on the Urlinq team are thrilled to be releasing this platform at a school we call home.

                  </h4>
                 <!--
                  <div class = "header-sec">
                    <div class = "header-sec-left">
                      <h4 class = "header">Sign Up
                    </div>
                    <div class = "header-sec-right">
                      <div class = "time-to-signup">45</div>
                      <div class = "signup-slog">seconds to get started</div>
                    </div>
                  </div>
                  <div class = "registration-form">
                    <form name = "register" id = "register" class = "register" method = "post" action = "/beta/php/afteremail_register.php"  >
                      <div class = "registration-sec">
                        <div class = "registration-sec-header">
                          Choose Your Account Type
                        </div>
                        <ul class = "account-types">
                          <li class = "account-type student">
                            <input name = "account-types" type = "radio" id = "student" class = "typecheck" value="s">
                            <label for = "student">Student</label>
                            <div id = "account-type-label">Student</div>
                          </li>
                          <li class = "account-type faculty">
                            <input name = "account-types" type = "radio" id = "faculty" class = "typecheck" value="p" >
                            <label for = "faculty">Faculty</label>
                            <div id = "account-type-label">Faculty</div>
                          </li>
                        </ul>
                      </div>
                      <div class = "fname-lname-sec registration-sec-texts">
                        <input type = "text" name ="fname" id = "fname" autocomplete = "on" placeholder = "First Name" required>
                        <input type = "text" name ="lname" class = "lname" id = "lname" autocomplete = "on" placeholder = "Last Name" required>
                      </div>
                      <div class = "registration-sec-texts">
                        <input type = "text" name = "email"  autocomplete = "off" placeholder = "Your School Email" required>
                        
                      </div>
                      <div class = "registration-sec-texts">
                        <input type = "password" name = "password" id = "password" placeholder = "Password" autocomplete = "off" required>
                      </div>
                      <button type = "submit" class = "rounded Button SignUp largeBtn" onclick="submitForm()">
                        <em></em>
                        <span class = "buttonText">
                          Create Your Account
                        </span>
                      </button>
                    </form>
                  </div>

                  <div class = "footer-sec">
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

                  </div>
                  <div class = "lp_terms">
                    <p class = "lp_terms_p">
                      By clicking Create Your Account or Continue with Facebook, you agree to our <a href = "/legal/terms" target = "_blank">Terms</a> and that you have read our <a href = "/legal/privacy" target = "_blank">Data Use Policy</a>.
                    </p>
                  </div>
              </div>
              <div class = "comingsoon-wrap">
                  <div id="getting-started">
                    <p id="countdown"></p>
                  </div>
              </div>-->
          </div>
          

          
    </div>

    <form name="test" id="test" method="post" action="/beta/php/fblogin.php">
      <input id="first" type="hidden" name="first"   value="">
        <input type="hidden" id="last" name="last" value="" >
        <input type="hidden"  id="email" name="email" value="">
        <input type="hidden" id="id" name="id" value="">
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
document.getElementById('email').value=email;
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
  //document.getElementById('offset').value=('0' +  document.getElementById('offset').value).slice(-2)
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