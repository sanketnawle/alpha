
<html>
    <head>
    
    <link rel="stylesheet" type="text/css" href="reset_password.css">
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
							<p id = "header-p">Reset Password
							</p>
                        </div>
                               
	                                                 
							<form id="signupform" class = "ajax" method="post" action='<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
	                            
				
								<div id = "input-fields">
                                                                        
                                                                        
							        	<div class = "ui-widget1">
							        		<div class="inputs"><input name = "p1" type="password" id="password1" placeholder="Enter your new password" class="signupinput"></input><p id="passworderror1" class = "signup-error"></p></div>
							        	</div>
                                                                        
								        
										
								        <div class="ui-widget2">
										  <div class="inputs"><input name = "p2" type="password" id="password2" placeholder="re-Enter your password" class="signupinput"></input><p id="passworderror2" class = "signup-error"></p></div>
										</div>
		                                

										<input name="submit" class="submit-button"  type = "submit" id = "submit-signup" value="Confirm"></input>

										<button  name="cancel" value='1' class="cancelreset">Cancel</button>
										
                                                                                
							    </div>

<?php                                                            
$error = FALSE;
$key = $_GET['key'];
$type = $key[0];
$key = substr($key,1,32);
include_once 'includes/user.php';
$users = new Users;

if(isset($_POST['cancel'])==1)
{
	ob_start();
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';

}

if(isset($_POST['p1'],$_POST['p2']))
{
    $p1 = hash('sha512',$_POST['p1']);
    $p2 = hash('sha512',$_POST['p2']);
    if($p1!=$p2)
    {
        $error = TRUE;
        $error_msg = "Password doesn't match. Please enter again";
    }
    else if(strlen($p1)<5)
    {
        $error = TRUE;
        $error_msg = "Password too short. Atlest 6 characters";
    }
    else if($users->resetPassword($p1, $key, $type)==TRUE)
    {
        $error = TRUE;
        $error_msg = "Password Reset sucessfully";
    }
    else
    {
        $error = TRUE;
        $error_msg = "No password reset request found";
    }
    
}
?>			

        
        </form>
       </div>
       </div>
                            <div> <?php if($error) echo $error_msg; ?> </div>
  </body>
</html>

