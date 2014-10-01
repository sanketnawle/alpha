<!DOCTYPE html> 
<?php
/*
In this page user enters nyu email and sent him to school_select
If he enters other than nyu we are sending him back to this page
If the email already exists in the database and user first registered with normal login I send him to this page where he enters 
the password for the account if the password matches we setsessions and cookies and send him to home.php
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/common_functions.php");
include_once("php/dbconnection.php");
/*if(!isset($_SESSION['id'])){
    header("location:lp_beta.php");
}*/
?>

<html>
<head>
<meta name = "viewport" content = "width = device-width">
<meta name = "viewport" content = "width = 320">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel = "stylesheet" type = "text/css" href = "signupOnboarding.css"> 
<link rel = "stylesheet" type = "text/css" href = "FBSignup.css"> 
<link rel = "stylesheet" type = "text/css" href = "commonStyles.css"> 
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>

<link rel = "stylesheet" type = "text/css" href = "leftmenu.css"><link rel="stylesheet" type="text/css" href="planner.css">
<script src='md5.js'></script>
<link rel="stylesheet" type="text/css" href="datepicker.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

  <script src="signupOnboarding.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


<script>


$(document).ready(function() {
	 //var param1var = getQueryVariable("pass");
	 //alert(param1var);
       //$(".eduEmailContinue").addClass("disabled");
       $("#eduemail").submit(function(e){
       	//alert("in this fucntion");
       	//alert("end of this fucntion");
       	  if($('#submit').hasClass('disabled')){
                 e.preventDefault();}   
                });
        $(document).delegate("#mail_id", "keyup", function () {                
	         if ($(this).val().toLowerCase().indexOf("nyu.edu") > -1) {
	                 $("#mail_id").addClass("eduInside");
	                 $(".eduEmailContinue").removeClass("disabled");
	             }
	         else{
	         	$("#mail_id").removeClass("eduInside");
	         	$(".eduEmailContinue").addClass("disabled");
	         	
	         	
	         }
	    });


	$(".blackBackground").delay(600).fadeIn(500);
  	
		

});



</script>

</head>
<body>
	<div class = "blackBackground">
		<div class = "logo_wrapper">
			<img class = "logo" src = "src/logo.png">
		</div>
		<div class = "FBSignupEmail">
			<h2 class = "EduEmailHeader">Hi <?php 
			echo $_SESSION['firstname']; ?>, <br><span><?php if(!isset($_GET['pass'])){?>
			                                                     Please enter your .edu email address to receive <b>full access to Urlinq</b> and your university's network.
			                                            <?php } else{?>
			                                            	    Please enter your password for the account to link your facebook account.
			                                            <?php } ?></span></h2>
			<form name="eduemail" id="eduemail" action="signup_school_select.php" method="post">
			<?php 
			  if(!isset($_GET['pass'])){?>
			  	<div class = "BiginputWrapper">
				   <input spellcheck="false" type = "text" name="email" id = "mail_id" placeholder = "Your School Email" autocomplete="off"/>
			   </div>
		 <?php }else if(isset($_GET['pass'])){
                       //$pass=input_sanitize($_GET['pass'],$con);
		 	?>
		             
                 <div class = "BiginputWrapper">
				   <input spellcheck="false" type = "password" name="password" id = "password" placeholder = "your password for the account" autocomplete="off"/>
			   </div>
		 <?php } ?> 
			 	
			
			
			<div class = "btmBtnWrapper">
				<button type = "submit" name="submit" id="submit" class = "eduEmailContinue nextBtn ">
					Get Started Now
					<em></em>
				</button>
			</div>
		</form>	
		</div>
	</div> 
</body>
</html>