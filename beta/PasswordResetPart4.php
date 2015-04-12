<html>
<?php
/*
In this we are checking the password reset key and user_id and removing 
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['key'])){
      //connecting to database
      include_once("php/dbconnection.php");
      include "includes/common_functions.php";

      //end of connecting db
      $key1=input_sanitize($_GET['key'],$con);
      //$key1=$_GET['key'];
      //echo $key1;
      //include("includes/common_functions.php");
      $query = $con->query("SELECT user_id FROM user_recovery
                             WHERE  key1='$key1'");
      if(!$query){
            //echo "as always database query failed";
      }else{
            if($query->num_rows==1){
               while($row=$query->fetch_array()){
                 $user_id=$row['user_id'];
                 
               }  
            }else{
              header("location:lp_beta.php?problem=10");
            }   
      }
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
      $( ".passwordResetForm" ).submit(function( event ) {
        //alert("something");
        var password = $('.passwordResetForm').find('input[name="password"]').val();
        var retype= $('.passwordResetForm').find('input[name="retype"]').val();
        //alert(password);
        //alert(retype);  
        if(password==retype){
            if(password.length<6){
              event.preventDefault();
              alert("length should be atleast 6 characters");
            }
        }else{
           event.preventDefault();
           alert("passwords dont match");
      }
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
              </div>
            </div>
      </div>
      <div class = "body-main-980">
        <div class = "content">
          <div class = "ui-content-container">
            <div class = "ui-intercontent">
              <div class = "intercontent-wrap finalStepintercontent">
                <div class = "ui-box-header">
                  <h3 class = "ui-box-headertext">
                    Choose your new Password
                  </h3>
                </div>
                <div class = "ui-box-content">
                  <div class = "ui-form-wrap">
                    <h5 class = "message">
                      A strong password is a combination of letters and punctuation marks. It must be at least 6 characters long.
                    </h5>
                    <form class = "passwordResetForm" name="passwordResetForm" method="post" onsubmit="return validateForm()" action="updatepwd.php">

                      <input autofocus type = "password" name = "password" id = "search_users"  class = "signin-err" placeholder = "New Password">
                      <input autofocus type = "password" name = "retype" id = "search_users" class = "signin-err" placeholder = "Confirm Password">
                      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                          <button type = "submit" class = "search_button">
                            <span class = "btn_text continue_btn">
                              Continue
                              <em></em>
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