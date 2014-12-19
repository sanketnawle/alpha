<?php
ob_start();
session_start();
require 'facebook-php-sdk-master/src/facebook.php';
include_once('includes/user.php');
$users = new Users;

$facebook = new Facebook(array(
  'appId'  => '237922879690774',
  'secret' => 'a964dc8a3e15cf4fe5fc5f307e31d694',
  
    ));

// See if there is a user from a cookie
$user = $facebook->getUser();
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    
        
        //Retriving movies those are user like using graph api
        try{
            $email = $user_profile['email'];;
        }
        catch(Exception $o){
            print_r($o);
        }
    
  } catch (FacebookApiException $e) {
    
    $user = null;
  }
}


$error=FALSE;
$error_msg=null;
if ($user) 
    {
      
    
 if($users->userAlreadyExists($email)== TRUE)
        {
              ob_start();
              header ("Location: home.php");
        }
 else 
     {
        
 ?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
    
    <link rel="stylesheet" type="text/css" href="login_fb.css">
		<link rel="stylesheet" href="https://yui.yahooapis.com/pure/0.3.0/pure-min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
                
                <script>
                var limit = 60;
		var start = 120;
		var moveBy = 1.4;
		var timer1 = setInterval(function() {
			$('#num').text(start);
			$('.body-background').css('background-position', start + 'px 0');
			start ++;
			if(start<0){
				alert("done");
				clearTimeout(timer1);
			}
		},50);
                </script>
    </head>
    <body>
        <div class = "body-background">
        <div id="banner">	


			</div>

			<div id = "content">

				<div class = "front-window">

					<div id ="banner-content">
						<div id = "logo-div">
							<img src = "src/logo.png" id = "logo" alt style = "vertical-align:middle"/>
						</div>
	
	                                    
					</div>
                                    
                                    
        <div class = "signup">

						<div id="header-signup">
							<p id = "header-p">Additional Information
							</p>
                        </div>
                               
	                                                 
							<form id="signupform" class = "ajax" method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
								<div id = "input-fields">                                                 
							        	<div class = "ui-widget2">
							        		<div class="inputs"><input name = "university" type="text" id="university-signup" placeholder="Your University" class="signupinput"></input><p id="universityerror" class = "signup-error"></p></div>
							        	</div>
										<div class="ui-widget">
										  <input name="major" type = "text" id="major-signup" placeholder = "Your Major" class="signupinput"></input>
										</div>
                                                                    <input name="user" type ="hidden" value = "<?php echo $user;?>"></input>
		                                
										<input style = "font-size:20px; font-weight:600;padding-top: 1.6px; padding-left: 3px;" type = "submit" id = "submit-signup" value="Sign Up"></input>
                                                                                <div class ="styled-select">  
									        <select name = "graduation-year" id = "year-signup">
									        	<option id = "placeholder_select" value = "0" selected = "1">Class Year</option>
									        	<option value = "2014">2014</option>
									        	<option value = "2015">2015</option>
									        	<option value = "2016">2016</option>
									        	<option value = "2017">2017</option>
									        	<option value = "2018">2018</option>
									        	<option value = "2019">2019</option>
									        </select>
								    	</div>
							    </div>
                                    
	                                                    <div id="ack"></div>

<?php
if($user)
{	
    if(isset($_POST['university'],$_POST['major'],$_POST['graduation-year']))
    {			
			if(empty($_POST['university']))       
			{            
			$error=TRUE;            
			$error_msg="Please enter university";        
			}		
			else		
			{			
				$university=$_POST['university'];
				$major=$_POST['major'];
				$year=$_POST['graduation-year'];
				$s_id=$user_profile['id'];
				$name=$user_profile['first_name'].$user_profile['last_name'];
				$email=$user_profile['email'];
				$profilepic="https://graph.facebook.com/<?=".$user_profile['id']."?>/picture?type=large";						
				
				if($users->addFbUser($s_id, $name, $email, $university, $major, $year, $profilepic)== FALSE)
				{
					$error=TRUE;
					$error_msg='Database Connectivity Issue';
				}
				else 
				{
					ob_start();								
					header ("Location: home.php");
				}		
			}
     }
} 
else
{
   $error=TRUE;
   $error_msg=$user;
}
     
    if ($error) { echo '<div class = "signin-error">'.$error_msg.'</div>'; } } }
?>	    	
    </form>

       </div>
       </div>
  </body>
</html>

