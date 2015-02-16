<html>
<?php
/*
In this we are sending user entered email via a ajax call to php/checkemail to validate his email
and post form will have the action PasswordResetPart2.php
*/
//header("location:lp_beta.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['forgot'])){

}else{
  header("location:lp_beta.php");
}
?>

<head>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
  <title>Urlinq</title>
  <link href="lp_beta.css" rel='stylesheet' type='text/css'>
  <link href="signin_error.css" rel='stylesheet' type='text/css'>
  <link href="password_reset.css" rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="jquery-ui-1.11.0/jquery-ui.min.js"></script>
  <script src="lp_beta.js"></script> 
  <script src="signin_error.js"></script> 
  <script>
  
  $(document).ready(function() {


  $(document).delegate(".search_button","click",function(){
    //alert("in here");
   var email=$('#search_users').val();
   //alert(email);
    $.ajax({
      type:"post",
      url:"php/checkemail.php",
      data:{email:email},
      datatype:"json",  
      success:function(response){
         if(response==1){
                window.location.href =("http://urlinq.com/beta/PasswordResetPart2.php");
         }else{
           $(".ui-box-headertext").addClass("accountNotFound");
            $("#search_users").addClass("accountNotFound");
           $(".message").text("Please try searching for your .edu email or full name again.");
          $(".ui-box-headertext").text("We couldn't find your account with that information");
         }
      }

    });
   
    
  });

  });
    
  </script>

</head>



  <body>
    <div class = "forgot-password-main">

      <div class = "header">
            <div class = "top-bar">
              <div class = "top-bar-wrapper content">
                  <a href="lp_beta.php" style="text-decoration : none;"><img src = "src/logo.png" class = "logo"></a>
                  <div class = "btn-wrap">
                     <a name = "signup-link" id = "signup-link" type = "button" href = "http://urlinq.com/beta/lp_beta.php" class = "rounded Button mediumBtn">
                        <span class = "btn_text">
                          Sign Up
                        </span>
                    </a>
                  </div>  
                  
                  <div class = "signin-wrap">
                    <form name = "login" id = "login" method = "post" action = "php/afterlogin.php">
                      <input type = "text" name = "login_email" id = "login_email" autocomplete = "on" placeholder = "School Email" value>
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
      <div class = "body-main-980">
        <div class = "content">
          <div class = "ui-content-container">
            <div class = "ui-intercontent">
              <div class = "intercontent-wrap">
                <div class = "ui-box-header">
                  <h3 class = "ui-box-headertext">
                    Find your Account
                  </h3>
                </div>
                <div class = "ui-box-content">

                  <div class = "ui-form-wrap">
                    <h5 class = "message">
                      Enter your .edu email address.
                    </h5>
                    <form>
                      <em class = "mail_icon">
                      </em>
                      <input autofocus type = "text" name = "search_users" id = "search_users" class = "signin-err" autocomplete = "on">
                        <div class = "ui-centerer">

                          <button type = "button" class = "search_button">
                            <span class = "btn_text">
                              Search
                            </span>
                          </button>                   
                        </div>


                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
         


  </body>

</html>