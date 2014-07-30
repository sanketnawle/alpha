  <?php
/*
In this page getting the user's login info both for fb and normal login
if he is logging in with fb sending him to fblogin.php
normal login goes to afterlogin.php
also we are checking if the cookies are set if they are set we are sending him to home
If he registring with fb we are getting his details from fb javascript plugin and grabbing his first last and email

*/
session_start();
if(isset($_COOKIE['user_id'])){
header('location:home.php');
}else{

}
?>
<html>
<head>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  <title>Your University - On Urlinq</title>
    <link href="lp_beta.css" rel='stylesheet' type='text/css'>
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


  var pcount=0;
  $(document).delegate(".pagination-item","click",function(){
    if($(this).hasClass("flag-active")){
      return false;
    }
    var nb_origin=$(".flag-active").attr("id").split("_")[1];
    //alert(nb_origin);
    var $original=$(".state"+nb_origin);

    $( ".pagination-item" ).removeClass("flag-active");
    $(this).addClass("flag-active");
    $( ".pagination-item" ).each(function() {
      if(!$(this).hasClass("flag-inactive")){
        $(this).addClass("flag-inactive");
      }
    });

    var nb= $(this).attr("id").split("_")[1];

    
    pcount=parseInt(nb);
    clearInterval(mytimer);
    mytimer=setInterval(function() {pinclick_trigger(); }, 7000);
    //alert(nb);

    var $newob=$(".state"+nb);
    //$newob.show();
     $original.animate({
      opacity: 0,
      left:180
      }, 650,'swing', function() {
        $original.css({"left":"0px"});
        $original.removeClass("text-grabber-active");
        $original.addClass("text-grabber-inactive");

        $newob.show();
        $newob.animate({
          opacity: 1,
          left:200
          }, 500,'swing', function() {
            $newob.css({"left":"0px"});
            $newob.addClass("text-grabber-active");
            $newob.removeClass("text-grabber-inactive");
          });

      });

  });

  $(document).delegate(".account-type","click",function(){
    if($(this).hasClass("student")){
      $(".faculty").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#student").prop("checked", true);
      $("#faculty").prop("checked", false);
    }
    if($(this).hasClass("faculty")){
      $(".student").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#faculty").prop("checked", true);
      $("#student").prop("checked", false);
            
      
    }
  });

  
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


  </script>

</head>



  <body>
      <div class = "lp-main">

          <div class = "header">
            <div class = "top-bar">
              <div class = "top-bar-wrapper content">
                  <img src = "src/logo.png" class = "logo">
                  <div class = "signin-wrap">
                    <form name = "login" id = "login" method = "post" action = "php/afterlogin.php">
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
            <div class = "color-changing-wrapper">
              <div class = "color-changing-div">
              </div>

            </div>

          <ul class = "color-border">
            <li style = "background-color:#565a5c;"><a style = "color: white; text-decoration:none" class = "cb-link1" href="http://urlinq.com/beta/lp_beta.php">Home</a></li>
          <li><a style = "color: #1DA7D3; text-decoration:none" class = "cb-link2" href="http://urlinq.com/blog">Blog</a></li>
          <li><a style = "color: rgba(253, 112, 45, 0.74); text-decoration:none" class = "cb-link3" href="https://urlinq.com/team/jobs">Jobs</a></li>
          <li><a style = "color: rgba(177, 104, 226, 0.8); text-decoration:none" class = "cb-link4" href="https://urlinq.com/team/contact">Team</a></li>
          <li><a style = "color: #ff5a5f; text-decoration:none" class = "cb-link5" href="https://urlinq.com/about/legal/privacy">Privacy</a></li>
          <li><p>&#169; 2014 Urlinq</p></li>
          </ul>
          
          </div>
          <div class = "signup-container">
              <div class = "signup-form-wrap">
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
                    <form name = "register" id = "register" class = "register" method = "post" action = "login1.php" autocomplete="on">
                      <div class = "registration-sec">
                        <div class = "registration-sec-header">
                          Choose Your Account Type
                        </div>
                        <ul class = "account-types">
                          <li class = "account-type student">
                            <input name = "account-types" type = "radio" id = "student" class = "typecheck">
                            <label for = "student">Student</label>
                            <div id = "account-type-label">Student</div>
                          </li>
                          <li class = "account-type faculty">
                            <input name = "account-types" type = "radio" id = "faculty" class = "typecheck">
                            <label for = "faculty">Faculty</label>
                            <div id = "account-type-label">Faculty</div>
                          </li>
                        </ul>
                      </div>
                      <div class = "fname-lname-sec registration-sec-texts">
                        <input type = "text" name ="fname" id = "fname" autocomplete = "on" placeholder = "First Name">
                        <input type = "text" name ="lname" class = "lname" id = "lname" autocomplete = "on" placeholder = "Last Name">
                      </div>
                      <div class = "registration-sec-texts">
                        <input type = "email" name = "email" autocomplete = "off" placeholder = "Your School Email">
                      </div>
                      <div class = "registration-sec-texts">
                        <input type = "password" name = "password" id = "password" placeholder = "Password">
                      </div>
                      <button type = "submit" class = "rounded Button SignUp largeBtn">
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
              </div>
          </div>
          

          
    </div>

    <form name="test" id="test" method="post" action="php/fblogin.php">
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
  </body>

</html>