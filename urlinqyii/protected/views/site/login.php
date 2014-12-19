<html>


<head>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  <title>Your University - On Urlinq</title>
    <link href="lp_beta.css" rel='stylesheet' type='text/css'>
    <link href="signin_error.css" rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>
  <script src="lp_beta.js"></script> 
  <script src="signin_error.js"></script> 
  

</head>



  <body>
    <div class = "signin-error-main">

      <div class = "header">
            <div class = "top-bar">
              <div class = "top-bar-wrapper content">
                  <a href="lp_beta.php"><img src = "src/logo.png" class = "logo"></a>
                  <div class = "btn-wrap">
                     <a name = "signup-link" id = "signup-link" type = "button" href = "http://urlinq.com/beta/lp_beta.php" class = "rounded Button mediumBtn">
                        <span class = "btn_text">
                          Sign Up
                        </span>
                    </a>
                  </div>
                  
                  <div class = "fb_signin_wrap">
                    <button name = "fb_signin" id = "fb_signin" type = "button" class = "rounded Button fb_signin smallBtn" onClick="fb_login();">
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
              </div>
            </div>
      </div>
      <div class = "body-main-980">
        <div class = "content">
          <div class = "ui-content-container">
            <div class = "ui-intercontent">
              <div class = "intercontent-wrap">
                <div class = "ui-box-header">
                  <h3 class = "ui-box-headertext">
                    Urlinq Login
                  </h3>
                </div>
                <div class = "ui-box-content">
                  <?php
                  if(isset($_GET['empty'])){

                }else{
                  echo "<div class = 'ui-error-box login-error'>
                    <div class = 'error-text-header'>
                      Please re-enter your email and password.
                    </div>
                    <div>
                      <p>
                        The email you entered doesnt match the records. Please try again.
                      </p>
                      <p>
                        New to Urlinq 
                        <a href='lp_beta.php'>Register here</a>
                      </p>
                    </div>
                  </div>";
                }?>
                  <div class = "ui-form-wrap">
                    <form method="post" action="php/afterlogin.php">
                      <input type = "text" name = "login_email" id = "login_email_2" class = "signin-err" autocomplete = "on" placeholder = "School Email">
                      <input type = "password" name = "login_password" id = "login_password_2" class = "signin-err" placeholder = "Password">
                      <div class = "signin_err_box_btm">
                        <div class = "ui-leftFl">
                          <button type = "button" class = "more_options_btn">
                            <em></em>
                          </button>
                           <div class = "help-div-black help-div" id ="help-2">
                              <div class ="help-wedge-black help-wedge">

                              </div>
                              <div class = "help-box-black help-box">
                                More Options
                              </div>
                            </div>
                        </div>
                        <div class = "ui-centerer">
                          <input type = "checkbox" value = "1" checked = "1" id = "keep_loggedin" name = "keep_loggedin" class = "uiInputCheckbox uiInputLabelCheckbox">
                          <label for = "keep_loggedin" class = "uiInputLabel">Keep me logged in</label>
                          <button type = "submit" class = "login_button">
                            <span class = "btn_text">
                              Log In
                            </span>
                          </button>                   
                        </div>
                      </div>
                    </form>
                    <div class = "signin_err_box_moreoptions">
                      <div class = "leftFl">
                        <form method="post" action="PasswordReset.php" >
                        <button class = "halfBtn cantLogIn" id="halfBtn cantLogIn" type="submit">
                          <span class = "btnText">
                            Forgot Password
                          </span>
                        </button>
                      </form>
                      </div>
                      <div class = "rightFl">
                        <form method="post" action="lp_beta.php">
                           <button class = "halfBtn createAccount">
                           <em></em>
                           <span class = "btnText">
                             Create your Account
                           </span>
                        </form> 
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <ul class = "color-border">
          <li><a href="http://urlinq.com/beta/lp_beta.php">Home</a></li>
          <li><a href="http://urlinq.com/blog">Blog</a></li>
          <li><a href="https://urlinq.com/team/jobs">Jobs</a></li>
          <li><a href="https://urlinq.com/team/contact">Team</a></li>
        </ul>
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