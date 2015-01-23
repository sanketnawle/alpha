
<html>
    <head>
    
    <link rel="stylesheet" type="text/css" href="retrieve_password.css">
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
							<img src = "src/logo.png" id = "logo" alt />
						</div>				
	                                </div>
                                    
                                    
        <div class = "signup">

						<div id="header-signup">
							<p id = "header-p">Retrieve Password Via Email
							</p>
                        </div>
                               
	                                                 
							<form id="signupform" class = "ajax" method="post" action='<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	                            
	                            
				
								<div id = "input-fields">
                                                                        
                                                                        
							        	<div class = "ui-widget1">
							        		<div class="inputs"><input name = "email" type="email" id="password1" placeholder="Enter your edu email address" class="signupinput"></input><p id="passworderror1" class = "signup-error"></p></div>
							        	</div>
                                         
										<input name = "submit" class="submit-button"  type = "submit" id = "submit-signup" value="Retrieve"></input>

										<button name = "cancel"  value = "1" class="cancelreset">Cancel</button>
                                                                                
							    </div>  
<?php
$error = FALSE;

if(isset($_POST['cancel'])==1)
{
	ob_start();
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';

}
if(isset($_POST['email']))
{
    
    $email = $_POST['email'];
    if(eregi('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+\.edu$', $email)== FALSE)
    {
        $error = TRUE;
        $error_msg = "Please enter .edu email address";
    }
    else 
     {
    include_once 'includes/user.php';
    $users = new Users;
    $key = $users->resetPasswordRequest($email);
    if($key != FALSE)
    {
            include_once('Mail.php');
                            
                            $headers = array(

                                    'From' => 'Urlinq<team@urlinq.com>',
                                    'To' => $email,
                                    'Content-Type' => "text/html",
                                    'Subject' => "Reset Password Link"
                            );
                            $smtp = Mail::factory('smtp', array(
                                    'host' => 'ssl://box791.bluehost.com',
                                    'port' => '465',
                                    'auth' => true,
                                    'username' => 'team@urlinq.com',
                                    'password' => 'urlinq1234'
                            ));
                            
                            
                            $body = "
                            <html>
                            <body>
                            You can reset your password by clicking on <a href='https://urlinq.com/reset_password.php?key=".$key."'>this link</a> to verify your account.
                                </body></html>";            
                            $mail = $smtp->send($email, $headers, $body);
                            
                            if(PEAR::isError($mail)) 
                            {
                               $error = TRUE;
                               $error_msg = 'Mail error';
                            } 
                            else 
                            {
                                 $error = TRUE;
                                 $error_msg = 'Message sent';
                            }
        
    }
    else if($key==FALSE)
    {
        $error = TRUE;
        $error_msg = 'You dont have an account with us';
        
    }
   }
}



?>                                   
        </form>
       </div>
       </div>
 
                            <div id="signin-error">  <?php if($error == TRUE) echo $error_msg;?> </div>
 
  </body>
</html>

